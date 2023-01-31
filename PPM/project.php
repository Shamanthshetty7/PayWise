
<?php include('db_connect.php');?>

<div class="container-fluid">
	
	<div class="col-lg-12">
		<div class="row">
			<!-- FORM Panel -->
			<div class="col-md-4">
			<form action="" id="manage-project">
				<div class="card">
					<div class="card-header">
						  Position Form
				  	</div>
					<div class="card-body">
							<input type="hidden" name="id">
							<div class="form-group">
								<label class="control-label">Poject Title</label>
								<textarea name="ptitle" id="" cols="30" rows="1" class="form-control"></textarea>
							</div>
                            <div class="form-group">
								<label class="control-label">Allowance</label>
								<textarea name="allowance" id="" cols="30" rows="1" class="form-control"></textarea>
							</div>
					</div>
							
					<div class="card-footer">
						<div class="row">
							<div class="col-md-12">
								<button class="btn btn-sm btn-primary col-sm-3 offset-md-3" > Save</button>
								<button class="btn btn-sm btn-secondary col-sm-3" type="button" onclick="_reset()"> Cancel</button>
							</div>
						</div>
					</div>
				</div>
			</form>
			</div>
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-8">
				<div class="card">
					<div class="card-body">
						<table class="table table-bordered table-hover">
							<thead>
								<tr><th class="text-center">#</th>
                                    <th class="text-center">Project Number</th>
									<th class="text-center">Project Title</th>
									<th class="text-center">Allowance</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$position = $conn->query("SELECT * FROM project order by Project_ID asc");
								while($row=$position->fetch_assoc()):

								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td class="">
										 <p> <b><?php echo $row['project_num'] ?></b></p>
									</td>
                                    <td class="">
										 <p> <b><?php echo $row['project_name'] ?></b></p>
									</td>
									<td class="">
										 <p> <b><?php echo $row['ALLOWANCE'] ?></b></p>
									</td>
									<td class="text-center">
										<button class="btn btn-sm btn-primary edit_project" type="button" data-id="<?php echo $row['Project_ID'] ?>"  data-name="<?php echo $row['project_name'] ?>" data-salary="<?php echo $row['ALLOWANCE'] ?>"   >Edit</button>
										<button class="btn btn-sm btn-danger delete_project" type="button" data-id="<?php echo $row['Project_ID'] ?>">Delete</button>
									</td>
								</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- Table Panel -->
		</div>
	</div>	

</div>
<style>
	
	td{
		vertical-align: middle !important;
	}
	td p{
		margin: unset
	}
	img{
		max-width:100px;
		max-height:150px;
	}
</style>
<script>
	function _reset(){
		$('[name="Project_ID"]').val('');
		$('#manage-project').get(0).reset();
		$('.select2').val('').select2({
			placeholder:"Please Select Here",
			width:"100%"
		})
	}
	$('.select2').select2({
		placeholder:"Please Select Here",
		width:"100%"
	})
	$('#manage-project').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_project',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully added",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
				else if(resp==2){
					alert_toast("Data successfully updated",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	})
	$('.edit_project').click(function(){
		start_load()
		var cat = $('#manage-project')
		cat.get(0).reset()
		cat.find("[name='id']").val($(this).attr('data-id'))
        cat.find("[name='ptitle']").val($(this).attr('data-name'))
		cat.find("[name='allowance']").val($(this).attr('data-salary'))
		
		end_load()
	})
	$('.delete_project').click(function(){
		_conf("Are you sure to delete this project?","delete_project",[$(this).attr('data-id')])
	})
	function displayImg(input,_this) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
        	$('#cimg').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}
	function delete_project($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_project',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>