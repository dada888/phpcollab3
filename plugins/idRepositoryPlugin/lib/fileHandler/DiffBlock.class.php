<?php

/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * DiffBlock
 *
 * @package    phpCollab3
 * @subpackage idRepositoryPlugin
 */

/**
 * A DiffBlock class manages a set of DiffLine objects to rapresent a sequence
 * of lines retrived from a diff file.
 *
 * @package    phpCollab3
 * @subpackage idRepositoryPlugin
 * @author Filippo (p16) de Santis <fd@ideato.it>
 * @author Francesco (cphp) Trucchia <ft@ideato.it>
 */
class DiffBlock {

  private $start_file_line_number;
  private $file_line_number;

  private $lines = array();
  private $empty_line_number;
  private $actual_line_number;
  private $total_line_inserted;

  /**
   * It adds an empty line in the list of DiffLine objects
   * and updates the DiffBlock empty line number index
   *
   * @param DiffLine $line
   */
  private function addEmptyLine($line)
  {
    $this->empty_line_number++;
    $this->lines[] = $line;
  }

  /**
   * Sets the DiffLine line number parameter of the DiffLine passed as input
   * and updates the line number count for the DiffBlock
   *
   * @param DiffLine $line
   * @return DiffLine
   */
  private function setLineNumber($line)
  {
    $line->setLineNumber($this->file_line_number);
    $this->file_line_number++;
    return $line;
  }

  /**
   * Adds a not empty line into the list of DiffLines inside the DiffBlock class.
   * This method updates the indexes for DiffBlock actual/total/empty line numbers
   *
   * @param DiffLine $line
   */
  private function addNotEmptyLine($line)
  {
    $this->actual_line_number++;
    $subtraction_value = $this->empty_line_number == 0 ? 0 : 1;
    $this->empty_line_number -= $subtraction_value;
    $this->total_line_inserted -= $subtraction_value;
    $this->lines[$this->actual_line_number-1] = $this->setLineNumber($line);
  }

  /**
   * initializes the file/empty/actual/total line number indexes
   *
   * @param int $line_number
   */
  public function __construct($line_number)
  {
    if($line_number < 0 || !is_numeric($line_number))
    {
      throw new Exception('Line number must be a positive integer or zero [ given '.$line_number.']');
    }
    $this->file_line_number = $this->start_file_line_number = $line_number;
    $this->empty_line_number = 0;
    $this->actual_line_number = 0;
    $this->total_line_inserted = 0;
  }

  /**
   * Adds a line into the DiffLine list
   *
   * @param DiffLine $line
   */
  public function addLine(DiffLine $line)
  {
    $this->total_line_inserted++;
    $status = $line->getStatus();
    $status == 'empty' ? $this->addEmptyLine($line) : $this->addNotEmptyLine($line);
  }

  /**
   * Returns the DiffLine objects list as array
   *
   * @return array
   */
  public function getLines()
  {
    return $this->lines;
  }

  /**
   * Returns the empty line number index
   *
   * @return int
   */
  public function getEmptyLine()
  {
    return $this->empty_line_number;
  }

  /**
   * Sets the actual/empty line number indexes to represent that the empty lines inserted has to remain empty
   * and will not be replaced if a not empty line will be added
   *
   */
  public function resetEmptyLineNumber()
  {
    if ($this->empty_line_number > 0)
    {
      $this->actual_line_number = $this->total_line_inserted == 0 ? 0 : $this->total_line_inserted;
      $this->empty_line_number = 0;
    }
  }

  /**
   * Returns the start line number index
   *
   * @return int
   */
  public function getStartLineNumber()
  {
    return $this->start_file_line_number;
  }

  /**
   * Returns the actual line number index
   *
   * @return int
   */
  public function getNumberOfLines()
  {
     return $this->actual_line_number;
  }

  /**
   * Returns the total line number index
   *
   * @return int
   */
  public function getTotalLineInserted()
  {
    return $this->total_line_inserted;
  }

  /**
   * Given an index, this method returns the DiffLine at that index or otherwise null
   *
   * @param <type> $index
   * @return <type>
   */
  public function getLine($index)
  {
    return isset($this->lines[$index]) ? $this->lines[$index] : null;
  }
}

