jQuery.noConflict()
jQuery(document).ready(function($) {
	$("#callmenow_form").submit(function() {
		$("#callmenow_error").hide();
		$("#callmenow_loader").show("slow");
		$.ajax({
			type: "post",
			url: callmenow.ajax,
			dataType: "json",
			data: {
				action: "callmenow_ajax",
				phone: $("#callmenow_phone").val(),
				nonce: callmenow.nonce
			},
			success: function(data) {
				$("#callmenow_loader").hide("slow", function() {
				if (data.message) {
					$("#callmenow_error").html(data.message+".").show("slow");
				}
				});
			}
		});
		return false;
	});
});