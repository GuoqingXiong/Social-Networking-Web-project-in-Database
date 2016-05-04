<?php
require "./SharedInformation.php";
$request_id = $_POST["request_id"];
$accept_id = $_POST["accept_id"];
$search_content = $_POST["search_content"];
$sql = "INSERT INTO FRIENDSHIP (REQUEST_ID, ACCEPT_ID, TIMESTAMP, SUCCESSFUL, PUBLICITY_LEVEL) VALUES ($1, $2, $3, $4, $5)";
$resource = pg_prepare($db, "", $sql);
$resource = pg_execute($db, "", array($request_id, $accept_id, 'now', 'false', 1));

header('Location: http://localhost:8888/friendlist.php?id=' . $search_content);
?>