<?php
include("./checkStaffLogin.php");
include('serverConnect.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/7016793479.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./style.css?v=2.4">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Document</title>
</head>

<body>
    <?php
    include("header.php");
    if (isset($_GET['cid'])) {
        $cid = $_GET['cid'];
        $select = "SELECT * FROM Category WHERE CategoryID='$cid'";
        $run =  mysqli_query($connect, $select);
        $data = mysqli_fetch_array($run);

        $selectIdea = "SELECT * FROM Ideas WHERE CategoryID='$cid'";
        $run1 = mysqli_query($connect, $selectIdea);
        $count = mysqli_num_rows($run1);

        //Set Category Timer

        $specificDuration = $data["Duration"];
    ?>
        <div class="time">

        </div>
        <?php
        $_SESSION["duration"] = $specificDuration;

        if (isset($_POST['btnPost'])) {
            $CategoryID = $data["CategoryID"];
            $StaffID = $_SESSION["StaffID"];
            $idea = $_POST['txtidea'];
            $date = date('Y-m-d');
            $time = date('h:i:sa');

            //get staffname and department
            $runStaffName = mysqli_query($connect, "SELECT * from Staff WHERE StaffID = '$StaffID'");
            $dataStaffName = mysqli_fetch_array($runStaffName);
            $StaffName = $dataStaffName["StaffName"];
            $Department = $dataStaffName["Department"];

            $file = $_FILES['txtfile'];

            //file properties
            $file_name = $file['name'];
            $file_tmp = $file['tmp_name'];
            $file_size = $file['size'];
            $file_error = $file['error'];

            //work out the file extension
            $file_ext = explode('.', $file_name);
            $file_ext = strtolower(end($file_ext));

            $allowed = array('txt', 'doc', 'docx', 'html', 'xml', 'pptx', 'pdf');

            if (in_array($file_ext, $allowed)) {
                if ($file_error === 0) {
                    if ($file_size <= 2097152) {
                        $file_destination = 'IdeaFiles/' . $file_name;

                        if (move_uploaded_file($file_tmp, $file_destination)) {
                            $radio = $_POST['rdo'];
                            $insert = "INSERT INTO `Ideas`(`IdeaID`, `CategoryID`, `StaffID`, `StaffName`, `Department`, `Idea`, `File`, `PostedDate`, `PostedTime`, `Anonymity`) 
                                VALUES (NULL,'$CategoryID','$StaffID','$StaffName','$Department', '$idea', '$file_name','$date', '$time', '$radio')";
                            $run = mysqli_query($connect, $insert);

                            if ($run) {
                                echo "<script>
                                alert('Idea Added');
                                </script>";
                                $CategoryID = $data["CategoryID"];
                                header("Location: viewCategory.php?cid=$CategoryID");

                                $cid = $_GET['cid'];
                                //Select Staff
                                $StaffID = $_SESSION['StaffID'];
                                $selectStaff = "SELECT * FROM Staff WHERE StaffID= '$StaffID'";
                                $runStaff = mysqli_query($connect, $selectStaff);
                                $dataStaff = mysqli_fetch_array($runStaff);

                                $StaffName = $dataStaff['StaffName'];
                                $Dep = $dataStaff['Department'];

                                // Select Idea for specific staff
                                // $selectIdeaID = "SELECT * FROM Ideas WHERE StaffID = '$StaffID'";
                                // $runIdeaID = mysqli_query($connect, $selectIdeaID);
                                // $dataIdeaID = mysqli_fetch_array($runIdeaID);
                                // $IdeaID = $dataIdeaID['IdeaID'];

                                //Select largest IdeaID 
                                $selectIdea = "SELECT MAX(IdeaID) as LargestID FROM Ideas";
                                $runIdea = mysqli_query($connect, $selectIdea);
                                $dataIdea = mysqli_fetch_assoc($runIdea);

                                $MaxIdeaID = $dataIdea['LargestID'];

                                //Select latest Idea with largest IdeaID
                                $selectfinalIdea = "SELECT * from Ideas WHERE IdeaID = '$MaxIdeaID'";
                                $runfinalIdea = mysqli_query($connect, $selectfinalIdea);
                                $datafinalIdea = mysqli_fetch_array($runfinalIdea);

                                $Idea = $datafinalIdea['Idea'];

                                //Select Category
                                $selectCate = "SELECT * FROM Category WHERE CategoryID='$cid'";
                                $runCate =  mysqli_query($connect, $selectCate);
                                $dataCate = mysqli_fetch_array($runCate);

                                $CategoryName =  $dataCate['CategoryName'];

                                //Select QAC
                                $selectQAC =  "SELECT * FROM Staff WHERE Department= '$Dep' AND UserType= 'QAC'";
                                $runQAC =  mysqli_query($connect, $selectQAC);
                                $dataQAC = mysqli_fetch_array($runQAC);

                                $QACMail = $dataQAC['Email'];

                                $to = "$QACMail";
                                $subject = "New Idea Added";
                                $txt = "Idea from $StaffName" . "\r\n" . "Added to: $CategoryName" . "\r\n" . "Idea: $Idea";
                                $headers = "From: IdeaUniversity";

                                mail($to, $subject, $txt, $headers);
                            }
                        } else {
                            echo "Sorry, there was an error uploading your file.";
                        }
                    } else {
                        echo "File size should be smaller of equal to 2M";
                    }
                }
            } else {
                echo "Only document file types are allowed!";
            }
        }
        ?>
        <div class="view-category">
            <div class="container">
                <div class="Idea-container">
                    <div class="viewCate-wrap">
                        <h1><?php echo $data['CategoryName']; ?></h1>
                        <div class="underline"></div>

                        <form method="POST" class="add-ideas" enctype="multipart/form-data">
                            <label for="idea">Add Ideas</label><br>
                            <textarea name="txtidea" id="" cols="70" rows="6" required></textarea> <br>

                            <div class="form-submit-wrap">
                                <div class="radios">
                                    <input type="radio" name="rdo" id="radioshow" value="No" checked>
                                    <label for="radioshow">Show Name</label>

                                    <input type="radio" name="rdo" id="radio" value="Yes">
                                    <label for="radio">Anonymous</label>
                                </div>

                                <div class="file-and-btn">
                                    <div class="file-upload">
                                        <input type="file" name="txtfile" id="file-input" required>
                                    </div>

                                    <button type="submit" name="btnPost">Post</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="viewCate-wrap">
                        <h1>Submitted Ideas</h1>
                        <div class="underline"></div>

                        <?php
                        if ($count > 0) {
                            //number of total pages avaliable
                            $results_per_page = 5;
                            $number_of_pages = ceil($count / $results_per_page);

                            //determine which page number the visitor is currently on
                            if (!isset($_GET['page'])) {
                                $page = 1;
                            } else {
                                $page = $_GET['page'];
                            }

                            //Determine the sql LIMIT starting number for the results on the displaying page
                            $this_page_first_result = ($page - 1) * $results_per_page;

                            $CategoryID = $data["CategoryID"];
                            $sqlpage = "SELECT * FROM Ideas WHERE CategoryID='$CategoryID' ORDER BY IdeaID Desc LIMIT $this_page_first_result,$results_per_page";
                            $runpage = mysqli_query($connect, $sqlpage);

                            while ($data1 = mysqli_fetch_array($runpage)) {
                                $likeClass = "before-color";
                                if (isset($_COOKIE['like_' . $data1['IdeaID']])) {
                                    $likeClass = "after-color";
                                }

                                $dislikeClass = "before-color";
                                if (isset($_COOKIE['dislike_' . $data1['IdeaID']])) {
                                    $dislikeClass = "after-color";
                                }

                                $StaffID = $data1['StaffID'];
                                $selectStaff = "SELECT * FROM Staff WHERE StaffID= '$StaffID'";
                                $runStaff =  mysqli_query($connect, $selectStaff);
                                $dataStaff = mysqli_fetch_array($runStaff);

                        ?>
                                <div class="view-ideas" id="post<?php echo $data1['IdeaID'] ?>">
                                    <div class="idea-wrap">
                                        <div class="idea-date-time">
                                            <?php
                                            if ($data1['Anonymity'] == 'Yes') {
                                            ?>
                                                <p class="staff-name"><?php echo 'Unknown' ?></p> |
                                            <?php
                                            } else {
                                            ?>
                                                <p class="staff-name"><?php echo $dataStaff['StaffName'] ?></p> |
                                            <?php
                                            }
                                            ?>

                                            <p><?php echo $data1['PostedDate'] ?></p> |
                                            <p><?php echo $data1['PostedTime'] ?></p>
                                        </div>
                                        <p class="idea-text"><?php echo $data1['Idea'] ?></p>
                                        <?php
                                        // $FileCheck = $data1['File'];
                                        ?>
                                        <a href="fileDownload.php?path=<?php echo 'IdeaFiles/' . $data1['File'] ?>" class="file-wrap">
                                            <div class="file-text-and-icon">
                                                <img src="./Images/file-upload-white.svg">
                                                <p><?php echo $data1['File'] ?></p>
                                            </div>

                                            <img src="./Images/file-download.svg">
                                        </a>
                                        <?php
                                        ?>
                                    </div>

                                    <div class="post-info">
                                        <div class="like-dislike">
                                            <div>
                                                <i class="fa-solid fa-thumbs-up like <?php echo $likeClass ?>" onclick="setLikeDislike('like','<?php echo $data1['IdeaID'] ?>')"></i>
                                                <span id="like"><?php echo $data1['LikeCount'] ?></span>
                                            </div>
                                            <div>
                                                <i class="fa-solid fa-thumbs-down dislike <?php echo $dislikeClass ?>" onclick="setLikeDislike('dislike','<?php echo $data1['IdeaID'] ?>')"></i>
                                                <span id="dislike"><?php echo $data1['DislikeCount'] ?></span>
                                            </div>
                                        </div>

                                        <!-- comment button -->
                                        <div class="comment">
                                            <i class="fa-solid fa-comment before-color"></i>
                                            <span>Comment</span>
                                        </div>
                                        <!-- comment button -->
                                    </div>
                                </div>

                                <!-- comment session -->
                                <form method="POST" class="comment-session" action="postComment.php?ideaID=<?php echo $data1['IdeaID'] ?> && cateID=<?php echo $cid ?>">
                                    <div class="comment-text">
                                        <div class="comment-header">
                                            <p>Comments</p>
                                            <i class="fa-solid fa-xmark close-comment"></i>
                                        </div>

                                        <div class="comment-text-wrap">
                                            <input type="text" name="txtcomment" placeholder="Add a comment ..." required>
                                            <button type="submit" name="btncomment">Post</button>
                                        </div>
                                    </div>

                                    <div class="display_comment">
                                        <!-- Select comments -->
                                        <?php
                                        $ideaID = $data1['IdeaID'];
                                        $sqlcomment = "SELECT * FROM IdeaComment WHERE IdeaID='$ideaID' ORDER BY CommentID Desc";
                                        $runcomment = mysqli_query($connect, $sqlcomment);
                                        echo "<div class='comment-main-wrap'>";
                                        while ($datacomment = mysqli_fetch_array($runcomment)) {
                                            $commentStaff = $datacomment['StaffID'];
                                            $selectCommentUser = "SELECT * FROM Staff WHERE StaffID='$commentStaff'";
                                            $runcommentuser = mysqli_query($connect, $selectCommentUser);
                                            $datacommentuser = mysqli_fetch_array($runcommentuser);
                                        ?>
                                            <div class="comment-wrap">
                                                <div class="comment-head">
                                                    <p class="comment-user">
                                                        <?php echo $datacommentuser['StaffName'] ?>
                                                    </p>
                                                    |
                                                    <p>
                                                        <?php echo $datacomment['CommentDate'] ?>
                                                    </p>
                                                    |
                                                    <p>
                                                        <?php echo $datacomment['CommentTime'] ?>
                                                    </p>
                                                </div>


                                                <div class="comment-main-text">
                                                    <?php echo $datacomment['Comment'] ?>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        echo "</div>";
                                        ?>

                                    </div>
                                </form>
                                <!-- comment session -->
                            <?php
                            }
                            echo "<div class='page-wrap'>";
                            //display the links of the pages 
                            if ($page > 1) {
                            ?>
                                <a href="viewCategory.php?cid=<?php echo $CategoryID ?> && page=<?php echo $page - 1 ?>" class="page-jump">Previous</a>
                            <?php
                            }

                            for ($i = 1; $i <= $number_of_pages; $i++) {
                            ?>
                                <a href="viewCategory.php?cid=<?php echo $CategoryID ?> && page=<?php echo $i ?>" class="page-btn"><?php echo $i ?></a>
                            <?php
                            }

                            if ($i > $page) {
                            ?>
                                <a href="viewCategory.php?cid=<?php echo $CategoryID ?> && page=<?php echo $page + 1 ?>" class="page-jump">Next</a>
                        <?php
                            }
                            echo "</div>";
                        } else {
                            echo " <h2 style='margin-top:3.2rem; font-weight: 400; color: #212121; font-size: 1.3rem;'>No ideas submitted yet</h2> ";
                        }
                        ?>

                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>

    <?php include("footer.php") ?>

    <script>
        function setLikeDislike(type, id) {
            jQuery.ajax({
                url: 'setLikeDislike.php',
                type: 'post',
                data: 'type=' + type + '&id=' + id,
                success: function(result) {
                    // 'operation' => $operation, 
                    // 'like_count' => $row['LikeCount'], 
                    // 'dislike_count' => $row['DislikeCount']
                    result = jQuery.parseJSON(result);
                    if (result.operation == 'like') {
                        $('#post' + id).find('.like').removeClass("before-color");
                        $('#post' + id).find('.like').addClass("after-color");
                        $('#post' + id).find('.dislike').removeClass("after-color");
                        $('#post' + id).find('.dislike').addClass("before-color");
                    }

                    if (result.operation == 'unlike') {
                        $('#post' + id).find('.like').removeClass("after-color");
                        $('#post' + id).find('.like').addClass("before-color");
                    }

                    if (result.operation == 'dislike') {
                        $('#post' + id).find('.dislike').removeClass("before-color");
                        $('#post' + id).find('.dislike').addClass("after-color");
                        $('#post' + id).find('.like').removeClass("after-color");
                        $('#post' + id).find('.like').addClass("before-color");
                    }

                    if (result.operation == 'undislike') {
                        $('#post' + id).find('.dislike').removeClass("after-color");
                        $('#post' + id).find('.dislike').addClass("before-color");
                    }

                    $('#post' + id).find('#like').html(result.like_count);
                    $('#post' + id).find('#dislike').html(result.dislike_count);
                }
            });
        }

        $(document).ready(function() {
            $(".comment-session").hide();
            $(".comment").click(function() {
                $(".comment-session").toggle();
            });
        });

        $(".close-comment").click(function() {
            $(".comment-session").hide();
        });
    </script>
</body>

</html>