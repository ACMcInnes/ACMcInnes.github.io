<?php
  // Start the session
  session_start();
  if(!isset($_SESSION["tally"])){
    $_SESSION["tally"] = 0;
  }

  if(!isset($_SESSION['sessioncart'])){
    $_SESSION['sessioncart'] = array();
  }

  if(!isset($_SESSION['sessionsearch'])){
    $_SESSION['sessionsearch'] = "SELECT * FROM shapes";
  }

  if(!isset($_SESSION['searchstring'])){
    $_SESSION['searchstring'] = "All Shapes";
  }
?>
<!DOCTYPE html>
<html>
<head>
<body>
<?php
    $servername = "localhost";
    $username = "root";
    $password = "EJT4eMU2jMn2"; //xamp "";
    $dbname = "shapes";
    $unset = false;
    

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    $dbstatus = "Connected successfully";



    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $unset = test_input($_GET["unset"] ?? false);
        if($unset){
            unset($_SESSION['sessioncart']);
            //session_unset();
            //session_destroy();
        }      
    }

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


function loopArray($array, $sessioncart){
    if(count($sessioncart)){
        echo 'cart lenght: '.count($sessioncart).'<br />';
        $total = 0;
        foreach($sessioncart as $a => $carts){
            foreach ($carts as $b => $cart) {
                //echo 'item: '.$cart.'<br />';
                //echo 'id: '.$carts[1].'<br />';
                if(isset ($array)){
                    //echo 'database set';
                    foreach ($array as $q => $values) {
                        foreach ($values as $c => $value) {
                            //echo '$value= '.$value.'';
                            //echo 'printing: '.$cart.' and: '.$value.'<br />';
                            if($cart == $value) {
                                //echo '<p>Item added to cart ['.$q.'] + ['.$c.']: '.$dbcontents[$q][$c].'</p>';
                                printCart($carts[1], $array[$q]);
                                $total += $array[$q]['price'];
                                break 3;

                                
                            }
                        }
                        unset($value);
                    } 
                    unset($values);            
                } else {
                    echo 'That item doesnt seem to be there, sorry about that';
                }
            }
            unset($cart);
        }
        unset($carts);
        echo 'cart lenght: '.count($sessioncart).'<br />';
        echo 'cart total: $'.$total.'';
    } else {
        echo '<p>Nothing in Cart, add something to continue</p>';
    }
    
    
    
}



function printCart($id, $row){
    if($row['price'] < 1){
        $tmpprice = "free!!";
    } else {
        $tmpprice = $row['price'];
    }
    echo '<div id="cart'.$id.'" class="card">
              <img class="image" src="images/shapes/'.$row['image'].'"/>
              <div class="cardcontent">
                  <p class="desc">'.$row['description'].'</p>
                  <p class="brand">Colour: '.$row['colour'].'</p>
                  <p class="brand">Price: '.$tmpprice.'</p>
                                          
                  <button class="button circular" type="button">Remove from Cart</button>
              </div>
          </div>';
}


function printQuery($id, $row){
    
		if($row['price'] < 1){
		    $tmpprice = "free!!";
    } else {
        $tmpprice = $row['price'];
    }
		echo '<div id="card'.$id.'" class="card">
              <img class="image" src="images/shapes/'.$row['image'].'"/>
              <div class="overlay">
                  <div class="text">Added to Cart</div>
              </div>
              <div class="cardcontent">
                  <p class="desc">'.$row['description'].'</p>
                  <p class="brand">Colour: '.$row['colour'].' Price: '.$tmpprice.'</p>
                                          
                  <button class="card-button button circular" type="button" 
                    onclick="loadCart(\''.$row['description'].'\', \''.$id.'\'); overlay('.$id.')">Add to Cart</button>
			        </div>
          </div>';
}

function myQueries($queryarray){
    $id = 0;
		foreach ($queryarray as $value){
			  printQuery($id, $value);
        $id++;
		}	
}

function queryArray($conn, $sql){
    $result = $conn->query($sql);
    $tmp = array();
    if ($result->num_rows >0) {
        while($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $tmp[] = $row;
        }
        $queryarray = $tmp;
        return $queryarray;
    } else {
        echo "<p class='error'>We couldn't find what you were looking for</p>";
        unset($_SESSION['sessionsearch']);
        exit();
    }
}
?>
</body>
</head>
</html>