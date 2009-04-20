<?php
include(dirname(__FILE__).'/../bootstrap/unit.php');
include(dirname(__FILE__).'/../../plugins/idRepositoryPlugin/lib/fileHandler/DiffBlockLine.class.php');

$t = new lime_test(4, new lime_output_color());

$line_block = "@@ -22,6 +11,9 @@\n";

$line = new DiffBlockLine($line_block);
$t->ok($line instanceof DiffBlockLine, '->__constructor() return DiffBlockLine object');

$t->is($line->getStartRight(), '11', '->getStartRight() returns the right value');

$t->is($line->getStartLeft(), '22', '->getStartLeft() returns the right value');

$t->is($line->__toString(), $line_block, '->__toString() returns the right value');

?>
