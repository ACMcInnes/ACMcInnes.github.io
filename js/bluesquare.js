/* Set the width of the side navigation to 250px */
var sidebar = document.getElementById("sidebarcart");
var sidebarbackground = document.getElementById("sidebarbackground");
var cart = document.getElementById("opencart");
var close = document.getElementById("closecart");
console.log("js loaded");

cart.onclick = function(e) {
	console.log("hello");
	sidebarbackground.style.display = "block";
    sidebar.style.width = "300px";
    e.preventDefault();
    //document.body.style.position = "fixed";
    document.body.style.overflow = "hidden";
}

/* Set the width of the side navigation to 0 */
close.onclick = function(e) {
	console.log("goodbye");
	sidebarbackground.style.display = "none";
    sidebar.style.width = "0";
    e.preventDefault();
    //document.body.style.position = "static";
    document.body.style.overflow = "auto";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(e) {
    if (e.target == sidebarbackground) {
        sidebarbackground.style.display = "none";
        e.preventDefault();
        document.body.style.overflow = "auto";
    }
}
    
