<?php

require_once('../simpletest/autorun.php');
include('../lib/FakeObjectGenerator.class.php');
include('../lib/DeclaredClass.class.php');

class fakeObjectGeneratorTest_deeper_level extends UnitTestCase {

    function test_returnJustGeneratedClass_return_object(){
        $rvm = new ReturnValuesManager('test_1');
        $rvm->setReturnObject('prova_metodo', 'test_2');

        FakeObjectGenerator::generate($rvm, new CodeGenerator(dirname(__FILE__).'/list.php'));

        $classe = "class test_1{
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
    function prova_metodo(){
        if(isset(self::\$times['prova_metodo'])){
            self::\$times['prova_metodo']++;
        }
        else{
            self::\$times['prova_metodo'] = 1;
        }
        \$rvm_test_2 = new ReturnValuesManager('test_2');
        if(self::\$times['prova_metodo'] == 1){
        FakeObjectGenerator::generate(\$rvm_test_2, new CodeGenerator('".dirname(__FILE__)."/list.php'));
        }
        \$mocktest_2 = new test_2();
        return new test_2();
    }
}";

        //echo FakeObjectGenerator::returnedCode();

        $this->assertEqual($classe, FakeObjectGenerator::returnedCode());
        $oggetto = new test_1();
        $this->assertIsA($oggetto->prova_metodo(), test_2);
    }


    function test_returnJustGeneratedClass_return_object_without_methods_list(){
        $rvm = new ReturnValuesManager('test_312432');
        $rvm->setReturnObject('prova_metodo', 'test_24892309');

        FakeObjectGenerator::generate($rvm, new CodeGenerator(null));

        $classe = "class test_312432{
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
    function prova_metodo(){
        if(isset(self::\$times['prova_metodo'])){
            self::\$times['prova_metodo']++;
        }
        else{
            self::\$times['prova_metodo'] = 1;
        }
        \$rvm_test_24892309 = new ReturnValuesManager('test_24892309');
        if(self::\$times['prova_metodo'] == 1){
        FakeObjectGenerator::generate(\$rvm_test_24892309, new CodeGenerator(null));
        }
        \$mocktest_24892309 = new test_24892309();
        return new test_24892309();
    }
}";

        $this->assertEqual($classe, FakeObjectGenerator::returnedCode());
        $oggetto = new test_1();
        $this->assertIsA($oggetto->prova_metodo(), test_2);
    }


    function test_returnJustGeneratedClass_return_objects_array_one_level_deep(){
        $rvm = new ReturnValuesManager('test_3');
        $rvm1 = new ReturnValuesManager('test_4');
        $rvm2 = new ReturnValuesManager('test_5');
        $rvm->setReturnObjectsArray('prova_metodo', array($rvm1,$rvm2));

        FakeObjectGenerator::generate($rvm, new CodeGenerator(dirname(__FILE__).'/list.php'));

        //echo FakeObjectGenerator::returnedCode();
        
        $classe = "class test_3{
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
    function prova_metodo(){
        if(isset(self::\$times['prova_metodo'])){
            self::\$times['prova_metodo']++;
        }
        else{
            self::\$times['prova_metodo'] = 1;
        }
        \$rvm_test_4 = new ReturnValuesManager('test_4');
        if(self::\$times['prova_metodo'] == 1){
        FakeObjectGenerator::generate(\$rvm_test_4, new CodeGenerator('".dirname(__FILE__)."/list.php'));
        }
        \$mocktest_4 = new test_4();
        \$rvm_test_5 = new ReturnValuesManager('test_5');
        if(self::\$times['prova_metodo'] == 1){
        FakeObjectGenerator::generate(\$rvm_test_5, new CodeGenerator('".dirname(__FILE__)."/list.php'));
        }
        \$mocktest_5 = new test_5();
        return array(\$mocktest_4,\$mocktest_5);
    }
}";
        $this->assertEqual($classe, FakeObjectGenerator::returnedCode());
        $oggetto = new test_3();
        $this->assertTrue(is_array($oggetto->prova_metodo()));
        $array = $oggetto->prova_metodo();
        $this->assertIsA($array[0], test_4);
        $this->assertIsA($array[1], test_5);
    }

    function test_returnJustGeneratedClass_return_objects_array_one_level_deep_without_methods_list(){
        $rvm = new ReturnValuesManager('test_33');
        $rvm1 = new ReturnValuesManager('test_44');
        $rvm2 = new ReturnValuesManager('test_55');
        $rvm->setReturnObjectsArray('prova_metodo', array($rvm1,$rvm2));

        FakeObjectGenerator::generate($rvm, new CodeGenerator(null));

        //echo FakeObjectGenerator::returnedCode();

        $classe = "class test_33{
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
    function prova_metodo(){
        if(isset(self::\$times['prova_metodo'])){
            self::\$times['prova_metodo']++;
        }
        else{
            self::\$times['prova_metodo'] = 1;
        }
        \$rvm_test_44 = new ReturnValuesManager('test_44');
        if(self::\$times['prova_metodo'] == 1){
        FakeObjectGenerator::generate(\$rvm_test_44, new CodeGenerator(null));
        }
        \$mocktest_44 = new test_44();
        \$rvm_test_55 = new ReturnValuesManager('test_55');
        if(self::\$times['prova_metodo'] == 1){
        FakeObjectGenerator::generate(\$rvm_test_55, new CodeGenerator(null));
        }
        \$mocktest_55 = new test_55();
        return array(\$mocktest_44,\$mocktest_55);
    }
}";
        $this->assertEqual($classe, FakeObjectGenerator::returnedCode());
        $oggetto = new test_33();
        $this->assertTrue(is_array($oggetto->prova_metodo()));
        $array = $oggetto->prova_metodo();
        $this->assertIsA($array[0], test_44);
        $this->assertIsA($array[1], test_55);
    }


    function test_returnJustGeneratedClass_return_objects_array_two_or_more_level_deep(){
        $rvm = new ReturnValuesManager('test_6');
        $rvm1 = new ReturnValuesManager('test_7');
        $rvm2 = new ReturnValuesManager('test_8');
        $rvm2->setReturnValue('prova_metodo', 'ritorno');
        $rvm->setReturnObjectsArray('prova_metodo', array($rvm1,$rvm2));

        FakeObjectGenerator::generate($rvm, new CodeGenerator(dirname(__FILE__).'/list.php'));

        $classe = "class test_6{
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
    function prova_metodo(){
        if(isset(self::\$times['prova_metodo'])){
            self::\$times['prova_metodo']++;
        }
        else{
            self::\$times['prova_metodo'] = 1;
        }
        \$rvm_test_7 = new ReturnValuesManager('test_7');
        if(self::\$times['prova_metodo'] == 1){
        FakeObjectGenerator::generate(\$rvm_test_7, new CodeGenerator('".dirname(__FILE__)."/list.php'));
        }
        \$mocktest_7 = new test_7();
        \$rvm_test_8 = new ReturnValuesManager('test_8');
        \$rvm_test_8->setReturnValue('prova_metodo', 'ritorno');
        if(self::\$times['prova_metodo'] == 1){
        FakeObjectGenerator::generate(\$rvm_test_8, new CodeGenerator('".dirname(__FILE__)."/list.php'));
        }
        \$mocktest_8 = new test_8();
        return array(\$mocktest_7,\$mocktest_8);
    }
}";
        $this->assertEqual($classe, FakeObjectGenerator::returnedCode());
        $oggetto = new test_6();
        $this->assertTrue(is_array($oggetto->prova_metodo()));
        $array = $oggetto->prova_metodo();
        $this->assertIsA($array[0], test_7);
        $this->assertIsA($array[1], test_8);
        $this->assertEqual('ritorno', $array[1]->prova_metodo());
    }

    function test_returnJustGeneratedClass_return_objects_array_two_or_more_level_deep_without_methods_list(){
        $rvm = new ReturnValuesManager('test_66');
        $rvm1 = new ReturnValuesManager('test_77');
        $rvm2 = new ReturnValuesManager('test_88');
        $rvm2->setReturnValue('prova_metodo', 'ritorno');
        $rvm->setReturnObjectsArray('prova_metodo', array($rvm1,$rvm2));

        FakeObjectGenerator::generate($rvm, new CodeGenerator(null));

        $classe = "class test_66{
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
    function prova_metodo(){
        if(isset(self::\$times['prova_metodo'])){
            self::\$times['prova_metodo']++;
        }
        else{
            self::\$times['prova_metodo'] = 1;
        }
        \$rvm_test_77 = new ReturnValuesManager('test_77');
        if(self::\$times['prova_metodo'] == 1){
        FakeObjectGenerator::generate(\$rvm_test_77, new CodeGenerator(null));
        }
        \$mocktest_77 = new test_77();
        \$rvm_test_88 = new ReturnValuesManager('test_88');
        \$rvm_test_88->setReturnValue('prova_metodo', 'ritorno');
        if(self::\$times['prova_metodo'] == 1){
        FakeObjectGenerator::generate(\$rvm_test_88, new CodeGenerator(null));
        }
        \$mocktest_88 = new test_88();
        return array(\$mocktest_77,\$mocktest_88);
    }
}";
        $this->assertEqual($classe, FakeObjectGenerator::returnedCode());
        $oggetto = new test_66();
        $this->assertTrue(is_array($oggetto->prova_metodo()));
        $array = $oggetto->prova_metodo();
        $this->assertIsA($array[0], test_77);
        $this->assertIsA($array[1], test_88);
        $this->assertEqual('ritorno', $array[1]->prova_metodo());
    }


    function test_timingConfigurationOnlyOncePerMethod(){
        $rvm = new ReturnValuesManager('test_9');
        $rvm_array = new ReturnValuesManager('test_10');
        $rvm->setReturnObject('prova_metodo','test_10',1)
        ->setReturnObjectsArray('prova_metodo', array($rvm_array, $rvm_array), 2);

        FakeObjectGenerator::generate($rvm, new CodeGenerator(dirname(__FILE__).'/list.php'));

        $classe = "class test_9{
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
    function prova_metodo(){
        if(isset(self::\$times['prova_metodo'])){
            self::\$times['prova_metodo']++;
        }
        else{
            self::\$times['prova_metodo'] = 1;
        }
switch (self::\$times['prova_metodo']){
        case 1:
        \$rvm_test_10 = new ReturnValuesManager('test_10');
        if(self::\$times['prova_metodo'] == 1){
        FakeObjectGenerator::generate(\$rvm_test_10, new CodeGenerator('".dirname(__FILE__)."/list.php'));
        }
        \$mocktest_10 = new test_10();
        return new test_10();
        break;
        case 2:
        \$rvm_test_10 = new ReturnValuesManager('test_10');
        if(self::\$times['prova_metodo'] == 1){
        FakeObjectGenerator::generate(\$rvm_test_10, new CodeGenerator('".dirname(__FILE__)."/list.php'));
        }
        \$mocktest_10 = new test_10();
        return array(\$mocktest_10,\$mocktest_10);
        break;
        default: return null;
        }
    }
}";

        $this->assertEqual($classe, FakeObjectGenerator::returnedCode());
        $oggetto = new test_9();
        $this->assertIsA($oggetto->prova_metodo(), test_10);
        $array = $oggetto->prova_metodo();
        $this->assertIsA($array[0], test_10);
        $this->assertIsA($array[1], test_10);

    }

    function test_timingConfigurationOnlyOncePerMethod_without_methods_list(){
        $rvm = new ReturnValuesManager('test_99');
        $rvm_array = new ReturnValuesManager('test_101');
        $rvm->setReturnObject('prova_metodo','test_101',1)
        ->setReturnObjectsArray('prova_metodo', array($rvm_array, $rvm_array), 2);

        FakeObjectGenerator::generate($rvm, new CodeGenerator(null));

        $classe = "class test_99{
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
    function prova_metodo(){
        if(isset(self::\$times['prova_metodo'])){
            self::\$times['prova_metodo']++;
        }
        else{
            self::\$times['prova_metodo'] = 1;
        }
switch (self::\$times['prova_metodo']){
        case 1:
        \$rvm_test_101 = new ReturnValuesManager('test_101');
        if(self::\$times['prova_metodo'] == 1){
        FakeObjectGenerator::generate(\$rvm_test_101, new CodeGenerator(null));
        }
        \$mocktest_101 = new test_101();
        return new test_101();
        break;
        case 2:
        \$rvm_test_101 = new ReturnValuesManager('test_101');
        if(self::\$times['prova_metodo'] == 1){
        FakeObjectGenerator::generate(\$rvm_test_101, new CodeGenerator(null));
        }
        \$mocktest_101 = new test_101();
        return array(\$mocktest_101,\$mocktest_101);
        break;
        default: return null;
        }
    }
}";

        $this->assertEqual($classe, FakeObjectGenerator::returnedCode());
        $oggetto = new test_99();
        $this->assertIsA($oggetto->prova_metodo(), test_101);
        $array = $oggetto->prova_metodo();
        $this->assertIsA($array[0], test_101);
        $this->assertIsA($array[1], test_101);

    }
}

?>
