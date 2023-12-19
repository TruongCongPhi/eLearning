<?php
include 'navbar.php';
?>
<?php
if (isset($_POST['xoa'])) {
    $course_id_delete = $_POST['xoa'];
    delete('courses', "id={$course_id_delete}");
    header('location:khoa_hoc.php');
}
?>
<?php if ($role_all > 0) : ?>

<div class="dropdown show">
    <a class="btn btn-outline-primary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        Tùy chọn
    </a>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="them_khoa_hoc.php">Thêm khóa học</a>
        <a class="dropdown-item" href="them_tai_khoan.php">Thêm tài khoản</a>
        <a class="dropdown-item" href="quan_ly_user.php">Quản lý người dùng</a>

    </div>
</div>
<?php endif ?>

<div class="" style="text-align: center;">
    <h2>Khóa học</h2>
</div>
<form method="post" action="">
    <div class="row row-cols-1 row-cols-md-3 g-4" style="margin: 0 auto; width: 80%;">
        <!-- begin khóa học -->

        <?php
        $username = $_SESSION['username'];
        if ($username == 'admin') { // admin: hiện tất cả
            $courses = getArray('courses', '');
        } else {
            $select = [
                'courses.*'
            ];
            $fromTable = 'courses';
            $joins = [
                'JOIN course_management ON courses.id = course_management.course_id'
            ];
            $conditions = [
                "course_management.username ='{$username}'"
            ];
            $courses = getJoin($select, $fromTable, $joins, $conditions);
        }
        ?>

        <div class="row row-cols-1 row-cols-md-3 g-4" style="margin: 0 auto; width: 80%;">
            <!-- Display courses -->
            <?php
            if (is_null($courses)) {
                echo '<div class="text-center alert alert-warning">Chưa có khóa học nào!</div>';
            } else {
                foreach ($courses as $course) : ?>
            <div class="col">
                <div class="card">
                    <img src="../images/khoahoc.jpg" class="card-img-top" alt="Course Image">
                    <div class="card-body">
                        <h5 class="card-title"><?= $course["course_title"] ?></h5>
                        <a class="btn btn-sm btn-primary" href="bai_giang.php?course_id=<?= $course["id"] ?>">Truy
                            cập</a>
                        <?php if ($role_all > 0) : ?>
                        <button class="btn btn-sm btn-danger" name="xoa" value="<?= $course['id'] ?>"
                            type="submit">Xóa</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach;
            } ?>

        </div>

        <!-- end khóa học -->

    </div>

</form>


<?php include 'footer.php'; ?>