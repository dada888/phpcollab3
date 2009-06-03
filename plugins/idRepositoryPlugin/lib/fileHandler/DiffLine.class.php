<?php

/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * DiffLine
 *
 * @package    phpCollab3
 * @subpackage idRepositoryPlugin
 */

/**
 * DiffLine class describes a line froma diff file.
 * It represents the type of a diff line : present only in the first file, only in the second file, in both files and an empty line.
 *
 * @package    phpCollab3
 * @subpackage idRepositoryPlugin
 * @author Filippo (p16) de Santis <fd@ideato.it>
 * @author Francesco (cphp) Trucchia <ft@ideato.it>
 */

class DiffLine {

  const right = '+';
  const left = '-';
  const equal = ' ';
  const block = '@';
  const empty_line = 'empty';

  private $line;
  private $status;
  private $line_number = null;

  /**
   * Remove the new line from a string.
   *
   * @param string $line
   * @return string
   */
  private static function stripNewLine($line)
  {
    return str_replace("\n", '', $line);
  }

  /**
   * initializes the status of the DiffLine and stores the diff file line.
   *
   * @param string $line
   */
  public function __construct($line)
  {
    if($line === null)
    {
      $this->status = 'empty';
      $this->line = '';
      return;
    }

    $this->status = $line[0];
    $this->line = self::stripNewLine(substr($line, 1));
  }

  /**
   * Returns true if the DiffLine is the starting line of a new diff block
   *
   * @return <type>
   */
  public function isStartBlock()
  {
    return $this->status == DiffLine::block;
  }

  /**
   * Return the status of the line
   *
   * @return string
   */
  public function getStatus()
  {
    return $this->status;
  }

  /**
   * MAgic method to print the actual line
   *
   * @return <type>
   */
  public function __toString()
  {
    return $this->line;
  }

  /**
   * Returns true if the diff line object represent a modified line.
   * It means that the status is a "+", "-" or "empty".
   *
   * @return <type>
   */
  public function isModifiedLine()
  {
    return $this->status != self::equal && $this->status != self::block;
  }

  /**
   * Sets the line number of the DiffLine object
   *
   * @param int $line_number
   */
  public function setLineNumber($line_number)
  {
    $this->line_number = $line_number;
  }

  /**
   * Returns the line number associated with the DiffLine object or null
   *
   * @return int or null
   */
  public function getLineNumber()
  {
    return $this->line_number;
  }
  
}
?>
