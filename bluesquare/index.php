<?php
  include 'myFunctions.php';
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\OAuth;
  // Alias the League Google OAuth2 provider class
  use League\OAuth2\Client\Provider\Google;
  require "../vendor/autoload.php";
?>
<!DOCTYPE html>
<html lang="en-AU">
<head>
	<title>Bluesquare - Andrew McInnes Portfolio</title>
	<meta charset="utf-8">
  <meta name="description" content="A Mock Store created by me, Andrew McInnes,
  part of my portfolio. Using AJAX PHP and MySQL to display different products.">
  <meta name="author" content="Andrew McInnes"> 
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="css/bluesquare.css">
  <script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>

  <?php

  // define variables and set to empty values
  $nameErr = $emailErr = $commentErr = "";
  $name = $fromEmail = $comment = $response =  "";
  $sent = false;
  $sentMsg = "";
  $ready = false;
  
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $response = $_POST["g-recaptcha-response"];
      $url = "https://www.google.com/recaptcha/api/siteverify";
      $data = array(
              'secret' => '6LfeV0cUAAAAAImgURX6BTS_seXtzYLwo0LSi5k3',
              'response' => $response
      );
      $options = array(
                 'http' => array(
                        'method' => 'POST',
                        'content' => http_build_query($data)
                  )
      );
      $context = stream_context_create($options);
      $verify = file_get_contents($url, false, $context);
      $captcha_success = json_decode($verify);



      if (empty($_POST["name"])) {
          $nameErr = "Name is required";
      } else {
          $name = test_input($_POST["name"]);
          // check if name only contains letters and whitespace
          if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
              $nameErr = "Only letters and white space allowed"; 
          }
          // name valid, check email
          if (empty($_POST["email"])) {
              $emailErr = "Email is required";
          } else {
              $fromEmail = test_input($_POST["email"]);
              // check if e-mail address is well-formed
              if (!filter_var($fromEmail, FILTER_VALIDATE_EMAIL)) {
                  $emailErr = "Invalid email format"; 
              }
              // name and email valid, check comment
              if (empty($_POST["comment"])) {
                  $commentErr = "Comment is required";
              } else {
                  $comment = test_input($_POST["comment"]);
                  // all fields valid
                  if ($captcha_success->success==false){
                      $sentMsg = "Looks like you're a robot, try clicking the reCAPTCHA box";
                  } else if ($captcha_success->success==true){
                      $sentMsg = "Looks good, sending message...";
                      $ready = true;
                  } 
              }
          }
      }    
  }
  if($ready){

    //Create a new PHPMailer instance
    $mail = new PHPMailer;
    //Tell PHPMailer to use SMTP
    $mail->isSMTP();
    //Enable SMTP debugging
    // 0 = off (for production use)
    // 1 = client messages
    // 2 = client and server messages
    $mail->SMTPDebug = 0;
    //Set the hostname of the mail server
    $mail->Host = 'smtp.gmail.com';
    //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
    $mail->Port = 587;
    //Set the encryption system to use - ssl (deprecated) or tls
    $mail->SMTPSecure = 'tls';
    //Whether to use SMTP authentication
    $mail->SMTPAuth = true;
    //Set AuthType to use XOAUTH2
    $mail->AuthType = 'XOAUTH2';
    //Fill in authentication details here
    //Either the gmail account owner, or the user that gave consent
    $email = 'mcinnesdesigns@gmail.com';
    $clientId = '1054743567262-b2jcsgqk2nmj1qcsvus1f8s9lpmk2cnn.apps.googleusercontent.com';
    $clientSecret = '2XV0R8mEo4YKQuieWdoHfh9_';
    //Obtained by configuring and running get_oauth_token.php
    //after setting up an app in Google Developer Console.
    $refreshToken = '1/BBNvQ-2FguIKk6DP_aJP_LUi7cDgG7NVPFiV-MCqVi8';
    //Create a new OAuth2 provider instance
    $provider = new Google([
        'clientId' => $clientId,
        'clientSecret' => $clientSecret
    ]);
    //Pass the OAuth provider instance to PHPMailer
    $mail->setOAuth(
        new OAuth([
            'provider' => $provider,
            'clientId' => $clientId,
            'clientSecret' => $clientSecret,
            'refreshToken' => $refreshToken,
            'userName' => $email
        ])
    );
    //Set who the message is to be sent from
    //For gmail, this generally needs to be the same as the user you logged in as
    $mail->setFrom($email, 'Andrew');
    //Set who the message is to be sent to
    $mail->addAddress('mcinnesdesigns@gmail.com', 'Andrew');
    //Set the subject line
    $mail->Subject = 'Email from ' . $name;
    //Read an HTML message body from an external file, convert referenced images to embedded,
    //convert HTML into a basic plain-text alternative body
    $mail->CharSet = 'utf-8';
    //$mail->msgHTML(file_get_contents('contentsutf8.html'), dirname(__FILE__));
    $mail->Body = $comment . ' From: ' . $fromEmail;
    //Replace the plain text body with one created manually
    $mail->AltBody = 'This is a plain-text message body';
    //Attach an image file
    //$mail->addAttachment('images/phpmailer_mini.png');
    //send the message, check for errors
    if (!$mail->send()) {
        $sentMsg = "Mailer Error: " . $mail->ErrorInfo;
    } else {
        $sentMsg = "Message sent!";
        $nameErr = $emailErr = $commentErr = "";
        $name = $fromEmail = $comment = $response =  "";
    }  
  } 

?>    

  <nav>
    <a href="http://acmcinnes.com.au">Portfolio</a>
    <div id="navmenu">
      <a href="#">Home</a>
      <a href="#about-top">About</a>
      <a href="#contact-top">Contact</a>
      <div class="dropdown">
        <a href="#" class="dropbtn">Range <i class="down"></i></a>
        <div class="dropdown-content">
          <div class="dropdown-header">
            <h2>Full Range</h2>
          </div>
          <div class="row">
            <div class="column col-4 col-m-6">
              <h3>Shapes</h3>

              <button class="not-a-button" type="button" onclick="loadURL('Square', '*', '')">Square</button>
              <button class="not-a-button" type="button" onclick="loadURL('Circle', '*', '')">Circle</button>
              <button class="not-a-button" type="button" onclick="loadURL('Triangle', '*', '')">Triangle</button>
              <button class="not-a-button" type="button" onclick="loadURL('Polygon', '*', '')">Polygon</button>
              <button class="not-a-button" type="button" onclick="loadURL('*', '*', '')">All</button>
        
            </div>

            <div class="column col-4 col-m-6">
              <h3>Colours</h3>

              <button class="not-a-button" type="button" onclick="loadURL('*', 'Red', '')">Red</button>
              <button class="not-a-button" type="button" onclick="loadURL('*', 'Blue', '')">Blue</button>
              <button class="not-a-button" type="button" onclick="loadURL('*', 'Green', '')">Green</button>
              <button class="not-a-button" type="button" onclick="loadURL('*', 'Yellow', '')">Yellow</button>
              <button class="not-a-button" type="button" onclick="loadURL('*', 'Black', '')">Black</button>
              <button class="not-a-button" type="button" onclick="loadURL('*', '*', '')">All</button>

            </div>
            <div class="column col-4 col-m-6">
              <img src="images/logo.svg" alt="bluesquare logo">
            </div>
          </div>
        </div>
      </div>
      <a href="javascript:void(0)" id="opencart">Cart</a>
    </div>
    <form id="navform">
      <input id="searchnav" type="text" name="search" placeholder="search..." onchange="loadURL('*','*',this.value)">
    </form>
  </nav>

  <header id="home">
    <div class="skewed"></div>

    <div id="headercontent">
      <h4>We are all about shapes here at</h4>
      <h1>bluesquare</h1>
    </div>
  </header>
    
  <div class="margin-topper">
    <div class="slant"></div>

    <p class="center">Can we help you find anything today?</p>

    <form id="searchbar">
      <input id="searchbox" type="text" name="search" placeholder="red, square, blue triangle...">
      <button id="searchbtn" type="button" onclick="loadURL('*','*',search.value)">Search</button>
    </form>


    <p class="line center">Or select from the options below:</p>

    <div class="select-flex">
      <form id="dropsearch">
        <p>Shapes:</p>
        <select name ="shapes">
          <option value="Square">Square</option>
          <option value="Circle">Circle</option>
          <option value="Triangle">Triangle</option>
          <option value="Polygon">Polygon</option>
          <option value="*" selected>All</option>
        </select>

        <p>Colours:</p>
        <select name="colours">
          <option value="Red">Red</option>
          <option value="Blue">Blue</option>
          <option value="Green">Green</option>
          <option value="Yellow">Yellow</option>
          <option value="Black">Black</option>
          <option value="*" selected>All</option>
        </select>  
      </form>
      <div class="selectbtn">
        <input id="selectbtn" class="button circular" type="button" form="dropsearch" onclick="loadURL(shapes.value, colours.value, '')" value="Search">
      </div>
    </div>
  </div>

  <div id="searchResults">
    <div class="row ">
      <h1 id="searchRow" class="search-header col-12">Last Search:</h1>
    </div>
    <div class ="flex-container">
      <?php myQueries(queryArray($conn, $_SESSION['sessionsearch'])); ?>
    </div>
  </div>

	
  <div>
    <h4 class="search-header col-12">Did you find everything you were looking for?</h4>
  </div>

  <form id="searchbar">
      <input id="searchbox" type="text" name="search" placeholder="red, square, blue triangle...">
      <button id="searchbtn" type="button" onclick="loadURL('*','*',search.value)">Search</button>
  </form>

  <div id="reco-top" class="background-black">
    <div class="row">
      <h4 class="search-header blue col-12">Recomendations</h4>
    </div>
    <div class ="flex-container">
      <div class="promo">
        <p>I never knew how much I needed a Yellow Polygon until I found Bluesquare,
           Everything was super easy to set up, love how yellow it is!!</p>
        <p class="inset">Larry - Customer</p>
      </div>
      <div class="promo">
        <p>I've spent so much time looking at sites for different shapes, finally BLuesquare
           has allowed me to view all the shapes I could need, in one easy place. Amazing.</p>
        <p class="inset">Bec - Customer</p>
      </div>
      <div class="promo">
        <p>Just purchased five of the Green Circles, looked exactly as the picture online,
           super impressed with the quality, thanks Bluesquare!!</p>
        <p class="inset">Matt - Customer</p>
      </div>
    </div>
  </div>

  <div id="about-top" class="row">
    <h4 class="search-header col-12">About</h4>
  </div>
  <div id="about">
    <p>Bluesquare is a website created by myself, Andrew McInnes. I studied Information Technology
       at the University of Queensland, with an interest in Human Computer Interaction, I enjoy
       creating interesting graphics, responsive websites and intuitive interfaces. </p>
    <p>This website showcases a potential store front, database queries are created by selecting
       any of the menu range or dropdown selectors, potential customers can also use the search box
       to create their own query. Once a selection is made the query is sent to a database of items,
       then items matching the query are sent back to be displayed.</p>
    <p>Customers can then add items to a cart to be purchased, or remove them from the cart if no longer
       wanted. All of this is done asynchronously thanks to AJAX, this means less interruption for the
       customer, and a more fluid experience overall.</p>
    <p>Please view my other page for some of my graphic design work: 
       <a class="link blue" href="http://acmcinnes.azurewebsites.net">Portfolio</a></p>
  </div>

  <div id="contact-top" class="background-black">
    <div class="row">
      <h4 class="search-header blue col-12">Contact</h4>
    </div>
    <div id="contact">
      <p>Currently available</p>
      <form class="contact-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>#contact-top">
         <label for="name">Name:</label><input type="text" name="name" value="<?php echo $name;?>">
        <span class="error">* <?php echo $nameErr;?></span>
        <br><br>
         <label for="email">E-mail:</label><input type="text" name="email" value="<?php echo $fromEmail;?>">
        <span class="error">* <?php echo $emailErr;?></span>
        <br><br>
         <label for="comment">Comment:</label><textarea placeholder=" " name="comment" rows="12"><?php echo $comment;?></textarea>
        <span class="error">* <?php echo $commentErr;?></span>
        <br><br>

        <div class="captcha-container">
          <div class="g-recaptcha" data-sitekey="6LfeV0cUAAAAACOZw6rn7haWKhLOiHCp4m501gcX"></div>
          <input class="form button" type="submit" name="submit" value="Send" style="align-self: center">
        </div>
      </form>
      <div class="row">
        <h4 class="search-header blue col-12"><?php echo $sentMsg;?></h4>
      </div>
    </div>
  </div>

<footer>
  <p>Website created and built by Andrew McInnes</p>
  <p>deployed using</p>
  <a href="https://cloud.google.com"><img src="images/gcp.png" alt="Google Cloud Platform"></a>
  <a href="https://bitnami.com/stack/lamp"><img src="images/lamp.png" alt="LAMP Stack"></a>
  <p>Google Cloud Platform + LAMP Stack</p>
  
  <p><a class="link blue" href="#">Back to Top</a></p>
  <p class="footer-padding">&copy 2018 - ABN: 32 205 159 015</p>
</footer>




	<div  class="nav-widget">
		<svg id="nav-toggle" height="100" width="100">
  			<circle cx="50" cy="50" r="40" fill="#fff" />
  			<text fill="#333"  font-size="60" x="35" y="65">+</text>
  			<!--transform="rotate(45 50 50)"-->
		</svg>
	</div>

	<div id="nav-modal" class="modal">
		<div class="modal-content">
			<svg id="nav-1" height="100" width="100">
  				<circle cx="50" cy="50" r="40" fill="#fff" />
  				<text fill="#333"  font-size="60" x="35" y="65">1</text>
  				<!--transform="rotate(45 50 50)"-->
			</svg>

			<svg id="nav-2" height="100" width="100">
  				<circle cx="50" cy="50" r="40" fill="#fff" />
  				<text fill="#333"  font-size="60" x="35" y="65">2</text>
  				<!--transform="rotate(45 50 50)"-->
			</svg>

			<svg id="nav-3" height="100" width="100">
  				<circle cx="50" cy="50" r="40" fill="#fff" />
  				<text fill="#333"  font-size="60" x="35" y="65">3</text>
  				<!--transform="rotate(45 50 50)"-->
			</svg>
		</div>
	</div>


  <div id="sidebarbackground" class="sidebar-background">
    <div id="sidebarcart" class="sidebar">
      <a href="javascript:void(0)" id="closecart" class="closebtn">&times;</a>
      <p>Your Cart:</p>

      <div id="cartContents">
        <?php
          $dbcontents = queryArray($conn, "SELECT * FROM shapes"); 
          loopArray($dbcontents, $_SESSION['sessioncart']); 
        ?>
      </div>

      <button class="button circular" type="button" onclick="loadDoc('myFunctions.php?unset=true', showCart); removeOverlay()">Empty Cart</button>

    </div>
  </div>

<script src="js/bluesquare.js"></script>

<script>
    //If page refreshed - show last search
    document.getElementById("searchRow").innerHTML = "Current Search: <?php echo $_SESSION['searchstring']; ?>";

    var cart = <?php echo json_encode($_SESSION['sessioncart']); ?>;
    if(cart.length){
      cart.forEach(printCart);
    }
    
    function printCart(item, index) {
      overlay(item[1]);
    }

    function loadDoc(url, cFunction) {
        var xhttp;

        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                cFunction(this);
            }
        };
        xhttp.open("GET", url, true);
        xhttp.send();
    }

    function loadURL(shape, colour, search) {
        var url = "getQuery.php?shapes=" + shape + "&colours=" + colour + "&search=" + search;
        console.log("query: shape=" + shape + " colour=" + colour + " search=" + search);
        loadDoc(url, showQuery);
    }

     function loadCart(desc, id) {
        var url = "getCart.php?add2cart=" + desc + "&id=" + id;
        console.log("cart: " + desc + " id: " + id);
        loadDoc(url, showCart);
    }

    function overlay(card){
        console.log("card= " + card)
        //var element = document.getElementById(card);
        var element = document.getElementsByClassName('overlay')[card];
        //element.classList.add("toggle-overlay");
        element.style.height = "20%";
    }

    function removeOverlay(){
        var element = document.getElementsByClassName('overlay');
        var i;
        for (i = 0; i < element.length; i++){
          element[i].style.height = "0";
        }
    }

    function showQuery(xhttp) {
        
        document.getElementById("searchResults").innerHTML = xhttp.responseText;
        window.location.hash="searchResults";
    }

    function showCart(xhttp) {
        console.log("cart modified");
        document.getElementById("cartContents").innerHTML = xhttp.responseText;
    }  

</script>

</body>
</html>