<?php include "./dbinfo.inc"; ?>
<html>
<head>
  <style type="text/css">
    a {
      font-size: 30;
    }
    h1 {
      text-align: center;
    }
    body{
      background: powderblue;
    }
    table.center {
      margin-left: auto; 
      margin-right: auto;
    }
    table {
      border: 1px solid black;
      border-collapse: collapse;
      width: 1000px;
      height: 800px;
      font-size:30px
    }
    form {
      border-collapse: collapse;
      margin: 0 auto;
      width: 400px;
      font-size:30px;
    }
    input {
      text-align: center;
      width: 150px;
      height: 30px;
    }
    </style>
  <!-- <a href="http://ec2-3-19-243-226.us-east-2.compute.amazonaws.com">Return to Home Page</a> -->
  <a href="/index.html">Return to Home Page</a>
  <h1>
    Inventory Page
  </h1>
</head>
<body>
<?php
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
    if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();
    mysqli_select_db($connection, DB_DATABASE); //Is needed to connect to database

    /* If input fields are populated, add a row to the EMPLOYEES table. */
  $StorageCapacity = htmlentities($_POST['StorageCapacity']);
  $SiloID = htmlentities($_POST['SiloID']);


  if (strlen($StorageCapacity) || strlen($SiloID)) {
    UpdateSilo($connection, $SiloID, $StorageCapacity);
  }

?>


<form action="<?PHP echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
  <label for="SiloID">Silo ID:</label>
  <input style="float: right"type="text" id="SiloID" name="SiloID"><br>
  <label for="StorageCapacity">Update Amount:</label>
  <input style="float: right" type="text" id="StorageCapacity" name="StorageCapacity"><br>
  <input style="font-size:20px" type="submit" value="Update"><br>
</form>


<!-- Display table data. -->
<table class="center" border="1" cellpadding="2" cellspacing="2">
  <tr>
    <td style="text-align:center">SiloID</td>
    <td style="text-align:center">Current Storage Capacity</td>
    <td style="text-align:center">Max Storage Capacity</td>
    <td style="text-align:center">Fruit Stored</td>
  </tr>

<?php
$result = mysqli_query($connection, 
  "SELECT StorageSilo.SiloID, StorageSilo.CurrentStorageCapacity, StorageSilo.MaxStorageCapacity, Fruit.FruitType
  FROM StorageSilo
  INNER JOIN Fruit ON StorageSilo.SiloFruitNum = Fruit.FruitID
  ORDER BY StorageSilo.SiloID");

while($query_data = mysqli_fetch_row($result)) {
  echo "<tr>";
  echo "<td style=\"text-align:center\">",$query_data[0], "</td>",
       "<td style=\"text-align:center\">",$query_data[1], "</td>",
       "<td style=\"text-align:center\">",$query_data[2], "</td>",
       "<td style=\"text-align:center\">",$query_data[3], "</td>";
  echo "</tr>";
}
?>

<?php 
function UpdateSilo($connection, $SiloID, $StorageCapacity) {
    $n = mysqli_real_escape_string($connection, $SiloID);
    $a = mysqli_real_escape_string($connection, $StorageCapacity);
 
    $query = "UPDATE StorageSilo SET CurrentStorageCapacity = '$a' WHERE (SiloID = '$n');";
 
    if(!mysqli_query($connection, $query)) echo("<p>Error updating capacity, current capacity must be less than or equal to max storage capacity.</p>");
 }
?>


</table>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>