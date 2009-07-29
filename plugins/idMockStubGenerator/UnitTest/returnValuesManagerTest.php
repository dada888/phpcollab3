<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('../simpletest/autorun.php');
include('../lib/ReturnValuesManager.class.php');
include('../lib/DeclaredClass.class.php');

class returnValueManagerTest extends UnitTestCase {
    function FileTestCase() {
        $this->UnitTestCase('ReturnValueManager test');
    }

    //Test per setReturnArray

    function testSetReturnArray_should_return_the_returnValuesManager(){
        $rvm = new ReturnValuesManager('foo');
        $arr = array();
        $this->assertIsA($rvm->setReturnValuesArray('bar', $arr), 'ReturnValuesManager');
    }

    function testSetReturnArray_should_throw_an_exception_when_the_second_parameter_is_not_an_array(){
        $rvm = new ReturnValuesManager('foo');
        $this->expectException('Exception'); // E' giusto così????
        $rvm->setReturnValuesArray('bar', 1);
    }


    //test per SetReturnException

    function testSetReturnException_should_return_an_object_of_type_ReturnValuesManager(){
        $rvm = new ReturnValuesManager('foo');
        $returnValue = $rvm->setReturnException('bar', 'Exception', 'messaggio');
        $this->assertIsA($returnValue, 'ReturnValuesManager', 'Il metodo SetReturnException restituisce oggetto di tipo ReturnValuesManager');
    }
    

    function testSetReturnException_should_set_an_exception_to_be_returned_by_the_method_passed_in(){
        $rvm = new ReturnValuesManager('foo');
        $returnValue = $rvm->setReturnException('bar', 'Exception', 'messaggio');
        $this->assertEqual($returnValue->getException('bar'), array('name'=>'Exception','message'=>'messaggio'), 'Il metodo SetReturnException imposta una eccezione per uno specifico metodo.');
    }


    function testSetReturnException_should__return_an_exception_when_a_return_value_is_already_set_for_a_method(){
        $rvm = new ReturnValuesManager('foo');
        $returnValue = $rvm->setReturnException('bar', 'foo','message');
        $this->expectException('Exception'); // E' giusto così????
        $returnValue->setReturnException('bar', 'foo2','message');
    }

 
    //tes per SetReturnObject

    function testSetReturnObject_should_return_an_object_of_type_ReturnValuesManager(){
        $rvm = new ReturnValuesManager('foo');
        $returnValue = $rvm->setReturnObject('bar', 'foo');
        $this->assertIsA($returnValue, 'ReturnValuesManager');
    }

    function testSetReturnObject_should_set_an_object_to_be_returned_by_the_method_passed_in(){
        $rvm = new ReturnValuesManager('foo');
        $returnValue = $rvm->setReturnObject('bar', 'foo');
        $this->assertIsA($returnValue->getReturnValue('bar'), ReturnValuesManager);
    }

    function testSetReturnObject_should__return_an_exception_when_a_return_value_is_already_set_for_a_method(){
        $rvm = new ReturnValuesManager('foo');
        $returnValue = $rvm->setReturnObject('bar', 'foo');
        $this->expectException('Exception'); // E' giusto così????
        $returnValue->setReturnObject('bar', 'foo2');
    }


    //test per SetReturnValue

    function testSetReturnValue_should_return_an_object_of_type_ReturnValuesManager(){
        $rvm = new ReturnValuesManager('foo');
        $returnValue =  $rvm->setReturnValue($methodName, $value);
        $this->assertIsA($returnValue, 'ReturnValuesManager');
    }

    function testSetReturnValue_should_set_a_string_value_to_be_returned_by_the_method_passed_in(){
        $rvm = new ReturnValuesManager('foo');
        $returnValue =  $rvm->setReturnValue('bar', 'foo');
        $this->assertEqual('foo', $returnValue->getReturnValue('bar'));
    }

    function testSetReturnValue_should_set_a_numeric_value_to_be_returned_by_the_method_passed_in(){
        $rvm = new ReturnValuesManager('foo');
        $returnValue =  $rvm->setReturnValue('bar', 20.3);
        $this->assertEqual(20.3, $returnValue->getReturnValue('bar'));
    }

    function testSetReturnValue_should_set_a_boolean_value_to_be_returned_by_the_method_passed_in(){
        $rvm = new ReturnValuesManager('foo');
        $returnValue =  $rvm->setReturnValue('bar', true);
        $this->assertTrue($returnValue->getReturnValue('bar'));
    }

    function testSetReturnValue_should__return_an_exception_when_a_return_value_is_already_set_for_a_method(){
        $rvm = new ReturnValuesManager('foo');
        $returnValue =  $rvm->setReturnValue('bar', 12);
        $this->expectException('Exception'); // E' giusto così????
        $returnValue->setReturnValue('bar', 'foo');
    }


    //test per SetReturnValueWithInputParameter

    function test_setInputParameterForMethod_return_ReturnValueManager_any(){
        $rvm = new ReturnValuesManager('foo');
        $this->assertIsA($rvm->setInputParameterForMethod('bar', array(1,2,3)), ReturnValuesManager);
        $array_string = $rvm->getInputParameter('bar');
        $this->assertEqual($array_string, "array('0'=>1,'1'=>2,'2'=>3)");
        $this->assertEqual($rvm->getAllInputParameter('bar'), array('any'=>"array('0'=>1,'1'=>2,'2'=>3)"));
    }

    
    function test_setInputParameterForMethod_return_ReturnValueManager_at(){
        $rvm = new ReturnValuesManager('foo');
        $this->assertIsA($rvm->setInputParameterForMethod('bar', array(1,2,3), 1), ReturnValuesManager);
        $array_string = $rvm->getInputParameter('bar', 1);
        $this->assertEqual($array_string, "array('0'=>1,'1'=>2,'2'=>3)");
        $this->assertEqual($rvm->getAllInputParameter('bar'), array('1'=>"array('0'=>1,'1'=>2,'2'=>3)"));
    }


    //test per GetClassName

    function testGetClassName_should_return_the_name_of_the_class_set_when_ReturnValuesManager_is_created(){
        $rvm = new ReturnValuesManager('foo');
        $this->assertEqual('foo',$rvm->getClassName());
    }



    //test per GetException()

    function testGetException_should_throw_an_exception_when_called_on_an_unset_method(){
        $rvm = new ReturnValuesManager('foo');
        $this->expectException('Exception');
        $rvm->getException('unset');
    }


    //test per GetReturnObject

    function testGetReturnObject_should_throw_an_exception_when_called_on_an_unset_method(){
        $rvm = new ReturnValuesManager('foo');
        $this->expectException('Exception');
        $rvm->getReturnValue('unset');
    }


    //test per GetReturnValue

    function testGetReturnValue_should_throw_an_exception_when_called_on_an_unset_method(){
        $rvm = new ReturnValuesManager('foo');
        $this->expectException('Exception');
        $rvm->getReturnValue('unset');
    }


    //test per GetReturnValueArray

    function testGetReturnValueArray_should_return_an_array(){
        $rvm = new ReturnValuesManager('foo');
        $rvm->setReturnValue('bar', 'bar1')
        ->setReturnValue('bar2', 'bar3');
        $this->assertTrue(is_array($rvm->getReturnValueArray()));
    }


    function testGetReturnValueArray_any(){
        $rvm = new ReturnValuesManager('foo');
        $rvm->setReturnValue('bar', 'bar1')
        ->setReturnValue('bar2', 1);
        $this->assertEqual(array('bar'=>array('any'=>'bar1'),'bar2'=>array('any'=>1)), $rvm->getReturnValueArray());
    }

    function testGetReturnValueArray_at(){
        $rvm = new ReturnValuesManager('foo');
        $rvm->setReturnValue('bar', 'bar1',1)
        ->setReturnValue('bar2', 1,2);
        $this->assertEqual(array('bar'=>array('1' =>'bar1'),'bar2'=>array('2'=>1)), $rvm->getReturnValueArray());
    }


    //test per HasReturnValues

    function testHasReturnValues_should_return_true_when_at_leat_one_return_value_is_set(){
        $rvm = new ReturnValuesManager('foo');
        $rvm->setReturnValue('bar', 'hello');
        $this->assertTrue($rvm->hasReturnValues());
    }


    function testHasReturnValues_should_return_true_when_at_leat_one_exception_is_set(){
        $rvm = new ReturnValuesManager('foo');
        $rvm->setReturnException('bar', 'foo', 'message');
        $this->assertTrue($rvm->hasReturnValues());
    }

    function testHasReturnValues_sould_return_false_when_no_return_value_is_set(){
        $rvm = new ReturnValuesManager('foo');
        $this->assertFalse($rvm->hasReturnValues());
    }


    //test per isSetException()

    function testIsSetException_should_return_true_when_at_least_one_exception_is_set(){
        $rvm = new ReturnValuesManager('foo');
        $rvm->setReturnException('bar', 'foo', 'message');
        $this->assertTrue($rvm->isSetException('bar'));
    }


    function testIsSetException_should_return_false_when_no_exception_is_set(){
        $rvm = new ReturnValuesManager('foo');
        $this->assertFalse($rvm->isSetException('bar'));
    }


    //test per isSetReturnParameter


    function testhHasReturnValues_should_return_true_when_at_least_one_return_value_is_set(){
        $rvm = new ReturnValuesManager('foo');
        $rvm->setReturnValue('bar', 'foo');
        $this->assertTrue($rvm->hasReturnValues('bar'));
    }


    function testIsSetReturnParameter_should_return_true_when_at_least_one_exception_is_set(){
        $rvm = new ReturnValuesManager('foo');
        $rvm->setReturnException('bar', 'foo', 'message');
        $this->assertTrue($rvm->hasReturnValues('bar'));
    }


    function testIsSetReturnParameter_should_return_false_when_no_return_value_is_set(){
        $rvm = new ReturnValuesManager('foo');
        $this->assertFalse($rvm->hasReturnValues('bar'));
    }

    //test per getMethodsSet

    function testGetMethodsSet_should_return_an_array(){
        $rvm = new ReturnValuesManager('foo');
        $this->assertTrue(is_array($rvm->getMethodsSet()));
        $array = $rvm->getMethodsSet();
        $this->assertTrue(empty($array));
    }

    function testGetMethodsSet_should_return_an_array_of_string_that_represent_the_names_of_set_methods(){
        $rvm = new ReturnValuesManager('foo');
        $rvm->setReturnValue('bar', 'foo');
        $rvm->setReturnValue('bar2', 'foo2');
        $this->assertEqual(array('bar','bar2'), $rvm->getMethodsSet());
    }

    function test_cannot_declare_any_after_declaring_at(){
        $rvm = new ReturnValuesManager('foo');
        $rvm->setReturnValue('bar', 'foo',1)
        ->setReturnValue('bar', 'foo2',2);
        $this->expectException();
        $rvm->setReturnValue('bar', 'foo3');
    }


    function test_returnCodeForReturnValueManager_one_level(){
        $rvm = new ReturnValuesManager('test_4');
        $classe = "        \$rvm_test_4 = new ReturnValuesManager('test_4');\n";
        $this->assertEqual($classe, $rvm->returnCodeForReturnValueManager($rvm));
    }

    function test_returnCodeForReturnValueManager_one_two_level_with_parameter_and_redeclaring_class(){
        $rm1 = new ReturnValuesManager('test_1');
        $rm2 = new ReturnValuesMAnager('test_2');
        $rm3 = new ReturnValuesManager('test_3');
        $rm5 = new ReturnValuesMAnager('test_5');
        $rvm = new ReturnValuesManager('test_4');
        $rvm->setInputParameterForMethod('metodo_1', array('ciao',1,2,3))
        ->setInputParameterForMethod('metodo_2',array('a','b','d'),1)
        ->setInputParameterForMethod('metodo_2', array(1,2,3), 2)
        ->setReturnException('metodo_3', 'Exception', 'Eccezione ritornata')
        ->setReturnException('metodo_4', 'Exception', 'Eccezione at',2)
        ->setReturnObject('metodo_5', 'oggetto_nuovo')
        ->setReturnValue('metodo_7', 'ritorno')
        ->setReturnValue('metodo_8', false, 1)
        ->setReturnValuesArray('metodo_9', array('a',1,false,true,33))
        ->setReturnValuesArray('metodo_10', array('b',1,false,false,4), 3)
        ->setReturnObjectsArray('metodo_6', array($rm1, $rm2))
        ->setReturnObjectsArray('metodo_11', array($rm3, $rm5), 3);
        $rvm5 = $rvm->getReturnValue('metodo_5');
        $rvm5->setReturnObject('metodo_23', 'oggetto_nuovo_2');

        //echo $rvm->returnCodeForReturnValueManager($rvm);

        $classe = "        \$rvm_test_4 = new ReturnValuesManager('test_4');
        \$rvm_test_4->setInputParameterForMethod('metodo_1', array('0'=>'ciao','1'=>1,'2'=>2,'3'=>3));
        \$rvm_test_4->setInputParameterForMethod('metodo_2', array('0'=>'a','1'=>'b','2'=>'d'), 1);
        \$rvm_test_4->setInputParameterForMethod('metodo_2', array('0'=>1,'1'=>2,'2'=>3), 2);
        \$rvm_test_4->setReturnException('metodo_3', 'Exception', 'Eccezione ritornata');
        \$rvm_test_4->setReturnException('metodo_4', 'Exception', 'Eccezione at', 2);
        \$rvm_test_4->setReturnObject('metodo_5','oggetto_nuovo');
        \$rvm_oggetto_nuovo = \$rvm_test_4->getReturnValue('metodo_5');
        \$rvm_oggetto_nuovo->setReturnObject('metodo_23','oggetto_nuovo_2');
        \$rvm_test_4->setReturnValue('metodo_7', 'ritorno');
        \$rvm_test_4->setReturnValue('metodo_8', false, 1);
        \$rvm_test_4->setReturnValuesArray('metodo_9', array('0'=>'a','1'=>1,'2'=>false,'3'=>true,'4'=>33));
        \$rvm_test_4->setReturnValuesArray('metodo_10', array('0'=>'b','1'=>1,'2'=>false,'3'=>false,'4'=>4), 3);
        \$rvm_test_1 = new ReturnValuesManager('test_1');
        \$rvm_test_2 = new ReturnValuesManager('test_2');
        \$rvm_test_4->setReturnObjectsArray('metodo_6',array(\$rvm_test_1,\$rvm_test_2));
        \$rvm_test_3 = new ReturnValuesManager('test_3');
        \$rvm_test_5 = new ReturnValuesManager('test_5');
        \$rvm_test_4->setReturnObjectsArray('metodo_11',array(\$rvm_test_3,\$rvm_test_5), 3);\n";
        $this->assertEqual($classe, $rvm->returnCodeForReturnValueManager($rvm));
    }
}

?>
