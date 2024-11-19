<?php
include('../serverConnect.php');
include "checkLogin.php";

if (isset($_POST['btnregister'])) {
    $name = $_POST['txtadminname'];
    $gender = $_POST['txtgender'];
    $email = $_POST['txtemail'];
    $password = $_POST['txtpass'];

    $select = "SELECT * FROM Admin WHERE Email='$email'";
    $run = mysqli_query($connect, $select);

    if (mysqli_num_rows($run) > 0) {
        echo "<script> alert ('This Email is already taken');</script>";
    } else {
        $password_hash = md5($password);
        $insert = "INSERT INTO `Admin`(`AdminID`, `AdminName`, `Gender`, `Email`, `Password`) 
        VALUES (NULL,'$name','$gender','$email','$password_hash')";
        $run = mysqli_query($connect, $insert);
        if ($run) {
            echo "<script>
                alert('Admin Register Successful');
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
                    <p>Register Admin</p>
                    <img src="../Images/user.svg" alt="" srcset="">
                </div>

                <div class="bread-crump">
                    <ul class="bread-content">
                        <a href="index.php">Home</a>
                        <span>/</span>
                        <a href="staffRegister.php">Register Staff</a>
                        <span>/</span>
                        <a href="#" id="this">Register Admin</a>
                    </ul>
                </div>

                <form method="POST" class="register-body">
                    <div>
                        <label>Admin Name</label>
                        <input type="text" name="txtadminname" required>
                    </div>
                    <div>
                        <label>Gender</label>
                        <select name="txtgender" required>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div>
                        <label>Email</label>
                        <input type="email" name="txtemail" required>
                    </div>
                    <div>
                        <label>Password</label>
                        <input type="password" name="txtpass" required>
                    </div>
                    <div>
                        <label>Confirm Password</label>
                        <input type="password" required>
                    </div> <br>
                    <div class="register-btn">
                        <button type="submit" name="btnregister">Create</button>
                        <div>
                            <img src="../Images/arrow-right.svg" alt="" srcset="">
                            <a href="staffRegister.php">STAFF</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>