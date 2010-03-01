<?php slot('title', __('Messages for project').' '.$project->getName()) ?>

<div class="block" id="block-tables">
  <?php include_partial('create_message_menu'); ?>
  <div class="content">
    <div class="inner">

      <table class="table">
            <tr>
            <th class="first">&nbsp;</th>
            <th><?php echo __('Title') ?></th>
            <th><?php echo __('Creation date') ?></th>
            <th><?php echo __('Created by') ?></th>
            <th class="last">
              <?php if($sf_user->hasCredential('idMessage-Edit')): ?>
              <?php echo __('Actions'); ?>
            <?php endif; ?>
            </th>
          </tr>

          <?php if (count($pager->getResults()) !== false && count($pager->getResults()) == 0): ?>
            <tr class="odd">
              <td></td>
              <td colspan="5"><?php echo __('No Results') ?></td>
              <td></td>
            </tr>
          <?php else: ?>
            <?php foreach ($pager->getResults() as $message): ?>
              <tr class="odd">
                <td>&nbsp;</td>
                <td><?php echo link_to($message->getTitle(), '@show_message?project_id='.$message->project_id.'&message_id='.$message->id); ?></td>
                <td><?php echo $message->getCreatedAt(); ?></td>
                <td><?php echo $message->UserProfile; ?></td>
                <td>
                  <?php if($sf_user->hasCredential('idMessage-Edit')): ?>
                    <?php echo link_to(__('Edit'), '@edit_message?project_id='.$project->getId().'&message_id='.$message->getId()) ?> |
                    <?php echo link_to(__('Delete'), '@delete_message?project_id='.$project->getId().'&message_id='.$message->getId(), array('confirm' => __('Do you really want to delete this tracker?'))) ?>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
          <tr>
            <td></td>
            <td><?php  echo pager_navigation($pager, '@index_messages?project_id='.$sf_request->getParameter('project_id')) ?></td>
            <td></td>
          </tr>
        </table>

    </div>
  </div>
</div>


