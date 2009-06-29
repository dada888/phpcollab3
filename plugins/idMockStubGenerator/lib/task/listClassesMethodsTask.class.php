<?php

class listClassesMethodsTask extends sfBaseTask
{
    private $methodsOfClasses;
    private $file = 'list.php';
    private $code;
    private $load_schema = false;
    private $notLoad = array();

    private $classnames=array();

  protected function configure()
  {
    $this->namespace        = 'test';
    $this->name             = 'listClassesMethods';
    $this->briefDescription = 'Creates a list of methods for each specified class.';
    $this->detailedDescription = <<<EOF
The [listClassesMethods|INFO] task creates a file in the test directory.
This file will cointain all the methods for the classes that are parsed by this task.
Each file should declare one class and the name of the file should be the same of the class.
Call it with:

  [php symfony listClassesMethods|INFO]
EOF;
    //$this->addOption('schema_type', null, sfCommandOption::PARAMETER_OPTIONAL, 'Schema type between xml(default) and yml', 'xml');
    //$this->addOption('reload_schema', null, sfCommandOption::PARAMETER_NONE, 'Reload the database schema');
    $this->addOption('class', null, sfCommandOption::PARAMETER_REQUIRED, 'A class (or a list of classes separaed by \",\") to be loaded', '');
    $this->addOption('reload_class', null, sfCommandOption::PARAMETER_OPTIONAL, 'Reload only the characteristics of the specified class (or list of classes separated by \",\" )', '');
    $this->addOption('remove_class', null, sfCommandOption::PARAMETER_OPTIONAL, 'Remove the characteristics of the specified class (or list of classes separated by \",\" )', '');
    $this->addOption('remove_all', null, sfCommandOption::PARAMETER_OPTIONAL, 'Remove all classes', '');
    //$this->addOption('dir_path', null, sfCommandOption::PARAMETER_OPTIONAL, 'Path to look for class files', '');
    //$this->addOption('type', null, sfCommandOption::PARAMETER_OPTIONAL , 'Model type (propel,doctrine)', 'propel');
    //$this->addOption('file_path', null, sfCommandOption::PARAMETER_OPTIONAL, 'Path to a single file containging a class (or classes)', '');
    //$this->addOption('recursive', null, sfCommandOption::PARAMETER_NONE, 'When a directory path is specified it will continued to searvh for php files in the subfolders');
    
  }

  protected function execute($arguments = array(), $options = array())
  {
      //TODO: Aggiungere un controllo sul fatto che non ci sia una classe denominata "__database_schema__";

      //Getting classes names
      if(file_exists(sfConfig::get('sf_test_dir')."/cache_method_list/".$this->file)){

          $this->logSection('listClassesMethods', sprintf("Loading list.php file.... \n") );

          $this->methodsOfClasses = include(sfConfig::get('sf_test_dir')."/cache_method_list/list.php");
          $this->classnames = array_keys($this->methodsOfClasses);
          $this->notLoad = $this->classnames;
      }

      if(isset($options['class']) && strlen($options['class']) > 0 ){
          $toLoad = split(",", trim($options['class']));
          foreach($toLoad as $class){
              $key = array_search($class, $this->classnames);
              if($key !== false){
                  $this->logSection('listClassesMethods', sprintf("Class ".$class." is already loaded. Use --reload_class=".$class.".\n") );
              }
              else{
                  $this->classnames[] = $class;
              }
          }
      }

      if(isset($options['reload_class']) && strlen($options['reload_class']) > 0 ){
          $toReload = split(",", trim($options['reload_class']));
          foreach($toReload as $class){
              $key = array_search($class, $this->notLoad);
              if($key !== false){
                  unset($this->notLoad[$key]);
              }
              else{
                  $this->classnames[] = $class;
                  $this->logSection('listClassesMethods', sprintf("Class ".$class." is not a loaded class.\n") );
              }
          }
      }

      if(isset($options['remove_class']) && strlen($options['remove_class']) > 0 ){
          $toReload = split(",", trim($options['remove_class']));
          foreach($toReload as $class){
              $key = array_search($class, $this->classnames);
              if($key !== false){
                  unset($this->classnames[$key]);
                  $this->logSection('listClassesMethods', sprintf("Class ".$class." has been removed.\n") );
              }
              else{
                  $this->logSection('listClassesMethods', sprintf("Class ".$class." has not been paserd so it won't be removed.\n") );
              }
          }
      }

      if(isset($options['remove_all']) && $options['remove_all'] == 'true'){
          $this->classnames = array();
          $this->write();
          $this->logSection('listClassesMethods', sprintf("All classes removed.\n") );
          return;
      }

      /*
      if(in_array('__database_schema__', $this->classnames)){
          if($options['reload_schema']){
              $this->logSection('listClassesMethods', sprintf("Re-Loading database schema...\n") );
              $this->methodsOfClasses['__database_schema__'] = $this->loadSchema($options);
              $this->load_schema = true;
          }
          else{
              $this->logSection('listClassesMethods', sprintf("Database schema already loaded...\n") );
          }
      }
      else{
          //loading schema
          $this->logSection('listClassesMethods', sprintf("Loading database schema for the first time...\n") );
          $this->methodsOfClasses['__database_schema__'] = $this->loadSchema($options);
          $this->load_schema = true;
      }
      if($key = array_search('__database_schema__', $this->classnames)){
        unset($this->classnames[$key]);
      }
      
      

      if($options['dir_path'] == null && $options['file_path'] == null){
          $this->logSection('listClassesMethods', sprintf('No path defined [use dir_path or file_path options]') );
      }
      else{
          if($options['dir_path'] != null){
              $this->browsDirectory($options);
          }

          if($options['file_path'] != null){
            require_once($options['file_path']);
            $classname = basename($options['file_path'], $this->modelTypes[$options['type']]['classFileSuffix']);
            if(!in_array($classname, $this->classnames)){
                $this->classnames[] = $classname;
            }
          }
      }
      */

      foreach($this->classnames as $classname){
          if(in_array($classname, $this->notLoad)){
              continue;
          }

          try{
              $rf = new ReflectionClass($classname);

              if($rf->isAbstract()){
                  $this->logSection('listClassesMethods', sprintf("Class ".$classname." (abstract) cannot be loaded.") );
                  $key = array_search($classname, $this->classnames);
                  unset($this->classnames[$key]);
                  continue;
              }

              $this->logSection('listClassesMethods', sprintf("Loading ".$classname."...\n") );

              //Getting methods of a class
              $methods = $rf->getMethods();
              $methodsNames = array();
              foreach($methods as $method){
                  $methodsNames[] = $method->getName();
              }
              $this->methodsOfClasses[$classname]['methods'] = $methodsNames;


              //If the class is a Peer it will be of the model so we need to know the table that it rapresents
              /*
              if(strpos($classname, "Peer") === false){
                  $sfAutoload = sfAutoload::getInstance();
                  $modelPeerClass = '';
                  if(strpos($classname, "Base") === false){
                      $modelPeerClass = $classname."Peer";
                  }
                  else{
                      $modelPeerClass = preg_replace('/Base/','',$classname,1)."Peer";
                  }

                  if($sfAutoload->autoload($modelPeerClass)){
                      $instance = new $modelPeerClass;
                      $this->methodsOfClasses[$classname]['idMethodsNames'] =$instance->getFieldNames(BasePeer::TYPE_PHPNAME);
                      $this->methodsOfClasses[$classname]['idDatabaseFields'] =$instance->getFieldNames(BasePeer::TYPE_FIELDNAME);
                  }
              }
              else{
                  $instance = new $classname;
                  $this->methodsOfClasses[$classname]['idMethodsNames'] =$instance->getFieldNames(BasePeer::TYPE_PHPNAME);
                  $this->methodsOfClasses[$classname]['idDatabaseFields'] =$instance->getFieldNames(BasePeer::TYPE_FIELDNAME);
              }
              */

              //we need the costant variables
              $costanti = $rf->getConstants();
              $this->methodsOfClasses[$classname]['costants'] = $costanti;


              //we need the public, private, static and protected variables
              $variables = $rf->getDefaultProperties();
              $statics = array_keys($rf->getStaticProperties());
              foreach($statics as $variable_name){
                    unset($variables[$variable_name]);
              }

              //We need variables (public, ptivate, protected)
              $this->methodsOfClasses[$classname]['variables'] = array_keys($variables);

              //we need static varable;
              $this->methodsOfClasses[$classname]['statics'] = $statics;
          }
          catch(ReflectionException $e){
               $this->logSection('listClassesMethods', sprintf("Class ".$classname." is not loaded by symfony / doesn't exist.") );
          }
      }
      
      $this->write();
  }


  private function loadSchema($options){
      if($options['schema_type'] == 'xml'){
        $sfPropelSchemaToYmlTask = new sfPropelSchemaToYmlTask($this->dispatcher, $this->formatter);
        $sfPropelSchemaToYmlTask->run();
        $ymlfile = sfYamlConfigHandler::parseYaml(sfConfig::get('sf_config_dir')."/schema.yml");
      }
      else if($options['schema_type'] == 'yml'){
        $ymlfile = sfYamlConfigHandler::parseYaml(sfConfig::get('sf_config_dir')."/schema.yml");
      }
      else{
          throw new Exception('Schema type not recognized.');
      }
      return $ymlfile;
  }


  private function browsDirectory($options = array()){
      if(is_dir($options['dir_path'])){
        $directoryContents = scandir($options['dir_path']);
        foreach($directoryContents as $filename){
            if($filename == "." || $filename == ".."){
                continue;
            }
            if(strpos($filename, $this->modelTypes[$options['type']]['classFileSuffix'])){
                $classname = str_replace($this->modelTypes[$options['type']]['classFileSuffix'],'',$filename);
                if(!in_array($classname, $this->classnames)){
                    $this->classnames[] = $classname;
                }
            }
            else if(is_dir($options['dir_path'].$filename."/") && $options['recursive']){
                $op = $options;
                $op['dir_path']=$options['dir_path'].$filename."/";
                $this->browsDirectory($op);
            }
        }
    }
    else{
        $this->logSection('listClassesMethods', sprintf('[ERROR] dir_path is not a directory...') );
    }
    }

    private function write(){

        $dir = sfConfig::get('sf_test_dir')."/cache_method_list";
        if(!file_exists($dir)){
            if(!mkdir($dir)){
                throw new Exception("It was impossible to create directory : ".$dir);
            }
        }
        

      //Writing code to represent the loaded classes
      $this->code = "<?php return array(";
      $prima = true;
      foreach($this->classnames as $classname){
          //writing class
          if($prima){
            $this->code .= "'$classname' => array('methods' => array(";
            $prima = false;
          }
          else{
            $this->code .= ",'$classname' => array('methods' => array(";
          }
          $primo = true;
          //writing methods
          $methods = $this->methodsOfClasses[$classname]['methods'];
          foreach($methods as $key => $method){
              if($primo){
                  $this->code .= "'".$method."'";
                  $primo = false;
              }
              else{
                  $this->code .= ",'".$method."'";
              }
          }
          $this->code .= ")\n";//chiudo l'array dei metodi

          //writing suffix of get and set methods
          if(!empty($this->methodsOfClasses[$classname]['idMethodsNames'])){
              $this->code .= ", 'idMethodsNames' => array(\n";//apro l'array degli identificativi dei campi nel database
              $idMethodsNames = $methods = $this->methodsOfClasses[$classname]['idMethodsNames'];
              $primo = true;
              foreach($idMethodsNames as $key => $idmethod){
                  if($primo){
                      $this->code .= "'".$idmethod."'";
                      $primo = false;
                  }
                  else{
                      $this->code .= ",'".$idmethod."'";
                  }
              }
              $this->code .= ")\n";//chiudo l'array degli idMetod
          }

          //writing table fields names
          if(!empty($this->methodsOfClasses[$classname]['idDatabaseFields'])){
              $this->code .= ", 'idDatabaseFields' => array(\n";//apro l'array degli identificativi dei campi nel database
              $idDatabaseFields = $methods = $this->methodsOfClasses[$classname]['idDatabaseFields'];
              $primo = true;
              foreach($idDatabaseFields as $key => $iddatabase){
                  if($primo){
                      $this->code .= "'".$iddatabase."'";
                      $primo = false;
                  }
                  else{
                      $this->code .= ",'".$iddatabase."'";
                  }
              }
              $this->code .= ")\n";//chiudo l'array degli idDatabase
          }

          //writing constants of the class
          $this->code .= ", 'costants' => array(\n";//apro l'array degli identificativi dei campi nel database
          $costants = $this->methodsOfClasses[$classname]['costants'];
          $primo = true;
          foreach($costants as $key => $costant){
              if($primo){
                  $this->code .= "'".$key."' => '".$costant."'";
                  $primo = false;
              }
              else{
                  $this->code .= ",'".$key."' => '".$costant."'";
              }
          }
          $this->code .= ")\n";//chiudo l'array degli costants

          //writing variables of the class
          $this->code .= ", 'variables' => array(\n";//apro l'array degli identificativi dei campi nel database
          $costants = $this->methodsOfClasses[$classname]['variables'];
          $primo = true;
          foreach($costants as $key => $costant){
              if($primo){
                  $this->code .= "'".$key."' => '".$costant."'";
                  $primo = false;
              }
              else{
                  $this->code .= ",'".$key."' => '".$costant."'";
              }
          }
          $this->code .= ")\n";//chiudo l'array degli variables

          $this->code .= ", 'statics' => array(\n";//apro l'array degli identificativi dei campi nel database
          $costants = $this->methodsOfClasses[$classname]['statics'];
          $primo = true;
          foreach($costants as $key => $costant){
              if($primo){
                  $this->code .= "'".$key."' => '".$costant."'";
                  $primo = false;
              }
              else{
                  $this->code .= ",'".$key."' => '".$costant."'";
              }
          }
          $this->code .= ")\n";//chiudo l'array degli statics
          
          //TODO: e le altre informazioni?? ci possono essere utili??
          $this->code .= ")\n";//chiudo l'array delle caratteristiche della


      }

      //writing database schema;
      if($this->load_schema || isset($this->methodsOfClasses['__database_schema__'])){
          $this->code .= ", '__database_schema__' => array(\n";//apro array schema
          $__database_schema__ = $this->methodsOfClasses['__database_schema__'];
          $database = array_keys($__database_schema__);
          $this->code .= "'".$database[0]."' => array(\n";//apro array database;
          $__database_schema__ = $__database_schema__[$database[0]];
          $primo_tabelle = true;
          foreach($__database_schema__ as $table => $fields){
              if($table == '_attributes'){
                  continue;
              }
              if($primo_tabelle){
                  $this->code .= "'".$table."' => array(\n";
                  $primo_tabelle = false;
              }
              else{
                  $this->code .= ",'".$table."' => array(\n";
              }
              $primo_campi = true;
              foreach($fields as $field => $charasteristics ){
                  if($primo_campi){
                      $this->code .= "'".$field."' => array(\n";
                      $primo_campi = false;
                  }
                  else{
                      $this->code .= ",'".$field."' => array(\n";
                  }
                  $primo_descrizione = true;
                  foreach($charasteristics as $description => $value){
                      if($primo_descrizione){
                        $this->code .= "'".$description."' => '".$value."'";
                        $primo_descrizione = false;
                      }
                      else{
                          $this->code .= ",'".$description."' => '".$value."'";
                      }
                  }
                  $this->code .= ")";//chiudo l'array della descrizione del campo della tabella
              }
              $this->code .= ")";//chiudo l'array dei campi della tabella
          }
          $this->code .= ")";//chiudo l'array della tabella
          $this->code .= ")";//chiudo l'array __database_schema__
      }

      $this->code .= "); ?>";//chiudo l'array delle classi


      $f = fopen(sfConfig::get('sf_test_dir')."/cache_method_list/".$this->file, w);
      if(!fwrite($f, $this->code)){
          fclose($f);
          throw new Exception("Cannot write on : ".sfConfig::get('sf_test_dir')."/cache_method_list/".$this->file);
      }
      fclose($f);

    }
}

?>

