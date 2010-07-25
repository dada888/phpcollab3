<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <?php include_javascripts() ?>
    <?php include_stylesheets() ?>
    <link rel="stylesheet" href="blueprint/print.css" type="text/css" media="print" />
    <link rel="shortcut icon" href="/favicon.ico" />
    <title><?php include_slot('title') ?></title>
  </head>
  <body>
    <div class="site-bg">
      <div class="container">
        <?php if ($sf_user->isAuthenticated()) : ?>
        <div id="utility" class="showgrid-off">
          Hello, <?php echo link_to($sf_user->getUsername(), '@edit_profile') ?> 
          <a href="<?php echo url_for('@sf_guard_signout') ?>" class="login">Logout</a>
          <?php if ($sf_user->isAdmin()):?>
            <a href="<?php echo url_for('@collab_settings')?>" class="settings">Settings</a>
          <?php endif; ?>
          <a href="#" class="help">Help</a>
          <select>
          <?php foreach($sf_user->getMyProjects() as $project): ?>
            <option><?php echo $project->name ?></option>
          <?php endforeach;?>
          </select>
        </div>

        <div id="header">
          <div id="application-title"><?php include_slot('title') ?></div>
          <div id="header-search" class="search-box utility-search right">
            <form id="main-search-form" action="#" method="post">
              <div class="search-button">
                <input class="submit" value="" type="submit" />
              </div>
              <div class="center">
                <input class="search placeholder" name="search" title="Search" value="" type="text" />
              </div>
              <div class="left"> </div>
            </form>
          </div>
        </div>
        <div id="navigation">
          <ul>
            <li><a href="<?php echo url_for('@dashboard') ?>"><?php echo __('Dashboard') ?></a></li>
              <li><?php echo link_to(__('Projects'), '@index_project') ?></li>
              <li><?php echo link_to(__('Time'), '@index_logtime') ?></li>

              <?php if ($sf_user->isAdmin()): ?>
                <li><?php echo link_to(__('Users'), '@sf_guard_user') ?></li>
              <?php endif; ?>
          </ul>
        </div>
        <?php else: ?>
        <div id="utility" class="showgrid-off">
          Hello! <a href="<?php echo url_for('@sf_guard_signin') ?>" class="login"><?php echo __('Signin') ?></a>
        </div>
        <div id="header">
          <div id="application-title"><?php include_slot('title') ?></div>
        </div>
        <?php endif; ?>

        <div id="wrapper">
          <?php echo $sf_content ?>
          <?php include_component_slot('sidebar') ?>
        </div>
      </div>
    </div>
  </body>
</html>