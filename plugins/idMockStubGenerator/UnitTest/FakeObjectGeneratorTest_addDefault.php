<?php

require_once('../simpletest/autorun.php');
include('../lib/FakeObjectGenerator.class.php');
include('../lib/DeclaredClass.class.php');

class fakeObjectGeneratorTest_deeper_level extends UnitTestCase {

    function test_adding_default_at(){
        $rvm = new ReturnValuesManager('test_default');
        $rvm->setReturnValue('metodo', 'primo',1)
        ->setReturnValue('metodo', 'secondo', 2)
        ->setReturnValue('metodo', 'terzo', 3)
        ->setReturnValueDefault('metodo', 'default');

        FakeObjectGenerator::generate($rvm, new CodeGenerator(null));

        $classe = "class test_default{
//timing
     private static \$times = array();
//Costants
//Magic methods
    public function __call(\$name, \$arguments) {
        return null;
    }
    public function __callStatic(\$name, \$arguments) {
        return null;
    }
//Methods
    function metodo(){
        if(isset(self::\$times['metodo'])){
            self::\$times['metodo']++;
        }
        else{
            self::\$times['metodo'] = 1;
        }
switch (self::\$times['metodo']){
        case 1:
        return 'primo';
        break;
        case 2:
        return 'secondo';
        break;
        case 3:
        return 'terzo';
        break;
        default:         return 'default';
        }
    }
}";

        $this->assertEqual($classe, FakeObjectGenerator::returnedCode());
        $test_deault = new test_default();
        $this->assertEqual($test_deault->metodo(), 'primo');
        $this->assertEqual($test_deault->metodo(), 'secondo');
        $this->assertEqual($test_deault->metodo(), 'terzo');
        $this->assertEqual($test_deault->metodo(), 'default');
        $this->assertEqual($test_deault->metodo(), 'default');

    }


    function test_addDefault_object(){
        $rvm = new ReturnValuesManager('classe');
        $rvm->setReturnValue('metodo', 'primo', 1)
        ->setReturnObjectDefault('metodo', 'pdefault');

        FakeObjectGenerator::generate($rvm, new CodeGenerator(null));

      //echo FakeObjectGenerator::returnedCode();die();

        $classe = "class classe{
//timing
     private static \$times = array();
//Costants
//Magic methods
    public function __call(\$name, \$arguments) {
        return null;
    }
    public function __callStatic(\$name, \$arguments) {
        return null;
    }
//Methods
public function __construct()
{        \$rvm_pdefault = new ReturnValuesManager('pdefault');
        FakeObjectGenerator::generate(\$rvm_pdefault, new CodeGenerator(null));
}
    function metodo(){
        if(isset(self::\$times['metodo'])){
            self::\$times['metodo']++;
        }
        else{
            self::\$times['metodo'] = 1;
        }
switch (self::\$times['metodo']){
        case 1:
        return 'primo';
        break;
        default:         return new pdefault();
        }
    }
}";

        $this->assertEqual(FakeObjectGenerator::returnedCode(), $classe);
        $test_deault = new classe();
        $this->assertEqual($test_deault->metodo(), 'primo');
        $this->assertIsA($test_deault->metodo(), 'pdefault');
        $this->assertIsA($test_deault->metodo(), 'pdefault');
    }
}

?>
