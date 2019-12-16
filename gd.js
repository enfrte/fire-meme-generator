// make sure only one field is submitted

var urlInputElement = document.getElementById("urlinput");
// remove file input
urlInputElement.addEventListener(
  "keyup",
  function() {
	fileInputElement.value = "";
  }
);

var fileInputElement = document.getElementById("fileinput");
// remove url input
fileInputElement.addEventListener(
  "change",
  function() {
	urlInputElement.value = "";
  }
);