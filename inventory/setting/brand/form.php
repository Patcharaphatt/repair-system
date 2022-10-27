<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/vendor/autoload.php";?>
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/auth/auth.php";?>

<?php

use App\Model\Brand;


if (isset($_REQUEST['action']) == 'edit') {
    $brandObj = new brand;
    $brand = $brandObj->getBrandById($_REQUEST['Id']); 
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
                        <h4 class="title-forms">ฟอร์ม<?php echo (isset($_REQUEST['action'])=='edit') ? "แก้ไขยี่ห้อ" : "เพิ่มยี่ห้อ";?></h4>
                    </div>

                    <!-- forms -->
					<div class="card-body ">
						<form action="save.php" method="GET">
                            
                            <!-- hidden input -->
                            <input type="hidden" name="action" value="<?php echo (isset($_REQUEST['action'])=='edit') ? "edit" : "add";?>">
                            <input type="hidden" name="Id" value="<?php echo (isset($_REQUEST['action'])=='edit') ? $brand['Id'] : "";?>">

                            <!-- forms Groups -->
                            
                            <div class="row mb-4">
                                <div class="col-lg">
                                    <!-- mobile input -->
                                    <div class="form-group">
                                        <label for="brand_Name">ชื่อ - ยี่ห้อ</label>
                                        <input type="text" name="brand_Name" id="brand_Name" class="form-control my-2" maxlength="255" value="<?php echo (isset($_REQUEST['action'])=='edit') ? $brand['title'] : "";?>" required>
            
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