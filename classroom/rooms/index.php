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
					<div class="col-lg-9 col-md-9 search-transection d-flex align-items-center">
						<div class="d-flex w-100 align-items-center">
							<div class="mr-component">
								<h4>รายการอาคารเรียน</h4>
							</div>
						</div>
					</div>

					<div class="col-lg-3 col-md-3 btn-add-transection d-flex justify-content-end align-items-center ">
						<a href="form_add_build.php" class="btn-ct btn btn-success text-align-center me-2 visibility">เพิ่มอาคาร</a>
					</div>

				</div>		
            </div>
					
			<div class="card-table py-4">
				<table class="table table-hover align-middle" id="dataTable">
					<thead>
						<tr>
							<th class="elm-2 text-center">ชื่อ-อาคาร</th>
                            <th></th>
						</tr>
					</thead> 
					<tbody>

								<?php
									$Obj = new classroom();
									$builds = $Obj->readAllBuild();
									$n=0;
									foreach($builds as $build) {
										echo "
											<tr>
												<td class='elm-2 text-center'>{$build['BUILD']}</td>
												   
												<td class='d-flex justify-content-end'>
													<a class='btn btn-warning' id='confirm_delete' href='show_floor.php?build_Name={$build['BUILD']}'>ดูรายการ</a>				
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