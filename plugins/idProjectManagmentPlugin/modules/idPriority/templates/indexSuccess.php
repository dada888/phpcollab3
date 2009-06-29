<?php slot('title', __('Manage priorities')) ?>
<?php use_helper('jQuery'); ?>

<div class="block" id="block-tables">
  <?php include_partial('create_priority_menu'); ?>
  <div class="content">
    <div class="inner">
      <h2 class="title"><?php echo __('Priorities list') ?></h2>
        <table class="table">

          <tr>
            <th class="first">&nbsp;</th>
            <th><?php echo __('Id') ?></th>
            <th><?php echo __('Name') ?></th>
            <th><?php echo __('Actions') ?></th>
            <th class="last">&nbsp;</th>
          </tr>
          
          <tbody class="sortable" id="ordered_priorities">
          <?php if ($priority_list->count() !== false && $priority_list->count() == 0): ?>
            <tr class="odd">
              <td></td>
              <td colspan="3"><?php echo __('No Results') ?></td>
              <td></td>
            </tr>
          <?php else: ?>
            <?php foreach ($priority_list as $priority): ?>
              <tr class="sortable" id="priority_<?php echo $priority->getId() ?>" name="priority_<?php echo $priority->getId() ?>">
                <td>&nbsp;</td>
                <td><a href="<?php echo url_for('@edit_priority?id='.$priority->getId()) ?>"><?php echo $priority->getId() ?></a></td>
                <td><?php echo $priority->getName() ?></td>
                <td><?php echo link_to(__('Edit'), '@edit_priority?id='.$priority->getId()) ?> | <?php echo link_to(__('Delete'), '@delete_priority?id='.$priority->getId(), array('onclick' => "var answer = confirm('".__("Do you really want to delete this priority?")."'); if (answer) { window.location = \$(this).attr('href'); }; return false;")) ?></td>
                <td>&nbsp;</td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
          </tbody>
        </table>
<div class="flash" id="feedback2"></div>

      <?php jq_add_plugin(sfConfig::get('jquery_sortable',
    'jquery-ui-sortable-1.6rc6.min.js')); ?>
<script type="text/javascript">
//<![CDATA[
$(document).ready(
  function()
  {
    $("#ordered_priorities").sortable(
    {
      update: function(e, ui)
      {
        serial = $('#ordered_priorities').sortable('serialize', {});
        $("#feedback2").html('');
        $.ajax({
          url: <?php echo json_encode(url_for('idPriority/order')) ?>,
          success: function(html) { $("#feedback2").html(html); },
          type: 'POST',
          data: serial
          , only: "sortable", tag: "tr"
        });
      }
    } );
  });
//]]>
</script>


    </div>
  </div>
</div>

