<?php
/**
 * Created by PhpStorm.
 * User: JQMen
 * Date: 16/4/25
 * Time: 14:15
 */

require "./SharedInformation.php";
$search_content = $_POST["search_content"];
$search_content="2016";
$sql = "SELECT * FROM USERS WHERE USERS.USER_NAME ILIKE $1";
$reg_exp = "%" . $search_content . "%";
$resource = pg_prepare($db, "my_query", $sql);
$resource = pg_execute($db, "my_query", array($reg_exp));

$user_name_list = array();
if ($resource == false || pg_num_rows($resource) == 0) {
} else {
    $index = 0;
    while ($array = pg_fetch_array($resource)) {
        $user_name_list[$index] = $array["user_name"];
        $index++;
    }
}
var_dump($user_name_list);