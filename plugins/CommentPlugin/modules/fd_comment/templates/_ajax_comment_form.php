<div id="ajax_comment_form">
  <p id="indicator_form" style="display:none">
    <?php echo image_tag('../CommentPlugin/images/loading.gif') ?><?php echo __('Loading comment form') ?>
  </p>

  <?php if ($sf_user->hasFlash('notice')) : ?>
    <div class="flash">
      <div class="message notice">
        <p><?php echo $sf_user->getFlash('notice');  ?></p>
      </div>
    </div>
  <?php endif; ?>
  <?php if ($sf_user->hasFlash('warning')) : ?>
    <div class="flash">
      <div class="message warning">
        <p><?php echo $sf_user->getFlash('warning');  ?></p>
      </div>
    </div>
  <?php endif; ?>
  <?php if ($sf_user->hasFlash('error')) : ?>
    <div class="flash">
      <div class="message error">
        <p><?php echo $sf_user->getFlash('error');  ?></p>
      </div>
    </div>
  <?php endif; ?>

  <div id="comment_form"></div>
</div>
<script type="text/javascript">
  $('#indicator_form').show();
  $.ajax({
    type: "POST",
    url: "<?php echo url_for('@fd_comment_new?model='.$model
                       .'&model_field='.$model_field
                       .'&model_field_value='.$model_field_value) ?>",
    success: function(html){
      $('#indicator_form').hide();
      $("#comment_form").replaceWith(html);
      $('#comment_form_submit').attr('onclick', 'submitAjaxForm(); return false;');
    }
  });

  function submitAjaxForm()
  {
    $('#indicator_form').show();
    $.ajax({
        type: "POST",
        url: $('#fd_form').attr('action'),
        data: $('#fd_form').serialize(),
        success: function(html){
          $('#indicator_form').hide();
          $("#comment_form").replaceWith(html);
          $('#comment_form_submit').attr('onclick', 'submitAjaxForm(); return false;');
          loadAjaxCommentList("<?php echo url_for('@fd_ajax_comment_list?model='.$model
                              .'&model_field='.$model_field
                              .'&model_field_value='.$model_field_value) ?>");
        }
      });
  }
</script>