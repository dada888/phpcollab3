<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());

$browser->
  get('/fr')->
    with('response')->begin()->
      isStatusCode(404)->
    end()->


  get('/en')->
    with('response')->begin()->
      isStatusCode(401)->
    end()->


  get('/it')->
    with('response')->begin()->
      isStatusCode(401)->
    end()->


  get('/sfGuardUser')->
    with('response')->begin()->
      isStatusCode(404)->
    end();