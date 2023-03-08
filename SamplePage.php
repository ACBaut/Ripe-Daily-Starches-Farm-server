<?php include "dbinfo.inc"; ?>
<html>
<body>
    <h1>
        Page used as an example
    </h1>
    <a href="http://ec2-3-19-243-226.us-east-2.compute.amazonaws.com">Return to Home Page</a>
<?php
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
    if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();
    mysqli_select_db($connection, DB_DATABASE); //Is needed to connect to database


//     $stmt = $mysqli->prepare("SELECT CurrentStorageCapacity FROM StorageSilo WHERE SiloID = 1");
//     $results = $stmt->get_result();
//     while ($row = $result->fetch_array(MYSQLI_ASSOC))
// {
//     $points = $row['points'];
// }




    /* If input fields are populated, add a row to the EMPLOYEES table. */
    $employee_Fname = htmlentities($_POST['First Name']);
    $employee_Minit = htmlentities($_POST['M Initial']);
    $employee_Lname = htmlentities($_POST['Lastname']);
    $employee_Age = htmlentities($_POST['Age']);
    $employee_Address = htmlentities($POST['Address']);
    $employee_Gender = htmlentities($_POST['Gender']);
    $employee_HourlyWage = htmlentities($_POST['HourlyWage']);
    $employee_EmployeeID = htmlentities($_POST['EmployeeID']);
    $employee_JobNum = htmlentities($_POST['Job Number']);

    if(strlen($employee_EmployeeID)||strlen($employee_Fname)||strlen($employee_Minit)||strlen($employee_Lname)||strlen($employee_Age)||strlen($employee_Address)||strlen($employee_Gender)||strlen($employee_HourlyWage)||strlen($employee_JobNum)){
      $id = mysqli_real_escape_string($connection, $employee_EmployeeID);
      $FNAME =  mysqli_real_escape_string($connection, $employee_Fname);
      $MINIT =  mysqli_real_escape_string($connection, $employee_Minit);
      $LNAME =  mysqli_real_escape_string($connection, $employee_Lname);
      $AGE =  mysqli_real_escape_string($connection, $employee_Age);
      $ADDRESS =  mysqli_real_escape_string($connection, $employee_Address);
      $GENDER =  mysqli_real_escape_string($connection, $employee_Gender);
      $HOURLYWAGE =  mysqli_real_escape_string($connection, $employee_HourlyWage);
      $JOBNUM =  mysqli_real_escape_string($connection, $employee_JobNum);
      //$query = "INSERT INTO Employee VALUES ($employee_Fname, $employee_Minit, $employee_Lname, $employee_Age, $employee_Address, $employee_Gender, $employee_HourlyWage, $employee_EmployeeID, $employee_JobNum)";
      $query = "INSERT INTO Employee (EmployeeID) VALUEs ('$id');";
      $query = "INSERT INTO Employee (Fname) VALUEs ('$FNAME');";
      $query = "INSERT INTO Employee (Minit) VALUEs ('$MINIT');";
      $query = "INSERT INTO Employee (Lname) VALUEs ('$LNAME');";
      $query = "INSERT INTO Employee (Age) VALUEs ('$AGE');";
      $query = "INSERT INTO Employee (Address) VALUEs ('$ADDRESS');";
      $query = "INSERT INTO Employee (Gender) VALUEs ('$GENDER');";
      $query = "INSERT INTO Employee (Hourly_Wage) VALUEs ('$HOURLYWAGE');";
      $query = "INSERT INTO Employee (JobNum) VALUEs ('$JOBNUM');";
      if(!mysqli_query($connection, $query)) echo("<p>Error updating Employees, all fields must be filled.</p>");
    }
?>



<form action="<?PHP echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
  <table border="0">
    <tr>
      <td>First Name</td>
      <td>Minit</td>
      <td>Lname</td>
      <td>Age</td>
      <td>Address</td>
      <td>Gender</td>
      <td>Hourly Wage</td>
      <td>Employee ID</td>
      <td>Job Number</td>
    </tr>
    <tr>
      <td>
        <input type="text" name="First Name" maxlength="45" size="30" />
      </td>
      <td>
        <input type="text" name="Minit" maxlength="45" size="30" />
      </td>
      <td>
      <input type="text" name="Lname" maxlength="45" size="30" />
      </td>
      <td>
      <input type="text" name="Age" maxlength="45" size="30" />
      </td>
      <td>
      <input type="text" name="Address" maxlength="45" size="30" />
      </td>
      <td>
      <input type="text" name="Gender" maxlength="45" size="30" />
      </td>
      <td>
      <input type="text" name="Hourly_Wage" maxlength="45" size="30" />
      </td>
      <td>
      <input type="text" name="EmployeeID" maxlength="45" size="30" />
      </td>
      <td>
      <input type="text" name="JobNum" maxlength="45" size="30" />
      </td>
      <td>
        <input type="submit" value="Add Data" />
      </td>
    </tr>
  </table>
</form>


<!-- Display table data. -->
<table border="1" cellpadding="2" cellspacing="2">
  <tr>
    <td>Fname</td>
    <td>Minit</td>
    <td>Lname</td>
    <td>Age</td>
    <td>Address</td>
    <td>Gender</td>
    <td>Hourly_Wage</td>
    <td>EmployeeID</td>
    <td>JobNum</td>
  </tr>

<?php
$result = mysqli_query($connection, "SELECT * FROM Employee");

while($query_data = mysqli_fetch_row($result)) {
  echo "<tr>";
  echo "<td>",$query_data[0], "</td>",
       "<td>",$query_data[1], "</td>",
       "<td>",$query_data[2], "</td>",
       "<td>",$query_data[3], "</td>",
       "<td>",$query_data[4], "</td>",
       "<td>",$query_data[5], "</td>",
       "<td>",$query_data[6], "</td>",
       "<td>",$query_data[7], "</td>",
       "<td>",$query_data[8], "</td>";
  echo "</tr>";
}
?>

<?php 
if(strlen($employee_Fname)){
  $query = "INSERT INTO Employee VALUES ($employee_Fname, $employee_Minit, $employee_Lname, $employee_Age, $employee_Address, $employee_Gender, $employee_HourlyWage, $employee_EmployeeID, $employee_JobNum)";
  mysqli_query($connection, $query);
}
?>


</table>

</body>
</html>