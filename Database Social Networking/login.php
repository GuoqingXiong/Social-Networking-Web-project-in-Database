<?php
/**
 * Created by PhpStorm.
 * User: JQMen
 * Date: 16/4/9
 * Time: 15:19
 */

include 'SharedInformation.php';

session_start();
const PHONE = "phone";
const PASSWORD = "password";
const REQUEST_FAILED = "Request failed";

$phone = $_POST[PHONE];
$password = $_POST[PASSWORD];
$_SESSION['phone']=$phone;

$query_result = pg_query($db, "SELECT PASSWORD FROM USERS WHERE USER_ID = " . $phone);

if ($query_result == false) {
    $result[DESCRIPTION] = REQUEST_FAILED;
} else if (pg_num_rows($query_result) == 0) {
    $result[DESCRIPTION] = "0 records";
} else {
    $array = pg_fetch_array($query_result);
    if ($array[PASSWORD] == $password) {
        $result[STATUS] = RESULT_CODE_SUCCESS;
        $result[DESCRIPTION] = SUCCESS;
    } else {
        $result[DESCRIPTION] = "Password doesn't match";
        echo $result;
    }
}

header('Location: http://localhost:8888/new_mainPage.php');
?>
