<?php
// CSV export
function exportToCSV(array $data, string $filename = 'tyres.csv') {
    $fp = fopen($filename, 'w');
    if (!$fp) {
        echo "❌ Could not open $filename for writing.\n";
        return;
    }

    // Write CSV header
    fputcsv($fp, ['Website', 'Brand', 'Pattern', 'Size', 'Price']);

    foreach ($data as $tyre) {
        fputcsv($fp, [
            $tyre['site'],
            $tyre['brand'],
            $tyre['pattern'],
            $tyre['size'],
            $tyre['price']
        ]);
    }

    fclose($fp);
    echo "✅ CSV exported to $filename\n";
}