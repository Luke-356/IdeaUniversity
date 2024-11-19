<?php
include("./checkStaffLogin.php");
include('serverConnect.php');
if (isset($_POST['type']) && $_POST['type'] != '' && isset($_POST['id']) && $_POST['id'] > 0) {
    $type = mysqli_real_escape_string($connect, $_POST['type']);
    $id = mysqli_real_escape_string($connect, $_POST['id']);

    if ($type == 'like') {
        if (isset($_COOKIE['like_' . $id])) {
            setcookie('like_' . $id, "yes", 1);
            $sql = "UPDATE Ideas set LikeCount=LikeCount-1 WHERE IdeaID='$id'";
            $operation = "unlike";
        } else {
            if (isset($_COOKIE['dislike_' . $id])) {
                setcookie('dislike_' . $id, "yes", 1);
                mysqli_query($connect, "UPDATE Ideas set DislikeCount=DislikeCount-1 WHERE IdeaID='$id'");
            }

            setcookie('like_' . $id, "yes", time() + 60 * 60 * 24 * 365 * 5);
            $sql = "UPDATE Ideas set LikeCount=LikeCount+1 WHERE IdeaID='$id'";
            $operation = "like";
        }
    }

    if ($type == 'dislike') {
        if (isset($_COOKIE['dislike_' . $id])) {
            setcookie('dislike_' . $id, "yes", 1);
            $sql = "UPDATE Ideas set DislikeCount=DislikeCount-1 WHERE IdeaID='$id'";
            $operation = "undislike";
        } else {
            if (isset($_COOKIE['like_' . $id])) {
                setcookie('like_' . $id, "yes", 1);
                mysqli_query($connect, "UPDATE Ideas set LikeCount=LikeCount-1 WHERE IdeaID='$id'");
            }

            setcookie('dislike_' . $id, "yes", time() + 60 * 60 * 24 * 365 * 2);
            $sql = "UPDATE Ideas set DislikeCount=DislikeCount+1 WHERE IdeaID='$id'";
            $operation = "dislike";
        }
    }
    mysqli_query($connect, $sql);
    $row =  mysqli_fetch_assoc(mysqli_query($connect, "SELECT * from Ideas WHERE IdeaID='$id'"));
    echo json_encode([
        'operation' => $operation,
        'like_count' => $row['LikeCount'],
        'dislike_count' => $row['DislikeCount']
    ]);
}
