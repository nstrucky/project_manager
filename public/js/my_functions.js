




function searchTableData(menuId, tableId, inputId) {
	var filter, input, rows, td, i, txtValue, table, columnIndex, selectionMenu;
	selectionMenu = document.getElementById(menuId);
	columnIndex = selectionMenu.options[selectionMenu.selectedIndex].value;
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