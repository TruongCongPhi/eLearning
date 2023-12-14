<?php
include 'navbar.php';
checkKhoaHoc();

$data = get('courses', 'id=' . $_GET['course_id'] . '');
$lecture_data = get('lectures', 'id=' . $_GET['lecture_id']  . '');

?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $type = $_POST['type'];
    $check = 1;
    $path = null;

    if ($type == 'link') {
        if (!empty($_POST["link"])) {
            $path = $_POST['link'];
        } else {
            $mess_link = true;
            $check = 0;
        }
    } elseif ($type != 'link' && empty($_FILES["file"]['name'])) {
        $mess_file = true;
        $check = 0;
    } elseif ($type != 'link' && !empty($_FILES["file"]['name'])) {
        $targetDirectory = "../uploads/";
        $imgFileType = strtolower(pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION));

        $j = 1;
        $newFileName = $_FILES["file"]["name"];
        while (file_exists($targetDirectory . $newFileName)) {
            $newFileName = pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME) . "($j)." . $imgFileType;
            $j++;
        }

        $uploadOk = move_uploaded_file($_FILES["file"]['tmp_name'], $targetDirectory . $newFileName);
        if ($uploadOk) {
            $path = $targetDirectory . $newFileName;
        } else {
            $mess = '<div class="alert alert-warning d-flex align-items-center" role="alert">Upload file không thành công!</div>';
            $check = 0;
        }
    }
    if ($check) {
        $data_material = [
            'lecture_id' => $_GET['lecture_id'],
            'material_title' => $_POST['material_title'],
            'type' => $_POST['type'],
            'path' => $path,
            'status' => $_POST['status_material']
        ];
        $insert_material = insert('materials', $data_material);

        if ($insert_material) {
            $mess = '<div class="alert alert-success d-flex align-items-center" role="alert">Thêm thành công!</div>';
        } else {
            $mess = "Thêm bài giảng thất bại!";
        }
    } else {
        $mess = '<div class="alert alert-warning d-flex align-items-center" role="alert">Thêm bài giảng thất bại!</div>';
    }
}
?>

<!-- điều hướng -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a class="link-secondary" href="khoa_hoc.php">Trang chủ</a></li>
        <li class="breadcrumb-item"><a class="link-secondary" href="bai_giang.php?course_id=<?= $_GET['course_id'] ?>">Khóa học:
                <?= $data['course_title'] ?></a>
        </li>

        <li class="breadcrumb-item text-dark active" aria-current="page">Thêm học liệu</li>
    </ol>
</nav>
<!-- thông tin khóa học -->
<div class="d-flex justify-content-between p-3 my-3 bg-purple rounded shadow">
    <div class="lh-1">
        <h2 class="mb-0 lh-1">Khóa học: <?= $data['course_title'] ?></h2>
        <p class="fw-medium fs-5 mt-2"><?= $lecture_data['lecture_title'] ?></p>

    </div>
</div>

<?php
if (isset($mess)) {
    echo $mess;
}
?>
<h2>Thêm bài giảng</h2>
<form method="post" enctype="multipart/form-data">
    <div class="my-3 p-3 bg-body border rounded shadow-sm">
        <div class="d-flex text-body-secondary border-bottom pt-3">
            <div class="pb-4 mt-2 mb-0 small lh-sm w-100">
                <div class="row  align-items-center">
                    <div class="row">
                        <div class="col-md-6"><input name="material_title" class="form-control form-control-sm me-3" type="text" value="<?php echo isset($_POST['material_title']) ? htmlspecialchars($_POST['material_title']) : ''; ?>" placeholder="Nhập tiêu đề học liệu" required>
                        </div>
                        <div class="col-md-3"><select class=" form-select form-select-sm" name="type" required>
                                <option selected disabled value="">Loại...</option>
                                <option value="notify">Thông báo</option>
                                <option value="document">Học liệu</option>
                                <option value="pdf">Slide(pdf)</option>
                                <option value="ppt">Powerpoint</option>
                                <option value="word">Word</option>
                                <option value="video">Video</option>
                                <option value="link">Liên kết link</option>
                            </select>
                        </div>
                        <div class="col-md-3 ">
                            <select class="form-select form-select-sm" name="status_material" required>
                                <option selected disabled value="">Trạng thái...</option>
                                <option value="0">Ẩn</option>
                                <option value="1">Hiện</option>
                            </select>
                        </div>

                        <div class="col-md-6 mt-1">
                            <input name="link" class="form-control form-control-sm me-3 <?php if (isset($mess_link)) echo 'is-invalid'; ?>" type="text" placeholder="Dán đường link" value="<?php echo isset($_POST['link']) ? htmlspecialchars($_POST['link']) : ''; ?>">
                            <?php if (isset($mess_link)) : ?>
                                <div class="invalid-feedback">
                                    Vui lòng nhập địa chỉ link !
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6 mt-1">
                            <input type="file" name="file" class=" form-control form-control-sm me-3 <?php if (isset($mess_file)) echo 'is-invalid'; ?>" aria-label="file example" />
                            <?php if (isset($mess_file)) : ?>
                                <div class="invalid-feedback">
                                    Vui lòng upload file!
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <button class="btn btn-success mt-3" type="submit">Thêm</button>
    </div>


</form>