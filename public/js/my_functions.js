



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
		document.vars.selectedProjectId.value = projectId;

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
}

/*{{$project->id}}, <?php $user = auth()->user(); ?>*/
function addNewNote(projectId, firstName, lastName) {
    $(document).ready(function(){
		$('#btn-new-note').on('click', function(event) {
			$('#newNoteModal').modal();
		});

		$('#btn-save-note').on('click', function(event) {
			$.ajax({
				type: 'POST',
				url: '/notes',
				data: {
					'_token' : $('input[name=_token]').val(),
					'project_id' : projectId,
					'content' : $('#input-note').val()
				},

				success: function(json) {
					toastr.success('Saved note: ' + json.id, 'Success', {timeOut: 5000});
					
					var toPrepend = 
						'<div>' +
							'<p class="notes-box">' + json.content + '</p>' +
							'<footer style="border-bottom: 1px solid #cccccc;">' +
								'<font size="2" style="margin-left: 10px;">' +
									firstName + ' ' + lastName + ' at ' +
									formatDate(json.created_at) + 
								'</font>' +
							'</footer>' +
						'</div>'; 

					$('#newNoteModal').modal('toggle');
					$(toPrepend).prependTo('#section-notes');
				},

				error: function(json) {
					console.log('app: ' + json.responseText);
					var jsonString = '';
					$.each(JSON.parse(json.responseText), function(key, value) {
						jsonString += value;
						console.log('error value = ' + value);
					});
					toastr.error(jsonString, 'Error', {timeOut: 5000});	
				}
			});
		});
	});
}

function formatDate(dateString) {
	var options = {day: '2-digit', year: '2-digit', month: '2-digit', hour: '2-digit', minute: '2-digit', second: '2-digit'};
    var noteDate = (new Date(dateString)).toLocaleDateString("en-US", options);

    return noteDate;
}


function makeNoteDiv(content, firstName, lastName, createdDate) {

	var toPrepend = 
		'<div>' +
			'<p class="notes-box">' + content + '</p>' +
			'<footer style="border-bottom: 1px solid #cccccc;">' +
				'<font size="2" style="margin-left: 10px;">' +
					firstName + ' ' + lastName + ' at ' +
					formatDate(createdDate) + 
				'</font>' +
			'</footer>' +
		'</div>'; 

	return toPrepend;

}