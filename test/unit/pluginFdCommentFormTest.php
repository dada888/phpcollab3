<?php

include(dirname(__FILE__).'/../bootstrap/unit.php');

$configuration = ProjectConfiguration::getApplicationConfiguration( 'fe', 'unittest', true);
$database_manager = new sfDatabaseManager($configuration);

$t = new lime_test(6, new lime_output_color());

try
{
  $form = new fdCommentForm();
  $t->fail('Creation of comment form without model and model_field');
}
catch(sfException $e)
{
  $t->pass('Catched exception when attempting to create a comment form without model and model_field');
}

try
{
  $form = new fdCommentForm(new fdComment());
  $t->fail('Creation of comment form without model and model_field');
}
catch(sfException $e)
{
  $t->pass('Catched exception when attempting to create a comment form without model_field');
}

try
{
  $form = new fdCommentForm(new fdComment(), 'pippolo_id', 1);
  $t->fail('Creation of comment form without model and model_field');
}
catch(sfException $e)
{
  $t->pass('Catched exception when attempting to create a comment form with a wrong model_field');
}

class prova {};

try
{
  $form = new fdCommentForm(null, 'id', 1);
  $t->fail('Creation of comment form without model and model_field');
}
catch(sfException $e)
{
  $t->pass('Catched exception when attempting to create a comment form without model');
}

try
{
  $form = new fdCommentForm(new prova(), 'id', 1);
  $t->fail('Creation of comment form without model and model_field');
}
catch(sfException $e)
{
  $t->pass('Catched exception when attempting to create a cooment form with a wrong model');
}

$form = new fdCommentForm(new fdComment(), 'id', 1);
$t->ok($form instanceof fdCommentForm, 'Valid construct');
