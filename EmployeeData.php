<?php include "./dbinfo.inc";?>

<!DOCTYPE html>
<html>
<head>
  <style>
    body{
      justify-content: center;
    }
    form {
      border-collapse: collapse;
      width: 900px;
      font-size:30px;
    }
    table {
      border: 1px solid black;
      border-collapse: collapse;
      width: 1300px;
      height: 800px;
      font-size:30px
    }
    table.center {
      margin-left: auto; 
      margin-right: auto;
    }
    form {
      margin-left: auto; 
      margin-right: auto;
      width: 1500px;
      float:center;
      text-align: center;
    }
    p {
      text-align: center;
      font-size: 30px;
    }
  </style>
<body style="background-color:powderblue;">
</head>
<h1>Employee Records</h1>
<!-- <a href="http://ec2-3-19-243-226.us-east-2.compute.amazonaws.com">Return to Home</a> -->
<a href="/index.html">Return to Home</a>
<p>This is where you can find information on all current employees of RDS Farms.</p>

<?php
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
    if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();
    mysqli_select_db($connection, DB_DATABASE); //Is needed to connect to database

    /* If input fields are populated, add a row to the EMPLOYEES table. */
    $employee_Fname = htmlentities($_POST['FirstName']);
    $employee_Minit = htmlentities($_POST['Minit']);
    $employee_Lname = htmlentities($_POST['Lname']);
    $employee_Age = htmlentities($_POST['Age']);
    $employee_Address = htmlentities($_POST['Address']);
    $employee_Gender = htmlentities($_POST['Gender']);
    $employee_HourlyWage = htmlentities($_POST['HourlyWage']);
    $employee_EmployeeID = htmlentities($_POST['EmployeeID']);
    $employee_JobNum = htmlentities($_POST['JobNum']);
    $x = rand(99999,999999);
    
    if(strlen($employee_HourlyWage)){
    //if(strlen($employee_EmployeeID)||strlen($employee_Fname)||strlen($employee_Minit)||strlen($employee_Lname)||strlen($employee_Age)||strlen($employee_Address)||strlen($employee_Gender)||strlen($employee_HourlyWage)||strlen($employee_JobNum)){
      $FNAME =  mysqli_real_escape_string($connection, $employee_Fname);
      $MINIT =  mysqli_real_escape_string($connection, $employee_Minit);
      $LNAME =  mysqli_real_escape_string($connection, $employee_Lname);
      $AGE =  mysqli_real_escape_string($connection, $employee_Age);
      $ADDRESS = mysqli_real_escape_string($connection, $employee_Address);
      $GENDER =  mysqli_real_escape_string($connection, $employee_Gender);
      $HOURLYWAGE =  mysqli_real_escape_string($connection, $employee_HourlyWage);
      $id = mysqli_real_escape_string($connection, $employee_EmployeeID);
      $JOBNUM =  mysqli_real_escape_string($connection, $employee_JobNum);
      //$query = "INSERT INTO Employee VALUES ($employee_Fname, $employee_Minit, $employee_Lname, $employee_Age, $employee_Address, $employee_Gender, $employee_HourlyWage, $employee_EmployeeID, $employee_JobNum)";
      $query = "INSERT INTO Employee VALUES('$FNAME', '$MINIT', '$LNAME', '$AGE', '$ADDRESS', '$GENDER', '$HOURLYWAGE', '$x', '$JOBNUM');";
      //$query = "INSERT INTO Employee (EmployeeID) VALUEs ('$id');";
      //$query = "INSERT INTO Employee (Fname) VALUEs ('$FNAME');";
      //$query = "INSERT INTO Employee (Minit) VALUEs ('$MINIT');";
      //$query = "INSERT INTO Employee (Lname) VALUEs ('$LNAME');";
      //$query = "INSERT INTO Employee (Age) VALUEs ('$AGE');";
      //$query = "INSERT INTO Employee (Address) VALUEs ('$ADDRESS');";
      //$query = "INSERT INTO Employee (Gender) VALUEs ('$GENDER');";
      //$query = "INSERT INTO Employee (Hourly_Wage) VALUEs ('$HOURLYWAGE');";
      //$query = "INSERT INTO Employee (JobNum) VALUEs ('$JOBNUM');";
      //if(!mysqli_query($connection, $query)) echo("<p>Error updating Employees, all fields must be filled.</p>");
      mysqli_query($connection, $query) or die(mysqli_error($connection)); //Use this, the 'or die' call will read the error given back by FarmDB database and tell you exactly what the issue is.
    }
?>

  <form action="<?PHP echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
    <label for="FirstName">First Name:</label>
    <input type="text" name="FirstName" id="FirstName" class="input">
    <label for="Minit">Middle Initial:</label>
    <input type="text" name="Minit" id="Minit" class="input">
    <label for="Lname">Last Name:</label>
    <input type="text" name="Lname" id="Lname" class="input">
    <label for="Age">Age:</label>
    <input type="text" name="Age" id="Age" class="input"><br>
    <label for="Address">Address:</label>
    <input type="text" name="Address" id="Address" class="input">
    <label for="Gender">Gender:</label>
    <input type="text" name="Gender" id="Gender" class="input">
    <label for="HourlyWage">HourlyWage:</label>
    <input type="text" name="HourlyWage" id="HourlyWage" class="input">
    <!-- <label for="EmployeeID">Employee ID:</label>
    <input type="text" name="EmployeeID" id="EmployeeID" class="input"> -->
    <!-- <label for="JobNum">Job Number:</label> -->
    <!-- <input type="text" name="JobNum" id="JobNum" class="input"> -->
    <label for="JobNum">Job Number:</label>
    <select id="JobNum" name="JobNum">
      <option value="">Select</option>
      <option value="3">1. Sorter</option>
      <option value="4">2. Delivery Driver</option>
      <option value="5">3. Equipment Mechanic</option>
      <option value="6">4. Farm Maintenance</option>
      <option value="7">5. Human Relations</option>
      <option value="8">6. Secretary</option>
      <option value="9">7. Agicultural Engineer</option>
      <option value="10">8. Picker</option>
      <option value="11">9. Fruit Transporter</option>
      <option value="12">10. Silo Operator</option>
    </select>
    <input type="submit" value="Add Employee">
  </form>


<!-- Display table data. -->
<table class="center" border="1" cellpadding="2" cellspacing="2">
  <tr>
    <td style="text-align:center">Employee ID</td>
    <td style="text-align:center">Employee Name</td>
    <td style="text-align:center">Age</td>
    <td style="text-align:center">Address</td>
    <td style="text-align:center">Gender</td>
    <td style="text-align:center">Wage (Hourly)</td>
    <td style="text-align:center">Title</td>
  </tr>

<?php
$result = mysqli_query($connection, 
  "SELECT Employee.Fname, Employee.Minit, Employee.Lname, Employee.Age, Employee.Address, Employee.Gender, Employee.Hourly_Wage, Employee.EmployeeID, Job.Job_Title
  FROM Employee
  INNER JOIN Job ON Job.JobID = Employee.JobNum
  ORDER BY Employee.EmployeeID;");

while($query_data = mysqli_fetch_row($result)) {
  echo "<tr>";
  echo "<td style=\"text-align:center\">",$query_data[7], "</td>",
       "<td style=\"text-align:center\">",$query_data[0]," ",$query_data[1],". ",$query_data[2], "</td>",
       "<td style=\"text-align:center\">",$query_data[3], "</td>",
       "<td style=\"text-align:center\">",$query_data[4], "</td>",
       "<td style=\"text-align:center\">",$query_data[5], "</td>",
       "<td style=\"text-align:center\">",$query_data[6], "</td>",
       "<td style=\"text-align:center\">",$query_data[8], "</td>";
  echo "</tr>";
}

function function_alert($message){
    echo "<script>alert('$message');</script>";
  }
?>

</table>

</body>
</html>