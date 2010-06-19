var myMenuNew = null;
var myMenuOld = null;
var myMenuCurrent = null;

function mySwitch(varID) {
	if (varID != myMenuNew) {	
		myMenuNew = varID;
		myMenuOld = myMenuCurrent;
		myMenuCurrent = myMenuNew;
		document.getElementById(myMenuNew).style.display = "";
		document.getElementById(myMenuOld).style.display = "none";
		document.getElementById("a-"+myMenuNew).setAttribute("class","selected");
		document.getElementById("a-"+myMenuOld).setAttribute("class","");
		document.getElementById("a-"+myMenuNew).setAttribute("className","selected");
		document.getElementById("a-"+myMenuOld).setAttribute("className","");
	}
}