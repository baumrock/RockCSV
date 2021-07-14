<?php namespace RockCSV;

use ProcessWire\RockCSV;
use ProcessWire\WireData;

class Line extends WireData {

  /** @var RockCSV $csv */
  public $csv;

  // item keys are numbers, eg 0, 1, 2, ...
  const keysNumber = 'number';

  // item keys are letters, eg A, B, ..., AA, AB, ...
  const keysLetter = 'letter';

  // item keys are taken from first line of CSV
  const keysHeader = 'header';

  public function __construct($csv) {
    $this->csv = $csv;
  }

  /**
   * Is this line empty?
   * @return bool
   */
  public function isEmpty() {
    foreach($this as $v) if($v) return false;
    return true;
  }

  /**
   * Set new item keys
   * @param string $type
   * @return self
   */
  public function keys($type) {
    foreach($this as $k=>$v) {
      unset($this->$k);
      if($type == self::keysLetter) $key = $this->letter($k);
      if($type == self::keysHeader) $key = $this->csv->headers[$k];
      $this->$key = $v;
    }
    return $this;
  }

  /**
   * Get column letter from number
   * eg 26 = Z, 27= AA, 28 = AB
   * @param integer $num
   * @return string
   */
  public function letter($num) {
    $num = intval($num+1);
    if($num <= 0) return '';
    $letter = '';
    while($num != 0) {
      $p = ($num - 1) % 26;
      $num = intval(($num - $p) / 26);
      $letter = chr(65 + $p) . $letter;
    }
    return $letter;
  }

  /**
   * Print this line (for debugging)
   * @return string
   */
  public function print() {
    return print_r($this, 1);
  }

  /**
   * Convert this object to a string
   * eg for echo $line;
   * @return string
   */
  public function __toString() {
    return implode($this->csv->opt->separator, $this->getArray());
  }

}
