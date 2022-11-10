<!-- include link conect file custom Javascript -->
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/inc/script/script_link/script.inc.link.php";?>

<!-- data table -->
<script>
    $(document).ready( function () {
        $('#dataTable').DataTable();
    } );
</script>


<!-- ยืนยันการทำรายการ -->
<script>

    // ยืนยันการเพิ่มข้อมูล
    function confirm_createAcc() {
        return confirm('ระบบจะเพิ่มข้อมูลรายการนี้เข้าระบบ');
    }

    function confirm_editAcc() {
        return confirm('ระบบจะแก้ไขข้อมูลรายการนี้เข้าระบบ');
    }
    
    // ยืนยันการลบข้อมูล
    function confirmDelete() {
        return confirm('คุณแน่ใจ ที่จะลบรายการนี้');
    }

    // ยกเลิกการเชื่อมต่อรายการ
    function confirmCancel() {
        return confirm('คุณแน่ใจ ที่จะยกเลิกเชื่อมต่อรายการนี้ใช่หรือไม่');
    }

    // ยกเลิกผู้ดูแลห้อง
    function cancelOwnerRoom() {
        return confirm('คุณแน่ใจ ที่จะยกเลิกผู้ดูแลห้องคนนี้');
    }
</script>


<script>
    // AJAX เรียกข้อมูลหน้า connect อุปกรณ์
    $(document).ready( function () {
        $('#inventoryName').change(function() {
            let inventoryName = $(this).val();
            $.ajax({
                type: "post",
                url: "/repair-system/classroom/inventory/ajax_read_serial.php",
                data: {inventoryName: inventoryName},
                success: function(data){
                    $('#serial_Inventory').html(data);
                    $('#serial_Inventory').val('');
                }
            });
        });
    });

    // AJAX เรียกข้อมูลคอมพิวเตอร์ว่าเชื่อมต่อกับตัวไหนบ้าง
    $(document).ready( function () {
        $('#computerID').change(function() {
            let computerID = $(this).val();
            $.ajax({
                type: "post",
                url: "/repair-system/repair/ajax_read_inventoryInComputer.php",
                data: {
                    computerID: computerID,
                    inventoryID: <?php echo (isset($_REQUEST['$inventoryID']) ? $_REQUEST['$inventoryID'] : 0);?>
                },
                success: function(data){
                    // console.log(data);
                    $('#inventoryID').html(data);
                    $('#inventoryID').val('');
                }
            });
        });
    });
</script>

</body>
</html>