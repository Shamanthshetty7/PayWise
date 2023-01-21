<?php
session_start();
include 'db_connect.php';
$id = $_GET['id'];

if (empty($id)) {
    echo "Invalid employee id";
    exit();
}

$stmt = $conn->prepare("SELECT e.*,d.DNAME as dname,p.PNAME as pname FROM employee e inner join department d on e.DEPT_ID = d.DEPT_ID inner join position p on e.POSITION_ID = p.POS_ID where e.EMP_ID = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$emp = $result->fetch_assoc();

if ($result->num_rows == 0) {
    echo "No employee found";
    exit();
}

$stmt_salary = $conn->prepare("SELECT POS.SALARY FROM POSITION POS
	 JOIN EMPLOYEE EMP ON POS.POS_ID = EMP.POSITION_ID 
	 WHERE EMP.EMP_ID = ?");
$stmt_salary->bind_param("i", $id);
$stmt_salary->execute();
$result_salary = $stmt_salary->get_result();
$salary = $result_salary->fetch_assoc();

$stmt_allowance = $conn->prepare("SELECT ALLOWANCE FROM PROJECT P
      JOIN EMPLOYEE EMP ON P.Project_ID = EMP.PROJECT_ID 
      WHERE EMP.EMP_ID = ?");
$stmt_allowance->bind_param("i", $id);
$stmt_allowance->execute();
$result_allowance = $stmt_allowance->get_result();
$allowance = $result_allowance->fetch_assoc();

$stmt_salary->close();
$stmt_allowance->close();
$stmt->close();
?>
<div class="container-fluid">
    <form  id="deduction_frm">
        <div class="form-group">
            <label>Deduction</label>
            <input type="hidden" name="id" value="<?php echo $id ?>" />
            <input type="hidden" name="salary" value="<?php echo $salary['SALARY']/12 ?>" />
            <input type="hidden" name="allowance" value="<?php echo $allowance['ALLOWANCE'] ?>" />
            <input type="text" name="deduction" class="form-control" placeholder="Enter the deduction amount(optional)" />
           
        </div>
    </form>
</div>
<script>
    $(document).ready(function(){  $('#deduction_frm').submit(function(e){
        
                e.preventDefault()
                start_load();
                $.ajax({
				url:'ajax.php?action=save_deduction',
				method:"POST",
				data:$(this).serialize(),
				error:err=>console.log(),
				success:function(resp){
						if(resp == 1){
							alert_toast("Salary slip updated successfully","success");
								setTimeout(function(){
								location.reload();

							},1000)
						}else {
                            alert_toast("Already calculated","success");
								setTimeout(function(){
								location.reload();

							},1000)
                        }
				}
			})
        })
    });
</script>
