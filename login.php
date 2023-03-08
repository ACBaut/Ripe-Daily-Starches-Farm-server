<?php
session_start();

include "logininfo.php";

if (isset($_POST['uname']) && isset($_POST['password'])) {

    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        $data = strtolower($data);
        return $data;
    }

    $uname = validate($_POST['uname']);

    $pass = validate($_POST['password']);

    if (empty($uname)) {
        header("Location: index.html?error=User Name is required");
        exit();
    }

    else if(empty($pass)){
        header("Location: index.html?error=Password is required");
        exit();
    }
    
    else{
        $sql = "SELECT * FROM CustomerLogin WHERE Username='$uname' AND Password='$pass'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if ($row['Username'] === $uname && $row['Password'] === $pass) {
                echo "Logged in!";
                $_SESSION['Username'] = $row['Username'];
                $_SESSION['Name'] = $row['Name'];
                $_SESSION['CustomerID'] = $row['CustomerID'];
                header("Location: home.php");
                exit();
            }
            
            else{
                header("Location: index.html?error=Incorect User name or password");
                exit();
            }
        }
        else {
            header("Location: index.html?error=Incorect User name or password");
            exit();
        }
    }
}

else{
    header("Location: index.html");
    exit();

}

?>