<div id="comment_form">
  <?php if ($sf_user->hasFlash('error')): ?>
    <div class="flash">
      <div class="message error">
        <p><?php echo $sf_user->getFlash('error') ?></p>
      </div>
    </div>
  <?php endif; ?>
  <?php if ($sf_user->hasFlash('success')): ?>
    <div class="flash">
      <div class="message notice">
        <p><?php echo $sf_user->getFlash('success') ?></p>
      </div>
    </div>
  <?php endif; ?>
  <h3>Leave a comment:</h3>
  <form class="form" id="fd_form" action="<?php echo url_for('@fd_comment_create?model='.$commentForm->getModel()
                     .'&model_field='.$commentForm->getModelField()
                     .'&model_field_value='.$commentForm->getModelFieldValue()
                     )
                   ?>" method="post" >
    <div class="group">
      <?php echo $commentForm['title']->renderLabel(null, array('class' => 'label')); ?>
      <?php echo $commentForm['title']->renderError(); ?>
      <?php echo $commentForm['title']->render(array('class' => 'text_field')); ?>
    </div>
    <div class="group">
      <?php echo $commentForm['body']->renderLabel(null, array('class' => 'label')); ?>
      <?php echo $commentForm['body']->renderError(); ?>
      <?php echo $commentForm['body']->render(array('class' => 'text_area')); ?>
    </div>
    <div class="group">
      <?php echo $commentForm->renderHiddenFields(); ?>
    </div>
    <input id="comment_form_submit" type="submit" value="<?php echo __('Leave a comment') ?>" />
  </form>
</div>