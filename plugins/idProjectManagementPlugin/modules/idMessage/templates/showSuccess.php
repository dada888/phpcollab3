<?php slot('title', __('Message discussion')); ?>

<div id="content" class="span-23">
  <?php include_partial('idProject/sub_menu', array('project' => $message->getProject()))?>

  <div id="specifications" class="span-full">
    <div class="title">
      <span><?php echo $message->getTitle() ?></span>
      <span class="actions">
        <?php echo link_to(__('Edit'), '@edit_message?project_id='.$message->project_id.'&message_id='.$message->getId()) ?>
        <?php echo link_to(__('Delete'), '@delete_message?project_id='.$message->project_id.'&message_id='.$message->getId(), array('confirm' => __('Do you really want to delete this message?'))) ?>
      </span>
    </div>
    <p><?php echo $message->getBody(); ?></p>
    <hr/>

    <h3>
      Comments
      <a id="add-comment"class="button block-green medium-round" href="#">Add</a>
    </h3>

    <?php if ($sf_user->hasFlash('error')): ?>
    <div class="error">
      <?php echo $sf_user->getFlash('error') ?>
    </div>
    <?php endif; ?>
    <?php if ($sf_user->hasFlash('success')): ?>
    <div class="notice">
      <?php echo $sf_user->getFlash('success') ?>
    </div>
    <?php endif; ?>

    <form id="fd_form" action="<?php echo url_for('@fd_comment_create?model='.$commentForm->getModel()
                                                 .'&model_field='.$commentForm->getModelField()
                                                 .'&model_field_value='.$commentForm->getModelFieldValue()) ?>" method="post" >
      <div class="span-full">
        <?php echo $commentForm['title']->renderError(); ?>
        <?php echo $commentForm['title']->renderLabel(null, array('class' => 'label')); ?><br/>
        <?php echo $commentForm['title']->render(array('class' => 'text_field')); ?>
      </div>
      <div class="span-full">
        <?php echo $commentForm['body']->renderError(); ?>
        <?php echo $commentForm['body']->renderLabel(null, array('class' => 'label')); ?><br/>
        <?php echo $commentForm['body']->render(array('class' => 'text_area')); ?>
      </div>
      <?php echo $commentForm->renderHiddenFields(); ?>
      <input class="button" type="submit" value="<?php echo __('Leave a comment') ?>" />
      <div class="clear"></div>
    </form>

    <?php include_component('fd_comment', 'listByModel', array('model' => $commentForm->getModel(), 'model_field' =>$commentForm->getModelField(), 'model_field_value' =>$message->getId())) ?>
  </div>
</div>
