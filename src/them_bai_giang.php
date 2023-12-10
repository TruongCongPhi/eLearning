<?php
include 'navbar.php';
checkKhoaHoc();

$data = get('courses', 'id=' . $_GET['course_id'] . '');
$lecture_data = get('lectures', 'course_id=' . $data['id'] . '');
$lectureCount = 1; // Initialize with a default value

?>
<!-- điều hướng -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a class="link-secondary" href="khoa_hoc.php">Trang chủ</a></li>
        <li class="breadcrumb-item"><a class="link-secondary" href="bai_giang.php?course_id=<?= $_GET['course_id'] ?>">Khóa học:
                 <?= $data['course_title'] ?></a>
         </li>
        <li class="breadcrumb-item"><a class="link-secondary" href="bai_giang.php?course_id=<?= $_GET['course_id'] ?>"><?= $lecture_data['lecture_title'] ?></a></li>
         <li class="breadcrumb-item text-dark active" aria-current="page">Thêm Bài giảng</li>
    </ol>
</nav>
<!-- thông tin khóa học -->
<div class="d-flex justify-content-between p-3 my-3 bg-purple rounded shadow">
    <div class="lh-1">
        <h2 class="mb-0 lh-1">Khóa học: <?= $data['course_title'] ?></h2>
        <p class="mt-2"><?= $data['course_desc'] ?></p>
    </div>
</div>

<h2>Thêm bài giảng</h2>
<form method="post">
<div class="my-3 p-3 bg-body border rounded shadow-sm">
    <div class="border-bottom pb-2 mb-0">
        <label for="formGroupExampleInput" class="form-label fs-4 fw-medium">Tiêu đề</label>
        <div class="row">
            <div class="col-md-10"><input type="text" name="lecture_title" class="form-control" id="formGroupExampleInput" placeholder="Ví dụ: Tuần 1" required></div>
            <div class="col-md-2">
                <select class="form-select form-select" name="status_lecture" required>
                    <option selected>Trạng thái</option>
                    <option value="0">Ẩn</option>
                    <option value="1">Hiện</option>
                </select>
            </div>
        </div>
    </div>
    <div class="d-flex text-body-secondary border-bottom pt-3">
        <div class="pb-4 mt-2 mb-0 small lh-sm w-100">
            <span>1</span>
            <div class="row">
                <div class="col-md-5"><input name="material_title[1]" class="col-md-6 form-control form-control-sm me-3" type="text" placeholder="Nhập tiêu đề học liệu"></div>
                <div class="col-md-3 "><input type="file" name="file_upload[1]" class=" form-control form-control-sm me-3 " id="customFile" /></div>
                <div class="col-md-1"><select class=" form-select form-select-sm" name="type[1]" required>
                    <option selected>Loại</option>
                    <option value="notify">Thông báo</option>
                    <option value="document">Học liệu</option>
                    <option value="slide">Slide</option>
                    <option value="quizz">Kiểm tra</option>
                    <option value="ppt">Powerpoint</option>
                    <option value="word">Word</option>
                    <option value="video">Video</option>
                    <option value="link">Liên kết link</option>
                    <option value="quizz">Kiểm tra</option>
                </select></div>
                <div class="col-md-2 ">
                    <select class="form-select form-select-sm" name="status_material[1]" required>
                    <option selected>Trạng thái</option>
                    <option value="0">Ẩn</option>
                    <option value="1">Hiện</option>
                </select>
            </div>
            <div class="col-md-1">
                    <button class="btn btn-danger btn-sm" type="button" onclick="deleteLecture(this)">Xóa</button>
                </div>
            </div>
        </div>
    </div>
    <button class="btn btn-primary btn-sm" type="button" onclick="addLecture()">Thêm bài giảng</button>
</div>
   <button class="btn btn-success" type="submit">Lưu</button>
</form>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data_lecture = [
        'course_id' => $_GET['course_id'],
        'lecture_title'=>$_POST['lecture_title'],
        'status' => $_POST['status_lecture']
    ];

    // Thêm bài giảng vào cơ sở dữ liệu
    $insert_lecture = insert('lectures',$data_lecture);
    if ($insert_lecture) {
        // Lấy ID của bài giảng mới thêm vào
        $lecture_id = mysqli_insert_id($conn);
        for ($i = 1; $i <= $lectureCount; $i++) {
            $material_title = $_POST['material_title'][$i];
            $type = $_POST['type'][$i];
            $status_material = $_POST['status_material'][$i];

            $data_material = [
                'lecture_id' => $lecture_id,
                'material_title' => $material_title,
                'type' => $type,
                'status' => $status_material
            ];

            // Thêm học liệu vào cơ sở dữ liệu
            insert('materials', $data_material);
        }
    } else {
        echo "Error: " . $stmt->error;
    }

}
?>
 <script>
    // Số bài giảng/tuần hiện tại
    var lectureCount = 1;
    // Hàm thêm bài giảng
   function addLecture() {
    lectureCount++;

    var lectureDiv = document.createElement("div");
    lectureDiv.className = "d-flex text-body-secondary border-bottom pt-3";

    lectureDiv.innerHTML = `
        <div class="pb-4 mt-2 mb-0 small lh-sm w-100">
            <span>${lectureCount}</span>
            <div class="row">
                <div class="col-md-5"><input name="material_title[${lectureCount}]" class="col-md-6 form-control form-control-sm me-3" type="text" placeholder="Nhập tiêu đề học liệu" required></div>
                <div class="col-md-3 "><input type="file" name="file_upload[${lectureCount}]" class=" form-control form-control-sm me-3 " id="customFile" /></div>
                <div class="col-md-1"><select name="type[${lectureCount}]" class=" form-select form-select-sm" required>
                    <option selected>Loại</option>
                    <option value="notify">Thông báo</option>
                    <option value="document">Học liệu</option>
                    <option value="slide">Slide</option>
                    <option value="quizz">Kiểm tra</option>
                    <option value="ppt">Powerpoint</option>
                    <option value="word">Word</option>
                    <option value="video">Video</option>
                    <option value="link">Liên kết link</option>
                    <option value="quizz">Kiểm tra</option>
                </select></div>
                <div class="col-md-2 "> <select name="status_material[${lectureCount}]" class="form-select form-select-sm" required>
                    <option selected>Tình trạng</option>
                    <option value="hide">Ẩn</option>
                    <option value="show">Hiện</option>
                </select></div>
                <div class="col-md-1">
                    <button class="btn btn-danger btn-sm" type="button" onclick="deleteLecture(this)">Xóa</button>
                </div>
            </div>
        </div>
    `;

    // Lấy nút "Thêm bài giảng"
    var addButton = document.querySelector(".btn-primary.btn-sm");

    // Thêm bài giảng mới phía trước của nút "Thêm bài giảng"
    document.querySelector(".bg-body").insertBefore(lectureDiv, addButton);
}

function deleteLecture(button) {
    // Xác định hàng cha của nút "Xóa" được nhấn
    var lectureDiv = button.closest(".d-flex.text-body-secondary.border-bottom.pt-3");

    // Xóa hàng
    lectureDiv.remove();
}



</script>

