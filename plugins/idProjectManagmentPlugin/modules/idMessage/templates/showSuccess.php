<?php slot('title', __('Message discussion')); ?>
<?php use_helper('jQuery'); ?>

<div class="block" id="message-table">
  <?php include_partial('create_message_menu'); ?>
  <div class="content">
    <h2 class="title"><?php echo $message->getTitle() ?></h2>
    <div class="inner">
      <div class="message">
        <p><?php echo $message->getBody(); ?></p>
      </div>
      <hr/>

      <?php include_partial('fd_comment/comment_form', array('commentForm' => $commentForm)); ?>
      <?php include_component('fd_comment', 'listByModel', array('model' => $commentForm->getModel(), 'model_field' =>$commentForm->getModelField(), 'model_field_value' =>$message->getId())) ?>

      <?php /*include_partial('fd_comment/ajax_comment_form', array('model' => get_class($message),
                                                                  'model_field' => 'id',
                                                                  'model_field_value' => $message->getId()))*/ ?>
      <?php /*include_partial('fd_comment/ajax_comments_list', array('model' => get_class($message),
                                                                   'model_field' => 'id',
                                                                   'model_field_value' => $message->getId()))*/ ?>

    </div>
  </div>
</div>