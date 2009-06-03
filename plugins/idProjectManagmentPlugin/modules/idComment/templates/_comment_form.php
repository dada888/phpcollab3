<?php use_helper('Javascript') ?>

  <div class="content">
    <div class="inner">
      <?php echo form_remote_tag(array('update' => 'comment_list','url' => 'idComment/create'), array('class' => 'form')) ?>

        <?php if (!$comment_form->getObject()->isNew()): ?>
          <input type="hidden" name="sf_method" value="put" />
        <?php endif; ?>
        <?php echo $comment_form->renderHiddenFields() ?>
        <div class="columns">
          <div class="column left">
            <div class="group">
              <label class="label"><?php echo __('Insert a comment') ?></label><br/>
              <?php echo $comment_form['body']->render(array('rows' => '3', 'cols' => '35')) ?>
            </div>
            <div class="group">
              <input type="submit" class="button" value="Save" />
            </div>
          </div>
          <div class="column right" id="comment_list"></div>
          <?php echo javascript_tag(
            remote_function(array(
              'update'  => 'comment_list',
              'url'     => 'idComment/index?issue_id='.$issue->getId()
            ))
          ) ?>
        </div>
        <div class="clear"></div>
      </form>
    </div>
  </div>