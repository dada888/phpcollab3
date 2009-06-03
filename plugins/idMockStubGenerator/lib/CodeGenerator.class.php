<?php

/**
 * This file is part of the idMockStubGenerator
 * (c) 2009 Filippo (p16) De Santis <fd@ideato.it> & Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * CodeGenerator.class.php
 *
 * @package    idMockStubGenerator
 */

/**
 * Class that contains the concrete code that will be put in a class definition depending on the configuration of the ReturnValuesManager
 *
 * Manages fake class configuration
 *
 * @package    idMockStubGenerator
 * @author     Filippo (p16) De Santis <fd@ideato.it>
 */
class CodeGenerator{

    private $pathToList = null;

    /**
     * Returns the code for the new object of a certain class that will be the default value of a switch statement.
     *
     * @param ReturnValuesManager $valueManager
     * @return string
     */
    private function getCodeForCreatingClassForDefault(ReturnValuesManager $valueManager)
    {
       $returnCode .= "public function __construct()\n{";
       $returnCode .= $valueManager->returnCodeForReturnValueManager($valueManager);
       $returnCode .= "        FakeObjectGenerator::generate(\$rvm_".$valueManager->getClassName();
       $returnCode .= ", new CodeGenerator(";
       $returnCode .= !is_null($this->pathToList) ? "'".$this->pathToList."'));\n" : "null));\n";
       $returnCode .= "}\n";
       return $returnCode;
    }

    /**
     * Cnstructor
     * @param string $custom_list_path
     */
    public function __construct($custom_list_path = null){
        if (!is_null($custom_list_path) && is_file($custom_list_path))
        {
          $this->pathToList = $custom_list_path;
        }
    }

    /**
     * Returns the path for the file containing a list of classes and their characteristics.
     *
     * @return string
     */
    public function getPathToClassesMethodsList()
    {
      return $this->pathToList;
    }

    /**
     * Returns the code that will be used to verify that the input of the method it's the same as expected.
     *
     * @param array $input
     * @param string $methodName
     * @param mixed $at can be an integer or 'any'
     * @return string
     */
    public function generateCodeForInputParameter($input, $methodName, $at){
        $returnCode = "        \$input = ".$input.";\n";
        $returnCode .= "        \$args = func_get_args();\n";
        $returnCode .= "        \$index = 0;
        foreach (\$args as \$arg)
        {
          if(is_object(\$arg))
          {
            \$args[\$index] = 'class:'.get_class(\$arg);
          }
          \$index++;
        }\n";
        $returnCode .= "        \$diff = array_diff(\$input,\$args);\n";
        $returnCode .= "        if(!empty(\$diff)){ throw new Exception(\"Invalid input parameters. [method ".$methodName."] [input \".\$args.\"] [case $at]\");}\n";
        return $returnCode;
    }

    /**
     * Generates the code for throwing an exception
     *
     * @param array $exception
     * @return string
     */
    public function generateCodeForException($exception){
        return "        throw new ".$exception['name']."('".$exception['message']."');\n";
    }

    /**
     * Generate the code to return and array of value (NOT OBJECT)
     *
     * @param array $array
     * @return string
     */
    public function generateCodeForArrayOfValues($array){
        return "        return ".$array.";\n";
    }

    /**
     * Generate the code to return and array of objects (NOT VALUE as int,string,bool)
     *
     * @param array $array
     * @param string $method
     * @return string
     */
    public function generateCodeForArrayOfObjects($array, $method){
        $declared_classes_in_array = array();
        $arraycode = "array(";
        $returnCode = "";
        $primo = true;
        foreach($array as $rvm_object){
            if(!in_array($rvm_object->getClassName(), $declared_classes_in_array)){
              $declared_classes_in_array[] = $rvm_object->getClassName();
              try
              {
                $this->checkClassDeclared($rvm_object->getClassName());
                $returnCode .= $this->generateCodeForNewInnerObjects($rvm_object, $method);
              }
              catch(Exception $e)
              {
                $returnCode .= "        \$mock".strtolower($rvm_object->getClassName())." = new ".$rvm_object->getClassName()."();\n";
              }
            }

            if($primo){
                $arraycode .= "\$mock".strtolower($rvm_object->getClassName());
                $primo = false;
            }
            else{
                $arraycode .= ",\$mock".strtolower($rvm_object->getClassName());
            }

        }
        $arraycode .= ")";
        $returnCode .= "        return ".$arraycode.";\n";
        return $returnCode;
    }

    /**
     * Main method that generates the code for a redefined class
     *
     * @param ReturnValueManager $actual_value
     * @param string $method
     * @return string
     */
    public function generateMethodCode($actual_value, $method){
        //controllo che cosa devo restituire
        if($actual_value instanceof ReturnValuesManager){
            try
            {
              $this->checkClassDeclared($actual_value->getClassName());
              $code .= $this->generateCodeForNewInnerObjects($actual_value, $method);
            }
            catch (Exception $e){}

            $code .= "        return new ".$actual_value->getClassName()."();\n";
        }
        else if(isset($actual_value['_exception_']) && is_array($actual_value['_exception_'])){
            //Eccezione
            $code .= $this->generateCodeForException($actual_value['_exception_']);
        }
        else if(isset($actual_value['_value_']) && is_array($actual_value['_value_'])){
            //array di valori
            $code .= $this->generateCodeForArrayOfValues($actual_value['_value_'][0]);
        }
        else if(isset($actual_value['_objects_'])  && is_array($actual_value['_objects_'])){
            //array di oggetti
            $code .= $this->generateCodeForArrayOfObjects($actual_value['_objects_'], $method);
        }
        else if(is_numeric($actual_value)){
            //numero
            $code .= "        return ".$actual_value.";\n";
        }
        else if(is_bool($actual_value)){
            //boolean
            if($actual_value){
                $code .= "        return true;\n";
            }
            else {
                $code .= "        return false;\n";
            }
        }
        else if(is_string($actual_value)){
            //string
            $code .= "        return '".$actual_value."';\n";
        }
        else{
            $code .= "        return false;\n";
        }

        return $code;
    }

    /**
     * Generates the code used to check if a method has been called once or more
     *
     * @param string $methodName
     * @return string
     */
    public function generateCodeForTimingConfiguration($methodName){
        return "        if(isset(self::\$times['".$methodName."'])){
            self::\$times['".$methodName."']++;
        }
        else{
            self::\$times['".$methodName."'] = 1;
        }\n";
    }

    /**
     * Generate the code for an object that has to be return from a method of my redefined class.
     * This implicates a new class definition where needed (see returnCodeForReturnValueManager method of ReturnValuesManager)
     *
     * @param ReturnValuesManager $rm
     * @param string $method
     * @return string
     */
    public function generateCodeForNewInnerObjects($rm, $method){
        $returnCode = $rm->returnCodeForReturnValueManager($rm);
        $returnCode .= "        if(self::\$times['".$method."'] == 1){\n";
        $returnCode .= "        FakeObjectGenerator::generate(\$rvm_".$rm->getClassName();
        $returnCode .= ", new CodeGenerator(";
        $returnCode .= !is_null($this->pathToList) ? "'".$this->pathToList."'));\n" : "null));\n";
        $returnCode .= "        }\n";
        $returnCode .= "        \$mock".strtolower($rm->getClassName())." = new ".$rm->getClassName()."();\n";
        return $returnCode;
    }

    /**
     * Verify if a class has been already redeclared. If it is so, an exception is thrown
     *
     * @param string $classname
     */
    public function checkClassDeclared($classname){
        $declared_classes = get_declared_classes();
        if(in_array($classname, $declared_classes)){
            throw new Exception("Class ".$classname." already declared. You should use differente test to instantiate the same STATIC class.");
        }
    }

    /**
     * Generate the code for magic method "__call" that will intercept
     * all those calls to methods that are not defined throw the
     * ReturnValuesManager instance or listClassesMethods task.
     *
     * @return string
     */
    public function generateCodeForCallMagicMethod()
    {
      $code = "    public function __call(\$name, \$arguments) {
        return null;
    }
";
      $code .= "    public function __callStatic(\$name, \$arguments) {
        return null;
    }
";
      return $code;
    }
    
    /**
     * Run throw all the methods looking for a method with a default value.
     * If it is found, this method acts as a proxy for the private method that generate the code.
     *
     * @param ReturnValuesManager $returnValuesManager
     * @return string
     */
    public function returnGenerateClassForDefault(ReturnValuesManager $returnValuesManager)
    {
      $code = "";
      foreach ($returnValuesManager->getMethodsSet() as $method)
      {
        $return_values = $returnValuesManager->getReturnValueArray();
        if (isset($return_values[$method]['default']) && $return_values[$method]['default'] instanceof ReturnValuesManager){
          $code .= $this->getCodeForCreatingClassForDefault($return_values[$method]['default']);
        }
      }
      return $code;
    }

    /**
     * Generates the code that will be put in the default case of a switch.
     *
     * @param mixed $value
     * @param string $method
     * @return string
     */
    public function generateReturnDefault($value, $method)
    {
      return $value instanceof ReturnValuesManager ? "        return new ".$value->getClassName()."();\n" : $this->generateMethodCode($value, $method);
    }
}

?>