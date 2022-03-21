# RockCSV

## A message to Russian 🇷🇺 people

If you currently live in Russia, please read [this message](https://github.com/Roave/SecurityAdvisories/blob/latest/ToRussianPeople.md).

[![SWUbanner](https://raw.githubusercontent.com/vshymanskyy/StandWithUkraine/main/banner2-direct.svg)](https://github.com/vshymanskyy/StandWithUkraine/blob/main/docs/README.md)

---

ProcessWire module to help handling/reading CSV files easily and efficiently

## Usage

```php
$csv = $modules->get("RockCSV");
$file = $config->paths->assets."backups/import.csv";
$options = [
  'separator' => ';',
  'maxColumns' => 7,
  'headers' => true,
];
foreach($csv->read($file, $options) as $n=>$line) {
  // do what you want :)
}
```
