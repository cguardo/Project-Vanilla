<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$name = $address = $date = "";
$name_err = $address_err = $date_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    $input_name = trim($_POST["name"]);
    if (empty($input_name)) {
        $name_err = "Please enter the food name.";
    } elseif (!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $name_err = "Please enter a valid food name.";
    } else {
        $name = $input_name;
    }

    // Validate address
    $input_address = trim($_POST["address"]);
    if (empty($input_address)) {
        $address_err = "Food Storage:";
    } else {
        $address = $input_address;
    }

    // Validate date
    $input_date = trim($_POST["date"]);
    if (empty($input_date)) {
         $date_err = "Please enter the expiration date";
    }
    //elseif (!ctype_digit($input_date)) {
    //     $date_err = "Please enter a positive integer value.";} 
    else {
        $date = $input_date;
    }

    // Check input errors before inserting in database
    if (empty($name_err) && empty($address_err) && empty($date_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO employees (name, address, date) VALUES (?, ?, ?)";

        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sss", $param_name, $param_address, $param_date);

            // Set parameters
            $param_name = $name;
            $param_address = $address;
            $param_date = $date;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Records created successfully. Redirect to landing page
                header("location: food.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        $stmt->close();
    }

    // Close connection
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<title>Login V18</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>

<body style="background-color: #666666;">
<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login1001">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
					<span class="login100-form-title p-b-43">
                    Add Food Record
					</span>
                    <p>Please fill this form and submit to add your food record to the database.</p>


					<div class="wrap-input100 validate-input" data-validate = "Enter a valid name">
						<input type="text" name="name" class="input100 <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
						<span class="focus-input100"></span>
						<span class="label-input100">Food Name</span>
						<span class="invalid-feedback"><?php echo $name_err; ?></span>
					</div>


					<div class="wrap-input100 validate-input" data-validate = "Enter a valid storage">
						<input type="text" name="address" class="input100 <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>"><?php echo $address; ?>
						<span class="focus-input100"></span>
						<span class="label-input100">Storage</span>
                        <span class="invalid-feedback"><?php echo $address_err; ?></span>
					</div>

                    <div class="wrap-input100 validate-input" data-validate="date is required">
						<input type="date" name="date" class="input100 <?php echo (!empty($salary_err)) ? 'is-invalid' : ''; ?>"value="<?php echo $salary; ?>">
						<span class="focus-input100"></span>
						<span class="label-input100">Expiration Date</span>
						<span class="invalid-feedback"><?php echo $salary_err; ?></span>
					</div>

					<div class="flex-sb-m w-full p-t-3 p-b-32">
						<!--<div class="contact100-form-checkbox">
							<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
							<label class="label-checkbox100" for="ckb1">
								Remember me
							</label>
						</div>-->

					</div>


                    <input type="hidden" name="id" value="<?php echo $id; ?>" />
                        <a href="food.php"><input type="submit" class="btn btn-primary" value="Submit"/></a>
                        <a href="food.php" class="btn btn-secondary ml-2">Cancel</a>


				</form>

				<!--<div class="login100-more" style="background-image: url('images/bg-01.jpg');">
				</div> -->
			</div>
		</div>
	</div>

 <!--===============================================================================================-->
 <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>   
</body>

</html>