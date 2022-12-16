<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <!-- <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <title>Medicine Table</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet" />

</head>
<body id="page-top">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand" href="#page-top"> HOME </a>
                <button class="navbar-toggler text-uppercase font-weight-bold bg-primary text-white rounded" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="#portfolio">FOOD & MEDICINE</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <header class="masthead bg-primary text-white text-center">
            <div class="container d-flex align-items-center flex-column">
                <!-- Masthead Avatar Image-->
                
                <!-- Masthead Heading-->
                <h1 class="masthead-heading text-uppercase mb-0">MEDICINE TRACKER</h1>
                <!-- Icon Divider-->
                <div class="divider-custom divider-light">
                    <div class="divider-custom-line"></div>
                    <div class="divider-custom-icon"><i class="fas fa-heart"></i></div>
                    <div class="divider-custom-line"></div>
                </div>
                <!-- Masthead Subheading-->
                <p class="masthead-subheading font-weight-light mb-0">"Once your medicine is expired, You're going to feel pain and be tired"</p>
            </div>
        </header>
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mt-4">
                    <!-- <div class="card-header">
                        <h4>How to make Search box & filter data in HTML Table from Database in PHP MySQL </h4>
                    </div> -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-7">

                                <form action="" method="GET">
                                    <div class="input-group mb-3">
                                        
                                        
                                        <input type="text" name="search" value="<?php if(isset($_GET['search'])){echo $_GET['search']; } ?>" class="form-control" placeholder="Search data">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                        <a href="med.php" class="btn btn-secondary" title="Reset search">Reset</a>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">

                <div class="card mt-5">
                    <div class="card-body">
                        
                        <form action="" method="GET">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-group mb-3">
                                    
                                    </div>
                                    <div class="mt-5 mb-3 clearfix">
                                        <!--<i class="fa-sharp fa-solid fa-plate-utensils"></i>-->
                                        <!--<h2 class="pull-left">Employees Details</h2>-->
                                        <a href="create.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New
                                        Product</a>
                                        </div>
                                </div>
                            </div>
                        </form>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
					                <th>Medicine Name</th>
                                    <th>Storage</th>
					                <th>Expiration Date</th>
                                    <th>Days Left</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                <?php
                                    $conn = new mysqli("localhost","root","","cts_db");
                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    } 

                                    $query=$conn->query("select * from `employees`");

                                ?>
                                </thead>
                                <tbody>






                                <?php 
                                
                                $con = mysqli_connect("localhost","root","","cts_db");


                                if(isset($_GET['search']))
                                {
                                    $filtervalues = $_GET['search'];
                                    $query = "SELECT * FROM employees WHERE CONCAT(id,name,address,date) LIKE '%$filtervalues%' ";
                                    $query_run = mysqli_query($con, $query);

                                    if(mysqli_num_rows($query_run) > 0)
                                    {

                                                    
                                        foreach($query_run as $items)
                                        {
                                            ?>
                                            
                                            <tr>
                                                <td><?= $items['id']; ?></td>
                                                <td><?= $items['name']; ?></td>
                                                <td><?= $items['address']; ?></td>
                                                <td><?= $items['date']; ?></td>
                                                

                                                <td>

                                    <?php
                                        

                                         $thisDate = date("Y-m-d");
                                         $date = $items['date'];
                                         $usedDays = round(abs(strtotime($thisDate)-strtotime($date))/60/60/24);
                                         if($usedDays==0)
                                        {
                                            $conn->query("update `employees` set status='Expired' where id='".$items['id']."'");
                                            echo $usedDays;
                                        }
                                        else if ($usedDays<=7){
                                            $conn->query("update `employees` set status='Expiring Next week' where id='".$items['id']."'");
                                            echo $usedDays;

                                        }
                                        else if ($usedDays<=30){
                                            $conn->query("update `employees` set status='Expiring Soon' where id='".$items['id']."'");
                                            echo $usedDays;

                                        }
                                        else
                                        {
                                            echo $usedDays;
                                        }

                                       ?>
                                
                                    </td>
                                    <td><?php echo $items['status']; ?></td>




                                                <td><a href="read.php?id=<?php echo $items['id']; ?>"><span class="fa fa-eye"></span></a>&nbsp;
                                                <a href="update.php?id=<?php echo $items['id']; ?>"><span class="fa fa-pencil"></span></a>&nbsp;
                                                <a href="delete.php?id=<?php echo $items['id']; ?>"><span class="fa fa-trash"></span></a>
                                                </td>
                                                
                                                
                                            </tr>
                                            <?php
                                        }
                                    }
                                    else
                                    {
                                        ?>
                                            <tr>
                                                <td colspan="4">No Record Found</td>
                                            </tr>
                                        <?php
                                    }
                                }

                                                        
                                            
                        ?>

                            </tbody>
                        </table>

                    </div>
                </div>
                <div class="mt-5 mb-3 clearfix">
                                        <!--<i class="fa-sharp fa-solid fa-plate-utensils"></i>-->
                                        <!--<h2 class="pull-left">Employees Details</h2>-->
                                        <a href="welcome.php" class="btn btn-success pull-right"><i class="fa fa-angle-left"></i> Back to Home</a>
                                        </div>                      
            </div>
        </div>
    </div>
    <!-- Footer-->
    <br><br>
    <footer class="footer text-center">
            <div class="container">
                <div class="row">
                    <!-- Footer Location-->
                    <div class="col-lg-4 mb-5 mb-lg-0">
                        <h4 class="text-uppercase mb-4">Location</h4>
                        <p class="lead mb-0">
                        High Street corner 5th Avenue, 2Floor, 
                        Exchange Stock Market Mall, BGC 1634 
                        Makati National Capital Region                            
                        <br>
                            
                        </p>
                    </div>
                    <!-- Footer Social Icons-->
                    <div class="col-lg-4 mb-5 mb-lg-0">
                        <h4 class="text-uppercase mb-4">Our Socials</h4>
                        <a class="btn btn-outline-light btn-social mx-1" href="#!"><i class="fab fa-fw fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social mx-1" href="#!"><i class="fab fa-fw fa-twitter"></i></a>
                        <a class="btn btn-outline-light btn-social mx-1" href="#!"><i class="fab fa-fw fa-linkedin-in"></i></a>
                        <a class="btn btn-outline-light btn-social mx-1" href="#!"><i class="fab fa-fw fa-dribbble"></i></a>
                    </div>
                    <!-- Footer About Text-->
                    <div class="col-lg-4">
                        <h4 class="text-uppercase mb-4">Contact Number</h4>
                        <p class="lead mb-0">
                        0927 172 4480
                            
                        </p>
                    </div>
                </div>
            </div>
    </footer>

        <!-- Copyright Section-->
        <div class="copyright py-4 text-center text-white">
            <div class="container"><small>Copyright &copy; PROJECT VANILLA 2022</small></div>
        </div>
        


       
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="assets/js/scripts.js"></script>
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <!-- * *                               SB Forms JS                               * *-->
        <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>