$(document).ready(function(){
  $('#fd_form').hide();
  $(function() {
    $("#add-comment").click(function() {
      $('#fd_form').show();
      return false;
    });

  });
}
);