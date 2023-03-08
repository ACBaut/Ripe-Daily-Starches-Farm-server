<?php

$sname= "database-1.crfg0sh2m8re.us-east-2.rds.amazonaws.com";

$unmae= "admin";

$password = "database83";

$db_name = "FarmDB";

$conn = mysqli_connect($sname, $unmae, $password, $db_name);
mysqli_select_db($conn, $db_name);

if (!$conn) {

    echo "Connection failed!";

}