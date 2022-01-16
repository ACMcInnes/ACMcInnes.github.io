$(document).ready(function(){

    // Get the modal
    var modal = document.getElementById('cta-modal');

    // Get the button that opens the modal
    var btn = document.getElementById("modal-toggle");
    modal.style.display = "none";

    document.addEventListener("touchstart", function(){}, true);

    // When the user clicks on the button, open the modal
    btn.onclick = function() {
        btn.classList.remove("rotate-open");
        btn.classList.add("rotate-close");
        //console.log("btn clicked");
        //console.log(modal.style.display);
        if(modal.style.display == "none"){
            //console.log("modal on");
            modal.style.display = "block";
            document.body.style.overflow = "hidden";
        } else if(modal.style.display == "block"){
            //console.log("modal off");
            modal.style.display = "none";
            document.body.style.overflow = "auto";
            //btn.classList.toggle("rotate-open");
            btn.classList.remove("rotate-close");
            btn.classList.add("rotate-open");
        }
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
            document.body.style.overflow = "auto";
            btn.classList.remove("rotate-close");
            btn.classList.add("rotate-open");
        }
    }

    // Slider
    var slideIndex = 0;
    showSlides();

    function showSlides() {
        var i;
        var slides = document.getElementsByClassName("mySlides");
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        slideIndex++;
        if (slideIndex > slides.length) {slideIndex = 1}
        slides[slideIndex-1].style.display = "block";
        setTimeout(showSlides, 5000); // Change image every 2 seconds
    }

    let updateYear = document.getElementById("year");
    let date = new Date().getFullYear();
    updateYear.innerHTML = date;

    // Add smooth scrolling to all links
    //".smooth a" for just select links
    $("a").on('click', function(event) {

        // Make sure this.hash has a value before overriding default behavior
        if (this.hash !== "") {
            // Prevent default anchor click behavior
            event.preventDefault();

            // Store hash
            var hash = this.hash;

            // Using jQuery's animate() method to add smooth page scroll
            // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
            $('html, body').animate({
                scrollTop: $(hash).offset().top
            }, 800, function(){

                // Add hash (#) to URL when done scrolling (default click behavior)
                window.location.hash = hash;
            });
        } // End if
    });
});


function closeModal(){
    var modal = document.getElementById('cta-modal');
    var btn = document.getElementById("modal-toggle");
    console.log("trying to close modal");
    if(modal.style.display == "block"){
        //console.log("modal off");
        modal.style.display = "none";
        document.body.style.overflow = "auto";
        //btn.classList.toggle("rotate-open");
        btn.classList.remove("rotate-close");
        btn.classList.add("rotate-open");
    }
}
