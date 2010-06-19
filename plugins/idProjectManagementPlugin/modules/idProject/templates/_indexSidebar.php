<div class="span-8 prepend-1 last" id="sidebar">
  <div class="title"><span>Filters</span></div>
  <form action="<?php echo url_for('@index_project') ?>" method="get">

    <div class="span-full box">
      <?php if ($form['name']->hasError()): ?>
        <?php echo $form['name']->renderError(); ?>
      <?php endif; ?>

      <?php echo $form['name']->renderLabel() ?>: <?php echo $form['name'] ?>
    </div>
    <div class="span-full box">
      <?php if ($form['created_at']->hasError()): ?>
        <?php echo $form['created_at']->renderError(); ?>
      <?php endif; ?>

      <?php echo $form['created_at']->renderLabel() ?>: <?php echo $form['created_at'] ?>
    </div>
    <div class="span-full box">
      <?php if ($form['starting_date']->hasError()): ?>
        <?php echo $form['starting_date']->renderError(); ?>
      <?php endif; ?>

      <?php echo $form['starting_date']->renderLabel() ?>:<br/>
      <?php echo $form['starting_date'] ?>
    </div>
    <div class="span-full box">
      <?php if ($form['end_date']->hasError()): ?>
        <?php echo $form['end_date']->renderError(); ?>
      <?php endif; ?>

      <?php echo $form['end_date']->renderLabel() ?>:<br/>
      <?php echo $form['end_date'] ?>
    </div>
    <div class="span-full box">
      <?php echo link_to(__('Reset'), '@index_project') ?> or <input type="submit" class="button" value="<?php echo __('Filter') ?>" />
    </div>
    
  </form>

</div>
