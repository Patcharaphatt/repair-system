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

            <div class="col btn-add-transection d-flex justify-content-end align-items-center ">
                <a href="/repair-system/repair/form.php" class="btn-ct btn btn-success text-align-center visibility">แจ้งซ่อม</a>
            </div>

        </div>		
    </div>
            
    <div class="card-table py-4">
        <table class="table table-hover align-middle" id="dataTable">
            <thead>
                <tr>
                    <th class="elm-1" width='250px'>รูปภาพ</th>
                    <th class="elm-1 text-center" width='300px'>รหัส</th>
                    <th class='elm-2'>อุปกรณ์ที่เสีย</th>
                    <th class="elm-2 hidden">รหัสคอมที่เสีย</th>
                    <th class='elm-3 hidden'>สถานะ</th>
                    <th></th>
                </tr>
            </thead> 
            <tbody>

                        <?php
                            $repair_Obj = new repair();
                            $room_Obj = new classroom();

                            $repairs = $repair_Obj->readListOfRepair($_REQUEST, 'OWNER_ROOM');
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
                                            <div class='area-stus status-color-3'>
                                                <p>{$REPAIR_STATUS_TITLE[3]}</p>
                                            </div>
                                        ";	
                                        break;
                                }
                                echo "
                                    <tr>
                                        <td class='elm-1 hidden'><img src='{$repair['OWNERROOM_IMG']}' alt='ไม่มีรูปภาพ' style='width: 240px;'></td>
                                        <td class='elm-1 text-center'>{$REPAIR_CODE}</td>
                                        <td class='elm-2'>{$repair['INVENTORY_NAME']}</td>
                                        <td class='elm-2 hidden'>{$repair['COMPUTER_CODE']}</td>
                                        <td class='elm-3 hidden'>{$STATUS_SHOW}</td>
                                  
                                        <td>
                                            <div class='dropdown d-flex justify-content-end'>
                                                <button class='btn btn-warning dropdown-toggle' type='button' id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-expanded='false'>
                                                    จัดการรายการ
                                                </button>
                                                <ul class='dropdown-menu' aria-labelledby='dropdownMenuButton1'>
                                                <li><a class='dropdown-item' href='details_transection.php?Id={$repair['ID']}&action=edit'>รายระเอียดเต็ม</a></li>
                                                <li><a class='dropdown-item' href='../repair/form.php?Id={$repair['ID']}&action=edit' class='btn btn-warning');>แก้ไข</a></li>
                                                <li><a id='confirm_delete' onclick='return confirmDelete()' class='dropdown-item' href='save.php?Id={$repair['ID']}&action=delete' class='btn btn-danger'>ยกเลิกรายการ</a></li>
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