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
            <li class="breadcrumb-item text-dark active" aria-current="page">Quản lý người dùng</li>
        </ol>
    </nav>

    <h1>Danh sách người dùng</h1>

    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Tên tài khoản</th>
                <th scope="col">Quyền</th>
                <th scope="col">Thao tác</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <?php
            $stt = 1;
            $data_user = getArrayOrder('users', '', 'id DESC', 200);
            if ($data_user && $data_user->num_rows > 0) {
                while ($row = $data_user->fetch_assoc()) {
                    if ($row['username'] == 'admin') {
                        break;
                    }
            ?>
                    <tr>
                        <td><?= $stt ?></td>
                        <td><?= $row['username'] ?></td>

                        <td><?php if ($row['role'] == 2) {
                                echo "ADMIN";
                            } elseif ($row['role'] == 1) {
                                echo "Quản trị";
                            } else echo "Người dùng";
                            ?>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <form action="quan_ly_user_form.php" method="post">
                                    <?php if ($role_all > 1) {
                                        if ($row['role'] == 0) { ?>
                                            <button class='btn btn-sm btn-success me-1' name="add_role" value="<?= $row['id'] ?>" type=" submit">Thêm quản trị</button>
                                        <?php
                                        } elseif ($row['role'] == 1) {
                                        ?>
                                            <button type="submit" name="delete_role" value="<?= $row['id'] ?>" class='btn btn-sm btn-warning me-1'>Hủy quản
                                                trị</button>
                                        <?php
                                        } ?>
                                    <?php } ?>
                                    <button class="btn btn-sm btn-danger" type=" submit" name="delete_user" value="<?= $row['id'] ?>">Xóa</button>
                                </form>
                            </div>
                        </td>

                    </tr>


            <?php
                    $stt++;
                }
            } else echo "<td colspan=5 align='center'> Trống</td>"
            ?>
        </tbody>
    </table>



<?php } ?>