<?php
include('../serverConnect.php');
include "checkLogin.php";

if (isset($_POST['btnregister'])) {
    $name = $_POST['txtstaffname'];
    $gender = $_POST['txtgender'];
    $usertype = $_POST['rdo'];
    $email = $_POST['txtemail'];
    $department = $_POST['txtdep'];
    $password = $_POST['txtpass'];

    $select = "SELECT * FROM Staff WHERE Email='$email'";
    $run = mysqli_query($connect, $select);

    $select1 = "SELECT * FROM Staff WHERE Department='$department' AND UserType='QAC'";
    $run1 = mysqli_query($connect, $select1);
    // $data = mysqli_fetch_array($run1);
    // $QACdepartment = $data["Department"];
    // $QACtype = $data["UserType"];

    if (mysqli_num_rows($run) > 0) {
        echo "<script> alert ('This Email is already taken');</script>";
    }
    // else if (mysqli_num_rows($run1) > 0) {
    //     echo "<script> alert ('QAC account is already existed for this department');</script>";
    // } 
    else {
        $password_hash = md5($password);
        $insert = "INSERT INTO `Staff`(`StaffID`, `StaffName`, `Gender`, `UserType`, `Email`, `Department`, `Password`) 
        VALUES (NULL,'$name','$gender','$usertype','$email','$department','$password_hash')";
        $run = mysqli_query($connect, $insert);
        if ($run) {
            echo "<script>
                alert('Staff Register Successful');
                </script>";
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
    <link rel="stylesheet" href="./style.css">
    <title>Register</title>
    <style>
        #register {
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
                    <p>Register Staff</p>
                    <img src="../Images/user.svg" alt="" srcset="">
                </div>

                <div class="bread-crump">
                    <ul class="bread-content">
                        <a href="index.php">Home</a>
                        <span>/</span>
                        <a href="#" id="this">Register Staff</a>
                    </ul>
                </div>

                <form method="POST" class="register-body">
                    <div>
                        <label>Staff Name</label> <br>
                        <input type="text" name="txtstaffname" required>
                    </div>
                    <div class="gender-type">
                        <div>
                            <label>Gender</label> <br>
                            <select name="txtgender" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div>
                            <label>User Type</label> <br>
                            <div class="radio-div">
                                <input type="radio" name="rdo" id="radio-staff" value="Staff" checked>
                                <label for="radio-staff">Staff</label>

                                <input type="radio" name="rdo" id="radio-qac" value="QAC">
                                <label for="radio-qac">QAC</label>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label>Email</label> <br>
                        <input type="email" name="txtemail" required>
                    </div>
                    <div>
                        <label>Department</label> <br>
                        <select name="txtdep" required>
                            <option value="Lecturer">Lecturer</option>
                            <option value="IT">IT</option>
                            <option value="Maintenance">Maintenance</option>
                        </select>
                    </div>
                    <div>
                        <label>Password</label> <br>
                        <input type="password" name="txtpass" required>
                    </div>
                    <div>
                        <label>Confirm Password</label> <br>
                        <input type="password" required>
                    </div>
                    <div class="register-btn">
                        <button type="submit" name="btnregister">Create</button>
                        <div>
                            <img src="../Images/arrow-right.svg" alt="" srcset="">
                            <a href="adminRegister.php">ADMIN</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>