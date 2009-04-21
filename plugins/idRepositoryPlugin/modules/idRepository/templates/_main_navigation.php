<div class="secondary-navigation">
    <ul>
      <li class="first <?php if (has_slot('show_repository')) { include_slot('show_repository'); } ?>"><?php echo link_to(__('Show Latest Revisions'), '@show_revisions') ?></li>
      <li class="<?php if (has_slot('show_repository_all')) { include_slot('show_repository_all'); } ?>"><?php echo link_to(__("Show All Revisions"), '@showall_revisions') ?></li>
    </ul>
    <div class="clear"></div>
  </div>