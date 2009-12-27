<?php slot('title', __('Repository Revisions')) ?>
<?php slot($slotType, 'active') ?>

<div class="block" id="block-tables">
  <?php include_partial('main_navigation'); ?>
  <div class="content">
    <?php
      if(empty($data)){
      ?>
        <h2 class="title"><?php echo __('No revision') ?></h2>
      <?php
      }
      else {
      ?>
    <h2 class="title"><?php echo $repositoryURL ?></h2>
    <div class="inner">
      <table class="table">
        <tr>
          <th class="first"><?php echo __('Revision Number') ?></th>
          <th><?php echo __('Author') ?></th>
          <th><?php echo __('Date') ?></th>
          <th><?php echo __('Message') ?></th>
          <th class="last"><?php echo __('&nbsp;') ?></th>
        </tr>
        <?php
        foreach($data as $key => $revision){
          ?>

          <tr class="odd">
            <td><?php echo link_to("".$revision->getLogRevisionNumber()."", '@show_revision_details?revisionid='.$revision->getLogRevisionNumber()) ?></td>
            <td><?php echo $revision->getAuthor() ?></td>
            <td><?php echo date('Y-m-d', $revision->getDate()) ?></td>
            <td><?php echo $revision->getMessage() ?></td>
            <td class="last">&nbsp;</td>
          </tr>

          <?php
        }
        ?>
      </table>
      <?php
      }
      ?>
      </div>
    </div>
  </div>