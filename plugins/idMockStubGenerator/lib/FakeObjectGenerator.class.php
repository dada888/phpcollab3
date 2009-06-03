<?php

/**
 * This file is part of the idMockStubGenerator
 * (c) 2009 Filippo (p16) De Santis <fd@ideato.it> & Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * FakeObjectGenerator.class.php
 *
 * @package    idMockStubGenerator
 */


/**
 * Requires ReturnValuesManager.class.php
 */
require_once('ReturnValuesManager.class.php');

/**
 * Requires CodeGenerator.class.php
 */
require_once('CodeGenerator.class.php');

/**
 * Requires DeclaredClass.class.php
 */
require_once('DeclaredClass.class.php');

/**
 * FakeObjectGenerator
 *
 * Main class for class redefinition
 *
 * @package    idMockStubGenerator
 * @author     Filippo (p16) De Santis <fd@ideato.it>
 */
class FakeObjectGenerator{

    private static $returnedCode;
    private static $className = null;
    private static $extends = null;
    private static $implements = null;
    private static $returnValuesManager = null;
    private static $classesMethods = array();


    /**
     * Checks if the input parameter are correct and load the parsed classes if needed
     *
     * @param mixed $arg
     * @param string $custom_list_path
     */
    private static function checkInputArgs($arg, CodeGenerator $codeGenerator)
    {
      $custom_path = $codeGenerator->getPathToClassesMethodsList();

      self::$returnValuesManager = $arg instanceof ReturnValuesManager ? $arg : new ReturnValuesManager($arg, $custom_path);
      self::$className = self::$returnValuesManager->getClassName();
      self::$extends = self::$returnValuesManager->getExtends();
      self::$implements = self::$returnValuesManager->getImplements();

      self::$classesMethods = !is_null($custom_path) ? require($custom_path) : array();
    }

    /**
     * Generates the definition of a class that has been analysed by listClassesMethodsTask
     *
     * @param mixed $arg This coukld be a string (the class' name) or a ReturnValuesManager object
     * @param string $custom_list_path optionl parameter
     * @return string eval(code of the faked class)
     */
    public static function generate($arg, CodeGenerator $codeGenerator){

        self::checkInputArgs($arg, $codeGenerator);

        //$className = self::$className;
        //$returnValuesManager = self::$returnValuesManager;

        $codeGenerator->checkClassDeclared(self::$className);
        
        $code = "class ".self::$className;
        $code .= is_null(self::$extends) ? '' : " extends ".self::$extends;
        $code .= is_null(self::$implements) ? '' : " implements ".self::$implements;
        $code .= " {\n";

        $code .= "//timing\n ";
        $code .= "    private static \$times = array();\n";


        //inserisco le costanti se ci sono;
        $code .= "//Costants\n";
        $costants = isset(self::$classesMethods[self::$className]['costants']) ? self::$classesMethods[self::$className]['costants'] : array();
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
        $methods = self::$classesMethods[self::$className]['methods'];
        if (!is_null(self::$returnValuesManager) && !empty($methods))
        {
          foreach (self::$returnValuesManager->getMethodsSet() as $method)
          {
            if(!in_array($method, $methods))
            {
              $methods[] = $method;
            }
          }
        }
        else
        {
          $methods = self::$returnValuesManager->getMethodsSet();
        }

        $code .= "//Magic methods\n";
        $code .= $codeGenerator->generateCodeForCallMagicMethod();

        if (!empty($methods))
        {
          $code .= "//Methods\n";
          $code .= $codeGenerator->returnGenerateClassForDefault(self::$returnValuesManager);
          foreach($methods as $name){
              $code .= "    function ".$name."(){\n";
              if(self::$returnValuesManager != null){
                  //controllo se un metodo restituisce sempre la stessa cosa:
                  if(self::$returnValuesManager->hasReturnValues()){
                      $returnValues = self::$returnValuesManager->methodReturnValues($name);

                      if(isset($returnValues['any'])){
                          $code .= $codeGenerator->generateCodeForTimingConfiguration($name);
                          if(self::$returnValuesManager->hasInputParameter($name)){
                              $input = self::$returnValuesManager->getInputParameter($name);
                              $code .= $codeGenerator->generateCodeForInputParameter($input, $name, 'any');
                          }
                          //inserisco i valori di input obbligatori se ci sono
                          $code .= $codeGenerator->generateMethodCode($returnValues['any'], $name);
                      }
                      else if(!empty($returnValues)){
                          $code .= $codeGenerator->generateCodeForTimingConfiguration($name);
                          //Ci sono più valori da restituire a seconda del momento in cui si chiama un metodo
                          $default = null;
                          $ats = array_keys($returnValues);
                          $code .= "switch (self::\$times['".$name."']){\n";
                          foreach($ats as $at){
                              if ($at == 'default')
                              {
                                $default = $codeGenerator->generateReturnDefault($returnValues[$at], $name);
                                continue;
                              }
                              $code .= "        case ".$at.":\n";
                              //inserisco i valori di input obbligatori se ci sono
                              if(self::$returnValuesManager->hasInputParameter($name, $at)){
                                  $input = self::$returnValuesManager->getInputParameter($methodName, $at);
                                  $code .= $codeGenerator->generateCodeForInputParameter($input, $name, $at);
                              }

                              $code .= $codeGenerator->generateMethodCode($returnValues[$at], $name);
                              $code .= "        break;\n";
                          }
                          $code .= "        default: ";
                          $code .= $default != null ? $default : "return null;\n";
                          $code .= "        }\n";
                      }
                      else{
                          //devo solo controllare che ci sia un determinato input
                          if(self::$returnValuesManager->hasInputParameter($name)){
                              $code .= $codeGenerator->generateCodeForTimingConfiguration($name);
                              if($input = self::$returnValuesManager->getInputParameter($name)){
                                  $code .= $codeGenerator->generateCodeForInputParameter($input, $name, 'any');
                              }
                              else{
                                  $ats = array_keys(self::$returnValuesManager->getAllInputParameter($name));
                                  $code .= "switch (self::\$times['".$name."']){\n";
                                  foreach($ats as $at){
                                      $code .= "        case ".$at.":\n";
                                      //inserisco i valori di input obbligatori se ci sono
                                      if($input = self::$returnValuesManager->getInputParameter($name, $at)){
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
