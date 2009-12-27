<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of idTestAllTask
 *
 * @author filo
 */

class idTestAllTask extends sfTestAllTask
{
  /**
   * @see sfTask
   */
  protected function configure()
  {
    $this->aliases = array('phpCollab-test-all');
    $this->namespace = 'phpCollab';
    $this->name = 'testAll';
    $this->briefDescription = 'Launches all tests and keep trace of the time';

    $this->detailedDescription = <<<EOF
The [test:all|INFO] task launches all unit and functional tests:

  [./symfony phpCollab:testAll|INFO]

The task launches all tests found in [test/|COMMENT].

If one or more test fail, you can try to fix the problem by launching
them by hand or with the [test:unit|COMMENT] and [test:functional|COMMENT] task.
EOF;
  }

  /**
   * @see sfTask
   */
  protected function execute($arguments = array(), $options = array())
  {
    $timer = new sfTimer();
    $timer->startTimer();
    $this->logSection('Timer started: ', '...');
    
    $result = parent::execute($arguments, $options);
    
    $this->logSection('Time: ', $timer->addTime()/60);

    return $result;
  }
}
