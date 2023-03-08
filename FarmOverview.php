<?php 
include "dbinfo.inc";
?>
<!doctype html>

<html lang="en">
  <head>
    <h1 style="text-align: center">This is the main overview page for all aspects of RDS Farms.</h1>
    <a class="btn btn-light btn-lg pull-right" href="index.html" role="button">Return Home</a>
    <style type="text/css">
      body{
        background: powderblue !important;
      }
      .row {
        text-align: center !important;
        justify-content: center !important;
      }
      .page-grid {
        display: grid; 
        grid-template-columns: 1fr , repeat (2 1fr); /* Two columns  */
        grid-template-rows:  1fr, repeat (8 1fr); /* eight rows  */

        grid-gap: 25px 25px; /* Short hand for both col and row */
        grid-gap: 25px 25px; /* Short hand for both col and row */
        margin:0px;
        padding:10px; 
      }
    </style>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <?php
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
    if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();
    mysqli_select_db($connection, DB_DATABASE); //Is needed to connect to database?>
  </head>
  <body>
  
    <p>
    </p>
    <div class="container-fluid text-center">
    <button class="btn btn-dark btn-lg pull-right" type="button" data-bs-toggle="collapse" data-bs-target="#employees" aria-expanded="false" aria-controls="employees">Employees</button>
    <button class="btn btn-dark btn-lg pull-right" type="button" data-bs-toggle="collapse" data-bs-target="#orders" aria-expanded="false" aria-controls="orders">Order History</button>
    <button class="btn btn-dark btn-lg pull-right" type="button" data-bs-toggle="collapse" data-bs-target="#silo" aria-expanded="false" aria-controls="orders">Current Storage</button>
      <div class="row">
        <div class="col-4">
          <div class="collapse border text-center" id="employees">
            <table class="table-success">
              <thread>
                <tr>
                  <th>Employee ID</th>
                  <th>Employee Name</th>
                  <th>Age</th>
                  <th>Address</th>
                  <th>Gender</th>
                  <th>Wage</th>
                  <th>JobNum</th>
                  <th>Job Title</th>
                </tr>
            </thread>
            <tbody>
              <?php
              $result = mysqli_query($connection, 
              "SELECT Employee.Fname, Employee.Minit, Employee.Lname, Employee.Age, Employee.Address, Employee.Gender, Employee.Hourly_Wage, Employee.EmployeeID, Employee.JobNum, Job.Job_Title
              FROM Employee
              INNER JOIN Job ON Job.JobID = Employee.JobNum
              ORDER BY Employee.EmployeeID;");

              while($query_data = mysqli_fetch_row($result)) {
                echo "<tr>";
                echo "<th scope=\"row\">",$query_data[7], "</th>",
                    "<td class>",$query_data[0]," ",$query_data[1],". ",$query_data[2], "</td>",
                    "<td>",$query_data[3], "</td>",
                    "<td>",$query_data[4], "</td>",
                    "<td>",$query_data[5], "</td>",
                    "<td>",$query_data[6], "</td>",
                    "<td>",$query_data[8], "</td>",
                    "<td>",$query_data[9], "</td>";
                echo "</tr>";
                      }?>
              </tbody>
              </table>
          </div>
        </div>
        <div class="col-3">
          <div class="collapse border text-center " id="orders">
            <table class="table-primary">
              <thread>
                <tr>
                  <th>Order ID</th>
                  <th>Customer Name</th>
                  <th>Fruit Ordered</th>
                  <th>Order Amount</th>
                  <th>Silo Used</th>
                  <th>Left in Silo</th>
                </tr>
            </thread>
            <tbody>
              <?php
              $result = mysqli_query($connection, "SELECT Orders.OrderID, CustomerLogin.Name, Fruit.FruitType, Orders.OrderAmt, StorageSilo.SiloID,  StorageSilo.CurrentStorageCapacity
              FROM Orders 
              INNER JOIN Fruit ON Orders.Orders_FruitID = Fruit.FruitID
              INNER JOIN CustomerLogin ON Orders.Orders_CustomerID = CustomerLogin.CustomerID
              INNER JOIN StorageSilo ON Orders.Orders_SiloID = StorageSilo.SiloID
              ORDER BY Orders.OrderID;");
                          

              while($query_data = mysqli_fetch_row($result)) {
                echo  "<tr>";
                echo "<th scope=\"row\">",$query_data[0], "</th>",
                      "<td>",$query_data[1], "</td>",
                      "<td>",$query_data[2], "</td>",
                      "<td>",$query_data[3], "</td>",
                      "<td>",$query_data[4], "</td>",
                      "<td>",$query_data[5], "</td>";
                echo  "</tr>";
                      }?>   
              </tbody>
              </table>
          </div>
        </div>
        <div class="col-md-2">
          <div class="collapse border text-center " id="silo">
            <table class="table-primary">
              <thread>
                <tr>
                  <th>Silo ID</th>
                  <th>Fruit Held</th>
                  <th>Currently Available</th>
                  <th>Max Held</th>
                </tr>
            </thread>
            <tbody>
              <?php
              $result = mysqli_query($connection, 
              "SELECT StorageSilo.SiloID, StorageSilo.CurrentStorageCapacity, StorageSilo.MaxStorageCapacity, Fruit.FruitType
              FROM StorageSilo
              INNER JOIN Fruit ON Fruit.FruitID = StorageSilo.SiloFruitNum
              ORDER BY StorageSilo.SiloID;");
                          

              while($query_data = mysqli_fetch_row($result)) {
                echo  "<tr>";
                echo "<th scope=\"row\">",$query_data[0], "</th>",
                      "<td>",$query_data[3], "</td>",
                      "<td>",$query_data[2], "</td>",
                      "<td>",$query_data[1], "</td>";
                echo  "</tr>";
                      }?>   
              </tbody>
              </table>
          </div>
        </div>
    </div>
    <button class="btn btn-dark btn-lg pull-left" type="button" data-bs-toggle="collapse" data-bs-target="#fruit" aria-expanded="false" aria-controls="orders">Fruits Stored</button>
    <div class="container text-center">
    <div class="row">
      <div class="col-2">
          <div class="collapse border text-center " id="fruit">
            <table class="table-primary">
              <thread>
                <tr>
                  <th>Fruit ID</th>
                  <th>Fruit</th>
                  <th>Price/Bsh.</th>
                </tr>
            </thread>
            <tbody>
              <?php
              $result = mysqli_query($connection, 
              "SELECT Fruit.FruitID, Fruit.FruitType, Fruit.FruitBushelPrice
              FROM Fruit
              ORDER BY Fruit.FruitID;");
                          

              while($query_data = mysqli_fetch_row($result)) {
                echo  "<tr>";
                echo "<th scope=\"row\">",$query_data[0], "</th>",
                      "<td>",$query_data[1], "</td>",
                      "<td>",$query_data[2], "</td>";
                echo  "</tr>";
                      }?>   
              </tbody>
              </table>
          </div>
        </div>
      </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>