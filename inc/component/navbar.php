<?php
$role = $_SESSION['role'];
$status = $_SESSION['status'];
?>

<?php if(isset($_SESSION['alert_welcome'])) { // message box alert ยินดีต้อนรับผู้ใช้งานระบบเข้าสู่ระบบ ?>
  <script>
    alert('สวัสดี คุณ <?php echo $_SESSION['name'] ?> ยินดีต้อนรับเข้าสู่ระบบ');
  </script>
<?php unset($_SESSION['alert_welcome']); } ?>


<!-- tag header -->
<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/inc/component/html_head.php";?>

<header class="sticky-top">
  <!-- navbar-top -->
  <div class="navbar-top d-flex justify-content-between align-items-center px-4">
    <div class="logo">
      <h4 class="m-0">ระบบแจ้งซ่อมบำรุง</h4>
    </div>
    <div class="email">
      <p class="m-0"><?php echo $_SESSION['email'];?></p>
    </div>
  </div>

  <!-- navbar-bottom -->
  <nav class="navbar-bottom px-4 d-flex justify-content-between align-items-center">
    <div class="collapsible-menu" id="collapsible-menu">
      <ul>
        <!-- หน้าหลัก -->
        <?php if($status == 1) {?>
          <li ><a class="link-item" href="/repair-system/<?php echo $role; ?>/index.php">หน้าหลัก</a></li>
        <?php } ?>
        <!-- แก้ไขโปรไฟล์ -->
        <li><a class="link-item" href="/repair-system/My_profile/form.php?action=edit&Id=<?php echo $_SESSION['Id'];?> ">จัดการโปรไฟล์</a></li>

        <!-- เมนูเพิ่มแจ้งรายการซ่อม -->
        <?php if($status === 1) {?>
          <?php if($role === 'ClassroomOwner') {?>
            <li ><a class="link-item" href="/repair-system/repair/form.php">เพิ่มรายการซ่อม</a></li>
          <?php } ?>
        <?php } ?>

        <!-- เมนูตั้งค่า -->
        <?php if($role === 'Admin') {?>
        <li class="dropdown-link">
          <a class="link-item" href="#">ตั้งค่า
            <i class="fas fa-chevron-down"></i>
          </a>
          <ul class="dropdown">
            <li><a href="/repair-system/department/index.php">จัดการแผนก</a></li>
            <li><a href="/repair-system/ownerClassDepart/index.php">จัดการแผนกผู้แจ้ง</a></li>
            <li><a href="/repair-system/inventory/index.php">จัดการอุปกรณ์</a></li>
            <li><a href="/repair-system/account/index.php">จัดการผู้ใช้งาน</a></li>
            <li><a href="/repair-system/classroom/rooms/index.php">จัดการห้อง</a></li>
          </ul>
        </li>
        
        <!-- ดูรายงาน -->
        <li ><a class="link-item" href="#">ดูรายงาน</a></li>
        <?php } ?>
        
        <!-- ออกจากระบบ -->
        <li><a onclick='return confirm_logout()' href="/repair-system/auth/logout.php">ออกจากระบบ</a></li>
      </ul>
    </div>
  </nav>
  <?php
        // ข้อความแจ้งเตือน

        // success
        if(isset($_SESSION['alert'])) {
            $message = $_SESSION['alert'];
            echo "<div class='alert alert-success' role='alert'>
                    $message
                </div>";
            unset($_SESSION['alert']);
        }

        if(isset($_SESSION['error'])) {
            $message = $_SESSION['error'];
            echo "<div class='alert alert-danger' role='alert'>
                    $message
                </div>";
            unset($_SESSION['error']);
        }  
    ?>
</header>

<script>
  
  function confirm_logout() {
    return confirm('คุณต้องการที่จะออกจากระบบใช่หรือไม่');
  }
</script>
