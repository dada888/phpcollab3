<?php
/**
 * This file is part of the idMockStubGenerator
 * (c) 2009 Filippo (p16) De Santis <fd@ideato.it> & Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * DeclaredClass.class.php
 *
 * @package    idMockStubGenerator
 */

/**
 * DeclaredClass
 *
 * Class containing class definition details
 *
 * @package    idMockStubGenerator
 * @author     Filippo (p16) De Santis <fd@ideato.it>
 */
class DeclaredClass {

  protected $class_name;
  protected $extends = null;
  protected $implements = null;

  /**
   * Constructor. Sets the parameters for declaring a class anc check if it is valid the class name.
   *
   * @param string $class_name
   * @param string $extends
   * @param string $implements
   */
  public function  __construct($class_name, $extends = null, $implements = null)
  {
    if (is_null($class_name))
    {
      throw new Exception('Cannot instantiate an object of class DeclaredClass with class name "'.$classname.'" ['.__FILE__.':'.__LINE__.']');
    }

    $this->class_name = $class_name;
    $this->extends = $extends;
    $this->implements = $implements;
  }

  /**
   * Return the definition definition of a class as a string without the "{",
   * so : "class <class_name> [extends <class_name> [implements <interface_name>]]".
   *
   * @return string
   */
  public function getClassDefinition()
  {
    $definition = 'class '.$this->class_name;
    $definition .= is_null($this->extends) ? '' : ' extends '.$this->extends;
    $definition .= is_null($this->implements) ? '' : ' implements '.$this->implements;

    return $definition;
  }
}
?>
