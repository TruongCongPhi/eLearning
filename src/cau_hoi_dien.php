<?php include 'navbar.php';
isLogin2();
checkKhoaHoc();
$data_course = get('courses', 'id=' . $_GET['course_id'] . '');
$data_lecture = get('lectures', 'id=' . $_GET['lecture_id'] . '');
?>
<!-- điều hướng -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a class="link-secondary" href="khoa_hoc.php">Trang chủ</a></li>
        <li class="breadcrumb-item"><a class="link-secondary" href="bai_giang.php?course_id=<?= $_GET['course_id'] ?>">Khóa học:
                <?= $data_course['course_title'] ?></a>
        </li>

        <li class="breadcrumb-item"><a class="link-secondary" href="bai_giang.php?course_id=<?= $_GET['course_id'] ?>"><?= $data_lecture['lecture_title'] ?></a></li>
        <li class="breadcrumb-item"><a class="link-secondary" href="bien_tap.php?course_id=<?= $_GET['course_id'] ?>&lecture_id=<?= $_GET['lecture_id'] ?>">Biên
                tập</a></li>
        <li class="breadcrumb-item text-dark active" aria-current="page">Thêm câu hỏi điền</li>
    </ol>
</nav>
<!-- thông tin khóa học -->
<div class="d-flex align-items-center p-3 my-3 bg-purple rounded shadow">
    <div class="lh-1">
        <h2 class="mb-0 lh-1">Khóa học: <?= $data_course['course_title'] ?></h2>
        <p class="fw-medium fs-5 mt-2"><?= $data_lecture['lecture_title'] ?></p>
    </div>
</div>
<a href="bien_tap.php?course_id=<?= $_GET['course_id'] ?>&lecture_id=<?= $_GET['lecture_id'] ?>" class="btn btn-primary">Trở
    lại</a>
<?php
if (isset($_POST['add_quiz'])) {

    $username = $_SESSION['username'];
    $ten_cau_hoi = $_POST['ten_cau_hoi'];
    $muc_do = $_POST['level'];
    $imgPath = null;
    $dap_an_dien = $_POST['dap_an_dien'];
    $addQuizSuccess = 0;
    $uploadCheck = 1;

    // Thêm câu hỏi vào bảng 'cau_hoi'
    if (!empty($_FILES['anh']['name'])) {
        $imgPath = checkImage($_FILES['anh']['name']);
        if (!$imgPath) {
            $uploadCheck = 0;
        }
    }
    if ($uploadCheck) {
        $questionData = [
            'lecture_id' => $data_lecture['id'],
            'question_name' => $_POST['ten_cau_hoi'],
            'image' => $imgPath,
            'level' => $_POST['level'],
            'type' => 'fill',
            'status' => ($_SESSION['username'] == 'admin') ? 1 : 0,
            'added_by' => $_SESSION['username'],
        ];
        $insert_question = insert('lecture_questions', $questionData);

        if ($insert_question) {
            $question_id = mysqli_insert_id($conn);
            $answerData = [
                'question_id' => $question_id,
                'answer_name' => $_POST['dap_an_dien'],
                'is_correct' => 1,
            ];
            $answer_insert = insert('answers', $answerData);
            if ($answer_insert) {
                $addQuizSuccess = 1;
            } else {
                $addQuizSuccess = 0;
            }
        }
    }
}
?>

<form method="POST" action="" enctype="multipart/form-data">
    <!-- thông báo -->
    <?php
    if (isset($addQuizSuccess) && $addQuizSuccess) {
        echo '<div class="alert alert-success  " role="alert">Câu hỏi đã được thêm thành công!</div>';
    } elseif (isset($uploadCheck) && !$uploadCheck) {
        echo '<div class="alert alert-warning d-flex align-items-center" role="alert"> Chỉ cho phép tải lên các định dạng JPG, JPEG, PNG và GIF!</div>';
    }
    ?>
    <div class="form-group mb-3">
        <label for="name_quiz">Nhập tên câu hỏi</label>
        <input type="text" value="<?= isset($_POST['ten_cau_hoi']) ? htmlspecialchars($_POST['ten_cau_hoi']) : '' ?>" required="required" class="form-control" id="name_quiz" name="ten_cau_hoi">
    </div>
    <div class="form-group mb-3">
        <label for="formFileSm" class="form-label">Upload ảnh từ máy tính:</label>
        <input class="form-control" type="file" name="anh">
    </div>
    <div class="form-group mb-3">
        <label for="">Dạng câu hỏi</label>
        <input class="form-control" type="text" value="Câu hỏi điền" readonly><br>
        <input type="hidden" value="singlechoice" name="loai_quiz">
        <label for="exampleFormControlSelect1">Chọn độ khó</label>
        <select class="form-control" id="exampleFormControlSelect1" name="level">
            <option value="1" <?= (isset($_POST['level']) && $_POST['level'] == '1') ? 'selected' : '' ?>>Dễ
            </option>
            <option value="2" <?= (isset($_POST['level']) && $_POST['level'] == '2') ? 'selected' : '' ?>>
                Trung Bình</option>
            <option value="3" <?= (isset($_POST['level']) && $_POST['level'] == '3') ? 'selected' : '' ?>>
                Khó</option>
        </select>
    </div>
    <div class="form-group">
        <label for="name_quiz">Nhập đáp án</label>
        <input type="text" value="<?= isset($_POST['dap_an_dien']) ? htmlspecialchars($_POST['dap_an_dien']) : '' ?>" required="required" class="form-control" name="dap_an_dien">
    </div>

    <br><br>
    <button type="submit" class="btn btn-primary" name="add_quiz">Thêm câu hỏi</button>
</form>
<?php include 'footer.php' ?>