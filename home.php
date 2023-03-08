<?php
session_start();
include "logininfo.php";	//Added to be able to use database information in this Session
if (isset($_SESSION['CustomerID']) && isset($_SESSION['Username'])) {

	$id = $_SESSION['CustomerID'];	//Created Id variable in order to be able to use this customers session CustomerID from FarmDB.CustomerLogin

	?>

	<!DOCTYPE html>
	<html>

	<head>
		<title>Welcome <?php echo $_SESSION['Name']; ?></title>
		<link rel="stylesheet" type="text/css" href="style.css">
		
	</head>
	<body>
		<h1>Welcome to your order page, <?php echo $_SESSION['Name']; ?></h1>
		<a href="logout.php">Logout</a>
	</body>
	</html>
	

	<?php

	$varFruit = htmlentities($_POST['Fruit']); //Grabs the value returned from dropdown menu and places it into
											   //the varFruit variable in a usable state
	$varOrderAmt = htmlentities($_POST['Amount']);//Grabs value that customer enters into Amount field

	if(strlen($varFruit)) { //strlen is 0 when empty, and shows length if populated, 
							//if it shows length it will run this if statement
		$n = mysqli_real_escape_string($conn, $varFruit); //real_escape_string prepares the varFruit value to be ready to be placed into a query
		$a = mysqli_real_escape_string($conn, $varOrderAmt);
		$siloID = mysqli_query($conn, 									//Storages the sql query into a variable to be used below
			"SELECT StorageSilo.SiloID, StorageSilo.CurrentStorageCapacity 
			FROM StorageSilo 
			WHERE SiloFruitNum = '$varFruit' 
			ORDER BY SiloID;");											//when this query is finally ran, output in MySQL Workbench will show 2 rows, 
																		//top being the 100ton silo and shows [SiloID] and [CurrentStorageCapacity] and
																		//bottom shows the 50ton silo with and its value

		while($siloIDResult = mysqli_fetch_row($siloID)){	//Statement will run until it has ran through each row once (so will loop a max of twice)
			if($varOrderAmt <= $siloIDResult[1]){			//Checks if the Amount Order by customer is Less than or Equal to the [CurrentStorageCapacity] of the first silo
				$silo = $siloIDResult[0];					//if yes, it will copy the [SiloID] from the first row into a variable to be used for later
				mysqli_query($conn, 						//Runs a query that UPDATES the StorageSilo table [CurrentStorageCapacity] of the SiloID that was just found and used
					"UPDATE StorageSilo 
					SET CurrentStorageCapacity = '$siloIDResult[1]' - '$varOrderAmt'
					WHERE (SiloID = '$silo');");			//Adjusts [CurrentStorageCapacity] by the curent amount - amount ordered
				break;										//Stops the loop, because if the 1st row is found to have enough inventory, we don't want it to run again and use the 2nd Silo as well
			}
		}
		$query = "INSERT INTO Orders (Orders_CustomerID, Orders_FruitID, Orders_SiloID, OrderAmt) VALUES ('$id', '$n', $silo, '$a');";
		//Places one last query into a variable to be used, this adds a new row to the Orders table with all the info we just collected from customer
		
		if(!mysqli_query($conn, $query)) echo("<p>Error adding order, please contact Braxton Maxwell.</p>");	//If query does not run, it will send error message to contact glorious team leader, Braxton Maxwell
	
		// }
	}

	?>
	<form action="<?PHP echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
  		<table border="0">
		  <p>Place your order:</p>
    		<tr>
      			<td>Fruit</td>
      			<td>Amount</td>
    		</tr>
    		<tr>
      		 <td>
        		<select name="Fruit" id="Fruit">	<!--Creates dropdown list with options-->
					<option value="">Select Fruit</option>	
					<option value="1">1. Oranges</option> <!--the value= is what is returned when that fruit is selected-->
    				<option value="2">2. Pears</option>
    				<option value="3">3. Apples</option>
    				<option value="4">4. Grapes</option>
					<option value="5">5. Peaches</option>
					<option value="6">6. Plums</option>
					<option value="7">7. Apricots</option>
					<option value="8">8. Mangoes</option>
					<option value="8">9. Avocadoes</option>
					<option value="9">10. Cherries</option>
					</select>
      		 </td>
      		 <td>
        		<input type="int" name="Amount" maxlength="20" size="15" /><!---->
      		 </td>
			 <td><!----------------------></td>
			 <td><!----------------------></td>
			 <td><!----------------------></td>
			 <td><!----------------------></td>
				<!-- Above lines are only used to make a space between Amount field and Place Order button -->
      		 <td>
        		<input type="submit" value="Place Order" />
      		 </td>
    		</tr>
  			</table>
	</form>
	<p>Your order history:</p>
	<!-- Display table data. -->
	<table border="0" cellpadding="0" cellspacing="2"><tr><td></td></tr></table>
	<!-- Ignore above code, used to make spacing between Order form and Customer Table -->
	<table border="2" cellpadding="4" cellspacing="2">
  		<tr>
  			<td>Customer ID</td>
    		<td>Order ID</td>
			<td>Fruit Ordered</td>
			<td>Order Amount</td>
 		</tr>

	<?php

	$result = mysqli_query($conn, 
		"SELECT Orders.Orders_CustomerID, Orders.OrderID, Fruit.FruitType, Orders.OrderAmt
		FROM Fruit
		INNER JOIN Orders ON Orders.Orders_FruitID = Fruit.FruitID
		WHERE Orders.Orders_CustomerID = '$id'
		ORDER BY Orders.OrderID;");

	while($query_data = mysqli_fetch_row($result)) {
  		echo "<tr>";
  		echo "<td>",$query_data[0], "</td>",
    	     "<td>",$query_data[1], "</td>",
	   		 "<td>",$query_data[2], "</td>",
	  		 "<td>",$query_data[3], "</td>";
  		echo "</tr>";
	}
	?>
	</table>



	<?php
}

else{
	header("Location: index.html");
	exit();
}
?>