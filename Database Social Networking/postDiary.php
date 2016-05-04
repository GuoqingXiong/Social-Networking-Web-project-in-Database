<?php
/**
 * Created by IntelliJ IDEA.
 * User: guoqingxiong
 * Date: 4/17/16
 * Time: 8:47 PM
 */

include 'SharedInformation.php';

$title=$_POST['title'];
$content=$_POST['content'];
$level=$_POST['level'];
$phone=$_POST['user_id'];
$str = 'insert into DIARY(TITLE, BODY, CREATE_TIMESTAMP, LAST_UPDATE_TIMESTAMP, PUBLICITY_LEVEL, USER_ID) values($1, $2, $3, $4, $5, $6)';
$insert_into_database_result = pg_prepare($db, "my_insert", $str);
$insert_into_database_result = pg_execute ($db, "my_insert", array($title, $content, 'now', 'now', $level, $phone));
if ($insert_into_database_result == false) {
    $result[DESCRIPTION] = FAIL_TO_INSERT;
    echo json_encode(1);
    return;
}

$diary_id = $title . $phone;


const POST_FILE = "fileUpload";
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

$target_dir = "diary/";//check if "upload/" folder exists. If not, create.
if (!is_dir($target_dir)) {
    mkdir($target_dir);
}

$file_temp_name = $_FILES[POST_FILE]["tmp_name"];
$file_location = $target_dir . $diary_id . "." . $file_name_extension;


if (file_exists($file_location)) {//need consider profile update function
} else {
    move_uploaded_file($file_temp_name, $file_location);
}


header('Location: http://localhost:8888/new_mainPage.php');