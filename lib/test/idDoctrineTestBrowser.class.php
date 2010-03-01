<?php
/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * idDoctrineTestBrowser.class.php
 *
 * @package    phpCollab3
 * @subpackage idProjectManagementPlugin Test
 */

/**
 * idDoctrineTestBrowser
 * 
 * Extends the standard sfTestFunctional class to add doctrine fixtures loading methods
 *
 * @package    phpCollab3
 * @subpackage idProjectManagementPlugin Test
 * @author     Filippo (p16) De Santis <fd@ideato.it>
 * @author     Francesco Fullone <ff@ideato.it>
 */
class idDoctrineTestBrowser extends sfBrowser {

  /**
   * Deselect otion of a select given a select name/id and the option value to deselect.
   *
   * @param string $name select name/id
   * @param string $option_value option value to be deselected
   * @return idDoctrineTestBrowser
   */
  public function deSelectOption($name, $option_value)
  {
    $position = 0;
    $dom = $this->getResponseDom();

    if (!$dom)
    {
      throw new LogicException('Cannot select because there is no current page in the browser.');
    }

    $xpath = new DomXpath($dom);

    if ($element = $xpath->query(sprintf('//select[(.="%s" or @id="%s" or @name="%s")]/option[@value="%s"]', $name, $name, $name, $option_value))->item($position))
    {
      $element->removeAttribute('selected');
    }
    else
    {
      throw new InvalidArgumentException(sprintf('Cannot find the select (%s) option value "%s" .', $name, $option_value));
    }

    return $this;
  }

}