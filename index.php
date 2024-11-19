<?php
include("./checkStaffLogin.php");
include('serverConnect.php');

/*select data form category table*/
$select = "SELECT * FROM Category ORDER BY CategoryID Desc";
$run = mysqli_query($connect, $select);
$count = mysqli_num_rows($run);

$selectIdea = "SELECT * FROM Ideas ORDER BY IdeaID Desc";
$runIdea = mysqli_query($connect, $selectIdea);
$countIdea =  mysqli_num_rows($runIdea);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="./style.css?v=2.9">
    <title>home</title>
</head>

<body>

    <?php
    include("header.php");
    ?>


    <div class="index-body">
        <div class="container">
            <h2 class="cate-header">Latest Topics</h2>
            <div class="category">
                <?php
                if ($count > 0) {
                    while ($data = mysqli_fetch_array($run)) {
                        $CateID = $data['CategoryID'];

                        $selectadmincate = "SELECT * FROM AdminCategory WHERE CategoryID = '$CateID'";
                        $runcate =  mysqli_query($connect, $selectadmincate);
                        $datacate = mysqli_fetch_array($runcate);
                        $AdminID = $datacate['AdminID'];

                        $selectadmin = "SELECT * FROM Admin WHERE AdminID = '$AdminID'";
                        $runadmin =  mysqli_query($connect, $selectadmin);
                        $dataadmin = mysqli_fetch_array($runadmin);

                ?>
                        <a href="viewCategory.php?cid=<?php echo $CateID ?>" class="cate-wrap">
                            <p class="cate-name"><?php echo $data['CategoryName']; ?></p>
                            <div class="cate-line">
                            </div>
                            <p class="desc"><?php echo $data['Description']; ?></p>
                            <div class="name-date-flex">
                                <div class="cate-name-date">
                                    <p><?php echo $dataadmin['AdminName']; ?></p>
                                    |
                                    <p><?php echo $data['StartDate']; ?></p>
                                </div>
                                <div class="class-link">View <i class="fa-solid fa-chevron-right"></i></div>
                            </div>
                        </a>
                <?php
                    }
                } else {
                    echo "<h2 style='margin-top:-0.5rem; font-weight: 400; color: #212121; font-size: 1.3rem;'>No Category submitted</h2>";
                }
                ?>
            </div>

            <!-- <div class="recent-ideas">
                <h2 class="recent-header">Recent Ideas</h2>

                <div class="category">

                </div>
            </div> -->
        </div>
    </div>

    <?php include("footer.php") ?>
</body>

</html>