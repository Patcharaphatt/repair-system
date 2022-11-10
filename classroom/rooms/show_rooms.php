<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/vendor/autoload.php";?>
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/auth/auth.php";?>

<?php
use App\Model\Classroom;
use App\Model\OwnerClassDepart;
use App\Model\Account;
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
							<h4>อาคาร <?php echo $_REQUEST['build'];?> ชั้น <?php echo $_REQUEST['floor'];?></h4>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 btn-add-transection d-flex justify-content-end align-items-center ">
					<a class="btn-ct btn btn-success text-align-center me-2 visibility"
						href="form_create_room.php?
							build=<?php echo $_REQUEST['build']; ?>
							&floor=<?php echo $_REQUEST['floor']; ?>
						">+ ห้องเรียน
					</a>
				</div>
			</div>		
         </div>			
		<div class="card-table py-4">
			<table class="table table-hover align-middle" id="dataTable">
				<thead>
					<tr>
						<th class="elm-2 text-center">ห้องเรียน</th>
						<th class="elm-2 text-center hidden">ผู้ดูแลห้อง</th>
						<th class="elm-2 text-center hidden">จำนวนคอม</th>
                        <th></th>
					</tr>
				</thead> 
				<tbody>
					<?php
						$MASSAGE_STATUS = ''; // ตัวแปรสถานะว่ามีเจ้าของห้องไหม
						$BTN_STATUS = ''; // ตัวแปรเก็บค่าปุ่มแสดงโชว์รายการ
						
						$Obj_Acc = new account;
						$Obj_Owner = new ownerClassDepart;
						$Obj = new classroom;

						$rooms = $Obj->readAllRooms($_REQUEST);
						$n=0;
						foreach($rooms as $room) {
							$n++;
							if($room['STATUS'] <> 0) { // เช็คจากสถานะห้องว่ามีเจ้าของห้องมั้ย -> ตั้งค่าให้มีผู้ดูแลห้องรึยัง
								// ----------  Object -------------
								// obj OwnerClass
								$OwnerRoom = $Obj_Owner->readOwnerClassDeptByroomId($room['ID']); // ค้นหา ID ของผู้ดูแลห้อง
								// Obj Account
								$AccOwnerRoom = $Obj_Acc->readAccountById($OwnerRoom['ACCOUNTID']); // แสดง ชื่อ-จริง ของผู้ดูแลห้อง
								// --------------------------

								$Obj_NumberOfComputers = $Obj->readAllComputersByRoomId($room['ID'], false); // นับจำนวนคอมพิวเตอร์ภายในห้อง
								$NumberOfComputers = $Obj_NumberOfComputers[0]['COUNT_COMPUTERID']; // จำนวนคอมพิวเตอร์ในห้อง
								
								$BTN_STATUS = "<div class='dropdown d-flex justify-content-end'>
													<button class='btn btn-warning dropdown-toggle' type='button' id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-expanded='false'>
														รายการอุปกรณ์
													</button>
													<ul class='dropdown-menu' aria-labelledby='dropdownMenuButton1'>
														<li>
															<a class='dropdown-item'
																href='../inventory/index.php?
																build={$room['BUILD']}
																&floor={$room['FLOOR']}
																&roomNUMBER={$room['ROOM_NUMBER']}
																&roomID={$room['ID']}
																'>รายการอุปกรณ์
															</a>
														</li>
														<li>
															<a class='dropdown-item text-danger' onclick='return confirmDelete()' href='../save.php?
																action=deleteRoom
																&roomID={$room['ID']}
																&roomNUMBER={$room['ROOM_NUMBER']}
																&build={$room['BUILD']}
																&floor={$room['FLOOR']}
															'>ลบรายการห้อง</a>
														</li>
													</ul>
												</div>"; // ปุ่มดูรายการอุปกรณ์ จะขึ้นในกรณีที่เพิ่มผู้ดูแลห้องแล้ว	
								$STATUS_COMPUTER='';
								if($NumberOfComputers > 0){ // จำนวนคอมพิวเตอร์ > 0 มั้ย
									$STATUS_COMPUTER = $Obj->CheckStusComputersByRoomId($room['ID']); // เช็คสถานะคอมพิวเตอร์โดยอ้างอิง ID ห้องเรียน
									// print_r($STATUS_COMPUTER);
									$colorFont = 'warning';
									switch($STATUS_COMPUTER['COMPUTER_STATUS']) {
										case 1: // สถานะอุปกรณ์ภายในห้องครบ
											$STATUS_COMPUTER = $NumberOfComputers;
											$colorFont = 'dark';
											break;
										case 0: // อุปกรณ์ภายในห้องไม่ครบ
											$STATUS_COMPUTER = 'รายการไม่ครบ';
											break;
										case -1: // รอเช็คอุปกรณ์จากผู้ดูแลห้อง
											$STATUS_COMPUTER = 'รอเช็คอุปกรณ์จากผู้ดูแลห้อง';
											$BTN_STATUS = "<div class='dropdown d-flex justify-content-end'> 
													<button class='btn btn-warning dropdown-toggle' type='button' id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-expanded='false' disabled>
														รายการอุปกรณ์
													</button>
													<ul class='dropdown-menu' aria-labelledby='dropdownMenuButton1'>
														<li>
															<a class='dropdown-item'
																href='../inventory/index.php?
																build={$room['BUILD']}
																&floor={$room['FLOOR']}
																&roomNUMBER={$room['ROOM_NUMBER']}
																&roomID={$room['ID']}
																'>รายการอุปกรณ์
															</a>
														</li>
														<li>
															<a class='dropdown-item text-danger' onclick='return confirmDelete()' href='../save.php?
																action=deleteRoom
																&roomID={$room['ID']}
																&roomNUMBER={$room['ROOM_NUMBER']}
																&build={$room['BUILD']}
																&floor={$room['FLOOR']}
															'>ลบรายการห้อง</a>
														</li>
													</ul>
												</div>"; // ปุ่มดูรายการอุปกรณ์ จะขึ้นในกรณีที่เพิ่มผู้ดูแลห้องแล้ว	
												break;
												
										case -2: // ทาง Admin ยังไม่ได้ตรวจสอบอุปกรณ์ และยังไม่ได้ส่งรายการอุปกรณ์ให้ผู้ดูแลห้องตรวจสอบ
											$STATUS_COMPUTER = 'กรุณาตรวจสอบอุปกรณ์';
											break;
									}
								}
								$MASSAGE_STATUS = "<p class='m-0'> {$AccOwnerRoom['FULL_NAME']} </p>";

							}else {
								$colorFont = 'dark';
								$STATUS_COMPUTER = '-';
								$MASSAGE_STATUS = "<p class='text-danger-ct m-0'>ยังไม่มีผู้ดูแลห้อง</p>"; // ขึ้นข้อความสีแดง
								$BTN_STATUS = "<div class='dropdown d-flex justify-content-end'> 
												<button class='btn btn-warning dropdown-toggle' type='button' id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-expanded='false'>
													เพิ่มผูัดูแลห้อง
												</button>
												<ul class='dropdown-menu' aria-labelledby='dropdownMenuButton1'>
													<li>
														<a class='dropdown-item'
															href='../classroom_owner/form_AddOwnerRoom.php?
															build={$room['BUILD']}
																&floor={$room['FLOOR']}								
																&roomNUMBER={$room['ROOM_NUMBER']}
																&roomID={$room['ID']}
															'>เพิ่มผู้ดูแล
														</a>
													</li>
													<li>
														<a class='dropdown-item text-danger' onclick='return confirmDelete()' href='../save.php?
															action=deleteRoom
															&roomID={$room['ID']}
															&roomNUMBER={$room['ROOM_NUMBER']}
															&build={$room['BUILD']}
															&floor={$room['FLOOR']}
														'>ลบรายการห้อง</a>
													</li>
												</ul>
											</div>"; // ปุ่มเพิ่มผู้ดูแลห้อง
							}

							if ($colorFont == 'warning') { // กำหนดสีการแสดงผล
								$STATUS_COMPUTER = "<div class='text-danger-ct m-0'>{$STATUS_COMPUTER}</div>";
							} else {
								$STATUS_COMPUTER = "<div class='text-dark m-0'>{$STATUS_COMPUTER}</div>";
							}

							// แสดงรายการห้อง
							echo "
								<tr>
									<td class='elm-2 text-center'>{$room['ROOM_NUMBER']}</td>
									<td class='elm-2 text-center hidden'>{$MASSAGE_STATUS}</td>
									<td class='elm-2 text-center hidden'>{$STATUS_COMPUTER}</td>
									<td class='d-flex justify-content-end'>
										{$BTN_STATUS}
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