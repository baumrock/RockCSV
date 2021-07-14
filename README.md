# RockCSV

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
