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

    <div id="container">
      <div id="header">
        <h1><?php include_slot('title') ?></h1>

        <div id="user-navigation">
          <ul>
            <?php if ($sf_user->isAuthenticated()) : ?>
              <li><?php echo link_to(__('Logout'), '@sf_guard_signout'); ?></li>
              <li><?php echo link_to(__('Edit my profile'), '@edit_profile') ?></li>
            <?php else: ?>
              <li><?php echo link_to(__('Signin'), '@sf_guard_signin'); ?></li>
            <?php endif; ?>
          </ul>
          <div class="clear"></div>
        </div>

        <div id="main-navigation">
          <?php include_partial('global/main_navigation', array('sf_guard_user' => $sf_user)) ?>
          <div class="clear"></div>
        </div>

      </div>

      <div id="wrapper">
        <div id="<?php if (!include_slot('main_div_class')) { echo "main"; } ?>">

          <?php echo $sf_content ?>

          <div id="footer">
            <div class="block">
              <p><?php echo __('Copyright &copy; 2009 Ideato s.r.l.') ?></p>
            </div>
          </div>
        </div>

        
        <?php include_component_slot('sidebar') ?>


        <div class="clear"></div>
      </div>
    </div>

  </body>
</html>
