
<?php
/**
 * Created by PhpStorm.
 * User: JQMen
 * Date: 16/4/3
 * Time: 11:52
 */
include 'SharedInformation.php';

const POST_FILE = "fileUpload";
const POST_PHONE = "phone";
const POST_NAME = "name";
const POST_PASSWORD = "password";


$file_name_extension = end(explode(".", $_FILES[POST_FILE]["name"]));
if ($file_name_extension != "jpg") {
    $result[DESCRIPTION] = FILE_TYPE_ERROR;
    echo json_encode($result);
    return;
}

if ($_FILES[POST_FILE]["error"] > 0) {
    $result[DESCRIPTION] = "Error: " . $_FILES[POST_FILE]["error"];
    echo json_encode($result);
    return;
}

$target_dir = "upload/";//check if "upload/" folder exists. If not, create.
if (!is_dir($target_dir)) {
    mkdir($target_dir);
}

$phone = $_POST[POST_PHONE];
$user_name = $_POST[POST_NAME];
$password = $_POST[POST_PASSWORD];

$file_temp_name = $_FILES[POST_FILE]["tmp_name"];
$file_name = $phone;
$file_location = $target_dir . $file_name . "." . $file_name_extension;


if (file_exists($file_location)) {//need consider profile update function
} else {
    move_uploaded_file($file_temp_name, $file_location);
}

if(!$db){
    $result[DESCRIPTION] = SYSTEM_ERROR;
    $result[CONTENT] = "Fail to open database";
    echo json_encode($result);
    return;
}

$str = 'insert into USERS(USER_ID, USER_NAME, PASSWORD, URL) values($1, $2, $3, $4)';
$insert_into_database_result = pg_prepare($db, "my_insert", $str);
$file_url = "http://" . SERVER_URL . "/~" . DB_NAME . "/" . $file_location;
#echo $file_url;
$insert_into_database_result = pg_execute ($db, "my_insert", array($phone, $user_name, $password, $file_url));
if ($insert_into_database_result == false) {
    $result[DESCRIPTION] = FAIL_TO_INSERT;
    echo json_encode($result);
    return;
}