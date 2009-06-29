<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

function initializeDatabase()
{
  `./symfony doctrine:drop-db --env=unittest --no-confirmation;`;
  `./symfony doctrine:build-db --env=unittest;`;
  `./symfony doctrine:build-sql --env=unittest;`;
  `./symfony doctrine:insert-sql --env=unittest;`;
}

$_test_dir = realpath(dirname(__FILE__).'/..');

require_once(dirname(__FILE__).'/../../config/ProjectConfiguration.class.php');
$configuration = new ProjectConfiguration(realpath($_test_dir.'/..'));
include($configuration->getSymfonyLibDir().'/vendor/lime/lime.php');