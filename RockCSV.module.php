<?php namespace ProcessWire;

use RockCSV\Line;

/**
 * @author Bernhard Baumrock, 13.07.2021
 * @license Licensed under MIT
 * @link https://www.baumrock.com
 */
class RockCSV extends WireData implements Module {

  public $headers = null;
  public $opt = null;

  public static function getModuleInfo() {
    return [
      'title' => 'RockCSV',
      'version' => '0.0.1',
      'summary' => 'ProcessWire module to help handling/reading CSV files easily
        and efficiently',
      'autoload' => false,
      'singular' => false,
      'icon' => 'download',
      'requires' => [],
      'installs' => [],
    ];
  }

  /**
   * Read CSV file line by line
   * @return mixed
   */
  public function read($file, $options = []) {
    require_once(__DIR__."/Line.php");

    // setup options
    $opt = (object)array_merge([
      // fgetcsv settings
      // see https://www.php.net/manual/en/function.fgetcsv.php
      'length' => 0,
      'separator' => ',',
      'enclosure' => '"',
      'escape' => '\\',

      // limit columns (array elements) of $line array
      'maxColumns' => 0,

      // first line has column headers that should be used as column keys
      // eg $line->forename instead of $line[0];
      'headers' => false,
    ], $options);
    $this->opt = $opt;

    $handle = fopen($file, 'rb');
    if($handle === false) throw new WireException("Error opening file $file");
    while(feof($handle) === false) {
      $_line = fgetcsv(
        $handle,
        $opt->length,
        $opt->separator,
        $opt->enclosure,
        $opt->escape
      );

      // remove unused columns
      if($opt->maxColumns) $_line = array_splice($_line, 0, $opt->maxColumns);

      // if the headers option is TRUE we use the first line to populate
      // the headers array that is used as data item keys
      if($opt->headers AND $this->headers === null) {
        $this->headers = $_line;
        continue;
      }

      // convert $line to Line object
      if($_line) {
        $line = new Line($this);
        if(is_array($_line)) $line->setArray($_line);
        if($opt->headers) $line = $line->keys($line::keysHeader);
        yield $line;
      }
    }

    fclose($handle);
  }

}
