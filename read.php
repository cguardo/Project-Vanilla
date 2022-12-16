<?php
// Check existence of id parameter before processing further
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    // Include config file
    require_once "config.php";

    // Prepare a select statement
    $sql = "SELECT * FROM employees WHERE id = ?";

    if ($stmt = $mysqli->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("i", $param_id);

        // Set parameters
        $param_id = trim($_GET["id"]);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = $result->fetch_array(MYSQLI_ASSOC);

                // Retrieve individual field value
                $name = $row["name"];
                $address = $row["address"];
                $date = $row["date"];
            } else {
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    // Close statement
    $stmt->close();

    // Close connection
    $mysqli->close();
} 
else {
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>

<!doctype html>
<html lang="en">
  <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Project Vanilla View</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css" />

	<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,700' rel='stylesheet' type='text/css'>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="css/style1.css">


	</head>
	<body>
    
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
					<h2 class="heading-section">View Food Records</h2>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="table-wrap">
						<table class="table table-bordered table-dark table-hover">
						  <thead>
						    <tr>

						      <th>Food Name</th>
						      <th>Storage</th>
						      <th>Expiration Date</th>
                  <th>Days Left</th>
                  <th>Status</th>
						    </tr>
                
						  </thead>
						  <tbody>
              <?php
                      $conn = new mysqli("localhost","root","","cts_db");
                      if ($conn->connect_error) {
                          die("Connection failed: " . $conn->connect_error);
                      } 

                    $query=$conn->query("select * from `employees`");

                  ?>
						    <tr>
						      
						      <td><?php echo $row["name"]; ?></td>
						      <td><?php echo $row["address"]; ?></td>
						      <td><?php echo $row["date"]; ?></td>
                  <td>
                  <?php
                                        

                                         $thisDate = date("Y-m-d");
                                         $date = $row['date'];
                                         $usedDays = round(abs(strtotime($thisDate)-strtotime($date))/60/60/24);
                                         if($usedDays==0)
                                        {
                                            $conn->query("update `employees` set status='Expired' where id='".$row['id']."'");
                                            echo $usedDays;
                                        }
                                        else if ($usedDays<=7){
                                            $conn->query("update `employees` set status='Expiring Next week' where id='".$row['id']."'");
                                            echo $usedDays;

                                        }
                                        else if ($usedDays<=30){
                                            $conn->query("update `employees` set status='Expiring Soon' where id='".$row['id']."'");
                                            echo $usedDays;

                                        }
                                        else
                                        {
                                            echo $usedDays;
                                        }

                                       ?>
                                
                                    </td>
                                    <td><?php echo $row['status']; ?></td>
						    </tr>

</tbody>
						</table>
					</div> <p><a href="food.php" class="btn btn-primary">Back</a></p>
				</div>
			</div>
		</div>
	</section> </body> </html>