// JavaScript Document
function searchOnFocus() {
	if (document.getElementById('search')) {
		var sField = document.getElementById('search');
		if (sField.value == 'Search') {
			sField.value = '';
		}
	}
}

function searchOnBlur() {
	if (document.getElementById('search')) {
		var sField = document.getElementById('search');
		if (sField.value == '') {
			sField.value = 'Search';
		}
	}
}