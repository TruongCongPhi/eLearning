<?php include 'navbar.php';
$data_course = get('courses', 'id=' . $_GET['course_id'] . '');
$data_lecture = get('lectures', 'id=' . $_GET['lecture_id'] . '');
print_r($_SESSION['quizz_session']);
?>

<div class="d-flex align-items-center p-3 my-3 bg-purple rounded shadow">
    <div class="lh-1">
        <h2 class="mb-0 lh-1">Khóa học: <?= $data_course['course_title'] ?></h2>
        <p class="fw-medium fs-5 mt-2"><?= $data_lecture['lecture_title'] ?></p>
        <p class="fs-4">Đáp án đã chọn</p>
    </div>
</div>

<a class="btn btn-primary"
    href="lich_su_quizz.php?course_id=<?= $_GET['course_id'] ?>&lecture_id=<?= $_GET['lecture_id'] ?>">Trở lại</a>



<div class="d-flex align-items-center justify-content-center m-auto p-3 my-3 bg-purple rounded shadow"
    style="width: 60%;">
    <!-- Your content goes here -->
    <div class="row">
        <?php
        $i = 1;
        foreach ($_SESSION['quizz_session'] as $key => $selected_answer_id) {
            $question_data = get('lecture_questions', "lecture_id={$_GET['lecture_id']} AND id={$key}");
        ?>

        <div class="col-12 mb-3">
            <div class="card rounded-4 p-3 mb-3">
                <!-- HIen thi cau hoi -->
                <h5 class="card-title">Câu <?= $i++ ?>: <?= $question_data["question_name"] ?></h5>

                <!-- Anh cau hoi -->
                <div class="form-group">
                    <img src='<?= (!is_null($question_data['image'])) ? $question_data['image'] : '' ?>' height='200px'>
                </div>

                <?php
                    $data_answer = getArray('answers', 'question_id=' . $key . '');

                    while ($row_answer = mysqli_fetch_assoc($data_answer)) {
                        // dap an dung                           
                        if ($question_data['type'] == "single_choice") {
                    ?>
                <div class="form-check p-3">
                    <input class="form-check-input" name="flag" type="radio"
                        <?= ($selected_answer_id == $row_answer['id']) ? "checked" : '' ?>>
                    <label class="form-check-label text-break"><?= $row_answer['answer_name'] ?></label>
                </div>
                <?php
                        } elseif ($question_data['type'] == "multiplechoice") {
                        ?>
                <div class="form-check p-3">
                    <input class="form-check-input" value='' type='checkbox'
                        <?= ($id == $row_answer['id']) ? "checked" : '' ?>>
                    <label class='form-check-label text-break' value=''><?= $row_answer['answer_name'] ?></label>
                </div>
                <?php
                        } elseif ($question_data['type'] == "fill") { ?>
                <div class='input-group-text'>
                    <input name='' type='text' class='form-control' value='<?= $row_answer['answer_name'] ?>' readonly>
                </div>

                <?php
                        }
                    }
                    ?>

            </div>
        </div>



        <?php
        } ?>
    </div>

</div>