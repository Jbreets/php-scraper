<?php

include("export.php"); // contains exportToCSV() and insertToDatabase()

$brands = [
    "Dunlop", 
    "Bridgestone",
    "Pirelli",
    "Goodyear",
    "Hankook",
    "Avon",
    "Michelin",
    "Supervalue",
    "Continental",
    "Firestone",
    "Yokohama",
    "Nexen"
];



$maxPages = 15;

function parseTyre($tyre) {
    $tyre = preg_replace('/\s+/', ' ', trim($tyre));
    $pattern = '/^([A-Z]+)\s+(\d{3})\s+(\d{2})\s+R(\d{2})\s+(\d{2,3}[A-Z])\s+(.*)$/i';

    if (preg_match($pattern, $tyre, $m)) {
        return [
            'brand' => strtoupper($m[1]),
            'width' => $m[2],
            'aspect_ratio' => $m[3],
            'rim' => $m[4],
            'load_speed' => $m[5],
            'model' => trim($m[6]),
        ];
    }

    return false;
}

function fetchHTML($url) {
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_USERAGENT => 'Mozilla/5.0 (compatible; JustTyresScraper/1.0)',
        CURLOPT_TIMEOUT => 15,
        CURLOPT_FOLLOWLOCATION => true
    ]);
    $html = curl_exec($ch);
    curl_close($ch);
    return $html;
}

function extractTyresFromMt3Divs($html, $site) {
    $doc = new DOMDocument();
    libxml_use_internal_errors(true);
    @$doc->loadHTML($html);
    libxml_clear_errors();

    $xpath = new DOMXPath($doc);
    $containers = $xpath->query("//div[contains(@class, 'mt-3')]");

    if ($containers->length === 0) {
        echo "  ⛔ No matching tyre containers found.\n";
        return [];
    }

    $results = [];

    foreach ($containers as $i => $container) {
        $nameNode = $xpath->evaluate(".//h4", $container)->item(0);
        $name = $nameNode ? trim($nameNode->textContent) : 'Unknown';

        $priceNode = $xpath->evaluate("//div[contains(@class, 'product-price') and contains(@class, 'fs-4')]", $doc)->item($i);
        $price = $priceNode ? trim($priceNode->textContent) : 'Unknown';

        $parsed = parseTyre($name);

        if ($parsed) {
            $brand = $parsed['brand'];
            $pattern = $parsed['model'];
            $size = "{$parsed['width']}/{$parsed['aspect_ratio']} R{$parsed['rim']} {$parsed['load_speed']}";

            $results[] = [
                'site' => $site,
                'brand' => $brand,
                'pattern' => $pattern,
                'price' => $price,
                'width' => $parsed['width'],
                'rim' => $parsed['rim'],
                'aspect_ratio' => $parsed['aspect_ratio'],
                'size' => $size
            ];
        } else {
            echo "⚠️ Could not parse: $name\n";
        }
    }

    return $results;
}

// Params
// $spec_width = "225";
// $spec_ratio = "50";
// $spec_rim   = "16";
// 
// $spec_width = "185";
// $spec_ratio = "16";
// $spec_rim   = "14";

// Scraping specs
$site = 'www.justtyres.co.uk';
$spec_width = "205";
$spec_ratio = "55";
$spec_rim   = "16";

$tyre_data = [];

foreach ($brands as $brand) {
    echo "\n🔍 Scraping brand: $brand\n";
    $brandSlug = strtolower(str_replace(' ', '-', $brand));

    for ($page = 1; $page <= $maxPages; $page++) {
        $url = "https://$site/brands/{$brandSlug}-tyres?page={$page}";
        echo "📄 Page $page URL: $url\n";

        $html = fetchHTML($url);
        $scrape_results = extractTyresFromMt3Divs($html, $site);

        foreach ($scrape_results as $tyre) {
            if (
                $tyre['width'] === $spec_width &&
                $tyre['aspect_ratio'] === $spec_ratio &&
                $tyre['rim'] === $spec_rim
            ) {
                $tyre_data[] = $tyre;
            }
        }

        sleep(rand(1, 2)); // Be polite
    }

    echo str_repeat("=", 80) . "\n";
}

// EXPORT RESULTS
if (!empty($tyre_data)) {
    exportToCSV($tyre_data);
    
    // Connect to DB (if using DB export)
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=tyre_scraper', 'your_user', 'your_pass', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        // insertToDatabase($tyre_data, $pdo);
    } catch (PDOException $e) {
        echo "❌ DB Connection Failed: " . $e->getMessage() . "\n";
    }

} else {
    echo "⚠️ No tyres matched the specified size criteria.\n";
}
