<?php include "logininfo.php"; ?>
<!DOCTYPE html>
<html>
<body>
<head>
<title>Customer Login</title>
<body style="background-color:powderblue;">
<style>
    h1 {
        text-align:center;
    }
</style>
<h1>Customer Login</h1>
<link rel="stylesheet" type="text/css" href="style.css">
<a href="index.html">Return to Home</a>
<p>This is where our Customers would be able to login to view current Inventory and place Orders.</p>
</head>

<form action="login.php" method="post">

    <h2>LOGIN</h2>

    <?php if (isset($_GET['error'])) { ?>

        <p class="error"><?php echo $_GET['error']; ?></p>

    <?php } ?>

    <label>User Name</label>

    <input type="text" name="uname" placeholder="User Name"><br>

    <label>Password</label>

    <input type="password" name="password" placeholder="Password"><br> 

    <button type="submit">Login</button>

    </form>
</body>
</html>