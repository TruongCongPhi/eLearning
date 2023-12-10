<?php include 'navbar.php';
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
        <li class="breadcrumb-item text-dark active" aria-current="page">Thêm câu hỏi 1 đáp án</li>
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
    $imgPath = null;
    $addQuizSuccess = 0;
    $uploadCheck = 1;
    // Thêm câu hỏi vào bảng cau_hoi
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
            'type' => 'single_choice',
            'status' => ($_SESSION['username'] == 'admin') ? 1 : 0,
            'added_by' => $_SESSION['username'],
        ];
        $insert_question = insert('lecture_questions', $questionData);

        if ($insert_question) {
            $question_id = mysqli_insert_id($conn);
            // Thêm các đáp án vào bảng 'dap_an'
            for ($i = 1; $i <= $_POST['sl_input']; $i++) {
                $answerData = [
                    'question_id' => $question_id,
                    'answer_name' => $_POST["dap_an$i"],
                    'is_correct' => ($_POST['flag'] == $i) ? 1 : 0,
                ];
                $answer_insert = insert('answers', $answerData);

                if ($answer_insert && $i == $_POST['sl_input']) {
                    $addQuizSuccess = 1;
                } else {
                    $addQuizSuccess = 0;
                }
            }
        }
    }
}
?>

<!-- Hiển thị thông báo -->
<?php if (isset($addQuizSuccess) && $addQuizSuccess) {
    echo '<div class="alert alert-success  " role="alert">Câu hỏi đã được thêm thành công!</div>';
} elseif (isset($uploadCheck) && !$uploadCheck) {
    echo '<div class="alert alert-warning d-flex align-items-center" role="alert"> Chỉ cho phép tải lên các định dạng JPG, JPEG, PNG và GIF!</div>';
}
?>
<form method="POST" action="" enctype="multipart/form-data">
    <div class="form-group mb-3">
        <label for="name_quiz">Nhập tên câu hỏi</label>
        <input type="text" value="<?= isset($_POST['ten_cau_hoi']) ? htmlspecialchars($_POST['ten_cau_hoi']) : '' ?>" required class="form-control" id="name_quiz" name="ten_cau_hoi">
    </div>
    <div class="form-group mb-3">
        <label for="formFileSm" class="form-label">Upload ảnh từ máy tính:</label>
        <input class="form-control <?php if (isset($uploadCheck) && !$uploadCheck) echo 'is-invalid'; ?>" aria-label="file example" type="file" name="anh">
        <?php if (isset($uploadCheck) && !$uploadCheck) : ?>
            <div class="invalid-feedback">
                Định dạng ảnh không hợp lệ. Chỉ chấp nhận các định dạng: jpg, jpeg, png, gif.
            </div>
        <?php endif; ?>
    </div>
    <div class="form-group mb-3">
        <label for="">Dạng câu hỏi</label>
        <input class="form-control" type="text" value="Chọn một đáp án" readonly><br>
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
    <div class="form-group mb-3">
        <label for="">Lựa chọn số đáp án</label>
        <input type="number" class="form-control" name="sl_input" value="<?= isset($_POST['sl_input']) ? $_POST['sl_input'] : '4' ?>" id="sl_input">
        <button style="margin-top:10px" type='button' class="btn btn-primary" onclick="create_element()">Tạo</button>
    </div>
    <div>Nhập các lựa chọn và tích vào đáp án đúng!</div><br>

    <div class="form-check" id="form-check">
        <?php
        $sl_input = isset($_POST['sl_input']) ? $_POST['sl_input'] : 4;
        for ($i = 1; $i <= $sl_input; $i++) {
            $checked = (isset($_POST['flag']) && $_POST['flag'] == $i) ? 'checked' : '';
        ?>
            <input class="form-check-input" type="radio" value="<?= $i ?>" id="flexCheckDefault<?= $i ?>" name="flag" <?= $checked ?> required>
            <input type="text" required="required" class="form-control remove-element" name="dap_an<?= $i ?>" value="<?= isset($_POST["dap_an$i"]) ? htmlspecialchars($_POST["dap_an$i"]) : '' ?>">
            <br>
        <?php
        }

        ?>
    </div>
    <br><br>
    <button type="submit" class="btn btn-primary d-grid col-6 mx-auto" name="add_quiz">Thêm câu hỏi</button>
</form>



<?php include 'footer.php' ?>

<script type="text/javascript">
    function create_element() {
        var value = $("#sl_input").val();
        // Kiểm tra giá trị nằm trong khoảng từ 2 đến 6
        if (value < 2 || value > 6) {
            alert("Vui lòng chọn từ 2 đến 6 ô");
            return;
        }
        $(".form-check-input").remove();
        $(".remove-element").remove();
        $("div br").remove();
        for (var i = 1; i <= value; ++i) {
            var txt_html1 =
                `<input class="form-check-input" type="radio" value="${i}" id="flexCheckDefault" name="flag" required>`;
            var txt_html2 =
                `<input type="text" required="required" class="form-control remove-element" name="dap_an${i}"> <br><br>`;
            $("#form-check").append(txt_html1, txt_html2);
        }
    }
</script>