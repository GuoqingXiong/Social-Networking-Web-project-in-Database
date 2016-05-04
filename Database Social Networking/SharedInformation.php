<?php
/**
 * Created by PhpStorm.
 * User: JQMen
 * Date: 16/4/7
 * Time: 16:40
 */

const STATUS = "status";
const DESCRIPTION = "description";
const CONTENT = "content";
const RESULT_CODE_FAILURE = 0;
const RESULT_CODE_SUCCESS = 1;

$result = array(STATUS => RESULT_CODE_FAILURE, DESCRIPTION => null, CONTENT => null);

const SYSTEM_ERROR = "System Error. Please try again later!";
const FILE_TYPE_ERROR = "File type is neither jpg";
const SUCCESS = "Success!";
const FAIL_TO_INSERT = "Fail to insert to DB! You may have registered with this phone number!";

const SERVER_URL ="";
const DB_NAME = "";
const DB_USER_NAME = "";
const DB_PASSWORD = "";

$dbconn = "host=" . SERVER_URL . " dbname=" . DB_NAME . " user=" . DB_USER_NAME . " password=" . DB_PASSWORD;
$db = pg_connect("$dbconn");
