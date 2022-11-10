<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/vendor/autoload.php";?>
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/auth/auth.php";?>

<?php
use App\Model\Classroom;
?>

	
<!-- navbar -->
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/inc/component/navbar.php";?>

	<!-- Tables -->

	<div class="px-4 h-100 w-100">
		<div class="row">
			<!-- search -->
			<div class="operation-card">
				<div class="row">
					<div class="col-lg col-md search-transection d-flex align-items-center">
						<div class="d-flex w-100 align-items-center">
							<div class="mr-component">
								<h4>อาคาร <?php echo $_REQUEST['build_Name'];?></h4>
							</div>
						</div>
					</div>
				</div>		
            </div>
					
			<div class="card-table py-4">
				<table class="table table-hover align-middle" id="dataTable">
					<thead>
						<tr>
							<th class="elm-2 text-center">ชั้น</th>
                            <th></th>
						</tr>
					</thead> 
					<tbody>

								<?php
								
									$Obj = new classroom();
									$floors = $Obj->readAllFloorByBuildName($_REQUEST['build_Name']);
									$n=0;
									foreach($floors as $floor) {
										$n++;
										echo "
											<tr>
												<td class='elm-2 text-center'>{$floor['FLOOR']}</td>
												   
												<td class='d-flex justify-content-end'>
													<a class='btn btn-warning' id='confirm_delete' href='show_rooms.php?build={$floor['BUILD']}&floor={$floor['FLOOR']}'>ดูรายการ</a>				
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