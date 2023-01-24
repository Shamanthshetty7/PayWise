

<!-- Salary Slip template -->



<?php 
session_start();
include('db_connect.php');


$id = $_GET['id'];
//Retrieve employee information
$employee_qry=$conn->query("SELECT * FROM employee where EMP_ID=$id") or die(mysqli_error());
$row=$employee_qry->fetch_array();

    //Retrieve salary information for each employee
$salary_qry = $conn->query("SELECT * FROM monthly_salary WHERE EMP_ID = '".$id."'") or die(mysqli_error());
$salary_row = $salary_qry->fetch_array();
if ($salary_qry->num_rows ==0) {
    return 0;
}
    //Retrieve deductions information
    $DEPARTMENT = $conn->query("SELECT * FROM DEPARTMENT WHERE DEPT_ID = '".$row['DEPT_ID']."'") or die(mysqli_error());
    $department_row = $DEPARTMENT->fetch_array();
   //retrieve position
   $position = $conn->query("SELECT * FROM position WHERE POS_ID = '".$row['POSITION_ID']."'") or die(mysqli_error());
    $position_row = $position->fetch_array(); 
?>
<!DOCTYPE html>
<html>
<head>
    <title>Salary Slip</title>
    <style>
        /* Add your CSS styles here */
        .salary-slip-template {
            width: 600px;
            margin: 0 auto;
            border: 1px solid #ccc;
            padding: 20px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
        }
        th {
            text-align: left;
        }
    </style>
</head>
<div class="header" style="background-color:rgba(0, 0, 0, 0.05)">

<body >
    <div class="salary-slip-template">
        <h2>Salary Slip</h2>
        <p>Employee Name: <?php echo $row['FIRSTNAME'] . " " . $row['LASTNAME'];?></p>
        <p>Employee Number: <?php echo $row['EMPLOYEE_NO']; ?></p>
        <p>Department: <?php echo $department_row['DNAME']; ?></p>
        <p>Designation: <?php echo $position_row['PNAME']; ?></p>
        <table>
            <tr>
                <th>Earnings</th>
                <th>Amount</th>
            </tr>
            <tr>
                <td>Basic Salary</td>
                <td><?php echo $salary_row['SALARY']; ?></td>
            </tr>
            <tr>
                <td>Allowances</td>
                <td><?php echo $salary_row['ALLOWANCE']; ?></td>
            </tr>
            <tr>
                <td>Gross Salary</td>
                <td><?php  echo $salary_row['SALARY']+$salary_row['ALLOWANCE']; ?></td>
            </tr>
            <tr>
                <td>Deductions</td>
                <td><?php echo $salary_row['DEDUCTION']; ?></td>
            </tr>
            <tr>
                <td>Net Salary</td>
                <td><?php echo $salary_row['TOTAL_SALARY'];?></td>
            </tr>
        </table>
        <hr style="margin-bottom: 20px;">


        <p>Signature: ____________</p> 
        <p>Date :<?php echo date("F j, Y"); ?></p>
    </div>
   
<div id="salary-slip-template" class="salary-slip-template">
<form method="post" id="myform">
        <input type="hidden" name="employee_name" value="<?php echo $row['FIRSTNAME'] . " " . $row['LASTNAME']; ?>">
        <input type="hidden" name="employee_number" value="<?php echo $row['EMPLOYEE_NO']; ?>">
        <input type="hidden" name="department" value="<?php echo $department_row['DNAME']; ?>">
        <input type="hidden" name="designation" value="<?php echo $position_row['PNAME']; ?>">
        <input type="hidden" name="gross_salary" value="<?php echo $salary_row['SALARY']+$salary_row['ALLOWANCE']; ?>">
        <input type="hidden" name="net_salary" value="<?php echo $salary_row['TOTAL_SALARY']; ?>">
        <button type="button" class="btn btn-primary" id='submit' >Download</button>
</form>

 </div> 
 </div>





</body>
</html>

