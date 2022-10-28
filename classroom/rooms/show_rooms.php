<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/vendor/autoload.php";?>
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/auth/auth.php";?>

<?php

use App\Model\Classroom;

// print_r($_REQUEST);
// exit;
?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title></title>
	<!-- include link conect file custom css -->
    <?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/inc/css/css_link/css.inc.link.php";?>
	
	<!-- icon link -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
</head>
<body>

	<!-- navbar -->
    <?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/inc/component/navbar.php";?>

	<!-- Tables -->

	<div class="px-4 h-100 w-100">
		<div class="row">
			<!-- search -->
			<div class="operation-card">
				<div class="row">
					<div class="col-lg-9 col-md-9 search-transection d-flex align-items-center">
						<div class="d-flex w-100 align-items-center">
							<div class="mr-component">
								<h4>อาคาร <?php echo $_REQUEST['build_Name'];?> ชั้น <?php echo $_REQUEST['floor'];?></h4>
							</div>
						</div>
					</div>

					<div class="col-lg-3 col-md-3 btn-add-transection d-flex justify-content-end align-items-center ">
						<a href="form_add_build.php" class="btn-ct btn btn-success text-align-center me-2 visibility">+ ห้องเรียน</a>
					</div>

				</div>		
            </div>
					
			<div class="card-table py-4">
				<table class="table table-hover align-middle" id="dataTable">
					<thead>
						<tr>
							<th class="elm-2 text-center">ห้องเรียน</th>
							<th class="elm-2 text-center">สถานะ</th>
                            <th></th>
						</tr>
					</thead> 
					<tbody>
								<?php
								
									$classroomObj = new classroom();
									$classrooms = $classroomObj->getAllRooms($_REQUEST);
									$n=0;
									foreach($classrooms as $classroom) {
										$n++;

										if($classroom['status'] <> 0) {
											$status = 'มีเจ้าของเรียบร้อยแล้ว';
										}else {
											$status ='ยังไม่มีเจ้าของห้อง';
										}
			
										echo "
											<tr>
												<td class='elm-2 text-center'>{$classroom['name']}</td>
												<td class='elm-2 text-center'>{$status}</td>
												   
												<td class='d-flex justify-content-end'>
													<a class='btn btn-warning' id='confirm_delete' onclick='return confirmDelete()' href='save.php?build_Name={$classroom['build']}&floor={$classroom['floor']}'>ดูรายการอุปกรณ์</a>				
												</td>

											</tr>
										";
									}
								?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- footer -->
		<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/inc/component/footer.php";?>

		<!-- include link conect file custom Javascript -->
		<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/inc/script/script_link/script.inc.link.php";?>

		<script>
			$(document).ready( function () {
    			$('#dataTable').DataTable();
			} );
		</script>

</body>
</html>