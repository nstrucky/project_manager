



/**
 * search table specifying column
 */
function searchTableData(columnIndex, tableId, inputId) {
	var filter, input, rows, td, i, txtValue, table, selectionMenu;
	input = document.getElementById(inputId);
	filter = input.value.toUpperCase();
	table = document.getElementById(tableId);
	rows = table.getElementsByTagName("tr");
	for (i = 0; i < rows.length; i++) {
		td = rows[i].getElementsByTagName("td")[columnIndex];
		if (td) {
			txtValue = td.textContent || td.innerText;
			if (txtValue.toUpperCase().indexOf(filter) > -1) {
				rows[i].style.display = "";
			} else {
				rows[i].style.display = "none";
			}
		}
	}
}

/**
 * columnIndex is an integer representing the column which should be used to filter data. 
 */
function filterBySelect(selectorId, tableId, columnIndex) {
	var selectedText, rows, td, i, txtValue, table, columnIndex, selectionMenu, testButton;
	selectionMenu = document.getElementById(selectorId);
	selectedText = selectionMenu.options[selectionMenu.selectedIndex].text.toUpperCase();
	table = document.getElementById(tableId);
	rows = table.getElementsByTagName("tr");
	for (i = 0; i < rows.length; i++) {
		td = rows[i].getElementsByTagName("td")[columnIndex];
		if (td) {
			txtValue = td.textContent || td.innerText;
			if (txtValue.toUpperCase().indexOf(selectedText) > -1 || 
				selectedText.localeCompare("ALL") == 0) {
				rows[i].style.display = "";
			} else {
				rows[i].style.display = "none";
			}
		}
	}
}


/*
 * Retrieves notes by project ID
 */
function retrieveNotes(projectId, projectName) {
	$(document).ready(function() {
		$.ajax({
			type: 'GET',
			url: '/projects/' + projectId + '/notes',
			success: function(json) {
				document.getElementById('title-notes').innerHTML = projectName;
				$('#section-notes').empty();
				for (i in json) {
					var noteDate = formatDate(json[i].created_at);
					var toAppend = 
					'<div>' +
						'<p class="notes-box">' + json[i].content + '</p>' +
						'<footer style="border-bottom: 1px solid #cccccc;">' +
							'<font size="2" style="margin-left: 10px;">'+ json[i].first_name + ' ' + json[i].last_name + ' at ' + noteDate + '</font>' +
						'</footer>' +
					'</div>';

					$(toAppend).appendTo('#section-notes');
				}
			}, 
			error: function(data) {
				toastr.error(data.statusText, 'Error', {timeOut: 5000});
			}
		});
	});


	function formatDate(dateString) {
		var options = {day: '2-digit', year: '2-digit', month: '2-digit', hour: '2-digit', minute: '2-digit', second: '2-digit'};
	    var noteDate = (new Date(dateString)).toLocaleDateString("en-US", options);

	    return noteDate;
	}
}

