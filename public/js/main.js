function updateSpacing() {
$(".calendar-table tr").each( function() {
			var row = $(this)
			row.find(".calendar-event-name").each( function() {
				var event_id = $(this).attr("id");
				var bar_positions = []
				var heights = []
				row.find("#" + event_id + ".calendar-event-name").each( function() {
					bar_positions.push($(this).offset().top)
					heights.push($(this).height())
					if (event_id == '48') {
					console.log(this)
					console.log(bar_positions)
					console.log(heights)
					}
				})
				if (event_id == '48') {
					console.log(bar_positions)
					console.log(heights)
				}
				var max_offset = Math.max.apply(Math, bar_positions);
				var max_height = Math.max.apply(Math, heights);
				if (typeof max_offset != 'NaN') {	
					row.find("#" + event_id + ".calendar-event-name").each( function() {
						var top_offset = $(this).offset().top;
						var height = $(this).height();

						if (max_offset != top_offset) {
							var difference = max_offset - top_offset;
							var new_margin = parseInt($(this).css("margin-top")) + difference;
							$(this).css("margin-top", new_margin + "px");
						}
						if (max_height != height) {
							$("#" + event_id + ".calendar-event-name").css("height", max_height + "px");
						}
					})
				}
			})
	});
}
