<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/vendor/autoload.php";?>
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/auth/auth.php";?>

<?php
use App\Model\Category;
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
									<h4>รายการหมวดหมู่</h4>
								</div>
							</div>
						</form>
					</div>

					<div class="col btn-add-transection d-flex justify-content-end align-items-center ">
						<a href="form.php" class="btn-ct btn btn-success text-align-center visibility">+ หมวดหมู่</a>
					</div>

				</div>		
            </div>
					
			<div class="card-table py-4">
				<table class="table table-hover align-middle" id="dataTable">
					<thead>
						<tr>
							<th class="elm-1 text-center">ลำดับที่</th>
							<th class="elm-2">ชื่อ-หมวดหมู่</th>
                            <th></th>
						</tr>
					</thead> 
					<tbody>

								<?php
									

									$categoryObj = new category;
									$categories = $categoryObj->getAllCategories();
									$n=0;
									foreach($categories as $category) {
										$n++;
										echo "
											<tr>
												<td class='elm-1 text-center'>{$n}</td>
												<td class='elm-2'>{$category['categoryTitle']}</td>
												<td>

													<div class='dropdown d-flex justify-content-end'>
														<button class='btn btn-warning dropdown-toggle' type='button' id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-expanded='false'>
															จัดการรายการ
														</button>
														<ul class='dropdown-menu' aria-labelledby='dropdownMenuButton1'>
														<li><a class='dropdown-item' href='form.php?Id={$category['Id']}&action=edit' class='btn btn-warning');>แก้ไข</a></li>
														<li><a id='confirm_delete' onclick='return confirmDelete()' class='dropdown-item' href='save.php?Id={$category['Id']}&action=delete' class='btn btn-danger'>ลบรายการ</a></li>
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