<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/vendor/autoload.php";?>
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/auth/auth.php";?>

<?php
use App\Model\Account;
use App\Model\Department;
use App\Model\OwnerClassDepart;
use App\Model\Inventory;
use App\Model\Classroom;
use App\Model\repair;
?>

<?php
$repair_Obj = new repair; // รายการซ่อม
$repair = $repair_Obj->readListOfRepairById($_REQUEST['Id']);
// print_r($repair); exit;
$ownerRoom_Obj = new OwnerClassDepart; // ข้อมูลเจ้าของห้อง
$ownerRoom = $ownerRoom_Obj->readOwnerClassDeptByAccountId($repair['OWNERROOMID']);
// print_r($ownerRoom); exit;
$account_Obj = new account; // ข้อมูล account
$account = $account_Obj->readAccountById($ownerRoom['ACCOUNTID']);
// print_r($account); exit;
$department_Obj = new department; // ข้อมูลแผนก
$department = $department_Obj->getDepartmentById($ownerRoom['DEPARTMENTID']);
// print_r($department); exit;
$inventory_Obj = new inventory; // ข้อมูลอุปกรณ์
$inventory = $inventory_Obj->readInventoryById($repair['INVENTORYID']);
// print_r($inventory); exit;
$ADDRESS_Obj = new classroom; // ที่อยู่คอมพิวเตอร์
$address = $ADDRESS_Obj->readAdressRoom($repair['ROOMID']);
// print_r($computer); exit;
?>

<!-- navbar -->
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/inc/component/navbar.php";?>

<div class="container d-flex justify-content-center">
    <div class="card-forms card-forms-width ">
        <!-- รายระเอียดผู้แจ้ง -->
        <div class="card-header text-white d-flex justify-content-between">
            <h4 class="title-forms">รายระเอียดผู้แจ้ง</h4>
        </div>
        <!-- forms -->
        <div class="card-body">
            <form action="#" method="GET">

                <!-- ชื่อผู้แจ้ง -->
                <div class="row mb-4">
                    <div class="col-lg">
                        <div class="form-group">
                            <div class="row">
                                <div class="col col-lg-6">
                                    <label for="fullname">ชื่อผู้แจ้ง</label>
                                </div>
                                <div class="col col-lg-6 d-flex justify-content-end align-items-start">
                                    <p class="d-inline"><?php echo $account['FULL_NAME'];?></p>
                                </div>
                            </div>
                        </div>   
                    </div>
                </div>
                <!-- โทรศัพท์ -->
                <div class="row mb-4">
                    <div class="col-lg">
                        <div class="form-group">
                            <div class="row">
                                <div class="col col-lg-6">
                                    <label for="fullname">โทรศัพท์</label>
                                </div>
                                <div class="col col-lg-6 d-flex justify-content-end align-items-start">
                                    <p class="d-inline"><?php echo $account['MOBILE'];?></p>
                                </div>
                            </div>
                        </div>   
                    </div>
                </div>
                <!-- อีเมล์ -->
                <div class="row mb-4">
                    <div class="col-lg">
                        <div class="form-group">
                            <div class="row">
                                <div class="col col-lg-6">
                                    <label for="fullname">อีเมล์</label>
                                </div>
                                <div class="col col-lg-6 d-flex justify-content-end align-items-start">
                                    <p class="d-inline"><?php echo $account['EMAIL'];?></p>
                                </div>
                            </div>
                        </div>   
                    </div>
                </div>
                <!-- แผนก -->
                <div class="row mb-4">
                    <div class="col-lg">
                        <div class="form-group">
                            <div class="row">
                                <div class="col col-lg-6">
                                    <label for="fullname">แผนก</label>
                                </div>
                                <div class="col col-lg-6 d-flex justify-content-end align-items-start">
                                    <p class="d-inline"><?php echo $department['title'];?></p>
                                </div>
                            </div>
                        </div>   
                    </div>
                </div>
            </form>

            <!-- รายระเอียดแจ้งซ่อม -->
            <div class="card-header text-white d-flex justify-content-between">
                <h4 class="title-forms mt-4">รายระเอียดแจ้งซ่อม</h4>
            </div>
            <form action="#" method="GET">

                <!-- อุปกรณ์ที่เสีย -->
                <div class="row mb-4">
                    <div class="col-lg">
                        <div class="form-group">
                            <div class="row">
                                <div class="col col-lg-6">
                                    <label for="fullname">อุปกรณ์ที่เสีย</label>
                                </div>
                                <div class="col col-lg-6 d-flex justify-content-end align-items-start">
                                    <p class="d-inline"><?php echo $inventory['INVENTORY_NAME'];?></p>
                                </div>
                            </div>
                        </div>   
                    </div>
                </div>
                <!-- หมายเลขเครื่อง/เลขทะเบียน -->
                <div class="row mb-4">
                    <div class="col-lg">
                        <div class="form-group">
                            <div class="row">
                                <div class="col col-lg-6">
                                    <label for="fullname">หมายเลขเครื่อง/เลขทะเบียน</label>
                                </div>
                                <div class="col col-lg-6 d-flex justify-content-end align-items-start">
                                    <p class="d-inline"><?php echo $inventory['SERIAL'];?></p>
                                </div>
                            </div>
                        </div>   
                    </div>
                </div>
                <!-- ที่อยู่ -->
                <div class="row mb-4">
                    <div class="col-lg">
                        <div class="form-group">
                            <div class="row">
                                <div class="col col-lg-6">
                                    <label for="fullname">ที่อยู่</label>
                                </div>
                                <div class="col col-lg-6 d-flex justify-content-end align-items-start">
                                    <p class="d-flex"><?php echo "ตึก {$address['BUILD']} ชั้น {$address['FLOOR']} ห้อง {$address['ROOM']} หมายเลขคอม {$repair['COMPUTER_CODE']}";?></p>
                                </div>
                            </div>
                        </div>   
                    </div>
                </div>
                <!-- รายระเอียดแจ้งซ่อม/ปัญหา -->
                <div class="row mb-4">
                    <div class="col-lg">
                        <div class="form-group">
                            <div class="row">
                                <div class="col col-lg-6">
                                    <label for="fullname">รายระเอียดแจ้งซ่อม/ปัญหา</label>
                                </div>
                                <div class="col col-lg-6 d-flex justify-content-end align-items-start">
                                    <p class="d-inline"><?php echo $repair['DETAILS'];?></p>
                                </div>
                            </div>
                        </div>   
                    </div>
                </div>
                <!-- วันที่แจ้ง -->
                <div class="row mb-4">
                    <div class="col-lg">
                        <div class="form-group">
                            <div class="row">
                                <div class="col col-lg-6">
                                    <label for="fullname">วันที่แจ้ง</label>
                                </div>
                                <div class="col col-lg-6 d-flex justify-content-end align-items-start">
                                    <p class="d-inline text-right"><?php echo date("d-m-Y H:i:s", strtotime($repair['DATE_NOTIFY']));?></p>
                                </div>
                            </div>
                        </div>   
                    </div>
                </div>
                <!-- รูปภาพแจ้งซ่อม -->
                <div class="row">
                    <div class="col-lg mt-4">
                        <div class="form-group">
                            <div class="row">
                                <div class="col col-lg-6 d-flex justify-content-end align-items-start">
                                    <p class="d-inline"><img src="<?php echo $repair['OWNERROOM_IMG'];?>" alt="" width="400"></p>
                                </div>
                                <div class="col col-lg-6">
                                    <label for="fullname"></label>
                                </div>
                            </div>
                        </div>   
                    </div>
                </div>
            </form>

            <!-- รายระเอียดการซ่อม -->
            <div class="card-header text-white d-flex justify-content-between mt-4">
                <h4 class="title-forms mt-4">รายระเอียดการซ่อม</h4>
            </div>
            <form action="#" method="GET">

                <!-- ชื่อช่างเทคนิค -->
                <div class="row mb-4">
                    <div class="col-lg">
                        <div class="form-group">
                            <div class="row">
                                <div class="col col-lg-6">
                                    <label for="fullname">ชื่อช่างเทคนิค</label>
                                </div>
                                <div class="col col-lg-6 d-flex justify-content-end align-items-start">
                                    <p class="d-inline"><?php echo $repair['TECHID'];?></p>
                                </div>
                            </div>
                        </div>   
                    </div>
                </div>
                <!-- วันที่รับเรื่อง -->
                <div class="row mb-4">
                    <div class="col-lg">
                        <div class="form-group">
                            <div class="row">
                                <div class="col col-lg-6">
                                    <label for="fullname">วันที่รับเรื่อง</label>
                                </div>
                                <div class="col col-lg-6 d-flex justify-content-end align-items-start">
                                    <p class="d-inline"><?php echo date("d-m-Y H:i:s", strtotime($repair['DATE_TECH']));?></p>
                                </div>
                            </div>
                        </div>   
                    </div>
                </div>
                <!-- รายระเอียดวิธีแก้ / ปัญหา -->
                <div class="row mb-4">
                    <div class="col-lg">
                        <div class="form-group">
                            <div class="row">
                                <div class="col col-lg-6">
                                    <label for="fullname">รายระเอียดวิธีแก้/ปัญหา</label>
                                </div>
                                <div class="col col-lg-6 d-flex justify-content-end align-items-start">
                                    <p class="d-flex"><?php echo $repair['DESCRIPTION_DETAILS'];;?></p>
                                </div>
                            </div>
                        </div>   
                    </div>
                </div>
                <!-- วันที่ส่ง -->
                <div class="row mb-4">
                    <div class="col-lg">
                        <div class="form-group">
                            <div class="row">
                                <div class="col col-lg-6">
                                    <label for="fullname">วันที่ส่ง</label>
                                </div>
                                <div class="col col-lg-6 d-flex justify-content-end align-items-start">
                                    <p class="d-inline"><?php echo date("d-m-Y H:i:s", strtotime($repair['DATE_SUCCESS']));?></p>
                                </div>
                            </div>
                        </div>   
                    </div>
                </div>
                <!-- รูปภาพแจ้งซ่อม -->
                <div class="row">
                    <div class="col-lg mt-4">
                        <div class="form-group">
                            <div class="row">
                                <div class="col col-lg-6 d-flex justify-content-end align-items-start">
                                    <p class="d-inline"><img src="<?php echo $repair['OWNERROOM_IMG'];?>" alt="" width="400"></p>
                                </div>
                                <div class="col col-lg-6">
                                    <label for="fullname"></label>
                                </div>
                            </div>
                        </div>   
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- footer -->
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/inc/component/footer.php";?>