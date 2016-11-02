function loadStartPage() {}

$.tablesorter.addParser({ 
	id: 'price', 
	is: function(s) { 
		return false; 
	}, 
	format: function(s) { 
		return s.replace(/,/g, ''); 
	}, 
	type: 'numeric' 
});

$(function() {
	$(".tbl-ahcat").tablesorter({
		headers: {
			3: {
				sorter: 'price'
			}
		}
	});
});