<?php
include "checkLogin.php";
include('../serverConnect.php');

//select all number staff, category, ideas
$runStaffs = mysqli_query($connect, "SELECT * FROM Staff");
$countStaffs = mysqli_num_rows($runStaffs);

$runCate = mysqli_query($connect, "SELECT * FROM Category");
$countCate = mysqli_num_rows($runCate);

$runIdeas = mysqli_query($connect, "SELECT * FROM Ideas");
$countIdeas = mysqli_num_rows($runIdeas);

//select users with most ideas
$runmostname = mysqli_query($connect, "SELECT StaffName, count(StaffID) from Ideas group by StaffID order by count(StaffID) desc");
$runmostdep = mysqli_query($connect, "SELECT Department, count(StaffID) from Ideas group by StaffID order by count(StaffID) desc");
// $dataassoc = mysqli_fetch_assoc($runmostid);
// $mostuserid = $dataassoc["StaffID"];
// $runfinalmostid = mysqli_query($connect, "SELECT * from Staff WHERE StaffID='$mostuserid'");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css?v=2.5">
    <title>Home</title>
    <style>
        #home {
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
                    <p>Admin Dashboard</p>
                    <img src="../Images/user.svg" alt="" srcset="">
                </div>

                <div class="dashboard-wrap">
                    <div class="dashboard-count">
                        <div class="staff-div">
                            <div class="staff-div-head">
                                <div></div>
                                <span>Current Staffs</span>
                                <div></div>
                            </div>

                            <div class="staff-div-number">
                                <img src="../Images/carbon_user-avatar.svg" alt="" srcset="">
                                <p><?php echo $countStaffs ?></p>
                            </div>

                        </div>
                        <div class="topic-div">
                            <div class="staff-div-head">
                                <div></div>
                                <span>Active Topics</span>
                                <div></div>
                            </div>

                            <div class="staff-div-number">
                                <img src="../Images/bx_category.svg" alt="" srcset="">
                                <p><?php echo $countCate ?></p>
                            </div>
                        </div>
                        <div class="idea-div">
                            <div class="staff-div-head">
                                <div></div>
                                <span>Total Ideas</span>
                                <div></div>
                            </div>

                            <div class="staff-div-number">
                                <img src="../Images/academicons_ideas-repec.svg" alt="" srcset="">
                                <p><?php echo $countIdeas ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="dashboard-table">
                        <div class="staff-table">
                            <h3>Top Staffs</h3>
                            <table>
                                <tr>
                                    <th>Staff Name</th>
                                    <th>Idea Given</th>
                                </tr>
                                <?php
                                while ($dataassocname = mysqli_fetch_assoc($runmostname)) {
                                    $staff = $dataassocname['StaffName'];
                                    //select number ideas given by staffs
                                    $runNStaffs = mysqli_query($connect, "SELECT * FROM Ideas WHERE StaffName = '$staff'");
                                    $countNStaffs = mysqli_num_rows($runNStaffs);
                                ?>
                                    <tr>
                                        <td><?php echo $staff ?></td>
                                        <td><?php echo $countNStaffs ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </table>
                        </div>

                        <div class="dep-table">
                            <h3>Top Departments</h3>
                            <table>
                                <tr>
                                    <th>Dep Name</th>
                                    <th>Idea Given</th>
                                </tr>
                                <?php
                                while ($dataassocdep = mysqli_fetch_assoc($runmostdep)) {
                                    $department = $dataassocdep['Department'];
                                    //select number ideas given by departments
                                    $runNDeps = mysqli_query($connect, "SELECT * FROM Ideas WHERE Department = '$department'");
                                    $countNDeps = mysqli_num_rows($runNDeps);
                                ?>
                                    <tr>
                                        <td><?php echo $department ?></td>
                                        <td><?php echo $countNDeps ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>