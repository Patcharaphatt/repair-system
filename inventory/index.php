<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/vendor/autoload.php";?>
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/auth/auth.php";?>

<?php

use App\Model\Inventory;
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
								<h4>รายการอุปกรณ์ทั้งหมด</h4>
							</div>
						</div>
					</div>

					<div class="col-lg-3 col-md-3 btn-add-transection d-flex justify-content-end align-items-center ">
						<a href="form.php" class="btn-ct btn btn-success text-align-center me-2 visibility">เพิ่มอุปกรณ์</a>
						<div class="container-menu visibility">
							<a href="#" class="menu d-flex align-items-center btn-ct btn btn-warning text-align-center visibility">
								ตั้งค่า
							</a>
							<ul class="dropdown ">
								<li><a href="/repair-system/inventory/setting/category/index.php">หมวดหมู่</a></li>
								<li><a href="/repair-system/inventory/setting/type/index.php">ประเภท</a></li>
								<li><a href="/repair-system/inventory/setting/brand/index.php">ยี่ห้อ</a></li>
								<li><a href="/repair-system/inventory/setting/unit/index.php">หน่วย</a></li>	
							</ul>
						</div>
					</div>

				</div>		
            </div>
					
			<div class="card-table py-4">
				<table class="table table-hover align-middle" id="dataTable">
					<thead>
						<tr>
							<th class="elm-1 text-center">ลำดับที่</th>
							<th class="elm-2">ชื่อ-พัสดุ</th>
							<th class='elm-2 hidden'>หมายเลขเครื่อง/เลขทะเบียน</th>
							<th class='elm-3 hidden'>หมวดหมู่</th>
                            <th class='elm-3 hidden'>ประเภท</th>
                            <th class='elm-3 hidden'>ยี่ห้อ</th>
                            <th class='elm-3 hidden text-center'>จำนวน</th>
                            <th></th>
						</tr>
					</thead> 
					<tbody>

								<?php
								
									$inventoryObj = new inventory();
									$inventories = $inventoryObj->getAllInventory();
									$n=0;
									foreach($inventories as $inventory) {
										$n++;
										$serial = substr($inventory['serial'], 0, strlen($inventory['serial'])-5);
										echo "
											<tr>
												<td class='elm-1 text-center'>{$n}</td>
												<td class='elm-2'>{$inventory['inventoryName']}</td>
												<td class='elm-2 hidden'>{$serial}</td>
												<td class='elm-3 hidden'>{$inventory['categoryTitle']}</td>
												<td class='elm-3 hidden'>{$inventory['typeTitle']}</td>
												<td class='elm-3 hidden'>{$inventory['brandTitle']}</td>
												<td class='elm-3 hidden text-center'>{$inventory['countInventoryStock']}</td>
												   
												<td class='d-flex justify-content-end'>

													<div class='dropdown d-flex justify-content-end'>
														<button class='btn btn-warning dropdown-toggle' type='button' id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-expanded='false'>
															จัดการรายการ
														</button>
														<ul class='dropdown-menu' aria-labelledby='dropdownMenuButton1'>
															<li><a class='dropdown-item' href='form.php?Id={$inventory['Id']}&action=edit'>แก้ไข</a></li>
															<li><a class='dropdown-item text-danger' id='confirm_delete' onclick='return confirmDelete()' class='dropdown-item' href='save.php?inventory_Name={$inventory['inventoryName']}&action=delete'>ลบรายการ</a></li>
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