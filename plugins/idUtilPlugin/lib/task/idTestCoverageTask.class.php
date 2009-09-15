<?php
class idTestCoverageTask extends sfTestCoverageTask
{
  protected function configure()
  {
    parent::configure();

    $this->addOptions(array(
      new sfCommandOption('exclude_files', null, sfCommandOption::PARAMETER_OPTIONAL, 'Output detailed information'),
    ));

    $this->namespace = 'phpCollab';
    $this->name = 'coverage';
    $this->briefDescription = 'Outputs test code coverage';

    $this->detailedDescription = <<<EOF
The [test:coverage|INFO] task outputs the code coverage
given one or more test files or test directories
and one or more lib files or lib directories for which you want code
coverage:

  [./symfony test:coverage test/unit/model[,test/functional/fe[,test/whatever]] lib/model[,plugin/myPlugin/lib[,apps/fe/modules/mymodule]]|INFO]

To output the lines not covered, pass the [--detailed|INFO] option:

  [./symfony test:coverage --detailed test/unit/model[,test/functional/fe[,test/whatever]] lib/model[,plugin/myPlugin/lib[,apps/fe/modules/mymodule]]|INFO]
EOF;
  }


  protected function excludeFiles($coveredFiles, $exclude)
  {
    $eclude_files = $this->idFindFilesFromArgument($exclude);
    return array_diff($coveredFiles, $eclude_files);
  }

  protected function execute($arguments = array(), $options = array())
  {
    require_once(sfConfig::get('sf_symfony_lib_dir').'/vendor/lime/lime.php');

    $coverage = $this->getCoverage($this->getTestHarness(), $options['detailed']);

    $testFiles = $this->idFindFilesFromArgument($arguments['test_name']);

    $max = count($testFiles);
    foreach ($testFiles as $i => $file)
    {
      $this->logSection('coverage', sprintf('running %s (%d/%d)', $file, $i + 1, $max));
      $coverage->process($file);
    }

    $coveredFiles = $this->idFindFilesFromArgument($arguments['lib_name']);
    $coveredFiles = $this->excludeFiles($coveredFiles, $options['exclude_files']);

    $coverage->output($coveredFiles);
  }

  protected function idFindFilesFromArgument($argument)
  {
    $test_names = explode(',', $argument);
    $test_names = is_array($test_names) ? $test_names : array($test_names);

    $results = array();
    foreach ($test_names as $test_name)
    {
      $files = $this->getFiles(sfConfig::get('sf_root_dir').'/'.$test_name);
      if (is_array($files))
      {
        $results = array_merge($results, $files);
        continue;
      }
      $results[] = $files;
    }
    return $results;
  }
}