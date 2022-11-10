<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/vendor/autoload.php";?>
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/auth/auth.php";?>

<?php
use App\Model\OwnerClassDepart;
?>

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
									<h4>รายการแผนกเจ้าของห้อง</h4>
								</div>
							</div>
						</form>
					</div>

					<div class="col btn-add-transection d-flex justify-content-end align-items-center ">
						<a href="form.php" class="btn-ct btn btn-success text-align-center visibility">จัดการแผนก</a>
					</div>

				</div>		
            </div>
					
			<div class="card-table py-4">
				<table class="table table-hover align-middle" id="dataTable">
					<thead>
						<tr>
							<th class="elm-1 text-center">ลำดับที่</th>
							<th class="elm-2">ชื่อ-เจ้าของห้อง</th>
							<th class="elm-2 hidden">แผนก</th>
							<th class="elm-2 hidden">ดูแลห้อง</th>
                            <th></th>
						</tr>
					</thead> 
					<tbody>

								<?php
									

									$ownerClassDeptObj = new ownerClassDepart();
									$ownerClassDepts = $ownerClassDeptObj->getAllOwnerClassDept($_REQUEST);
									$n=0;
									foreach($ownerClassDepts as $ownerClassDept) {
										$n++;
										$room = '';

										if ($ownerClassDept['room_Id'] == 0) {
											$room = 'ยังไม่มีห้องดูแล';
										} else {
											$room = 'มีห้องดูแลแล้ว xxxx-xxx';
										}
										
										echo "
											<tr>
												<td class='elm-1 text-center'>{$n}</td>
												<td class='elm-2'>{$ownerClassDept['ownerName']}</td>
												<td class='elm-2 hidden'>{$ownerClassDept['deptTitle']}</td>
												<td class='elm-2 hidden' id='room'>{$room}</td>
												<input type='hidden' id='roomInput' value='{$ownerClassDept['room_Id']}'>
												<td>

													<div class='dropdown d-flex justify-content-end'>
														<button class='btn btn-warning dropdown-toggle' type='button' id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-expanded='false'>
															จัดการรายการ
														</button>
														<ul class='dropdown-menu' aria-labelledby='dropdownMenuButton1'>
														<li><a class='dropdown-item' href='form.php?Id={$ownerClassDept['Id']}&action=edit' class='btn btn-warning');>แก้ไข</a></li>
														<li><a id='confirm_delete' onclick='return confirmDelete()' class='dropdown-item' href='save.php?Id={$ownerClassDept['Id']}&userId={$ownerClassDept['account_Id']}&action=delete' class='btn btn-danger'>ลบรายการ</a></li>
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