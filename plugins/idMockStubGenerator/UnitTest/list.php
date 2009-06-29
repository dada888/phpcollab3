<?php return array('test_1' => array('methods' => array('prova_metodo')
, 'costants' => array(
)
, 'variables' => array(
)
, 'statics' => array(
)
),'test_2' => array('methods' => array('prova_metodo')
, 'costants' => array(
)
, 'variables' => array(
)
, 'statics' => array(
)
),'test_3' => array('methods' => array('prova_metodo')
, 'costants' => array(
)
, 'variables' => array(
)
, 'statics' => array(
)
),'test_4' => array('methods' => array('prova_metodo')
, 'costants' => array(
)
, 'variables' => array(
)
, 'statics' => array(
)
),'test_5' => array('methods' => array('prova_metodo')
, 'costants' => array(
)
, 'variables' => array(
)
, 'statics' => array(
)
),'test_6' => array('methods' => array('prova_metodo')
, 'costants' => array(
)
, 'variables' => array(
)
, 'statics' => array(
)
),'test_7' => array('methods' => array('prova_metodo')
, 'costants' => array(
)
, 'variables' => array(
)
, 'statics' => array(
)
),'test_8' => array('methods' => array('prova_metodo')
, 'costants' => array(
)
, 'variables' => array(
)
, 'statics' => array(
)
),'test_9' => array('methods' => array('prova_metodo')
, 'costants' => array(
)
, 'variables' => array(
)
, 'statics' => array(
)
),'test_10' => array('methods' => array('prova_metodo')
, 'costants' => array(
)
, 'variables' => array(
)
, 'statics' => array(
)
),'test_11' => array('methods' => array('prova_metodo')
, 'costants' => array(
)
, 'variables' => array(
)
, 'statics' => array(
)
),'test_12' => array('methods' => array('prova_metodo')
, 'costants' => array(
)
, 'variables' => array(
)
, 'statics' => array(
)
)
, '__database_schema__' => array(
'propel' => array(
'appuntamento' => array(
'id' => array(
'type' => 'INTEGER','required' => '1','autoIncrement' => '1','primaryKey' => '1'),'title' => array(
'type' => 'VARCHAR','size' => '255'),'description' => array(
'type' => 'LONGVARCHAR'),'created_at' => array(
'type' => 'TIMESTAMP'),'data' => array(
'type' => 'TIMESTAMP')),'partecipanti' => array(
'id' => array(
'type' => 'INTEGER','required' => '1','autoIncrement' => '1','primaryKey' => '1'),'appuntamento_id' => array(
'type' => 'INTEGER','required' => '1','primaryKey' => '1','foreignTable' => 'appuntamento','foreignReference' => 'id','onDelete' => 'cascade'),'firstname' => array(
'type' => 'VARCHAR','size' => '255'),'lastname' => array(
'type' => 'LONGVARCHAR'),'sex' => array(
'type' => 'VARCHAR','size' => '1'))))); ?>