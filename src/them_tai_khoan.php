<?php
include 'navbar.php';
if ($role_all < 1) {
    echo '<div class="text-center alert alert-warning">
   Bạn không được quyền truy cập vào trang này!<a href="khoa_hoc.php" class="alert-link">Quay lại</a>
  </div>';
} else {
?>
    <!-- điều hướng -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="link-dark link-opacity-50 link-opacity-100-hover link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="khoa_hoc.php">Trang chủ</a></li>
            <li class="breadcrumb-item text-dark active" aria-current="page">Thêm tài khoản</li>
        </ol>
    </nav>

    <h1>Thêm Tài khoản</h1>
    <form method="post" action="">
        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label">Tên tài khoản</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required>
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label">Password</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" name="password">
            </div>
        </div>
        <div class="mb-3">Nếu không nhập mật khẩu, mặc định là 1</div>

        <button class="btn btn-success" name="submit" type="submit">Thêm</button>
    </form>
    <?php
    if (isset($_POST['submit'])) {
        $check_user_users = get('users', "username='{$_POST['username']}'"); //truy vấn thông tin input :username
        if (is_null($check_user_users) && empty($_POST['password'])) { // quản trị = null :thông báo lỗi
            insert('users', ['username' => $_POST['username'], "password" => md5('1')]);
            echo '<script>alert("Thêm tài khoản thành công, mật khẩu mặc định là 1");</script>';
        } elseif (is_null($check_user_users) && !empty($_POST['password'])) {
            insert('users', ['username' => $_POST['username'], "password" => md5($_POST['password'])]);
            echo '<script>alert("Thêm tài khoản thành công, mật khẩu tùy chọn");</script>';
        } elseif (!is_null($check_user_users)) {
            echo '<script>alert("Tài khoản đã tồn tại");</script>';
        }
    }
    ?>
<?php } ?>

<?php include 'footer.php' ?>