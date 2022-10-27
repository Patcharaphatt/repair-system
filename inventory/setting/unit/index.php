<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/vendor/autoload.php";?>
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/auth/auth.php";?>

<?php

use App\Model\Unit;
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

	<div class="px-4 d-flex align-items-start h-100 justify-content-center">
		<div class="row w-100">
			<!-- search -->
			<div class="operation-card ">
				<div class="row">
					<div class="col-9 search-transection d-flex align-items-center">
							<div class="d-flex w-100 align-items-center">
								<div class="mr-component">
									<h4>รายการหน่วยอุปกรณ์</h4>
								</div>
							</div>
						</form>
					</div>

					<div class="col btn-add-transection d-flex justify-content-end align-items-center ">
						<a href="form.php" class="btn-ct btn btn-success text-align-center visibility">เพิ่มหน่วย</a>
					</div>

				</div>		
            </div>
					
			<div class="card-table py-4">
				<table class="table table-hover align-middle" id="dataTable">
					<thead>
						<tr>
							<th class="elm-1 text-center">ลำดับที่</th>
							<th class="elm-2">ชื่อ-หน่วยอุปกรณ์</th>
                            <th></th>
						</tr>
					</thead> 
					<tbody>

								<?php

									$unitObj = new unit;
									$units = $unitObj->getAllUnits();
									$n=0;
									foreach($units as $unit) {
										$n++;
										echo "
											<tr>
												<td class='elm-1 text-center'>{$n}</td>
												<td class='elm-2'>{$unit['unitTitle']}</td>
												<td>

													<div class='dropdown d-flex justify-content-end'>
														<button class='btn btn-warning dropdown-toggle' type='button' id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-expanded='false'>
															จัดการรายการ
														</button>
														<ul class='dropdown-menu' aria-labelledby='dropdownMenuButton1'>
														<li><a class='dropdown-item' href='form.php?Id={$unit['Id']}&action=edit' class='btn btn-warning');>แก้ไข</a></li>
														<li><a id='confirm_delete' onclick='return confirmDelete()' class='dropdown-item' href='save.php?Id={$unit['Id']}&action=delete' class='btn btn-danger'>ลบรายการ</a></li>
														</ul>
													</div>
				
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

		<script>
			// ยืนยันการลบข้อมูล
			function confirmDelete() {
				return confirm('คุณแน่ใจ ที่จะลบรายการนี้');
			}
		</script>

</body>
</html>