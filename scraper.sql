-- Create DB
CREATE DATABASE IF NOT EXISTS tyre_scraper;
USE tyre_scraper;

CREATE TABLE IF NOT EXISTS tyres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    website VARCHAR(255),
    brand VARCHAR(100),
    pattern VARCHAR(255),
    size VARCHAR(100),
    price VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert Tyre Data
INSERT INTO tyres (website, brand, pattern, size, price) VALUES
('www.justtyres.co.uk', 'DUNLOP', 'SPORT BLURESPONSE', '205/55 R16 91V', '£86.17'),
('www.justtyres.co.uk', 'DUNLOP', 'SP SPORT MAXX TT', '205/55 R16 91W', '£201.49'),
('www.justtyres.co.uk', 'DUNLOP', 'SPORT MAXX RT', '205/55 R16 91W', '£177.60'),
('www.justtyres.co.uk', 'DUNLOP', 'SPORT MAXX RT', '205/55 R16 91Y', '£177.60'),
('www.justtyres.co.uk', 'DUNLOP', 'SPORT BLURESPONSE', '205/55 R16 91H', '£93.13'),
('www.justtyres.co.uk', 'DUNLOP', 'SPORT BLURESPONSE', '205/55 R16 91V', '£183.49'),
('www.justtyres.co.uk', 'DUNLOP', 'SPORT BLURESPONSE', '205/55 R16 91W', '£70.93'),
('www.justtyres.co.uk', 'BRIDGESTONE', 'TURANZA ER300A', '205/55 R16 91W', '£161.78'),
('www.justtyres.co.uk', 'BRIDGESTONE', 'TURANZA ER300', '205/55 R16 91V', '£91.56'),
('www.justtyres.co.uk', 'PIRELLI', 'CINTURATO P7', '205/55 R16 91V', '£187.49'),
('www.justtyres.co.uk', 'PIRELLI', 'CINTURATO P7 (P7C2) RUNFLAT', '205/55 R16 91V', '£207.49'),
('www.justtyres.co.uk', 'PIRELLI', 'CINTURATO P7 (P7C2) RUNFLAT', '205/55 R16 91W', '£194.52'),
('www.justtyres.co.uk', 'PIRELLI', 'CINTURATO P7', '205/55 R16 91W', '£178.49'),
('www.justtyres.co.uk', 'GOODYEAR', 'EFFICIENTGRIP RUNFLAT', '205/55 R16 91W', '£126.49'),
('www.justtyres.co.uk', 'GOODYEAR', 'VECTOR 4SEASONS', '205/55 R16 94V', '£88.19'),
('www.justtyres.co.uk', 'GOODYEAR', 'VECTOR 4SEASONS GEN-2 RUNFLAT', '205/55 R16 91V', '£93.19'),
('www.justtyres.co.uk', 'GOODYEAR', 'EFFICIENTGRIP PERFORMANCE', '205/55 R16 91W', '£136.49'),
('www.justtyres.co.uk', 'GOODYEAR', 'VECTOR 4SEASONS GEN-2', '205/55 R16 94H', '£153.49'),
('www.justtyres.co.uk', 'GOODYEAR', 'EFFICIENTGRIP PERFORMANCE', '205/55 R16 91V', '£143.82'),
('www.justtyres.co.uk', 'GOODYEAR', 'EFFICIENTGRIP PERFORMANCE', '205/55 R16 91V', '£166.58'),
('www.justtyres.co.uk', 'HANKOOK', 'KINERGY 4S 2 H750', '205/55 R16 94H', '£277.22'),
('www.justtyres.co.uk', 'HANKOOK', 'KINERGY ECO 2 K435', '205/55 R16 91H', '£114.84');
