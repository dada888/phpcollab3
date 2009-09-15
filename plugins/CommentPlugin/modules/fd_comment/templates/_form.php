<h3>Leave a comment:</h3>
<form class="form" action="<?php echo url_for('@fd_comment_create?model='.$form->getModel()
                   .'&model_field='.$form->getModelField()
                   .'&model_field_value='.$form->getModelFieldValue()
                   )
                 ?>" method="post" >
  <?php if ($form->hasGlobalErrors()): ?>
    <div class="group red">
      <?php echo $form; ?>
    </div>
  <?php endif; ?>
  <div class="group">
    <?php echo $form['title']->renderLabel(null, array('class' => 'label')); ?>
    <?php echo $form['title']->renderError(); ?>
    <?php echo $form['title']->render(array('class' => 'text_area', 'cols' => 30, 'rows' => 1)); ?>
  </div>
  <div class="group">
    <?php echo $form['body']->renderLabel(null, array('class' => 'label')); ?>
    <?php echo $form['body']->renderError(); ?>
    <?php echo $form['body']->render(array('class' => 'text_area')); ?>
  </div>
  <div class="group">
    <?php echo $form->renderHiddenFields(); ?>
  </div>
  <input type="submit" value="<?php echo __('Leave a comment') ?>" />
</form>