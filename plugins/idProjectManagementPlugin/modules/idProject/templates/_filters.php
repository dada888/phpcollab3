<h3><?php echo __('Filters') ?></h3>
<hr />
<form action="<?php echo url_for('@index_project') ?>" method="get">
  <div class="sidebar_filter_form">
    <div class="input_values">
      <?php echo $form['name']->render() ?>
    </div>
    <div class="label">
      <label><?php echo $form['name']->renderLabel() ?></label>
    </div>
    <div class="clear"></div>
    <?php echo $form['name']->renderError() ?>
  </div>

  <div class="sidebar_filter_form">
    <div class="input_values">
      <?php echo $form['starting_date']->render() ?>
    </div>
    <div class="label">
      <label><?php echo $form['starting_date']->renderLabel() ?></label>
    </div>
    <div class="clear"></div>
    <?php echo $form['starting_date']->renderError() ?>
  </div>

  <div class="sidebar_filter_form">
    <div class="input_values">
      <?php echo $form['end_date']->render() ?>
    </div>
    <div class="label">
      <label><?php echo $form['end_date']->renderLabel('Ending date') ?></label>
    </div>
    <div class="clear"></div>
    <?php echo $form['end_date']->renderError() ?>
  </div>

  <div class="sidebar_filter_form">
    <div class="input_values">
      <?php echo $form['created_at']->render() ?>
    </div>
    <div class="label">
      <label><?php echo $form['created_at']->renderLabel() ?></label>
    </div>
    <div class="clear"></div>
    <?php echo $form['created_at']->renderError() ?>
  </div>

  <div class="sidebar_filter_form">
    <div class="input_values">
      <?php echo link_to(__('Reset'), '@index_project') ?> or <input type="submit" class="button" value="<?php echo __('Filter') ?>" />
    </div>
    <div class="clear"></div>
  </div>
  <hr />
</form>
