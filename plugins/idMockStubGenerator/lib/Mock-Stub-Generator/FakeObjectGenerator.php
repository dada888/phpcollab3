<?php

require_once('ReturnValuesManager.php');

/**
 * Class that contains the concrete code that will be put in a class definition depending on the configuration of the ReturnValuesManager
 */
class codeGenerator{

    private $pathToList;

    /**
     * Cnstructor
     * @param string $custom_list_path
     */
    function codeGenerator($custom_list_path){
        if (!is_null($custom_list_path))
        {
          $this->pathToList = $custom_list_path;
        }
    }

    /**
     * Returns the code that will be used to verify that the input of the method it's the same as expected.
     *
     * @param array $input
     * @param string $methodName
     * @param mixed $at can be an integer or 'any'
     * @return string
     */
    function generateCodeForInputParameter($input, $methodName, $at){
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
    function generateCodeForException($exception){
        return "        throw new ".$exception['name']."('".$exception['message']."');\n";
    }

    /**
     * Generate the code to return and array of value (NOT OBJECT)
     *
     * @param array $array
     * @return string
     */
    function generateCodeForArrayOfValues($array){
        return "        return ".$array.";\n";
    }

    /**
     * Generate the code to return and array of objects (NOT VALUE as int,string,bool)
     *
     * @param array $array
     * @param string $method
     * @return string
     */
    function generateCodeForArrayOfObjects($array, $method){
        $declared_classes_in_array = array();
        $arraycode = "array(";
        $returnCode = "";
        //$returnCode .= $this->generateCodeForTimingConfiguration($method);
        $primo = true;
        foreach($array as $rvm_object){
            if(!in_array($rvm_object->getClassName(), $declared_classes_in_array)){
              $declared_classes_in_array[] = $rvm_object->getClassName();
              $this->checkClassDeclared($rvm_object->getClassName());
              $returnCode .= $this->generateCodeForNewInnerObjects($rvm_object, $method);
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
    function generateMethodCode($actual_value, $method){
        //controllo che cosa devo restituire
        if($actual_value instanceof ReturnValuesManager){
            $this->checkClassDeclared($actual_value->getClassName());
            //$code .= $this->generateCodeForTimingConfiguration($method);
            $code .= $this->generateCodeForNewInnerObjects($actual_value, $method);
            $code .= "        return \$mock".strtolower($actual_value->getClassName()).";\n";
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
    function generateCodeForTimingConfiguration($methodName){
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
    function generateCodeForNewInnerObjects($rm, $method){
        $returnCode = $rm->returnCodeForReturnValueManager($rm);
        $returnCode .= "        if(self::\$times['".$method."'] == 1){\n";
        $returnCode .= "        FakeObjectGenerator::generate(\$rvm_".$rm->getClassName();
        $returnCode .= !is_null($this->pathToList) ? ", '".$this->pathToList."');\n" : ");\n";
        $returnCode .= "        }\n";
        $returnCode .= "        \$mock".strtolower($rm->getClassName())." = new ".$rm->getClassName()."();\n";
        return $returnCode;
    }

    /**
     * Verify if a class has been already redeclared. If it is so, an exception is thrown
     *
     * @param string $classname
     */
    function checkClassDeclared($classname){
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
    function generateCodeForCallMagicMethod()
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
}


/**
 * Main class for class redefinition
 */
class FakeObjectGenerator{

    private static $returnedCode;

    /**
     * Constructor
     */
    function __costructor(){
    }

    /**
     * Generate the definition of a class that has been analysed by listClassesMethodsTask
     *
     * @param mixed $arg This coukld be a string (the class' name) or a ReturnValuesManager object
     * @param string $custom_list_path optionl parameter
     * @return string eval(code of the faked class)
     */
    public static function generate($arg, $custom_list_path = null){
      
        $className = null;
        $returnValuesManager = null;

        if($arg == null){
            throw new Exception('Cannot generate a class without a name.');
        }
        else if($arg instanceof ReturnValuesManager){
            $returnValuesManager = $arg;
            $className = $returnValuesManager->getClassName();
        }
        else if(is_string($arg)){
            $className = $arg;
        }

        if($custom_list_path != null && is_file($custom_list_path)){
            $classesMethods = require($custom_list_path);
        }

        $codeGenerator = new codeGenerator($custom_list_path);

        $codeGenerator->checkClassDeclared($className);
        
        $code = "class ".$className."{\n"; //inizio il codice della classe fake


        $code .= "//timing\n ";
        $code .= "    private static \$times = array();\n";


        //inserisco le costanti se ci sono;
        $code .= "//Costants\n";
        $costants = isset($classesMethods[$className]['costants']) ? $classesMethods[$className]['costants'] : array();
        foreach($costants as $name => $value){
            if(is_numeric($value)){
                $code .= "    const ".$name." = ".$value.";\n";
            }
            else if(is_bool($value)){
                if($value === false){
                    $code .= "    const ".$name." = false;\n";
                }
                else{
                    $code .= "    const ".$name." = true;\n";
                }
            }
            else{
                $code .= "    const ".$name." = '".$value."';\n";
            }
        }

        //inserisco i metodi e cosa devono restituire
        $methods = $classesMethods[$className]['methods'];
        if (!is_null($returnValuesManager) && !empty($methods))
        {
          foreach ($returnValuesManager->getMethodsSet() as $method)
          {
            if(!in_array($method, $methods))
            {
              $methods[] = $method;
            }
          }
        }
        else
        {
          $methods = $returnValuesManager->getMethodsSet();
        }

        $code .= "//Magic methods\n";
        $code .= $codeGenerator->generateCodeForCallMagicMethod();

        if (!empty($methods))
        {
          $code .= "//Methods\n";
          foreach($methods as $name){
              $code .= "    function ".$name."(){\n";
              if($returnValuesManager != null){
                  //controllo se un metodo restituisce sempre la stessa cosa:
                  if($returnValuesManager->hasReturnValues()){
                      $returnValues = $returnValuesManager->methodReturnValues($name);

                      if(isset($returnValues['any'])){
                          $code .= $codeGenerator->generateCodeForTimingConfiguration($name);
                          if($returnValuesManager->hasInputParameter($name)){
                              $input = $returnValuesManager->getInputParameter($name);
                              $code .= $codeGenerator->generateCodeForInputParameter($input, $name, 'any');
                          }
                          //inserisco i valori di input obbligatori se ci sono
                          $code .= $codeGenerator->generateMethodCode($returnValues['any'], $name);
                      }
                      else if(!empty($returnValues)){
                          $code .= $codeGenerator->generateCodeForTimingConfiguration($name);
                          //Ci sono più valori da restituire a seconda del momento in cui si chiama un metodo
                          $ats = array_keys($returnValues);
                          $code .= "switch (self::\$times['".$name."']){\n";
                          foreach($ats as $at){
                              $code .= "        case ".$at.":\n";
                              //inserisco i valori di input obbligatori se ci sono
                              if($returnValuesManager->hasInputParameter($name, $at)){
                                  $input = $returnValuesManager->getInputParameter($methodName, $at);
                                  $code .= $codeGenerator->generateCodeForInputParameter($input, $name, $at);
                              }

                              $code .= $codeGenerator->generateMethodCode($returnValues[$at], $name);
                              $code .= "        break;\n";
                          }
                          $code .= "        default: return null;\n";
                          $code .= "        }\n";
                      }
                      else{
                          //devo solo controllare che ci sia un determinato input
                          if($returnValuesManager->hasInputParameter($name)){
                              $code .= $codeGenerator->generateCodeForTimingConfiguration($name);
                              if($input = $returnValuesManager->getInputParameter($name)){
                                  $code .= $codeGenerator->generateCodeForInputParameter($input, $name, 'any');
                              }
                              else{
                                  //$code .= $codeGenerator->generateCodeForTimingConfiguration($name);
                                  $ats = array_keys($returnValuesManager->getAllInputParameter($name));
                                  $code .= "switch (self::\$times['".$name."']){\n";
                                  foreach($ats as $at){
                                      $code .= "        case ".$at.":\n";
                                      //inserisco i valori di input obbligatori se ci sono
                                      if($input = $returnValuesManager->getInputParameter($name, $at)){
                                          $code .= $codeGenerator->generateCodeForInputParameter($input, $name, $at);
                                      }
                                      $code .= "        return null;\n";
                                      $code .= "        break;\n";
                                  }
                                  $code .= "        default: return null;\n";
                                  $code .= "        }\n";
                              }
                          }
                      }
                  }
                  else{
                      $code .= "        return null;\n";
                  }
              }
              else{
                  $code .= "        return null;\n";
              }

              $code .= "    }\n";
          }
        }

        $code .= "}";//fine del codice della classe fake

        self::$returnedCode = $code;

        return eval($code);
    }

    /**
     * Returns the generated code as a string
     *
     * @return string
     */
    public static function returnedCode(){
        return self::$returnedCode;
    }
    
}


?>
