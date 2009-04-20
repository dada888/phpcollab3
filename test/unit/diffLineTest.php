<?php
include(dirname(__FILE__).'/../bootstrap/unit.php');
include(dirname(__FILE__).'/../../plugins/idRepositoryPlugin/lib/fileHandler/DiffLine.class.php');

$t = new lime_test(25, new lime_output_color());

$line1 = "+prova right\n";
$line2 = "-prova left\n";
$line3 = " prova equal\n";
$line_block = "@@ -1,6 +1,9 @@\n";

$line = new DiffLine($line1);
$t->is($line->getStatus(), DiffLine::right, '->getStatus() returns right status');
$t->ok(!$line->isStartBlock(), '->isStartBlock() returns right boolean value');
$t->is('prova right', $line->__toString(), '->__toString() returns right value');
$t->ok($line->isModifiedLine(), '->isModifiedLine() return the right value.');
$line->setLineNumber(12);
$t->is($line->getLineNumber(), 12, '->getLineNumber() returns the right value');

$line = new DiffLine($line2);
$t->is($line->getStatus(), DiffLine::left, '->getStatus() returns left status');
$t->ok(!$line->isStartBlock(), '->isStartBlock() returns right boolean value');
$t->is('prova left', $line->__toString(), '->__toString() returns right value');
$t->ok($line->isModifiedLine(), '->isModifiedLine() return the right value.');
$line->setLineNumber(13);
$t->is($line->getLineNumber(), 13, '->getLineNumber() returns the right value');

$line = new DiffLine($line3);
$t->is($line->getStatus(), DiffLine::equal, '->getStatus() returns equal status');
$t->ok(!$line->isStartBlock(), '->isStartBlock() returns right boolean value');
$t->is('prova equal', $line->__toString(), '->__toString() returns right value');
$t->ok(!$line->isModifiedLine(), '->isModifiedLine() return the right value.');
$line->setLineNumber(14);
$t->is($line->getLineNumber(), 14, '->getLineNumber() returns the right value');

$line = new DiffLine($line_block);
$t->is($line->getStatus(), DiffLine::block, '->getStatus() returns right status');
$t->ok($line->isStartBlock(), '->isStartBlock() returns right boolean value');
$t->is('@ -1,6 +1,9 @@', $line->__toString(), '->__toString() returns right value');
$t->ok(!$line->isModifiedLine(), '->isModifiedLine() return the right value.');
$line->setLineNumber(15);
$t->is($line->getLineNumber(), 15, '->getLineNumber() returns the right value');

$line = new DiffLine(null);
$t->is($line->getStatus(), DiffLine::empty_line, '->getStatus() returns right status');
$t->ok(!$line->isStartBlock(), '->isStartBlock() returns right boolean value');
$t->is('', $line->__toString(), '->__toString() returns right value');
$t->ok($line->isModifiedLine(), '->isModifiedLine() return the right value.');
$line->setLineNumber(16);
$t->is($line->getLineNumber(), 16, '->getLineNumber() returns the right value');

?>
