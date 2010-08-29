<?php

include(dirname(__FILE__).'/../bootstrap/unit.php');
include(sfConfig::get('sf_plugins_dir').'/idMockStubGenerator/lib/FakeObjectGenerator.class.php');

FakeObjectGenerator::generate(new ReturnValuesManager('sfStorage'), new CodeGenerator());

$query_config = new ReturnValuesManager('Query');
$query_config->setReturnValue('execute', null);
FakeObjectGenerator::generate($query_config, new CodeGenerator());

$mockproject_config = new ReturnValuesManager('MockProject');
$mockproject_config->setReturnValue('getId', 1);
FakeObjectGenerator::generate($mockproject_config, new CodeGenerator());

class ProfileMock {
  public $projects;

  public function  __construct() {
     $this->projects = array(new MockProject());
  }
}

class myMockUserSecutiryClass {

  public $Profile;
  
  public function getGuardUser()
  {
    $this->Profile = new ProfileMock();
    return $this;
  }
}

$secuser_config = new ReturnValuesManager('sfGuardSecurityUser', 'myMockUserSecutiryClass');
$secuser_config->setReturnValue('isSuperAdmin', false, 1)
->setReturnValue('isSuperAdmin', false, 4)
->setReturnValue('isSuperAdmin', false, 7)
->setReturnValue('isSuperAdmin', false, 8)
->setReturnValue('isSuperAdmin', false, 9)
->setReturnValue('isSuperAdmin', false, 10)
->setReturnValue('isSuperAdmin', false, 11)
->setReturnValue('isSuperAdmin', false, 12)
->setReturnValue('isSuperAdmin', false, 13)
->setReturnValue('getId', 1)
->setReturnValueDefault('isSuperAdmin', true)
->setReturnValue('hasPermission', false, 4);
FakeObjectGenerator::generate($secuser_config, new CodeGenerator());

$issue_config = new ReturnValuesManager('Issue');
$issue_config->setReturnObject('getProject', 'ProjectMock');
$project_config = $issue_config->getReturnValue('getProject');
$project_config->setReturnValue('getId', 12, 1);
$project_config->setReturnValue('getId', 1, 2);
FakeObjectGenerator::generate($issue_config, new CodeGenerator());


include(dirname(__FILE__).'/../../apps/fe/lib/myUser.class.php');
$t = new lime_test(15, new lime_output_color());

$user = sfContext::createInstance(ProjectConfiguration::getApplicationConfiguration('fe', 'test', true))->getUser();

$t->is($user->isAdmin(), false, '->isAdmin() returns the right boolean');
$t->is($user->isAdmin(), true, '->isAdmin() returns the right boolean');
$t->is($user->isAdmin(), true, '->isAdmin() returns the right boolean');
$t->is($user->isAdmin(), false, '->isAdmin() returns the right boolean');

$t->is($user->getMyProjects(new Query()), null, '->getMyProject() returns null for not authenticated users');
$t->ok($user->getQueryForMyProjects() instanceof Doctrine_Query, '->getQueryForMyProjects() returns a Doctrine_Query object');

$t->is($user->isMyProject(2), true, '->isMyProject(2) returns true for admin users');
$t->is($user->isMyProject(2), false, '->isMyProject(2) returns false for unauthenticated users');

$t->is($user->isMyProjectByIssue(null), false, '->isMyProjectByIssue(null) returns false if no issue is passed ads input parameter');
$t->is($user->isMyProjectByIssue(new Issue()), false, '->isMyProjectByIssue(Issue) returns false if the issue is not one of my projects issues');

$t->is($user->isMyProject(1), false, '->isMyProject(1) returns true with the right project id');
$t->is($user->isMyProjectByIssue(new Issue()), false, '->isMyProjectByIssue(Issue) returns true if the right issue and project id');

$t->is($user->isMyProfile(1), true, '->isMyProject(1) returns true with the right project id');
$t->is($user->isMyProfile(2), false, '->isMyProject(2) returns false with the wrong project id');

$t->ok($user->getQueryForMyProjects() instanceof Doctrine_Query, '->getQueryForMyProjects() returns a Doctrine_Query object');
