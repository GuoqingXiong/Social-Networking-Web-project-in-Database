<?php
/**
 * Created by IntelliJ IDEA.
 * User: guoqingxiong
 * Date: 4/17/16
 * Time: 3:40 PM
 */

include 'SharedInformation.php';
$diary_id=$_POST['diary_id'];
$body=$_POST['comment'];
$theUserID=$_POST['theUserID'];
$userPhone=$_POST['userPhone'];

$str = 'insert into COMMENT_FOR_DIARY(BODY, CREATE_TIMESTAMP, PUBLICITY_LEVEL, USER_ID, DIARY_ID) values($1, $2, $3, $4, $5)';
$insert_into_database_result = pg_prepare($db, "my_insert", $str);
$insert_into_database_result = pg_execute ($db, "my_insert", array($body, 'now', 1, $theUserID, $diary_id));
if ($insert_into_database_result == false) {
    $result[DESCRIPTION] = FAIL_TO_INSERT;
    echo json_encode($result);
    return;
}
header('Location: http://localhost:8888/new_mainPage.php?id=' . $theUserID);