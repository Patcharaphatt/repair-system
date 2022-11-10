<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/vendor/autoload.php";?>
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/auth/auth.php";?>

<?php
use App\Model\Classroom;

// print_r($_REQUEST);
// exit
?>

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
							<h4>รายการอุปกรณ์ของ คอมพิวเตอร์หมายเลข <?php echo $_REQUEST['computerCODE']; ?></h4>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 btn-add-transection d-flex justify-content-end align-items-center ">
					
					<!-- ปุ่มเชื่อมต่ออุปกรณ์กับคอมพิวเตอร์ -->
					<a 
						href="
							form_connect_inventory&computer.php?
							computerID=<?php echo $_REQUEST['computerID'] // ส่งค่า Id คอมพิวเตอร์ ?>
							&computerCODE=<?php echo $_REQUEST['computerCODE'] // ส่งค่า Id คอมพิวเตอร์ ?>
						"
						class="btn-ct btn btn-success text-align-center me-2 visibility"  style="width: auto !important;">
						เชื่อมต่ออุปกรณ์
					</a>

				</div>
			</div>		
        </div>
		<div class="card-table py-4">
			<table class="table table-hover align-middle" id="dataTable">
				<thead>
					<tr>
						<th class="elm-1">อันดับ</th>
						<th class="elm-1 text-center">ชื่ออุปกรณ์</th>
						<th class="elm-1 text-center">หมายเลขเครื่อง/เลขทะเบียน</th>
                        <th></th>
					</tr>
				</thead>
				<tbody>
					<?php		
						$Obj = new classroom();
						$inventories = $Obj->readConnectInventoryToComputer($_REQUEST['computerID']);
						$n = 0;
						foreach($inventories as $inventory) {
							$n++;
							echo "
								<tr>
									<td class='elm-2 text-center'>{$n}</td>   
									<td class='elm-2 text-center'>{$inventory['INVENTORY_NAME']}</td>   
									<td class='elm-2 text-center'>{$inventory['SERIAL']}</td>   
									<td class='d-flex justify-content-end'>
										<a class='btn btn-danger' style='width: auto !important;' href='../save.php?
											
											action=cancelConnect
											&connectID={$inventory['ID']}
											&computerID={$inventory['COMPUTERID']}
											&inventoryID={$inventory['INVENTORYID']}
											&computerCODE={$inventory['CODE']}

										' onclick='return confirmCancel();'>ยกเลิกการเชื่อมต่อ</a>										
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