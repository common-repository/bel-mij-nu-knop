jQuery.noConflict()
jQuery(document).ready(function($) {

	DayNames = new Array('Maa', 'Din', 'Woe', 'Don', 'Vri', 'Zat', 'Zon');
	var Days = new Array();
	openingstijden = new Array();
	if (callmenow.openingstijden != null) {
		openingstijden = callmenow.openingstijden;
	}
	rebuildOverview();
	
	$(".dayclicker").click(function() {
		if ($(this).hasClass("notselected")) {
			$(this).removeClass("notselected");
			Days.push($(this).attr("id"));
		} else {
			$(this).addClass("notselected");
			Days.splice(Days.indexOf($(this).attr("id")), 1);
		}
		Days.sort();
	});
	
	$("#add_time").click(function() {
		if (Days.length > 0) {
			Adding = new Array();
				Adding[0] = Days;
				Adding[1] = $("#start").val();
				Adding[2] = $("#end").val();
			openingstijden.push(Adding);
			resetAfterInsert();
			rebuildOverview();
		}
	});
	
	function resetAfterInsert() {
		delete Days;
		Days = new Array();
		$(".day").each(function(index) {
			if (!$(this).hasClass("notselected")) {
				$(this).addClass("notselected");
			}
		});
	}
		
	function rebuildOverview() {
		saveOpeningstijden();
		$("#current").html("");
		$("#current").empty().append(
			$("<table>").attr(
				"id", "rules"
			)
		);
		if (openingstijden.length == 0) {
			$("#rules").append(
				$("<tr>").append(
					$("<td>").append(
						"U heeft geen openingstijden toegevoegd. Dit betekent dat u altijd telefonisch bereikbaar bent."
					)
				)
			);
		} else {
			$.each(openingstijden, function(index, value) {
				var DayString;
				for ($i=0; $i<7; $i++) {
				var ExtraClass = "day notselected";
					$.each(value[0], function(index, value) {
						if (value == $i) {
							ExtraClass = "day";
						}
					});
					var row = $("<span>").append(
							DayNames[$i]
						).addClass(
							ExtraClass
						);
					if (!DayString) {
						DayString = row;
					} else {
						DayString = DayString.add(row);
					}
				}
				$("#rules").append(
					$("<tr>").append(
						$("<td>").append(
							$("<div>").append(
								$("<span>").addClass(
									"day notselected small pointer"
								).append(
									$("<img>").attr(
										"src", callmenow.base_url+"/delete.png"
									).addClass(
										"alignmiddle"
									)
								).attr(
									"id", "delete_time"
								)
							).click(function() {
								openingstijden.splice($(this).parent().parent().attr("id"), 1);
								rebuildOverview();
							}).addClass(
								"displayinline"
							)
						)
					).append(
						$("<td>").append(
							$("<div>").append(
								$("<span>").append(
									value[1]
								).addClass(
									"day cursor"
								)
							).append(
								$("<span>").append(
									value[2]
								).addClass(
									"day cursor"
								)
							).addClass(
								"days"
							)
						)
					).append(
						$("<td>").append(
							$("<div>").append(
								DayString
							).addClass(
								"days cursor"
							)
						)
					).attr(
						"id", index
					)
				);
			});
		}
	}
	
	function saveOpeningstijden() {
		var tijden = new Array();
		$.each(openingstijden, function(index, value) {
			tijden.push(value);
		});
		$.ajax({
			type: "post",
			url: callmenow.ajax,
			dataType: "json",
			beforeSend: function() {
				$("#openingstijden_loader").show();
			},
			data: {
				action: "callmenow_admin_ajax",
				nonce: callmenow.nonce,
				openingstijden: openingstijden
			},
			success: function(data) {
				$("#openingstijden_loader").hide();
			}
		});
		return false;
	}
	
});