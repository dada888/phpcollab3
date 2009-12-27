<?php

/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * DiffBlockLine
 *
 * @package    phpCollab3
 * @subpackage idRepositoryPlugin
 */

/**
 * DiffBlockLine class represents a particular diff file line.
 * It takes as input a line like "@@ -16,88 +35,83 @@".
 * This line indicates the starting line for each file and the number of line for each diff block.
 *
 * @package    phpCollab3
 * @subpackage idRepositoryPlugin
 * @author Filippo (p16) de Santis <fd@ideato.it>
 * @author Francesco (cphp) Trucchia <ft@ideato.it>
 */

class DiffBlockLine{

  private $star_right;
  private $star_left;
  private $line;

  /**
   * initializes the start line for the firsr and secondo file in comparison
   *
   * @param string $line 
   */
  private function setStartLines($line)
  {
    $data = explode(' ', $line);
    $left_data = explode(',',$data[1]);
    $right_data = explode(',',$data[2]);

    $this->star_left = str_replace('-', '',$left_data[0]);
    $this->star_right = str_replace('+', '',$right_data[0]);
  }

  /**
   * Returns the value for the second file start line of a diff block.
   *
   * @return int
   */
  public function getStartRight()
  {
    return $this->star_right;
  }

  /**
   * Returns the value for the first file start line of a diff block.
   *
   * @return int
   */
  public function getStartLeft()
  {
    return $this->star_left;
  }

  /**
   * Magic method for printing the actual line
   *
   * @return string
   */
  public function __toString()
  {
    return $this->line;
  }

  /**
   * initializes the internal line value and sets the start line numbers.
   *
   * @param string $line
   */
  public function __construct($line)
  {
    $this->line = $line;
    $this->setStartLines($line);
  }
}
