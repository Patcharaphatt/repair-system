<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/vendor/autoload.php";?>
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/auth/auth.php";?>

<?php

use App\Model\Inventory;
use App\Model\Brand;
use App\Model\Type;
use App\Model\Category;
use App\Model\Unit;


if (isset($_REQUEST['action']) == 'edit') {
    $inventoryObj = new inventory;
    $inventory = $inventoryObj->getInventoryById($_REQUEST['Id']); 
}

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

	<div class="container">
				<div class="card-forms">
                    <!-- title forms -->
					<div class="card-header text-white d-flex justify-content-between">
                        <h4 class="title-forms">ฟอร์ม<?php echo (isset($_REQUEST['action'])=='edit') ? "แก้ไขข้อมูลอุปกรณ์" : "เพิ่มข้อมูลอุปกรณ์";?></h4>
                    </div>

                    <!-- forms -->
					<div class="card-body ">
						<form action="save.php" method="GET">
                            
                            <!-- hidden input -->
                            <input type="hidden" name="action" value="<?php echo (isset($_REQUEST['action'])=='edit') ? "edit" : "add";?>">
                            <input type="hidden" name="get_inventory_Name_ById" value="<?php echo (isset($_REQUEST['action'])=='edit') ? $inventory['inventoryName'] : "";?>">

                            <!-- forms Groups -->
                            <div class="row mb-4">
                                <div class="col-lg">
                                    <!-- name inventory -->
                                    <div class="form-group">
                                        <label for="inventory_Name">ชื่อ-อุปกรณ์</label>
                                        <input type="text" name="inventory_Name" id="inventory_Name" class="form-control my-2" value="<?php echo (isset($_REQUEST['action'])=='edit') ? $inventory['inventoryName'] : "";?>" required>
                                    </div>
                                </div>

                                <?php if(isset($_REQUEST['action'])!='edit') { ?>
                                <div class="col-lg">
                                    <div class="form-group">
                                        <!-- serial number -->
                                        <label for="serial">หมายเลขเครื่อง/เลขทะเบียน</label>
                                        <input type="text" name="serial" id="serial" class="form-control my-2" maxlength="255" value="<?php echo (isset($_REQUEST['action'])=='edit') ? $inventory['serial'] : "";?>" required>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>

                            <div class="row mb-4">
                                <?php if(isset($_REQUEST['action'])!='edit') { ?>
                                <div class="col-lg">
                                    <div class="form-group">
                                        <!-- stocks -->
                                        <label for="stock">จำนวน</label>
                                        <input type="text" name="stock" id="stock" class="form-control my-2" value="<?php echo (isset($_REQUEST['action'])=='edit') ? "" : "";?>" required>
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="col-lg">
                                    <div class="form-group">
                                        <label for="unitId">หน่วย</label>
                                        <!-- unit -->
                                        <select name="unitId" id="unitId" class="form-control my-2" required>
                                            <option value="">เลือก</option>
                                            <?php
                                                $unitObj = new unit;
                                                $units = $unitObj->getAllUnits();
                                                foreach($units as $unit) {
                                                    $selected = ($unit['Id'] == $inventory['unit_Id']) ? "selected" : "";
                                                    echo "
                                                        <option value='{$unit['Id']}' {$selected}>{$unit['unitTitle']}</option> 
                                                    ";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="categoryId">หมวดหมู่</label>
                                        <!-- category -->
                                        <select name="categoryId" id="categoryId" class="form-control my-2" required>
                                            <option value="">เลือก</option>
                                            <?php
                                                $categoryObj = new category;
                                                $categories = $categoryObj->getAllCategories();
                                                foreach($categories as $category) {
                                                    $selected = ($category['Id'] == $inventory['category_Id']) ? "selected" : "";
                                                    echo "
                                                        <option value='{$category['Id']}' {$selected}>{$category['categoryTitle']}</option> 
                                                    ";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="typeId">ประเภท</label>
                                        <!-- type -->
                                        <select name="typeId" id="typeId" class="form-control my-2" required>
                                            <option value="">เลือก</option>
                                            <?php
                                                $typeObj = new type;
                                                $types = $typeObj->getAllTypes();
                                                foreach($types as $type) {
                                                    $selected = ($type['Id'] == $inventory['type_Id']) ? "selected" : "";
                                                    echo "
                                                        <option value='{$type['Id']}' {$selected}>{$type['typeTitle']}</option> 
                                                    ";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-lg">
                                    <div class="form-group">
                                        <label for="brandId">ยี่ห้อ</label>
                                        <!-- brand -->
                                        <select name="brandId" id="brandId" class="form-control my-2" required>
                                            <option value="">เลือก</option>
                                            <?php
                                                $brandObj = new brand;
                                                $brands = $brandObj->getAllBrands();
                                                foreach($brands as $brand) {
                                                    $selected = ($brand['Id'] == $inventory['brand_Id']) ? "selected" : "";
                                                    echo "
                                                        <option value='{$brand['Id']}' {$selected}>{$brand['brandTitle']}</option> 
                                                    ";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>


                            
                            <button class="btn-ct btn btn-success" id="heckFormsAccount" type="submit" 
                            onclick="return <?php echo (isset($_REQUEST['action'])=='edit') ? 'confirm_editAcc()':'confirm_createAcc()'; ?>">บันทึกข้อมูล</button>
                        </form>	
					</div>
				</div>
	</div>
    <!-- footer -->
    <?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/inc/component/footer.php";?>

    <script>
        function confirm_createAcc() {
            return confirm('ระบบจะเพิ่มข้อมูลรายการนี้เข้าระบบ');
        }

        function confirm_editAcc() {
            return confirm('ระบบจะแก้ไขข้อมูลรายการนี้');
        }
    </script>
</body>
</html>