<?php
include('../serverConnect.php');

//drop tables
// $dropIdeaComment = "Drop Table IdeaComment";
// $runDrop = mysqli_query($connect, $dropIdeaComment);
// if ($runDrop) {
//     echo "IdeaComment Table Dropped <br>";
// } else {
//     mysqli_error($connect);
// }

// $dropIdeas = "Drop Table Ideas";
// $runDrop = mysqli_query($connect, $dropIdeas);
// if ($runDrop) {
//     echo "Ideas Table Dropped <br>";
// } else {
//     mysqli_error($connect);
// }

// $dropAdminCate = "Drop Table AdminCategory";
// $runDrop = mysqli_query($connect, $dropAdminCate);
// if ($runDrop) {
//     echo "AdminCategory Table Dropped <br>";
// } else {
//     mysqli_error($connect);
// }

// $dropAdmin = "Drop Table Admin";
// $runDrop = mysqli_query($connect, $dropAdmin);
// if ($runDrop) {
//     echo "Admin Table Dropped <br>";
// } else {
//     mysqli_error($connect);
// }

// $dropStaff = "Drop Table Staff";
// $runDrop = mysqli_query($connect, $dropStaff);
// if ($runDrop) {
//     echo "Staff Table Dropped <br>";
// } else {
//     mysqli_error($connect);
// }

// $dropCate = "Drop Table Category";
// $runDrop = mysqli_query($connect, $dropCate);
// if ($runDrop) {
//     echo "Category Table Dropped <br>";
// } else {
//     mysqli_error($connect);
// }

//create tables
$createAdmin = "CREATE TABLE Admin
(
    AdminID int Auto_Increment not null primary key,
    AdminName Varchar(50),
    Gender Varchar(10),
    Email Varchar(60),
    Password Varchar(60)
)";

$run = mysqli_query($connect, $createAdmin);
if ($run) {
    echo "Admin Table Created <br>";
} else {
    mysqli_error($connect);
}

$password = 12345;
$password_hash = md5($password);

$insertAdmin = "INSERT INTO Admin (AdminID, AdminName, Gender, Email, Password)
VALUES (NULL, 'John', 'Male', 'john@gmail.com', '$password_hash')";

$runinsert = mysqli_query($connect, $insertAdmin);
if ($runinsert) {
    echo "Admin Data Inserted <br>";
} else {
    mysqli_error($connect);
}
//-----------------------------------------------

$createStaff = "CREATE TABLE Staff
(
    StaffID int Auto_Increment not null primary key,
    StaffName Varchar(50),
    Gender Varchar(10),
    UserType Varchar(10),
    Email Varchar(60),
    Department Varchar(30),
    Password Varchar(60)
)";

$run = mysqli_query($connect, $createStaff);
if ($run) {
    echo "Staff Table Created <br>";
} else {
    mysqli_error($connect);
}

//-----------------------------------------------

$createCate = "CREATE TABLE Category
(
    CategoryID int Auto_Increment not null primary key,
    CategoryName Varchar(50),
    StartDate Date,
    EndDate Date,
    Description Text,
    Duration Varchar(10)
)";

$run = mysqli_query($connect, $createCate);
if ($run) {
    echo "Category Table Created <br>";
} else {
    mysqli_error($connect);
}

$createAdminCate = "CREATE TABLE AdminCategory
(
    AdminID int,
    CategoryID int,
	FOREIGN KEY (AdminID) REFERENCES Admin(AdminID), 
    FOREIGN KEY (CategoryID) REFERENCES Category(CategoryID)
)";

$run = mysqli_query($connect, $createAdminCate);
if ($run) {
    echo "AdminCategory Table Created <br>";
} else {
    mysqli_error($connect);
}

//-----------------------------------------------

$createIdeas = "CREATE TABLE Ideas
(
    IdeaID int Auto_Increment not null primary key,
    CategoryID int,
    FOREIGN KEY (CategoryID) REFERENCES Category(CategoryID),
    StaffID int,
    FOREIGN KEY (StaffID) REFERENCES Staff(StaffID),
    StaffName Varchar(50),
    Department Varchar(50),
    Idea Text,
    File Varchar(500),
    PostedDate Date,
    PostedTime Varchar(20),
    LikeCount int NOT NULL,
    DislikeCount int NOT NULL,
    Anonymity VARCHAR(20)
)";

$run = mysqli_query($connect, $createIdeas);
if ($run) {
    echo "Ideas Table Created <br>";
} else {
    mysqli_error($connect);
}

$createComment = "CREATE TABLE IdeaComment
(
CommentID int Auto_Increment not null primary key,
IdeaID int,
FOREIGN KEY (IdeaID) REFERENCES Ideas(IdeaID),
StaffID int,
FOREIGN KEY (StaffID) REFERENCES Staff(StaffID),
CommentDate Date,
CommentTime Time,
Comment Text
)";

$run = mysqli_query($connect, $createComment);
if ($run) {
    echo "IdeaComment Table Created <br>";
} else {
    mysqli_error($connect);
}
