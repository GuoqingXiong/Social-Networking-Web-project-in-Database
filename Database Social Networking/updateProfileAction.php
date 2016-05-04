<?php
/**
 * Created by IntelliJ IDEA.
 * User: guoqingxiong
 * Date: 4/18/16
 * Time: 11:45 PM
 */

include 'SharedInformation.php';

const POST_FILE = "file";
const POST_NAME = "name";
const POST_PASSWORD = "password";

session_start();
$user_phone=$_SESSION['phone'];

$phone = $user_phone;
$user_name = $_POST[POST_NAME];
$password = $_POST[POST_PASSWORD];

$first_name = $_POST["first_name"];
$last_name = $_POST["last_name"];
$age = $_POST["age"];
$first_name = $_POST["first_name"];
$first_name = $_POST["first_name"];
$first_name = $_POST["first_name"];


$query="UPDATE USERS
        SET (PASSWORD,USER_NAME) = 
        ('$password','$user_name')
        WHERE USER_ID= '$phone'";
pg_query($db, $query);


$file_name_extension = end(explode(".", $_FILES[POST_FILE]["name"]));
$target_dir = "upload/";//check if "upload/" folder exists. If not, create.
if (!is_dir($target_dir)) {
    mkdir($target_dir);
}



$file_temp_name = $_FILES[POST_FILE]["tmp_name"];
$file_name = $phone;
$file_location = $target_dir . $file_name . "." . $file_name_extension;
//update image
    move_uploaded_file($file_temp_name, $file_location);
