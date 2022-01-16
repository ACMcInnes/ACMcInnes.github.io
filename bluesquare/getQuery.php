<!DOCTYPE html>
<html>
<head>
<body>
<?php

	include 'myFunctions.php';
   
    $file = fopen("shapes.csv","r");

    while (($data = fgetcsv($file, 10000, ";")) !== FALSE){
        $sql = "SELECT description FROM shapes WHERE description = '".$data[3]."'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            $fileread = "true, file already in db";
        } else {
            $sql = "INSERT INTO shapes (shape, price, colour, description, image) 
                VALUES (
                       '".$data[0]."',
                       '".$data[1]."',
                       '".$data[2]."',
                       '".$data[3]."',
                       '".$data[4]."'
                       )";
            
			if ($conn->query($sql) === TRUE) {
                $fileread = "true, new items added";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
	}


    //echo '<p>database status: '.$dbstatus .'</p>
    //      <p>file loaded into db: '. $fileread .'</p>
    //      <p>Queries:</p>';

    $shapes = '*';
    $colours = '*';
    $search = '';
    $dbcontents = queryArray($conn, "SELECT * FROM shapes");
    $unset = false;
       

    // Strip search results of any nasty input

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $shapes = test_input($_GET["shapes"] ?? '*');
        $colours = test_input($_GET["colours"] ?? '*');
        $search = test_input($_GET["search"] ?? '');
        
        //array_push($_SESSION['sessioncart'], test_input($_POST["add2cart"] ?? ''));
       
            
    }

    

    //Select from dropdowns
    //echo '<p>selected shape: '.$shapes .'</p>
    //      <p>selected colour: '.$colours.'</p>
    //      <p>searched: '.$search.'</p>';

    //Form dropdown results into sql queries
    if ($shapes == "*"){
        $sqlshape = "";
    } else {
        $sqlshape = " WHERE shape = '".$shapes."'";
    }
	if ($colours == "*"){
        $sqlcolour = "";
        $selector = "";
    } elseif ($sqlshape == ""){
        $selector = " WHERE ";
        $sqlcolour = "".$selector."colour = '".$colours."'";
    } else {
        $selector = " AND ";
        $sqlcolour = "".$selector."colour = '".$colours."'";
    }
        

    $sqlfilter = "SELECT * FROM shapes".$sqlshape.$sqlcolour."";
    //echo '<p>sqlfilter: '.$sqlfilter.'</p>';

    // Search bar overrides drop down menu
    if($search != ""){
        $first = true;
        $sqlfilter = "SELECT * FROM shapes WHERE ";
        $tmparray = preg_split("/[\s,]+/", $search);
        foreach ($tmparray as $value) {
            if ($first){
            	$first = false;
            	$sqlfilter .= "description LIKE '%".$value."%'";
            } else {
            	$sqlfilter .= " OR description LIKE '%".$value."%'";
            }
        }
        //echo '<p>sqlfilter search: '.$sqlfilter.'</p>';
    }

    // Tidy Up Search query for display
    $tmpstring = "";
    if($shapes == "*" && $colours == "*"){
        $tmpstring = "All Shapes";
    } elseif ($colours == "*"){
        $tmpstring = $shapes."'s of all colours";
    } elseif ($shapes == "*") {
        $tmpstring = "All Shapes that are ".$colours;
    } else {
        $tmpstring = $shapes."'s that are ".$colours."";
    }

    if($search !=""){
        $tmpstring = $search. " Shapes";
    }
    //Output search results to screen
    echo '<div class="row">
              <h1 class="search-header col-12">Current Search: '.$tmpstring.'</h1>
          </div>

          <div class="flex-container">';

              myQueries(queryArray($conn, $sqlfilter));
    echo '</div>';
    $_SESSION['searchstring'] = $tmpstring;
	$_SESSION['sessionsearch'] = $sqlfilter;
	//myQueries(queryArray($conn, $sqlfilter));
        


    fclose($file);
    $conn->close();
?>		
</body>
</head>
</html>