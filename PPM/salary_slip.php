

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
    <link rel="stylesheet" type="text/css" href="styles.css">

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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    
</head>




<body >
    <div class="salary-slip-template" id="salary-slip">
        <h2>Salary Slip</h2>
        <p>Employee Name&ensp;&ensp;: <?php echo $row['FIRSTNAME'] . " " . $row['LASTNAME'];?></p>
        <p>Employee Number: <?php echo $row['EMPLOYEE_NO']; ?></p>
        <p>Department&emsp;&emsp;&emsp;: <?php echo $department_row['DNAME']; ?></p>
        <p>Designation&emsp;&emsp; &emsp;: <?php echo $position_row['PNAME']; ?></p>
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

    <button   class="btn btn-primary" onclick="downloadSalarySlip()" id="download-button" >Download</button>
  
 </div>
 <script>
    function downloadSalarySlip() {
        document.getElementById("download-button").style.display = "none";
html2pdf(document.querySelector("#salary-slip"), {
    margin:       0.5,
    filename:     '<?php echo $row['FIRSTNAME']; ?>.pdf',
    image:        { type: 'jpeg', quality: 0.98 },
    html2canvas:  { dpi: 96, letterRendering: true },
    jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' }
});
    }
</script>
</body>
</html>

