<?php

include(dirname(__FILE__).'/../bootstrap/unit.php');
include(sfConfig::get('sf_plugins_dir').'/idProjectManagementPlugin/lib/test/idDoctrineTestBrowser.class.php');

$t = new lime_test(6, new lime_output_color());

// ->click()
$t->diag('->click()');
class myClickBrowser extends idDoctrineTestBrowser
{
  public function setHtml($html)
  {
    $this->dom = new DomDocument('1.0', 'UTF-8');
    $this->dom->validateOnParse = true;
    $this->dom->loadHTML($html);
  }

  public function getFiles()
  {
    $f = $this->files;
    $this->files = array();

    return $f;
  }

  public function call($uri, $method = 'get', $parameters = array(), $changeStack = true)
  {
    $uri = $this->fixUri($uri);

    $this->fields = array();

    return array($method, $uri, $parameters);
  }

  public function getDefaultServerArray($name)
  {
    return isset($this->defaultServerArray[$name]) ? $this->defaultServerArray[$name] : false;
  }

}

$html = <<<EOF
<html>
  <body>
    <form action="/myform" method="post">
      <select name="select">
        <option value="first">first</option>
        <option value="selected" selected="selected">selected</option>
        <option value="last">last</option>
      </select>
      <select name="select_multiple" multiple="multiple">
        <option value="first">first</option>
        <option value="selected" selected="selected">selected</option>
        <option value="last" selected="selected">last</option>
      </select>
      <select name="article[category]" multiple="multiple">
        <option value="1">1</option>
        <option value="2" selected="selected">2</option>
        <option value="3" selected="selected">3</option>
      </select>
      <input type="submit" name="submit" value="submit" />
    </form>

  </body>
</html>
EOF;

$b = new myClickBrowser();
$b->setHtml($html);


// ->deselect()/select()
$t->diag('->deSelectOption()');
list($method, $uri, $parameters) = $b->
  deSelectOption('select', 'selected')->
  click('submit')
;
$t->ok( $parameters['select'] == 'first', '->deSelectOption() deselect the specified option');

$t->diag('->deSelectOption()');
list($method, $uri, $parameters) = $b->
  deSelectOption('select_multiple', 'selected')->
  deSelectOption('select_multiple', 'last')->
  click('submit')
;
$t->is(isset($parameters['select_multiple']), 'first', '->deSelectOption() deselect the specified option');

$t->diag('->deSelectOption()');
list($method, $uri, $parameters) = $b->
  deSelectOption('article[category]', '2')->
  click('submit')
;

//var_dump($parameters['article']['category']);die();

$t->ok(array_search(3, $parameters['article']['category']) !== false, '->deSelectOption() leave selected option 3');
$t->is(array_search('2', $parameters['article']['category']), false, '->deSelectOption() deselect option 2');

try
{
  $t->diag('->deSelectOption() with empty value');
  $b->deSelectOption('article[category]', null);
  $t->fail('->deselect() cannot deselect empty option');
}
catch(Exception $e)
{
  $t->pass('->deselect() cannot deselect empty option');
}

try
{
  $t->diag('->deSelectOption() with empty value');
  $b->deSelectOption('article[category]', '5');
  $t->fail('->deselect() cannot deselect not existent option');
}
catch(Exception $e)
{
  $t->pass('->deselect() cannot deselect not existent option');
}