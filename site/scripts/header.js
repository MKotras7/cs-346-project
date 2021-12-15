const dateDisplay = document.getElementById("dateDisplay");
const headerButtons = document.getElementById("headerButton");
const moreButton = document.getElementById("moreButton");

var dateNumber = parseInt(dateDisplay.innerHTML);
const formatStyle = "MM-DD-YYYY hh:mm:ss a";
dateDisplay.innerHTML = moment.unix(dateNumber).utc().format(formatStyle);

moreButton.addEventListener("click", function() {
	if(headerButtons.style.display == "flex")
	{
		headerButtons.style.display = "none";
	}
	else
	{
		headerButtons.style.display = "flex";
	}
} );
window.addEventListener("resize", function()
{
	headerButtons.style.display = "";
} );
var interval = window.setInterval( function() {
	dateNumber++;
	dateDisplay.innerHTML = moment.unix(dateNumber).utc().format(formatStyle);
}, 1000);