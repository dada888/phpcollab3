<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <?php include_javascripts() ?>
    <?php include_stylesheets() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <title><?php include_slot('title') ?></title>
  </head>
  <body>
    <div class="container wrapper">
      <?php if ($sf_user->isAuthenticated()) : ?>
      <div class="span-24 container last  utility-nav right">
        Hello, <?php echo link_to($sf_user->getUsername(), '@edit_profile') ?> <a href="<?php echo url_for('@sf_guard_signout') ?>" class="utilLogout">Logout</a> <a href="#" class="utilSettings">Settings</a> <a href="#" class="utilHelp">Help</a>
        <select>
          <option>One</option>
        </select>
      </div>
      <div class="span-24 container last header">
        <div class="span-15 title"><?php include_slot('title') ?></div>
        <div id="header-search" class="search-box span-7 utility-search last right">
          <form id="main-search-form" action="index.php?page=list" method="post">
            <div class="search-button">
              <input class="submit" value="" type="submit" />
            </div>
            <div class="center">
              <input class="search placeholder" name="search" title="Search for a Contact" value="" type="text" />
            </div>
            <div class="left"> </div>
          </form>
        </div>
      </div>
      <div class="span-24 main_menu last">
        <div class="span-18 navigation">
          <ul>
            <li><a href="<?php echo url_for('@dashboard') ?>"><?php echo __('Dashboard') ?></a></li>
            <li><?php echo link_to(__('Projects'), '@index_project') ?></li>
            <li><?php echo link_to(__('Time'), '@index_logtime') ?></li>
            <li><a href="calendar.html">Calendar</a></li>
            
            <?php if ($sf_user->isAdmin()):?>
              <li><?php echo link_to(__('Users'), '@sf_guard_user') ?></li>
            <?php endif;?>

            <li><a href="messages.html"><span>5</span>Messages</a></li>
          </ul>
        </div>
        <div class="span-6 navigationRight last">
          <ul>
            <li><a id="addIcon" href="#" >Quick Add</a></li>
          </ul>
        </div>
      </div>
      <?php else: ?>
      <div class="span-24 container last  utility-nav right">
        Hello! <a href="<?php echo url_for('@sf_guard_signin') ?>" class="utilLogin"><?php echo __('Signin') ?></a>
      </div>
      <div class="span-24 container last header">
        <div class="span-15 title"><?php include_slot('title') ?></div>
      </div>
      <?php endif; ?>

      <div class="span-24 append-1 prepend-1 last contentWrapper rounded">
        <?php echo $sf_content ?>
        <?php include_component_slot('sidebar') ?>
      </div>

      <div class="span-24 append-1 prepend-1 last footer">&nbsp;</div>
    </div>
  </body>
</html>