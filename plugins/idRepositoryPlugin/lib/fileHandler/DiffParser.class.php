<?php

/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * DiffParser
 *
 * @package    phpCollab3
 * @subpackage idRepositoryPlugin
 */

/**
 * DiffParser manages the parsing and reading of a diff file.
 *
 * @package    phpCollab3
 * @subpackage idRepositoryPlugin
 * @author Filippo (p16) de Santis <fd@ideato.it>
 * @author Francesco (cphp) Trucchia <ft@ideato.it>
 */

class DiffParser {

  private $right;
  private $left;

  /**
   * Removes the first lines of the diff file.
   *
   * @param array $lines
   * @return array
   */
  private function unsetSummaryInformation($lines)
  {
    unset($lines[0], $lines[1], $lines[2], $lines[3]);
    return $lines;
  }

  /**
   * Checks if two different blocks have the same number of lines.
   *
   * @param DiffBlock $left
   * @param DiffBlock $right
   * @return boolean
   */
  private function checkCorrectLineNumbers($left, $right)
  {
    if ($left instanceof DiffBlock && $right instanceof DiffBlock)
    {
      return $left->getNumberOfLines() == $right->getNumberOfLines() ? true : false;
    }
    return true;
  }

  /**
   * empty
   */
  public function __construct()
  {
  }

  /**
   * Main method that creates for each line of the diff file a DiffLine object
   * and add it to the right DiffBlock object
   *
   * @param array $lines
   */
  public function parse($lines)
  {
    $lines = $this->unsetSummaryInformation($lines);
    $factory = FactoryLine::init();

    foreach ($lines as $line)
    {
      $line = $factory->build($line);

      if($line instanceof DiffBlockLine)
      {
        if (isset($left) && isset($right) && !$this->checkCorrectLineNumbers($left, $right))
        {
          throw new Exception('There are differeces in the number of line of the two cloks left and right. '.__FILE__.':'.__LINE__);
        }

        //echo "DiffBlock\n";
        $right = new DiffBlock($line->getStartRight());
        $left = new DiffBlock($line->getStartLeft());

        $this->right[] = $right;
        $this->left[] = $left;

        continue;
      }

      switch($line->getStatus())
      {
        case DiffLine::equal:
          //echo "*** equal\n";
          //echo "left:\n";
          $left->resetEmptyLineNumber();
          $left->addLine($line);
          //echo "right:\n";
          $right->resetEmptyLineNumber();
          $right->addLine($line);
          break;
        case DiffLine::left:
          //echo "*** left:\n";
          //echo "left \n";
          $left->addLine($line);
          //echo "right \n";
          $right->getTotalLineInserted() < $left->getTotalLineInserted() ? $right->addLine(new DiffLine(null)) : null;
          break;
        case DiffLine::right:
          //echo "*** right:\n";
          //echo "right \n";
          $right->addLine($line);
          //echo "left \n";
          $left->getTotalLineInserted() < $right->getTotalLineInserted() ? $left->addLine(new DiffLine(null)) : null;
          break;
      }
    }
  }

  /**
   * Return an array of DiffBlock objects that represent the first file differences
   *
   * @return array
   */
  public function getLeftBlocks()
  {
    return $this->left;
  }

  /**
   * Return an array of DiffBlock objects that represent the second file differences
   *
   * @return array
   */
  public function getRightBlocks()
  {
    return $this->right;
  }
}

