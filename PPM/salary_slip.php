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

<!-- Salary Slip template -->
<div class="salary-slip-template">
    <h2>Salary Slip</h2>
    <p>Employee Name  : <?php echo $row['FIRSTNAME'] . " " . $row['LASTNAME']; ?></p>
    <p>Department Name: <?php echo $department_row['DNAME']  ?></p>
    <p>Position       : <?php echo $position_row['PNAME']  ?></p>
    <p>Employee Number: <?php echo $row['EMPLOYEE_NO']; ?></p>
    <p>Basic Salary   : <?php echo $salary_row['SALARY']; ?></p>
    <p>Allowances     : <?php echo $salary_row['ALLOWANCE']; ?></p>
    <p>Gross Salary   : <?php echo $salary_row['SALARY']+$salary_row['ALLOWANCE']; ?></p>
    <p>Deductions     : <?php echo $salary_row['DEDUCTION']; ?></p>
    <p>Net Salary     : <?php echo $salary_row['TOTAL_SALARY']; ?></p>
</div>

<?php
if(isset($_POST['download_slip'])){
    $file_name = $_POST['employee_name'] . " - Salary Slip.txt";
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
