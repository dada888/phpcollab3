<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class PluginMessage extends BaseMessage
{
  public function setUp()
  {
    parent::setUp();
    $this->addListener(new EventLogDoctrineListener());
  }
}