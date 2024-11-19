<?php
session_start();
include('serverConnect.php');
//Post Comments
if (isset($_GET['ideaID'])) {
    if (isset($_POST["btncomment"])) {
        $cateID = $_GET["cateID"];
        $staffID = $_SESSION["StaffID"];
        $ideaID = $_GET['ideaID'];
        $comment_content = $_POST['txtcomment'];
        $date = date('Y-m-d');
        $time = date('h:i:sa');
        $addcomment = "INSERT INTO `IdeaComment`(`CommentID`, `IdeaID`, `StaffID`, `CommentDate`, `CommentTime`, `Comment`) 
            VALUES (NULL,'$ideaID','$staffID', '$date', '$time', '$comment_content')";
        $run = mysqli_query($connect, $addcomment);
        if ($run) {
            echo "<script>alert('Comment Added');</script>";
            header("Location: viewCategory.php?cid=$cateID");

            $runIdeaUser = mysqli_query($connect, "SELECT * FROM Ideas WHERE IdeaID = '$ideaID'");
            $dataIdeaUser = mysqli_fetch_array($runIdeaUser);
            $IdeaUserID = $dataIdeaUser["StaffID"];

            $selectfromUser = mysqli_query($connect, "SELECT * FROM Staff WHERE StaffID = '$IdeaUserID'");
            $dataselectUser = mysqli_fetch_array($selectfromUser);
            $SelectEmail = $dataselectUser["Email"];

            //get commenter name
            $runcommenter =  mysqli_query($connect, "SELECT * FROM Staff WHERE StaffID = '$staffID'");
            $datacommenter = mysqli_fetch_array($runcommenter);
            $commenter = $datacommenter["StaffName"];

            $to = "$SelectEmail";
            $subject = "New Comment Added To Your Idea";
            $txt = "Comment from $commenter" . "\r\n" . "Comment: $comment_content";
            $headers = "From: IdeaUniversity";

            mail($to, $subject, $txt, $headers);
        }
    }
}
