<?php 
include '../conn.php';
    //fetching transaction info//
    $result = mysqli_query($connect, "SELECT * FROM users
    INNER JOIN reg_transaction ON  users.id = reg_transaction.user_id
    INNER JOIN office ON reg_transaction.office_id = office.id
    INNER JOIN reg_services ON reg_transaction.services_id = reg_services.services_id
    INNER JOIN reg_status ON reg_transaction.status_id = reg_status.id");
   
   $table = 'view_table';
        if (isset($_POST['submit'])) {
            $table = $_POST['table-select'];
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Office - Your Registrar Transactions</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="/assets/favicon.ico">
    <link rel="stylesheet" href="/node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/style.css">
    <script src="https://kit.fontawesome.com/fe96d845ef.js" crossorigin="anonymous"></script>
    <script src="/node_modules/jquery/dist/jquery.min.js"></script>
    <script src="/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <link rel="icon" type="image/x-icon" href="../../../assets/favicon.ico">
    <link rel="stylesheet" href="../../../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../style.css">
    <script src="https://kit.fontawesome.com/fe96d845ef.js" crossorigin="anonymous"></script>
    <script src="../../../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../../../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> -->
</head>
<body>
    <div class="wrapper">
        <?php
            $office_name = "Registrar Office";
            include "../navbar.php";
            include "../../breadcrumb.php";
        ?>
        <div class="container-fluid p-4">
            <?php
            $breadcrumbItems = [
                ['text' => 'Registrar Office', 'url' => '../registrar.php', 'active' => false],
                ['text' => 'Registrar Transactions History', 'active' => true],
            ];

            echo generateBreadcrumb($breadcrumbItems, true);
            ?>
        </div>
        <div class="container-fluid text-center p-4">
            <h1>My Transactions</h1>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12">
                    <div class="alert alert-info" role="alert">
                        <h4 class="alert-heading">
                        <i class="fa-solid fa-circle-info"></i> Reminder
                        </h4>
                        <p class="mb-0" >Always check your transaction status to follow instructions.</p>
                        <p class="mb-0">You can delete and edit transactions during <span class="badge rounded-pill bg-dark">Pending</span> status.</p>
                        <p class="mb-0"><small><span class="badge rounded-pill bg-dark">Pending</span> - The requester should settle the deficiency/ies to necessary office.</small></p>
                        <p class="mb-0"><small><span class="badge rounded-pill" style="background-color: orange;">For receiving</span> - The request is currently in Receiving window and waiting for submission of requirements.</small></p>
                        <p class="mb-0"><small><span class="badge rounded-pill" style="background-color: blue;">For evaluation</span> - Evaluation and Processing of records and required documents for releasing.</small></p>
                        <p class="mb-0"><small><span class="badge rounded-pill" style="background-color: DodgerBlue;">Ready for pickup</span> - The requested document/s is/are already available for pickup at the releasing section of student records.</small></p>
                        <p class="mb-0"><small><span class="badge rounded-pill" style="background-color: green;">Released</span> - The requested document/s was/were claimed.</small></p>
                        <p class="mb-0">You will find answers to the questions we get asked the most about requesting for academic documents through <a href="FAQ.php">FAQs</a>.</p>
                    </div>
                    <div class="d-flex w-100 justify-content-between p-0">
                        <div class="d-flex p-2">
                            <form class="d-flex" action="your_transaction.php" method="post">
                                <select class="form-select" name="table-select">
                                    <option value="view_table" <?php if ($table === 'view_table') echo 'selected'; ?>>View Table</option>
                                    <option value="delete_table" <?php if ($table === 'delete_table') echo 'selected'; ?>>Delete Table</option>
                                    <option value="edit_table" <?php if ($table === 'edit_table') echo 'selected'; ?>>Edit Table</option>
                                </select>
                                <button type="submit" name="submit" class="btn btn-primary">Filter</button>
                            </form>
                        </div>
                    </div>
                    <div id="table-container">
                        <?php
                            // Load the requested table
                            if ($table === 'view_table') {
                                include 'trans_tables/view_row.php';
                            } elseif ($table === 'delete_table') {
                                include 'trans_tables/delete_row.php';
                            } elseif ($table === 'edit_table') {
                                include 'trans_tables/edit_row.php';
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="push"></div>
    </div>
    <footer class="footer container-fluid w-100 text-md-left text-center d-md-flex align-items-center justify-content-center bg-light flex-nowrap">
            <small>PUP Santa Rosa - Online Transaction Management System Beta 0.1.0</small>
        </div>
        <div>
            <small><a href="https://www.pup.edu.ph/terms/" target="_blank" class="btn btn-link">Terms of Use</a>|</small>
            <small><a href="https://www.pup.edu.ph/privacy/" target="_blank" class="btn btn-link">Privacy Statement</a></small>
        </div>
    </footer>
    <?php
        mysqli_close($connect);
    ?>
    <script>
        $(document).ready(function(){
            $('.dropdown-submenu a.dropdown-toggle').on("click", function(e){
            $(this).next('ul').toggle();
            e.stopPropagation();
            e.preventDefault();
            });
        });
    </script>
</body>
</html>