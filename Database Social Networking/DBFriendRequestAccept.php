<?php
require "./SharedInformation.php";
$request_id = $_POST["request_id"];
$accept_id = $_POST["accept_id"];
$sql = "UPDATE FRIENDSHIP SET SUCCESSFUL = TRUE WHERE REQUEST_ID = $1 AND ACCEPT_ID = $2";
$resource = pg_prepare($db, "", $sql);
$resource = pg_execute($db, "", array($request_id, $accept_id));
?>