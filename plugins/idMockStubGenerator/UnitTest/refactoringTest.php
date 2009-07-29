<?php
require_once('../simpletest/autorun.php');
include('../lib/FakeObjectGenerator.class.php');
include('../lib/DeclaredClass.class.php');

class fakeObjectGeneratorTest extends UnitTestCase {

  function test_ReturnValuesManger_CreationOfTheRightSetOfClasses()
  {
    $rvm = new ReturnValuesManager('Classe', 'Classe_da_estendere');

    $rvm->setReturnObject('getObject', 'Object', null, 'Class_extended');
    $rvm->setReturnObjectDefault('getObjectDefault', 'DefaultClass', 'SuperClass');

    $rvm->setReturnObjectsArray('getObjectArray',
                                array(
                                      new ReturnValuesManager('Classe_1', 'ext1','implemento'),
                                      new ReturnValuesManager('Classe_2', 'ext2'),
                                      new ReturnValuesManager('Classe_3', 'ext3'),
                                      new ReturnValuesManager('Classe_4', 'ext4','implemento'),
                                      new ReturnValuesManager('Classe_5', 'ext5'),
                                      new ReturnValuesManager('Classe_6', 'ext6'),
                                      new ReturnValuesManager('Classe_7', 'ext7','implemento')
                                     ),
                                $at = null);



    $this->assertTrue(is_array($rvm->getClassesDeclared()), '->getClassesDeclared() returns an array');
    $array = $rvm->getClassesDeclared();
    $this->assertIsA($array[0], 'DeclaredClass', 'the array conmtains DeclaredClass objects');
    $this->assertEqual(count($array), 10, '->getClassesDeclared() returns the right number of elements');
    $object = $array[0];
    $this->assertEqual($object->getClassDefinition(), 'class Classe extends Classe_da_estendere', '->getDeclaration() returns the right values');
    $object = $array[3];
    $this->assertEqual($object->getClassDefinition(), 'class Classe_1 extends ext1 implements implemento', '->getDeclaration() returns the right values');
    $object = $array[9];
    $this->assertEqual($object->getClassDefinition(), 'class Classe_7 extends ext7 implements implemento', '->getDeclaration() returns the right values');
  }

  function test_ReturnValuesManger_setConstants()
  {
    $rvm = new ReturnValuesManager('classe_con_costanti');
    $rvm->setConstant('NAME', 'name');
    $rvm->setConstant('DB', 'db');
    $rvm->setConstant('PIPPO', 'pippo');

    $this->assertTrue(is_array($rvm->getConstants()), '->getConstants() return an array');
    $constants = $rvm->getConstants();
    $this->assertTrue(isset($constants['NAME']), '->getConstants() has set the right value');
    $this->assertEqual($constants['NAME'], 'name', '->getConstants() return the right value for costant');
    $this->assertTrue(isset($constants['DB']), '->getConstants() has set the right value');
    $this->assertEqual($constants['DB'], 'db', '->getConstants() return the right value for costant');
    $this->assertTrue(isset($constants['PIPPO']), '->getConstants() has set the right value');
    $this->assertEqual($constants['PIPPO'], 'pippo', '->getConstants() return the right value for costant');

    $this->assertEqual($rvm->returnCodeForReturnValueManager($rvm), '        $rvm_classe_con_costanti = new ReturnValuesManager(\'classe_con_costanti\');
        $rvm_classe_con_costanti->setConstant(NAME, name);
        $rvm_classe_con_costanti->setConstant(DB, db);
        $rvm_classe_con_costanti->setConstant(PIPPO, pippo);
');

  }


  function test_ReturnValuesManger_setConstantsWithoutName()
  {
    $rvm = new ReturnValuesManager('classe_senza_costanti');

    $this->expectException('Exception');
    $rvm->setConstant('', '');
  }
}


?>
