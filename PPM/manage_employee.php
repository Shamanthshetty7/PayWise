<?php 
include 'db_connect.php'; 
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM employee where EMP_ID = ".$_GET['id'])->fetch_array();
	foreach($qry as $k => $v){
		$$k = $v;
	}
}
?>

<div class="container-fluid">
	<form id='employee_frm'>
		<div class="form-group">
			<label>Firstname</label>
			<input type="hidden" name="id" value="<?php echo isset($EMP_ID) ? $EMP_ID : "" ?>" />
			<input type="text" name="firstname" required="required" class="form-control" value="<?php echo isset($FIRSTNAME) ? $FIRSTNAME : "" ?>" />
		</div>
		
		<div class="form-group">
			<label>Lastname</label>
			<input type="text" name="lastname" required="required" class="form-control" value="<?php echo isset($LASTNAME) ? $LASTNAME : "" ?>" />
		</div>
		<div class="form-group">
			<label>Department</label>
			<select class="custom-select browser-default select2" name="department_id">
				<option value=""></option>
			<?php
			$dept = $conn->query("SELECT * from department order by DNAME asc");
			while($row=$dept->fetch_assoc()):
			?>
				<option value="<?php echo $row['DEPT_ID'] ?>" <?php echo isset($DEPT_ID) && $DEPT_ID == $row['DEPT_ID'] ? "selected" :"" ?>><?php echo $row['DNAME'] ?></option>
			<?php endwhile; ?>
			</select>
		</div>
		<div class="form-group">
			<label>Position</label>
			<select class="custom-select browser-default select2" name="position_id">
				<option value=""></option>
			<?php
			$pos = $conn->query("SELECT * from position order by PNAME asc");
			while($row=$pos->fetch_assoc()):
			?>
				<option class="opt" value="<?php echo $row['POS_ID'] ?>" data-did="<?php echo $row['DEPT_ID'] ?>" <?php echo isset($DEPT_ID) && $DEPT_ID == $row['DEPT_ID'] ? '' :"disabled" ?> <?php echo isset($POSITION_ID) && $POSITION_ID == $row['POS_ID'] ? " selected" : '' ?> ><?php echo $row['PNAME'] ?></option>
			<?php endwhile; ?>
			</select>
		</div>
		<div class="form-group">
			<label>Project NO</label>
			<select class="custom-select browser-default select2" name="project_id">
				<option value=""></option>
			<?php
			$dept = $conn->query("SELECT * from project order by project_name asc");
			while($row=$dept->fetch_assoc()):
			?>
				<option value="<?php echo $row['Project_ID'] ?>" <?php echo isset($PROJECT_ID) && $PROJECT_ID == $row['Project_ID'] ? "selected" :"" ?>><?php echo $row['project_name'] ?></option>
			<?php endwhile; ?>
			</
	</form>
</div>
<script>
	$('[name="department_id"]').change(function(){
		var did = $(this).val()
		$('[name="position_id"] .opt').each(function(){
			if($(this).attr('data-did') == did){
				$(this).attr('disabled',false)
			}else{
				$(this).attr('disabled',true)
			}
		})
	})
	$(document).ready(function(){
		$('.select2').select2({
			placeholder:"Please Select Here",
			width:"100%"
		})
		$('#employee_frm').submit(function(e){
				e.preventDefault()
				start_load();
			$.ajax({
				url:'ajax.php?action=save_employee',
				method:"POST",
				data:$(this).serialize(),
				error:err=>console.log(),
				success:function(resp){
						if(resp == 1){
							alert_toast("Employee's data successfully saved","success");
								setTimeout(function(){
								location.reload();

							},1000)
						}
				}
			})
		})
	})
</script>