<?php
session_start();
include('../serverConnect.php');

if (!isset($_SESSION['AdminID'])) {
    echo "<script>
    alert('Please Login');
    window.location.assign('adminLogin.php');
    </script>";
} else {
    if (isset($_POST['btncate'])) {
        $name = $_POST['txtcatename'];
        $date = $_POST['txtdate'];
        $des = $_POST['txtdes'];

        $select = "SELECT * FROM Category WHERE CategoryName='$name'";
        $run = mysqli_query($connect, $select);

        if (mysqli_num_rows($run) > 0) {
            echo "<script> alert ('This Category already exist');</script>";
        } else {
            $todayDate = date('Y-m-d H:i:s');
            // Function to find the difference 
            // between two dates.
            function dateDiffInSec($date1, $date2)
            {
                // Calculating the difference in timestamps
                $diff = strtotime($date2) - strtotime($date1);
                return abs(round($diff));
            }
            // Start date
            $date1 = "$todayDate";
            // End date
            $date2 = "$date";
            // Function call to find date difference
            $dateDiff = dateDiffInSec($date1, $date2);

            $insert = "INSERT INTO `Category`(`CategoryID`, `CategoryName`, `StartDate`, `EndDate`, `Description`, `Duration`) 
                VALUES (NULL,'$name','$todayDate','$date','$des','$dateDiff')";
            $run = mysqli_query($connect, $insert);

            if ($run) {
                echo "<script>
                        alert('Category Added Successfully');
                        </script>";

                $AdminID = $_SESSION['AdminID'];
                $select = "Select * from Category WHERE CategoryName ='$name'";
                $run1 = mysqli_query($connect, $select);
                $data = mysqli_fetch_array($run1);
                $CateID = $data[0];

                $insert1 = "INSERT INTO `AdminCategory`(`AdminID`, `CategoryID`) VALUES ('$AdminID', '$CateID')";
                $run2 = mysqli_query($connect, $insert1);
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css?v=1.4">
    <title>Register</title>
    <style>
        #category {
            background-color: #535353;
        }
    </style>
</head>

<body>
    <?php
    include "header.php";
    ?>

    <div class="container">
        <div class="body">
            <div class="form-wrap">
                <div class="register-head">
                    <p>Add Category</p>
                    <img src="../Images/user.svg" alt="" srcset="">
                </div>

                <div class="bread-crump">
                    <ul class="bread-content">
                        <a href="index.php">Home</a>
                        <span>/</span>
                        <a href="#" id="this">Add Category</a>
                    </ul>
                </div>

                <form method="POST" class="category-body">
                    <div class="category-wrap">
                        <div class="category-div">
                            <div>
                                <label>Category Name</label> <br>
                                <input type="text" name="txtcatename" required>
                            </div>

                            <div>
                                <label>Closure Date</label> <br>
                                <input type="datetime-local" name="txtdate" required>
                            </div>
                        </div>

                        <div>
                            <label>Description</label> <br>
                            <textarea name="txtdes" cols="30" rows="6" required></textarea>
                        </div>
                    </div>

                    <div class="register-btn cate-div">
                        <button type="submit" name="btncate">Create</button>
                        <a>Clear</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>