

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
<body>
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
        <p>Date: <?php echo date("F j, Y"); ?></p>
    </div>
    <form method="post">
        <input type="hidden" name="employee_name" value="<?php echo $row['FIRSTNAME'] . " " . $row['LASTNAME']; ?>">
        <input type="hidden" name="employee_number" value="<?php echo $row['EMPLOYEE_NO'];?>">
        <input type="hidden" name="basic_salary" value="<?php echo $salary_row['SALARY']; ?>">
        <input type="hidden" name="allowances" value="<?php echo $salary_row['ALLOWANCE'];?>">
        <input type="hidden" name="gross_salary" value="<?php echo $salary_row['SALARY']+$salary_row['ALLOWANCE']; ?>">
        <input type="hidden" name="deductions" value="<?php echo $salary_row['DEDUCTION']; ?>">
        <input type="hidden" name="net_salary" value="<?php echo  $salary_row['TOTAL_SALARY'];?>">
<input type="submit" name="download_slip" value="Download">
<button onclick="goBack()">Go Back</button>

<script>
    function goBack() {
        window.history.back();
    }
</script>
    </form>
</body>
</html>
<?php
if(isset($_POST['download_slip'])){
    $file_name = $_POST['employee_name'] . " - Salary Slip.pdf";
    $file_content = "Employee Name: " . $_POST['employee_name'] . "\r\n";
    $file_content .= "Employee Number: " . $_POST['employee_number'] . "\r\n";
    $file_content .= "Basic Salary: " . $_POST['basic_salary'] . "\r\n";
    $file_content .= "Allowances: " . $_POST['allowances'] . "\r\n";
    $file_content .= "Gross Salary: " . $_POST['gross_salary'] . "\r\n";
    $file_content .= "Deductions:" . $_POST['deductions'] . "\r\n";
    $file_content .= "Net Salary: " . $_POST['net_salary'] . "\r\n";
    header("Content-Disposition: attachment; filename=".$file_name);
echo $file_content;
exit();

}


?>
