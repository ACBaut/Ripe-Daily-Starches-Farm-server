<?php
include "./dbinfo.inc";

$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
mysqli_select_db($conn, DB_DATABASE);

if (!$conn) {

    echo "Connection failed!";

}