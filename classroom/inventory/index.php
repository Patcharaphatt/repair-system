<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/vendor/autoload.php";?>
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/auth/auth.php";?>

<?php
use App\Model\Classroom;
?>

<!-- navbar -->
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/inc/component/navbar.php";?>

<?php

$Obj = new classroom;
$NumberOfComputer_ARR = $Obj->readAllComputersByRoomId($_REQUEST['roomID'], false); // นับจำนวนคอมพิวเตอร์ภายในห้อง
$NumberOfComputers = $NumberOfComputer_ARR[0]['COUNT_COMPUTERID']; // จำนวนคอมพิวเตอร์ในห้อง

$computers = $Obj->readAllComputersByRoomId($_REQUEST['roomID']); 
$Connect_inventories = [];
$n=0;
foreach($computers as $computer) { // ลูปคอมพิวเตอร์ทั้งหมดโดยอ้างอิง Id ห้อง (กรองคอมพิวเตอร์มาแล้วเอาเฉพาะคอมพิวเตอร์ที่อยู่ในห้องที่เลือก)
	$Connect = $Obj->readConnectInventoryToComputer($computer['ID']); // ดึงข้อมูล tbl_connect ที่มี IdComputer อยู่เพื่อกรองอุปกรณ์ที่เชื่อมต่อ
	if($Connect){ // ถ้ามีข้อมูลให้ดึงให้เข้า if นี้
		$Connect_inventories[$n] = $Connect; // เก็บค่าที่ลูปออกมา
		$n++;
		continue; // ให้โปรแกรมทำงานลูปต่อ 
	}
}
// print_r($Connect_inventories);
?>

<!-- Tables -->
<div class="px-4 h-100 w-100">
	<div class="row">
	<?php 
		// ถ้าคอมพิวเตอร์ในห้อง = 0 ให้ขึ้น alert
		if($NumberOfComputers == 0) {
			$message = 'คำแนะนำ !!! เพิ่มคอมพิวเตอร์ และเชื่อมต่ออุปกรณ์';
			echo "<div class='alert alert-danger' role='alert'>
					$message
				</div>";
		}
	?>
	<!-- search -->
		<div class="operation-card">
			<div class="row">
				<div class="col-lg-8 col-md-9 search-transection d-flex align-items-center">
					
					<div class="d-flex w-100 align-items-center">
						<div class="mr-component">
							<h4>รายการคอมพิวเตอร์ของ ห้อง <?php echo $_REQUEST['roomNUMBER']; // แสดงหมายเลขห้อง ?></h4>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-3 btn-add-transection d-flex justify-content-end align-items-center ">

					<!-- เมนู่จัดการรายการห้องเรียน -->
					<div class="container-menu visibility">
						<a href="#" class="menu d-flex align-items-center btn-ct btn btn-warning text-align-center visibility">
							จัดการผู้ดูแล
						</a>
						<ul class="dropdown">
							<li>
								<?php 
									if($NumberOfComputers <> 0 && $Connect_inventories <> []) { // ถ้าจำนวนคอมพิวเตอร์ในห้อง = 0 ไม่ให้โชว์ส่งรายการอุปกรณ์
								?>
								<a " href="/repair-system/classroom/inventory/details_Inventory_confirm.php?
									roomID=<?php echo $_REQUEST['roomID']; // ไอดีรหัสห้อง ?>
									&build=<?php echo $_REQUEST['build']; // เลขตึก ?>
									&floor=<?php echo $_REQUEST['floor']; // เลขห้อง ?>
									">ส่งตรวจสอบ
								</a>
								<?php } ?>
							</li>

							<li>
								<a href="../classroom_owner/form_AddOwnerRoom.php?
									action=cancelOwnerRoom
									&roomID=<?php echo $_REQUEST['roomID']; // ไอดีรหัสห้อง ?>
									&roomNUMBER=<?php echo $_REQUEST['roomNUMBER']; // หมายเลขห้อง ?>
									&floor=<?php echo $_REQUEST['floor']; // หมายเลขชั้น ?>
									&build=<?php echo $_REQUEST['build']; // หมายเลขตึก ?>
									"style="color: #dc3545 !important;">ยกเลิกผู้ดูแล
								</a>
							</li>	
						</ul>
					</div>

					<!-- ปุ่มเพิ่มคอมพิวเตอร์ -->
					<a
						href="
							form_CreateComputer.php?
							roomID=<?php echo $_REQUEST['roomID']; // ไอดีรหัสห้อง ?>
							&roomNUMBER=<?php echo $_REQUEST['roomNUMBER']; // หมายเลขห้อง ?>
							&floor=<?php echo $_REQUEST['floor']; // หมายเลขชั้น ?>
							&build=<?php echo $_REQUEST['build']; // หมายเลขตึก ?>
						"
						class="btn-ct btn btn-success text-align-center visibility" style="margin-left: 8px !important;">
						เพิ่มคอม
					</a>

				</div>
			</div>		
        </div>
		<div class="card-table py-4">
			<table class="table table-hover align-middle" id="dataTable">
				<thead>
					<tr>
						<th class="elm-1 text-center">หมายเลขคอม</th>
						<th class="elm-1 text-center">จำนวนอุปกรณ์</th>
                        <th></th>
					</tr>
				</thead>
				<tbody>
					<?php		
						$Obj = new classroom;
						$computers = $Obj->readAllComputersByRoomId($_REQUEST['roomID']);
						$COUNT_COMPUTERID = '';

						foreach($computers as $computer) { // loop รหัสคอมภายในห้อง
							$numberOfInventory = $Obj->readNumberOfInventoryByComId($computer['ID']); // ดึงข้อมูลจำนวนอุปกรณ์ภายในเครื่องที่เลือกมา

							if($numberOfInventory['COUNT_COMPUTERID'] == '0'){ // เช็คว่าจำนวนอุปกรณ์ = 0 มั้ย
								$COUNT_COMPUTERID = '<p class="text-danger-ct">'.$numberOfInventory['COUNT_COMPUTERID'].'</p>'; // เปลื่ยนข้อความเป็นสีแดง
							}else {
								$COUNT_COMPUTERID = '<p>'.$numberOfInventory['COUNT_COMPUTERID'].'</p>'; // ข้อความเป็นสีดำค่า De
							}

							echo "
								<tr>
									<td class='elm-2 text-center'>{$computer['CODE']}</td>   
									<td class='elm-2 text-center'>{$COUNT_COMPUTERID}</td>
									<td class='d-flex justify-content-end'>
										<div class='dropdown d-flex justify-content-end'>
											<button class='btn btn-warning dropdown-toggle' type='button' id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-expanded='false'>
												จัดการรายการ
											</button>
											<ul class='dropdown-menu' aria-labelledby='dropdownMenuButton1'>
												<li>
													<a class='dropdown-item' href='show_Inventory.php?
														computerID={$computer['ID']}
														&computerCODE={$computer['CODE']}
													'>ดูรายการอุปกรณ์</a>
												</li>
												<li>
													<a class='dropdown-item text-danger' onclick='return confirmDelete()' href='../save.php?
														action=deleteComputer
														&computerID={$computer['ID']}
														&computerCODE={$computer['CODE']}
														&roomID={$_REQUEST['roomID']}
														&roomNUMBER={$_REQUEST['roomNUMBER']}
														&build={$_REQUEST['build']}
														&floor={$_REQUEST['floor']}
													'>ลบรายการคอม</a>
												</li>
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