<?php
session_start();
include('serverConnect.php');

if (isset($_POST['btnlogin'])) {
    $email = $_POST['txtemail'];
    $pass = $_POST['txtpass'];
    $password_hash = md5($pass);
    $select = "Select * from Staff where Email='$email' and Password='$password_hash'";
    $run = mysqli_query($connect, $select);

    $count = mysqli_num_rows($run);
    if ($count > 0) {
        $data = mysqli_fetch_array($run);
        $StaffID = $data[0];
        $_SESSION['StaffID'] = $StaffID;

        echo "<script>   
        alert('Staff Login Successful');
        window.location.assign('index.php');
        </script>";
    } else {
        echo "<script>   
    		alert('Incorrect UserName or Password');
    	</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./Admin/style.css?v=2.8">
    <style>
    </style>
    <title>Staff Login</title>
    <style>
        .login-body h1 {
            color: #294852;
        }

        .register-btn button {
            background-color: #294852;
        }

        .register-btn a {
            color: #294852;
            border: 2px solid #294852;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <form method="POST" class="login-body">
            <h1>Staff Login</h1>
            <div>
                <label>Email</label>
                <input type="email" name="txtemail" required>
            </div>
            <div>
                <label>Password</label>
                <input type="password" name="txtpass" required>
            </div>

            <div class="terms">
                <p>By continuing, I aggree to <a target="_blank" rel="noopener noreferrer" href="https://www.termsandcondiitionssample.com/live.php?token=BdmoTnMhe1kvSju7JdWNTNqMCLgCK1Fg">Terms and Conditions</a></p>
            </div>

            <div>
                <div class="register-btn" style="justify-content: center; margin-top: 1.6rem;">
                    <button type="submit" name="btnlogin">Login</button>
                    <div>
                        <img src="./Images/arrow-right.svg" alt="" srcset="">
                        <a href="./Admin/adminLogin.php">ADMIN</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>

</html>