<?php
/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * idDoctrineTestFunctional.class.php
 *
 * @package    phpCollab3
 * @subpackage idProjectManagmentPlugin Test
 */

/**
 * idDoctrineTestFunctional
 * 
 * Extends the standard sfTestFunctional class to add doctrine fixtures loading methods
 *
 * @package    phpCollab3
 * @subpackage idProjectManagmentPlugin Test
 * @author     Filippo (p16) De Santis <fd@ideato.it>
 */

class idDoctrineTestFunctional extends sfTestFunctional
{
  /**
   * Creates the commands for loading the fixture into the database for the test enviroment, and then it calls executeShellCommand for the created command.
   *
   * @access private
   */
  public function inizilizeDatabase()
  {
    $this->info('Loading fixtures');

    $command = "./symfony doctrine:drop-db --env=test --no-confirmation; ";
    $command .= "./symfony doctrine:build-db --env=test; ";
    $command .= "./symfony doctrine:build-sql --env=test; ";
    $command .= "./symfony doctrine:insert-sql --env=test; ";
    $command .= "./symfony doctrine:data-load --env=test --dir=test/fixtures/fixtures.yml";

    $this->executeShellCommand($command);

  }

  /**
   * Gets a command as string and call "exec" php function on it.
   * If the command return an error the method will throw an exception
   *
   * @param string $command
   */
  private function executeShellCommand($command)
  {
    $result = exec($command." 2>&1", $output, $error);
    if($error){
      throw new Exception('Error at [line '.__LINE__.'] of [file '.__FILE__.'] in loading fixtures : '.print_r($output));
    }
  }


  public function showPage()
  {
    $this->with('response')->begin()->
      debug()->
    end();

    return $this;
  }

}

?>
