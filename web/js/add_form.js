$(document).ready(function(){
  $('#add-form').hide();
	$(function() {
		$("#add").click(function() {
			$('#add-form').show();
			return false;
		});

	});
}
);