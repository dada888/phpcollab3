<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class PluginTracker extends BaseTracker
{
  public function setUp()
  {
    parent::setUp();
    $this->addListener(new EventLogDoctrineListener());
  }
}
