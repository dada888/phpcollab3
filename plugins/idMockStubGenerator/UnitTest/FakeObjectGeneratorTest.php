<?php

require_once('../simpletest/autorun.php');
include('../lib/FakeObjectGenerator.class.php');
include('../lib/DeclaredClass.class.php');

class fakeObjectGeneratorTest extends UnitTestCase {


    function test_returnJustGeneratedClass(){
        $rvm = new ReturnValuesManager('test_1');
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
        return null;
    }
}";

        FakeObjectGenerator::generate($rvm, new CodeGenerator(dirname(__FILE__).'/list.php'));

      //echo FakeObjectGenerator::returnedCode();die();

        $this->assertEqual(FakeObjectGenerator::returnedCode(), $classe);
    }


    function test_returnClass_already_declared(){
        $rvm = new ReturnValuesManager('test_1');
        $this->expectException('Exception');
        FakeObjectGenerator::generate($rvm, new CodeGenerator(null));
    }

    function test_returnJustGeneratedClassWithInputParameter_any(){
        $rvm = new ReturnValuesManager('test_2');
        $rvm->setInputParameterForMethod('prova_metodo', array('ciao', 'faccia', 1,2,3,5));
        
        FakeObjectGenerator::generate($rvm,new CodeGenerator(dirname(__FILE__).'/list.php'));
        
        $classe = "class test_2{
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
        \$input = array('0'=>'ciao','1'=>'faccia','2'=>1,'3'=>2,'4'=>3,'5'=>5);
        \$args = func_get_args();
        \$index = 0;
        foreach (\$args as \$arg)
        {
          if(is_object(\$arg))
          {
            \$args[\$index] = 'class:'.get_class(\$arg);
          }
          \$index++;
        }
        \$diff = array_diff(\$input,\$args);
        if(!empty(\$diff)){ throw new Exception(\"Invalid input parameters. [method prova_metodo] [input \".\$args.\"] [case any]\");}
    }
}";

        $this->assertEqual($classe, FakeObjectGenerator::returnedCode());
        $oggetto = new test_2();
        $this->assertNull($oggetto->prova_metodo('ciao', 'faccia', 1,2,3,5));
        $this->expectException();
        $oggetto->prova_metodo();
        
    }

    function test_returnJustGeneratedClassWithInputParameter_any_but_not_parser_class(){
        $rvm = new ReturnValuesManager('classe');
        $rvm->setInputParameterForMethod('metodo_non_dichiarato', array('ciao', 'faccia', 1,2,3,5));

        FakeObjectGenerator::generate($rvm, new CodeGenerator(dirname(__FILE__).'/list.php'));

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
    function metodo_non_dichiarato(){
        if(isset(self::\$times['metodo_non_dichiarato'])){
            self::\$times['metodo_non_dichiarato']++;
        }
        else{
            self::\$times['metodo_non_dichiarato'] = 1;
        }
        \$input = array('0'=>'ciao','1'=>'faccia','2'=>1,'3'=>2,'4'=>3,'5'=>5);
        \$args = func_get_args();
        \$index = 0;
        foreach (\$args as \$arg)
        {
          if(is_object(\$arg))
          {
            \$args[\$index] = 'class:'.get_class(\$arg);
          }
          \$index++;
        }
        \$diff = array_diff(\$input,\$args);
        if(!empty(\$diff)){ throw new Exception(\"Invalid input parameters. [method metodo_non_dichiarato] [input \".\$args.\"] [case any]\");}
    }
}";

        $this->assertEqual($classe, FakeObjectGenerator::returnedCode());
        $oggetto = new classe();
        $this->assertNull($oggetto->metodo_non_dichiarato('ciao', 'faccia', 1,2,3,5));
    }


    function test_returnJustGeneratedClassWithInputParameter_at(){
        $rvm = new ReturnValuesManager('test_3');
        $rvm->setInputParameterForMethod('prova_metodo', array('ciao', 'faccia', 1,2,3,5), 2)
        ->setInputParameterForMethod('prova_metodo', array(6,7,8), 3);

        
        FakeObjectGenerator::generate($rvm, new CodeGenerator(dirname(__FILE__).'/list.php'));

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
switch (self::\$times['prova_metodo']){
        case 2:
        \$input = array('0'=>'ciao','1'=>'faccia','2'=>1,'3'=>2,'4'=>3,'5'=>5);
        \$args = func_get_args();
        \$index = 0;
        foreach (\$args as \$arg)
        {
          if(is_object(\$arg))
          {
            \$args[\$index] = 'class:'.get_class(\$arg);
          }
          \$index++;
        }
        \$diff = array_diff(\$input,\$args);
        if(!empty(\$diff)){ throw new Exception(\"Invalid input parameters. [method prova_metodo] [input \".\$args.\"] [case 2]\");}
        return null;
        break;
        case 3:
        \$input = array('0'=>6,'1'=>7,'2'=>8);
        \$args = func_get_args();
        \$index = 0;
        foreach (\$args as \$arg)
        {
          if(is_object(\$arg))
          {
            \$args[\$index] = 'class:'.get_class(\$arg);
          }
          \$index++;
        }
        \$diff = array_diff(\$input,\$args);
        if(!empty(\$diff)){ throw new Exception(\"Invalid input parameters. [method prova_metodo] [input \".\$args.\"] [case 3]\");}
        return null;
        break;
        default: return null;
        }
    }
}";

        $this->assertEqual($classe, FakeObjectGenerator::returnedCode());
        $oggetto = new test_3();
        $this->assertNull($oggetto->prova_metodo('ciao'));
        $this->assertNull($oggetto->prova_metodo('ciao', 'faccia', 1,2,3,5));
        $this->expectException('Exception');
        $oggetto->prova_metodo('porca');
    }

    function test_returnJustGeneratedClass_return_exception_any(){
        $rvm = new ReturnValuesManager('test_4');
        $rvm->setReturnException('prova_metodo', 'Exception', 'eccezione sollevata');

        FakeObjectGenerator::generate($rvm, new CodeGenerator(dirname(__FILE__).'/list.php'));

        $classe = "class test_4{
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
        throw new Exception('eccezione sollevata');
    }
}";

        $this->assertEqual($classe, FakeObjectGenerator::returnedCode());
        $this->expectException('Exception');
        $oggetto = new test_4();
        $oggetto->prova_metodo();
    }

    function test_returnJustGeneratedClass_return_exception_at(){
        $rvm = new ReturnValuesManager('test_11');
        $rvm->setReturnException('prova_metodo', 'Exception', 'eccezione sollevata 1',1)
        ->setReturnException('prova_metodo', 'Exception', 'eccezione sollevata 2',2);

        FakeObjectGenerator::generate($rvm, new CodeGenerator(dirname(__FILE__).'/list.php'));

        $classe = "class test_11{
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
        throw new Exception('eccezione sollevata 1');
        break;
        case 2:
        throw new Exception('eccezione sollevata 2');
        break;
        default: return null;
        }
    }
}";

        $this->assertEqual(FakeObjectGenerator::returnedCode(), $classe);
        $this->expectException('Exception');
        $oggetto = new test_4();
        $oggetto->prova_metodo();
    }


    function test_returnJustGeneratedClass_return_value_any(){
        $rvm = new ReturnValuesManager('test_7');
        $rvm->setReturnValue('prova_metodo', 'tornato');

        FakeObjectGenerator::generate($rvm, new CodeGenerator(dirname(__FILE__).'/list.php'));

        $classe = "class test_7{
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
        return 'tornato';
    }
}";
        $this->assertEqual($classe, FakeObjectGenerator::returnedCode());
        $oggetto = new test_7();
        $this->assertEqual('tornato', $oggetto->prova_metodo());
    }


    function test_returnJustGeneratedClass_return_value_at(){
        $rvm = new ReturnValuesManager('test_8');
        $rvm->setReturnValue('prova_metodo', 1,1)
        ->setReturnValue('prova_metodo', 'ciao',2)
        ->setReturnValue('prova_metodo', false,3)
        ->setReturnValue('prova_metodo', true,4);


        FakeObjectGenerator::generate($rvm, new CodeGenerator(dirname(__FILE__).'/list.php'));

        $classe = "class test_8{
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
        return 1;
        break;
        case 2:
        return 'ciao';
        break;
        case 3:
        return false;
        break;
        case 4:
        return true;
        break;
        default: return null;
        }
    }
}";
        $this->assertEqual($classe, FakeObjectGenerator::returnedCode());
        $oggetto = new test_8();
        $this->assertEqual(1, $oggetto->prova_metodo());
        $this->assertEqual('ciao', $oggetto->prova_metodo());
        $this->assertFalse($oggetto->prova_metodo());
        $this->assertTrue($oggetto->prova_metodo());
        $this->assertNull($oggetto->prova_metodo());

    }


    function test_returnJustGeneratedClass_return_array_any(){
        $rvm = new ReturnValuesManager('test_9');
        $rvm->setReturnValuesArray('prova_metodo', array(1,2,3,'prova'=>'provolone', false, true));
        
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
        return array('0'=>1,'1'=>2,'2'=>3,'prova'=>'provolone','3'=>false,'4'=>true);
    }
}";
        $this->assertEqual($classe, FakeObjectGenerator::returnedCode());
    }


    function test_returnJustGeneratedClass_return_array_at(){
        $rvm = new ReturnValuesManager('test_10');
        $rvm->setReturnValuesArray('prova_metodo', array(1,2,3,'prova'=>'provolone', false, true), 1)
        ->setReturnValuesArray('prova_metodo', array(1,'pippo'), 2)
        ->setReturnValuesArray('prova_metodo', array('prova'=>'provolone', true), 3);


        FakeObjectGenerator::generate($rvm, new CodeGenerator(dirname(__FILE__).'/list.php'));

        $classe = "class test_10{
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
        return array('0'=>1,'1'=>2,'2'=>3,'prova'=>'provolone','3'=>false,'4'=>true);
        break;
        case 2:
        return array('0'=>1,'1'=>'pippo');
        break;
        case 3:
        return array('prova'=>'provolone','0'=>true);
        break;
        default: return null;
        }
    }
}";
        $this->assertEqual($classe, FakeObjectGenerator::returnedCode());
        $oggetto = new test_10();
        $this->assertEqual(array(1,2,3,'prova'=>'provolone', false, true), $oggetto->prova_metodo());
        $this->assertEqual(array(1,'pippo'), $oggetto->prova_metodo());
        $this->assertEqual(array('prova'=>'provolone', true), $oggetto->prova_metodo());

    }



    function test_returnJustGeneratedClassWithInputParameter_any_input_accept_object(){
        $rvm = new ReturnValuesManager('Instance');
        FakeObjectGenerator::generate($rvm, new CodeGenerator(null));

        $rvm = new ReturnValuesManager('test_222');
        $rvm->setInputParameterForMethod('prova_metodo', array('ciao', 'faccia', 1,2,3,5, 'class:Instance'));

        FakeObjectGenerator::generate($rvm, new CodeGenerator(null));

        $classe = "class test_222{
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
        \$input = array('0'=>'ciao','1'=>'faccia','2'=>1,'3'=>2,'4'=>3,'5'=>5,'6'=>'class:Instance');
        \$args = func_get_args();
        \$index = 0;
        foreach (\$args as \$arg)
        {
          if(is_object(\$arg))
          {
            \$args[\$index] = 'class:'.get_class(\$arg);
          }
          \$index++;
        }
        \$diff = array_diff(\$input,\$args);
        if(!empty(\$diff)){ throw new Exception(\"Invalid input parameters. [method prova_metodo] [input \".\$args.\"] [case any]\");}
    }
}";

        $this->assertEqual($classe, FakeObjectGenerator::returnedCode());
        $oggetto = new test_222();
        $this->assertNull($oggetto->prova_metodo('ciao', 'faccia', 1,2,3,5, new Instance()));
        $this->expectException();
        $oggetto->prova_metodo('ciao', 'faccia', 1,2,3,5);

    }

    function test_returnJustGeneratedClassWithInputParameter_at_with_object_input(){
        $rvm = new ReturnValuesManager('Instance2');
        FakeObjectGenerator::generate($rvm, new CodeGenerator(null));
      
        $rvm = new ReturnValuesManager('test_333');
        $rvm->setInputParameterForMethod('prova_metodo', array('ciao', 'faccia', 1,2,3,5, 'class:Instance2'), 2)
        ->setInputParameterForMethod('prova_metodo', array(6,7,8, 'class:Instance2'), 3);

        
        FakeObjectGenerator::generate($rvm, new CodeGenerator(null));

        $classe = "class test_333{
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
        case 2:
        \$input = array('0'=>'ciao','1'=>'faccia','2'=>1,'3'=>2,'4'=>3,'5'=>5,'6'=>'class:Instance2');
        \$args = func_get_args();
        \$index = 0;
        foreach (\$args as \$arg)
        {
          if(is_object(\$arg))
          {
            \$args[\$index] = 'class:'.get_class(\$arg);
          }
          \$index++;
        }
        \$diff = array_diff(\$input,\$args);
        if(!empty(\$diff)){ throw new Exception(\"Invalid input parameters. [method prova_metodo] [input \".\$args.\"] [case 2]\");}
        return null;
        break;
        case 3:
        \$input = array('0'=>6,'1'=>7,'2'=>8,'3'=>'class:Instance2');
        \$args = func_get_args();
        \$index = 0;
        foreach (\$args as \$arg)
        {
          if(is_object(\$arg))
          {
            \$args[\$index] = 'class:'.get_class(\$arg);
          }
          \$index++;
        }
        \$diff = array_diff(\$input,\$args);
        if(!empty(\$diff)){ throw new Exception(\"Invalid input parameters. [method prova_metodo] [input \".\$args.\"] [case 3]\");}
        return null;
        break;
        default: return null;
        }
    }
}";

        $this->assertEqual($classe, FakeObjectGenerator::returnedCode());
        $oggetto = new test_333();
        $this->assertNull($oggetto->prova_metodo('ciao'));
        $this->assertNull($oggetto->prova_metodo('ciao', 'faccia', 1,2,3,5,new Instance2()));
        $this->expectException('Exception');
        $oggetto->prova_metodo(new Instance2());
    }

}

?>
