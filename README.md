# PHP Tyre Scraper

This is a **command-line PHP scraper** built to extract tyre data from [www.justtyres.co.uk](https://www.justtyres.co.uk).

It collects:
- Tyre **brand**, **pattern**, **size**, and **price**
- Filters based on specified tyre dimensions (e.g., width, aspect ratio, rim)
- Exports the results to a `.csv` file and/or a MySQL database

## ⚙️ How to Run

1. Clone the repository:

```bash
git clone https://github.com/Jbreets/php-scraper.git
cd php-scraper
php scraper.php

 - Database information may need to be altered depending on local or live db as well as db user information