<?php


class ReturnValuesManager{
    private $ClassName;
    private $ReturnValues = array();
    private $methodsSet = array();
    private $inputParameters=array();
    private $returnCodeBufferArray = array();

    /**
     * Costructor of the class. It takes as input the name of the class to be stubbed.
     *
     * @param string $className
     *
     */
    function ReturnValuesManager($className){
        $this->ClassName = $className;
    }

    /**
     * Checks if the ReturnValuesManager has values to return.
     *
     * @return boolean true if there are return values, false otherwise.
     * @access public
     */
    public function hasReturnValues(){
        return !empty($this->methodsSet);
    }

    /**
     *
     * @param string $methodName
     * @return array
     */
    public function methodReturnValues($methodName){
        return $this->ReturnValues[$methodName];
    }


    /**
     * Returns the name of the class which the return manager referes.
     *
     * @return string   class name
     * @access public
     */
    public function getClassName(){
        return $this->ClassName;
    }

    /**
     * Returns an array that describes the methods and the values that they have to return.
     *
     * @return array
     * @access public
     */
    public function getReturnValueArray(){
        return $this->ReturnValues;
    }

    /**
     * Sets the return value for a method.
     * It throws an exception when a return value has already been set for a method.
     *
     * @param string $methodName
     * @param mixed $value It can be a number or a string
     * @param int $at At which call it will be used this return value, if null it means that the method has to return always the same thing
     * @return ReturnValuesManager
     * @access public
     */
    public function setReturnValue($methodName, $value, $at = null){
        if($value === false){
            $this->returnValues($methodName, $at, false);
        }
        else{
            $this->returnValues($methodName, $at, $value);
        }
        $this->methodSet($methodName);
        return $this;
    }

    /**
     * Sets the return value of a method that has to return an object.
     * It throws an exception when a return value has already been set for a method.
     *
     * @param string $methodName
     * @param string $ChildClass
     * @param int $at At which call it will be used this return value, if null it means that the method has to return always the same thing
     * @return ReturnValuesManager
     * @access public
     */
    public function setReturnObject($methodName, $ChildClass, $at = null){
        $this->returnValues($methodName, $at, new ReturnValuesManager($ChildClass));
        $this->methodSet($methodName);
        return $this;
    }

    /**
     * Sets a method to return an exception when called.
     *
     * @param string $methodName
     * @param string $exceptionName
     * @param string $message
     * @param int $at At which call it will be used this return value, if null it means that the method has to return always the same thing
     * @return ReturnValuesManager
     * @access public
     */
    public function setReturnException($methodName, $exceptionName, $message, $at = null){
        $this->returnValues($methodName, $at, array('_exception_' => array('name'=>$exceptionName, 'message'=>$message)));
        $this->methodSet($methodName);
        return $this;
    }

    /**
     * Check if it has been set an excepotion for a method.
     * 
     * @deprecated
     * @param string $methodName
     * @return boolean
     * @access public
     */
    public function isSetException($methodName, $at = 'any'){
        return isset($this->ReturnValues[$methodName][$at]['_exception_']);
    }

    /**
     * Returns an array ['name' => ExceptionName, 'message' => exception message].
     *
     *
     * @deprecated
     * @param string $methodName
     * @return array
     * @access public
     */
    public function getException($methodName, $at = 'any'){
        if(isset($this->ReturnValues[$methodName][$at]['_exception_'])){
            return $this->ReturnValues[$methodName][$at]['_exception_'];
        }
        else{
            throw new Exception('No exception set for method '.$methodName);
        }
    }

    /**
     * Sets an array as return value for the specified method.
     * If the input paramet "at" is set, it specifies when the array will be returned.
     *
     * @param string $methodName
     * @param array $array
     * @param int $at At which call it will be used this return value, if null it means that the method has to return always the same thing
     * @return ReturnValuesManager
     */
    public function setReturnValuesArray($methodName, $array = array(), $at = null){
        if(!is_array($array)){
            throw new Exception('setReturnValuesArray cannot accept a second parameter that is not an array. ['.var_dump($array)."]");
        }
        $this->returnValues($methodName, $at, array('_value_' => array($this->arrayToCode($array))));
        $this->methodSet($methodName);
        return $this;
    }

    /**
     * Sets an array of Object specified by ReturnValueManager istances.
     * If the input paramet "at" is set, it specifies at which call the input parameters should be checked.
     *
     * @param string $methodName
     * @param array $returnValuesManagersForEachObject Array of ReturnValueManager istances that describe the objects that should be returned and their configuration
     * @param int $at At which call it will be used this return value, if null it means that the method has to return always the same thing
     * @return <type> 
     */
    public function setReturnObjectsArray($methodName, $returnValuesManagersForEachObject = array() , $at = null){
        if(empty($returnValuesManagersForEachObject)){
            throw new Exception('No ReturnValuesManager object in array.');
        }
        else{
            $this->returnValues($methodName, $at, array('_objects_' => $returnValuesManagersForEachObject ));
            $this->methodSet($methodName);
        }
        return $this;
    }

    /**
     * Sets the input parameter for the specified method.
     * If the input paramet "at" is set, it specifies at which call the input parameters should be checked.
     *
     * The input array can cointains reference to classes.
     * Example: array(1,2,3, 'hello', 'class:MyClass')
     *
     * This will set a check on the fifth parameter to be of the same class as specified after 'class:'
     *
     * @param string $methodName
     * @param array $inputParameter
     * @param int $at 
     * @return ReturnValuesManager
     */
    public function setInputParameterForMethod($methodName, $inputParameter = array(), $at = 'any'){
        $this->inputParameters[$methodName][$at] = $this->arrayToCode($inputParameter);
        $this->methodSet($methodName);
        return $this;
    }


    /**
     * Return true if a methods has specific input parameter at least for one of its calls.
     *
     * @param string $methodName
     * @return boolean
     */
    public function hasInputParameter($methodName){
        return isset($this->inputParameters[$methodName]);
    }

    /**
     * Returns the array that represent the input parametes specified for a method at a specific call
     *
     * @param string $methodName
     * @param int $at
     * @return array
     */
    public function getInputParameter($methodName, $at = 'any'){
        return $this->inputParameters[$methodName][$at];
    }

    /**
     * Return all the specified input parameter for a method
     *
     * @param String $methodName
     * @return array
     */
    public function getAllInputParameter($methodName){
        return $this->inputParameters[$methodName];
    }

    /**
     * Returns the "return value" of a method. It can be an object, a string or a number.
     *
     * @param string $methodName
     * @return mixed
     * @access public
     */
    public function getReturnValue($methodName, $at = 'any'){
        if(isset($this->ReturnValues[$methodName][$at])){
            return $this->ReturnValues[$methodName][$at];
        }
        else{
             throw new Exception('Requested a value/object that doesn\'t exist for method '.$methodName.' [at = '.$at.'].');
        }
    }

    /**
     * Check if it is set a return parameter for a method.
     *
     * @param string $methodName
     * @return boolean
     * @access public
     */
    public function isSetReturnValue($methodName, $at = 'any'){
        return isset($this->ReturnValues[$methodName][$at]);
    }

    public function isSetAtLeastOneReturnValue($methodName){
        return isset($this->ReturnValues[$methodName]);
    }

    /**
     * Returns an array of names of methods set with return values/objects/exceptions
     *
     * @return array
     */
    public function getMethodsSet(){
        return $this->methodsSet;
    }

    /**
     * Traslates an array of value (not object) into a string
     *
     * @param array $array
     * @return string
     */
    private function arrayToCode($array){
        $code = "array(";
        $c = 0;
        foreach($array as $key => $value){
            if($c>0){
                $code .= ",";
            }
            if(is_array($value)){
                $c++;
                $code .= "'".$key."'=>".$this->arrayToCode($value);
            }
            else if(is_numeric($value)){
                $c++;
                $code .= "'".$key."'=>".$value."";
            }
            else{
                $c++;
                if(is_bool($value)){
                    if($value){
                        $code .= "'".$key."'=>true";
                    }
                    else{
                        $code .= "'".$key."'=>false";
                    }
                }
                else{
                    $code .= "'".$key."'=>'".$value."'";
                }
            }
        }
        $code .= ")";
        return $code;
    }


    /**
     * Stores all the methods that are set
     *
     * @param string $methodName
     */
    private function methodSet($methodName){
        if(!in_array($methodName, $this->methodsSet)){
            $this->methodsSet[] = $methodName;
        }
    }

    /**
     * Sets the return value for a method at a specific call
     *
     * @param string $methodName
     * @param int $at
     * @param mixed $value
     */
    private function returnValues($methodName, $at, $value){
        if($at != null && (!is_int($at) || $at <= 0 )){
            throw new Exception('Return (value) parameter \"at\" has to be an integer > 0.');
        }
        else if(isset($this->ReturnValues[$methodName][$at]) || isset($this->ReturnValues[$methodName]['any'])
            || ($at == null && isset($this->ReturnValues[$methodName])) ){
            throw new Exception("Return value is already set for method ".$methodName." and call number ".$at.".\n");
        }

        /*
        if($value == null){
            $value = '';
        }
        */
        
        if($at == null){
            $this->ReturnValues[$methodName]['any'] = $value;
        }
        else{
            $this->ReturnValues[$methodName][$at] = $value;
        }
    }

    /**
     * Generates a string that describes as code a ReturnValuesManager object
     *
     * @param ReturnValuesManagers $rm
     * @param bool $first_level
     * @return string
     */
    public function returnCodeForReturnValueManager($rm, $first_level = true){
        $code = "";
        if($first_level){
            $code .= "        \$rvm_".$rm->ClassName." = new ReturnValuesManager('".$rm->ClassName."');\n";
        }
        if($this->hasReturnValues()){
            foreach($rm->getMethodsSet() as $method){
                if($rm->hasInputParameter($method)){
                    $input = $rm->getAllInputParameter($method);;
                    foreach($input as $at => $array){
                        if($at == 'any'){
                            $code .= "        \$rvm_".$rm->ClassName."->setInputParameterForMethod('".$method."', $array);\n";
                        }
                        else {
                            $code .= "        \$rvm_".$rm->ClassName."->setInputParameterForMethod('".$method."', $array, $at);\n";
                        }
                    }
                }
            }
            //non c'è nessun metodo settato, nenache solamente per i parametri di input
            foreach($rm->ReturnValues as $method => $ats){
                foreach($ats as $at => $value){
                    if($value instanceof ReturnValuesManager){
                        if($at == 'any'){
                            $code .= "        \$rvm_".$rm->ClassName."->setReturnObject('".$method."','$value->ClassName');\n";
                            if($value->hasReturnValues()){
                                $code .= "        \$rvm_".$value->ClassName." = \$rvm_".$rm->ClassName."->getReturnValue('".$method."');\n";
                                $code .= $this->returnCodeForReturnValueManager($value, false);
                            }
                        }
                        else{
                            $code .= "        \$rvm_".$rm->ClassName."->setReturnObject('".$method."','$value->ClassName', $at);\n";
                            if($value->hasReturnValues()){
                                $code .= "        \$rvm_".$value->ClassName." = \$rvm_".$rm->ClassName."->getReturnValue('".$method."', $at);\n";
                                $code .= $this->returnCodeForReturnValueManager($value, false);
                            }
                        }
                        //devi inserire la configurazione di questo nuovo oggetto
                    }
                    else if(isset($value['_exception_']) && is_array($value['_exception_'])){
                        //Eccezione
                        if($at == 'any'){
                            $code .= "        \$rvm_".$this->ClassName."->setReturnException('".$method."', '".$value['_exception_']['name']."', '".$value['_exception_']['message']."');\n";
                        }
                        else{
                            $code .= "        \$rvm_".$this->ClassName."->setReturnException('".$method."', '".$value['_exception_']['name']."', '".$value['_exception_']['message']."', $at);\n";
                        }
                    }
                    else if(isset($value['_value_']) && is_array($value['_value_'])){
                        //array di valori
                        if($at == 'any'){
                            $code .= "        \$rvm_".$this->ClassName."->setReturnValuesArray('".$method."', ".$value['_value_'][0].");\n";
                        }
                        else{
                            $code .= "        \$rvm_".$this->ClassName."->setReturnValuesArray('".$method."', ".$value['_value_'][0].", $at);\n";
                        }
                    }
                    else if(isset($value['_objects_'])  && is_array($value['_objects_'])){
                        $arraycode = "array(";
                        $primo=true;
                        foreach($value['_objects_'] as $rvm_object){
                            if($primo){
                                $arraycode .= "\$rvm_".$rvm_object->ClassName;
                                $primo = false;
                            }
                            else{
                                $arraycode .= ",\$rvm_".$rvm_object->ClassName;
                            }
                            $code .= "        \$rvm_".$rvm_object->ClassName." = new ReturnValuesManager('".$rvm_object->ClassName."');\n";
                            if($rvm_object->hasReturnValues()){
                                $code .= $this->returnCodeForReturnValueManager($rm, false);
                            }
                        }
                        $arraycode .= ")";
                        if($at == 'any'){
                            $code .= "        \$rvm_".$rm->ClassName."->setReturnObjectsArray('".$method."',$arraycode);\n";
                        }
                        else{
                            $code .= "        \$rvm_".$rm->ClassName."->setReturnObjectsArray('".$method."',$arraycode, $at);\n";
                        }
                    }
                    else if(is_numeric($value)){
                        //numero
                        if($at == 'any'){
                            $code .= "        \$rvm_".$this->ClassName."->setReturnValue('".$method."', ".$value.");\n";
                        }
                        else{
                            $code .= "        \$rvm_".$this->ClassName."->setReturnValue('".$method."', ".$value.", $at);\n";
                        }
                    }
                    else if(is_bool($value)){
                        //boolean
                        if($value){
                            if($at == 'any'){
                                $code .= "        \$rvm_".$this->ClassName."->setReturnValue('".$method."', true);\n";
                            }
                            else{
                                $code .= "        \$rvm_".$this->ClassName."->setReturnValue('".$method."', true, $at);\n";
                            }
                        }
                        else{
                            if($at == 'any'){
                                $code .= "        \$rvm_".$this->ClassName."->setReturnValue('".$method."', false);\n";
                            }
                            else{
                                $code .= "        \$rvm_".$this->ClassName."->setReturnValue('".$method."', false, $at);\n";
                            }
                        }
                    }
                    else if(is_string($value)){
                        //string
                        if($at == 'any'){
                            $code .= "        \$rvm_".$this->ClassName."->setReturnValue('".$method."', '".$value."');\n";
                        }
                        else{
                            $code .= "        \$rvm_".$this->ClassName."->setReturnValue('".$method."', '".$value."', $at);\n";
                        }
                    }
                    else{
                        //qualsiasi altra cosa è false!!
                        if($at == 'any'){
                            $code .= "        \$rvm_".$this->ClassName."->setReturnValue('".$method."', false);\n";
                        }
                        else{
                            $code .= "        \$rvm_".$this->ClassName."->setReturnValue('".$method."', false, $at);\n";
                        }
                    }
                }
            }
        }

        return $code;
    }

}
?>
