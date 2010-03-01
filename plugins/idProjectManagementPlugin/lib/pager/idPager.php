<?php
/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * idPager.php
 *
 * @package    phpCollab3
 * @subpackage idProjectManagementPlugin Model
 */


/**
 * Pager for an array of objects.
 *
 * @package    phpCollab3
 * @author Filippo (p16) De Santis <fd@ideato.it>
 * @subpackage idProjectManagementPlugin Model
 */
class idPager extends sfPager
{
  protected $resultsArray = null;

  public function __construct($class = null, $maxPerPage = 10)
  {
    parent::__construct($class, $maxPerPage);
  }

  public function init()
  {
    $this->setNbResults(count($this->resultsArray));

    if (($this->getPage() == 0 || $this->getMaxPerPage() == 0))
    {
     $this->setLastPage(0);
    }
    else
    {
     $this->setLastPage(ceil($this->getNbResults() / $this->getMaxPerPage()));
    }
  }

  private function convertToArray($array)
  {
    $results = array();
    foreach ($array as $object)
    {
      $results[] = $object;
    }

    return $results;
  }

  public function setResultArray($array)
  {
    $this->resultsArray = ($array instanceof Doctrine_Collection) ? $this->convertToArray($array) : $array;
  }

  public function getResultArray()
  {
    return $this->resultsArray;
  }

  public function retrieveObject($offset) {
    return $this->resultsArray[$offset];
  }

  public function getResults()
  {
    return array_slice($this->resultsArray, ($this->getPage() - 1) * $this->getMaxPerPage(), $this->maxPerPage);
  }

}