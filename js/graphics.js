$(document).ready(function(){
    // When the user scrolls the page, execute myFunction
    window.onscroll = function() {myFunction()};

    // Get the navbar
    var navbar = document.getElementById("navbar");

    var navMobile = document.getElementById("myNav");
    var navLink = document.getElementsByClassName("navLink");

    // Get the offset position of the navbar
    var sticky = navbar.offsetTop;

    // Add the sticky class to the navbar when you reach its scroll position. Remove "sticky" when you leave the scroll position
    function myFunction() {
        if (window.pageYOffset >= sticky) {
            navbar.classList.add("sticky")
        } else {
            navbar.classList.remove("sticky");
        }
    }

    window.onclick = function(event) {
        if (event.target == navMobile) {
            navMobile.style.height = "0%";
        }
        for (var i = 0; i < navLink.length; i++) {
            if (event.target == navLink[i]) {
                //console.log("link clicked: " + navLink[i].innerHTML + i)
                navMobile.style.height = "0%";
            }
        }
    }

    /* When the user clicks on the button,
    toggle between hiding and showing the dropdown content */
    function dropdownToggle() {
      console.log("button toggled");
      document.getElementById("myDropdown").classList.toggle("show");
    }

    // Close the dropdown menu if the user clicks outside of it
    window.onclick = function(event) {
      if (!event.target.matches('.dropbtn')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
          var openDropdown = dropdowns[i];
          if (openDropdown.classList.contains('show')) {
            openDropdown.classList.remove('show');
          }
        }
      }
    }



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


    //snackbar
    // Get the snackbar DIV
    var snack = document.getElementById("snackbar");
    var snackClose = document.getElementById("closeSnack");

      // Add the "show" class to DIV
      //snack.className = "show";

      // After 3 seconds, remove the show class from DIV
      setTimeout(function(){ snack.className = "showSnack"; }, 3000);


      snackClose.onclick = function(event) {
        console.log("button clicked");
        snack.className = snack.className.replace("showSnack", "closeSnack");
      }

});

/* lazy loading starts */

document.addEventListener("DOMContentLoaded", function() {
  var lazyloadImages;

  if ("IntersectionObserver" in window) {
    lazyloadImages = document.querySelectorAll(".lazy");
    var imageObserver = new IntersectionObserver(function(entries, observer) {
      entries.forEach(function(entry) {
        if (entry.isIntersecting) {
          var image = entry.target;
          image.src = image.dataset.src;
          image.classList.remove("lazy");
          imageObserver.unobserve(image);
        }
      });
    });

    lazyloadImages.forEach(function(image) {
      imageObserver.observe(image);
    });
  } else {
    var lazyloadThrottleTimeout;
    lazyloadImages = document.querySelectorAll(".lazy");

    function lazyload () {
      if(lazyloadThrottleTimeout) {
        clearTimeout(lazyloadThrottleTimeout);
      }

      lazyloadThrottleTimeout = setTimeout(function() {
        var scrollTop = window.pageYOffset;
        lazyloadImages.forEach(function(img) {
            if(img.offsetTop < (window.innerHeight + scrollTop)) {
              img.src = img.dataset.src;
              img.classList.remove('lazy');
            }
        });
        if(lazyloadImages.length == 0) {
          document.removeEventListener("scroll", lazyload);
          window.removeEventListener("resize", lazyload);
          window.removeEventListener("orientationChange", lazyload);
        }
      }, 20);
    }

    document.addEventListener("scroll", lazyload);
    window.addEventListener("resize", lazyload);
    window.addEventListener("orientationChange", lazyload);
  }
})

/* lazy loading ends */


var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight) {
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    }
  });
}

function openNav() {
    var nav = document.getElementById("myNav");
    if(nav.style.height == "100%"){
        nav.style.height = "0%";
    } else {
        nav.style.height = "100%";
    }
}

function closeNav() {
    var nav = document.getElementById("myNav");
    nav.style.height = "0%";
}

function galleryToggle(event) {
    //var element = document.getElementById("myDIV");
    //element.classList.add("mystyle");
    var e = event.target;
    var kid = e.parentNode.children;
    var elements = document.getElementsByClassName("active");

    for (var i = 0; i < elements.length; i++) {
        if(elements[i].children){
            //If Fact active remove fact text and active class
            elements[i].children[0].classList.remove("hidden");
            elements[i].children[1].classList.add("hidden");
            elements[i].classList.remove("active");
        }
    }

    if(kid.length == 2){
        //Fact not active
        e.parentNode.classList.toggle("active");
        //IMG
        kid[0].classList.add("hidden");
        //IMG + TEXT
        kid[1].classList.remove("hidden");

    } else {
        //Fact already active - do nothing
    }

}
