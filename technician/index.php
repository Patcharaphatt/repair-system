<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/vendor/autoload.php";?>
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/auth/auth.php";?>

<?php
use App\Model\Role;
use App\Model\repair;
use App\Model\Classroom;
?>

<!-- navbar -->
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/inc/component/navbar.php";?>

<?php
$REPAIR_STATUS_TITLE = ['รอดำเนินการ', 'กำลังดำเนินการ', 'ซ่อมสำเร็จ', 'ยกเลิก'];
?>

<!-- Tables -->
<div class="px-4 d-flex align-items-start h-100">
<div class="row">
    <!-- search -->
    <div class="operation-card">
        <div class="row">
            <div class="col-9 search-transection d-flex align-items-center">
                <form action="" class="form-inline" method="GET">
                    <div class="d-flex w-100 align-items-center">
                        <div class="mr-component">
                            <h4>รายการแจ้งซ่อม</h4>
                        </div>
                        <div class="mr-component visibility">	
                            <!-- กรองสถานะการดำเนินการซ่อม -->
                            <select name="filters" id="filters" class="select_filter form-control">
                                <option selected disabled>ทั้งหมด</option>
                                <option value="1"><?php echo $REPAIR_STATUS_TITLE[0]; ?></option>
                                <option value="2"><?php echo $REPAIR_STATUS_TITLE[1]; ?></option>
                                <option value="3"><?php echo $REPAIR_STATUS_TITLE[2]; ?></option>
                                <option value="4"><?php echo $REPAIR_STATUS_TITLE[3]; ?></option>
                            </select>
                        </div>

                        <div class="mr-component visibility">
                            <button type="submit" class="btn-ct btn btn-success text-align-center">ค้นหา</button>
                        </div>
                    </div>
                </form>
            </div>



        </div>		
    </div>
            
    <div class="card-table py-4">
        <table class="table table-hover align-middle" id="dataTable">
            <thead>
                <tr>
                    <th class="elm-1 text-center" width='300px'>รหัส</th>
                    <th class='elm-2'>อุปกรณ์ที่เสีย</th>
                    <th class="elm-2 hidden">รหัสคอมที่เสีย</th>
                    <th class="elm-2 hidden">ผู้ปฎิบัติงาน</th>
                    <th class='elm-3 hidden'>สถานะ</th>
                    <th></th>
                </tr>
            </thead> 
            <tbody>

                        <?php
                            $repair_Obj = new repair();
                            $room_Obj = new classroom();

                            $repairs = $repair_Obj->readListOfRepair($_REQUEST, 'TECHNICIAL');
                            foreach($repairs as $repair) { // สถานะแจ้งซ่อม
                                $REPAIR_CODE = str_pad($repair['ID'] , 4, "0", STR_PAD_LEFT); // รหัสแจ้งซ่อม
                                $ADDRESS_INVENTORY_ARR = $room_Obj->readAdressRoom($repair['ROOMID']); // ที่อยู่แจ้งซ่อมแบบ Array
                                $ADDRESS_INVENTORY = "
                                    ตึก {$ADDRESS_INVENTORY_ARR['BUILD']}
                                    ชั้น {$ADDRESS_INVENTORY_ARR['FLOOR']}
                                    ห้อง {$ADDRESS_INVENTORY_ARR['ROOM']}
                                "; // แสดงผลที่อยู่แจ้งซ่อม

                                switch($repair['REPAIR_STATUS']){ // สถานะแจ้งซ่อม
                                    case 1:
                                        $STATUS_SHOW = "
                                            <div class='area-stus status-color-1'>
                                                <p>{$REPAIR_STATUS_TITLE[0]}</p>
                                            </div>
                                        ";	
                                        break;
                                    case 2:
                                        $STATUS_SHOW = "
                                            <div class='area-stus status-color-2'>
                                                <p>{$REPAIR_STATUS_TITLE[1]}</p>
                                            </div>
                                        ";	
                                        break;
                                    case 3:
                                        $STATUS_SHOW = "
                                            <div class='area-stus status-color-3'>
                                                <p>{$REPAIR_STATUS_TITLE[2]}</p>
                                            </div>
                                        ";	
                                        break;
                                    case 4:
                                        $STATUS_SHOW = "
                                            <div class='area-stus bg-secondary'>
                                                <p>{$REPAIR_STATUS_TITLE[3]}</p>
                                            </div>
                                        ";	
                                        break;
                                }

                                // จัดการรูปภาพ หากไม่มีรูปภาพ
                                $SHOW_IMG = $repair['OWNERROOM_IMG'];
                                $SHOW_CANCEL = '';
                                $SHOW_EDIT = '';
								$SHOW_TECH = '';
                                if($repair['REPAIR_STATUS'] <> 4) { // ถ้าสถานะเป็นยกเลิกไม่ให้แสดงรายการ แก้ไข และยกเลิก
                                    
                                    if($repair['REPAIR_STATUS'] !== 3) {
                                        // เมนูยกเลิกรายการซ่อม
                                        $SHOW_CANCEL = "<li>
                                                            <a id='confirm_delete' onclick='return confirmDelete()' class='dropdown-item' href='../repair/save.php?Id={$repair['ID']}&action=cancel' class='btn btn-danger'>ยกเลิกรายการ</a>  
                                                        </li>
                                        ";
                                    }

                                    if($repair['REPAIR_STATUS'] !== 3) {
                                        // เมนูรับงานใหม่
                                        $SHOW_CANCEL = "<li>
                                                            <a id='confirm_delete' onclick='return confirmDelete()' class='dropdown-item' href='../repair/save.php?Id={$repair['ID']}&action=cancel' class='btn btn-danger'>ยกเลิกรายการ</a>  
                                                        </li>
                                        ";
                                    }


                                }
                                echo "
                                    <tr>
                                        <td class='elm-1 text-center'>{$REPAIR_CODE}</td>
                                        <td class='elm-2'>{$repair['INVENTORY_NAME']}</td>
                                        <td class='elm-2 hidden'>{$repair['COMPUTER_CODE']}</td>
                                        <td class='elm-2 hidden'>{$repair['COMPUTER_CODE']}</td>
                                        <td class='elm-3 hidden'>{$STATUS_SHOW}</td>
                                  
                                        <td>
                                            <div class='dropdown d-flex justify-content-end'>
                                                <button class='btn btn-warning dropdown-toggle' type='button' id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-expanded='false'>
                                                    จัดการรายการ
                                                </button>
                                                <ul class='dropdown-menu' aria-labelledby='dropdownMenuButton1'>
                                                    <li><a class='dropdown-item' href='../repair/repair_details.php?Id={$repair['ID']}'>รายระเอียดเต็ม</a></li>
                                                    {$SHOW_CANCEL}
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