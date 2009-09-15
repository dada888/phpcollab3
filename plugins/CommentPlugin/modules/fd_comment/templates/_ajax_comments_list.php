<div id="ajax_comments_list">
  <p id="indicator_list" style="display:none">
    <?php echo image_tag('../CommentPlugin/images/loading.gif') ?><?php echo __('Loading comments list') ?>
  </p>
  <div id="comments_list"></div>
</div>
<script type="text/javascript">

  $('#indicator_list').show();

  $.ajax({
    type: "POST",
    url: "<?php echo url_for('@fd_ajax_comment_list?model='.$model
                       .'&model_field='.$model_field
                       .'&model_field_value='.$model_field_value) ?>",
    success: function(html){
      $('#indicator_list').hide();
      $("#comments_list").replaceWith(html);
    }
  });

  function loadAjaxCommentList(remote_url)
  {
    $('#indicator_list').show();
    $.ajax({
      type: "POST",
      url: remote_url,
      success: function(html){
        $('#indicator_list').hide();
        $("#comments_list").replaceWith(html);
      }
    });
  }
</script>
