<?php

include(dirname(__FILE__).'/../bootstrap/unit.php');
include(dirname(__FILE__).'/../../plugins/idRepositoryPlugin/lib/commands/GitLogFormat.class.php');
include(dirname(__FILE__).'/../../plugins/idMockStubGenerator/lib/Mock-Stub-Generator/FakeObjectGenerator.php');

$gitLogFormat = new GitLogFormat();

$gitLogFormat->setSeparator('|');
$gitLogFormat->setPrefix('prefix:');
$gitLogFormat->setSuffix('suffix');

$gitLogFormat->addPlaceholderCommitHash()
->addPlaceholderAbbreviatedCommitHash()
->addPlaceholderTreeHash()
->addPlaceholderAbbreviatedTreeHash()
->addPlaceholderParentHash()
->addPlaceholderAbbreviatedParentHash()
->addPlaceholderAuthorName()
->addPlaceholderAuthorEmail()
->addPlaceholderAuthorDateUnixTimestamp()
->addPlaceholderCommitterName()
->addPlaceholderCommitterEmail()
->addPlaceholderCommitterDateUnixTimestamp()
->addPlaceholderCommitterName()
->addPlaceholderEncoding()
->addPlaceholderSubject()
->addPlaceholderBody()
;

$t = new lime_test(4, new lime_output_color());
$t->diag('GitLogFormat');

$t->is($gitLogFormat->getLogFormat(), '"prefix:%H|%h|%T|%t|%P|%p|%an|%ae|%at|%cn|%ce|%ct|%cn|%e|%s|%b|suffix"', 'AddPlaceholder methods set the right values');

$t->is($gitLogFormat->getSeparator(), '|', '->getSeparator() returns the right values');

$t->ok(is_array($gitLogFormat->getAddedOptionsAsArray()), '->getAddedOptionsAsArray() returns an array');

$t->is(count($gitLogFormat->getAddedOptionsAsArray()), 16, '->getAddedOptionsAsArray() returns the right number of set elements');