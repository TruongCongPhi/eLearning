<?php
include 'navbar.php';
if ($role_all < 2) {
    echo '<div class="text-center alert alert-warning">
   Bạn không được quyền truy cập vào trang này!<a href="khoa_hoc.php" class="alert-link">Quay lại</a>
  </div>';
} else {
?>
    <!-- điều hướng -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="link-dark link-opacity-50 link-opacity-100-hover link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="khoa_hoc.php">Trang chủ</a></li>
            <li class="breadcrumb-item text-dark active" aria-current="page">Thêm khóa học</li>
        </ol>
    </nav>

    <h1>Thêm khóa học</h1>
    <form method="post" action="">
        <div class="input-group mb-3">
            <span class="input-group-text">Khóa học</span>
            <input type="text" class="form-control" name="course_title" placeholder="Nhập tiêu đề khóa học" required value="<?php echo isset($_POST['course_title']) ? htmlspecialchars($_POST['course_title']) : ''; ?>">
        </div>
        <div class="input-group">
            <span class="input-group-text">Mô tả</span>
            <textarea class="form-control" name="course_desc" placeholder="Nhập mô tả khóa học"><?php echo isset($_POST['course_desc']) ? htmlspecialchars($_POST['course_desc']) : ''; ?></textarea>
        </div>
        <div class="mt-3 mb-3">
            <label class="form-label">Thêm giảng viên hoặc người quản trị khóa học</label>
            <input type="text" class="form-control" name="user_role" placeholder="Nhập tên tài khoản cần thêm" value="<?php echo isset($_POST['user_role']) ? htmlspecialchars($_POST['user_role']) : ''; ?>">
        </div>
        <button class="btn btn-success" name="submit" type="submit">Thêm</button>
    </form>
    <?php
    if (isset($_POST['submit'])) {
        $inser_course = insert('courses', ['course_title' => $_POST['course_title'], 'course_desc' => $_POST['course_desc']]);
        if ($inser_course) {
            $id_course_insert = mysqli_insert_id($conn);
        } else {
            return;
        }
        $check_user_users = searchUser($_POST['user_role']);
        if (is_null($check_user_users) && !empty($_POST['user_role'])) {
            echo '<script>alert("Tài khoản không tồn tại vui lòng kiểm tra lại");</script>';
            return;
        } elseif (!empty($_POST['user_role'])) {
            insert('course_management', ['course_id' => $id_course_insert, 'username' => $_POST['user_role'], 'role' => 1]);
            echo '<script>alert("Thêm thành công");</script>';
        } else {
            echo '<script>alert("Thêm thành công, chưa có giảng viên");</script>';
        }
    }
    ?>
<?php } ?>

<?php include 'footer.php' ?>