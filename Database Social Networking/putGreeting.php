<?php
/**
 * Created by IntelliJ IDEA.
 * User: guoqingxiong
 * Date: 4/18/16
 * Time: 6:58 PM
 */


include 'SharedInformation.php';
$from_user_id=$_POST['from_user_id'];
$to_user_id=$_POST['to_user_id'];
$body=$_POST['comment'];
$str = 'insert into GREETING(BODY, PUBLICITY_LEVEL, FROM_USER_ID, TO_USER_ID) values($1, $2, $3, $4)';
$insert_into_database_result = pg_prepare($db, "my_insert", $str);
$insert_into_database_result = pg_execute ($db, "my_insert", array($body, 1, $from_user_id, $to_user_id));
if ($insert_into_database_result == false) {
    $result[DESCRIPTION] = FAIL_TO_INSERT;
    echo json_encode($result);
echo $from_user_id . " my_insert ";
echo $to_user_id . " my_insert ";
echo $body;
    return;
}
header('Location: http://localhost:8888/new_mainPage.php?id=' . $to_user_id);