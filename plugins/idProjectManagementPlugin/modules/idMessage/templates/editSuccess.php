<?php slot('title', __('Edit Message')) ?>

<div id="content" class="span-23">
  <?php include_partial('idProject/sub_menu', array('project' => $project))?>
  <div class="span-full">
    <div class="title">
      <span><?php echo !$form->getObject()->isNew() ? __('Edit message') : __('Create new message'); ?></span>
    </div>
    <form id="new" action="<?php echo url_for('idMessage/'.($form->getObject()->isNew() ? 'create' : 'update').'?project_id='.$sf_request->getParameter('project_id').(!$form->getObject()->isNew() ? '&message_id='.$form->getObject()->getId() : '')) ?>" method="post" >
    <?php if ($form->hasGlobalErrors()): ?>
      <div class="error">
        <?php echo $form->renderGlobalErrors() ?>
      </div>
    <?php endif; ?>
    <?php if ($sf_user->hasFlash('notice')): ?>
      <div class="notice">
        <?php echo $sf_user->getFlash('notice') ?>
      </div>
    <?php endif; ?>


      <div class="span-22 last">
        <?php if($form['title']->hasError()): ?>
          <div class="error">
            <?php echo $form['title']->renderError() ?>
          </div>
        <?php endif; ?>
        <?php echo $form['title']->renderLabel() ?><br/>
        <?php echo $form['title'] ?>
      </div>
      <div class="span-22 last">
        <?php if($form['body']->hasError()): ?>
          <div class="error">
            <?php echo $form['body']->renderError() ?>
          </div>
        <?php endif; ?>
        <?php echo $form['body']->renderLabel() ?><br/>
        <?php echo $form['body'] ?>
      </div>
      <div class="clear"></div>

      <div class="span-3">
        <input class="button block-green medium-round" type="submit" value="<?php echo __('Save') ?>" />
      </div>
      <div class="span-16">&nbsp;
        <?php if (!$form->getObject()->isNew()): ?>
          <?php echo link_to('Delete', '@delete_message?message_id='.$form->getObject()->getId().'&project_id='.$sf_request->getParameter('project_id'), array('method' => 'delete', 'confirm' => 'Do you really want to delete this message?')) ?>
        <?php endif; ?>
        <?php echo $form->renderHiddenFields() ?>
      </div>
      <div class="span-3 last">
        <a href="<?php echo url_for('@index_messages?project_id='.$sf_request->getParameter('project_id')) ?>" class="button block-red medium-round"><?php echo __('Cancel'); ?></a>
      </div>
      <div class="clear"></div>
    </form>
  </div>
</div>

