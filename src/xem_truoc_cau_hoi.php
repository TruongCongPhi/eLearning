<?php
include 'navbar.php';
include '../function.php';
isLogin2();
checkKhoaHoc();
$data_course = get('courses', 'id=' . $_GET['course_id'] . '');
$data_lecture = get('lectures', 'id=' . $_GET['lecture_id'] . '');
$data_question = get('lecture_questions', 'id=' . $_GET['question_id'] . '')
?>
<div class="d-flex align-items-center p-3 my-3 bg-purple rounded shadow">
    <div class="lh-1">
        <h2 class="mb-0 lh-1">Khóa học: <?= $data_course['course_title'] ?></h2>
        <p class="fw-medium fs-5 mt-2"><?= $data_lecture['lecture_title'] ?></p>
    </div>
</div>

<a class="btn btn-primary" href="bien_tap.php?course_id=<?= $_GET['course_id'] ?>&lecture_id=<?= $_GET['lecture_id'] ?>">Trở lại</a>


<br><br>

<div style="width: 60%;
        margin: auto;">
    <!-- tên câu hỏi -->
    <div class="shadow py-5 px-4 bg-body-tertiary rounded" style="width:100%">

        <div class="form-group">
            <label for="name_quiz" class="text-break">
                <h4>Câu hỏi: <?= $data_question['question_name'] ?></h4>
            </label>
        </div>
        <!-- ảnh câu hỏi -->
        <div class="form-group">
            <img src='<?= (!is_null($data_question['image'])) ? $data_question['image'] : '' ?>' height='200px'>
        </div><br>

        <!-- đáp án -->
        <h4>Đáp án</h4>
        <div class="card border-light-subtle ps-3 ">
            <?php
            $data_answer = getArray('answers', 'question_id=' . $_GET['question_id'] . '');

            while ($data = mysqli_fetch_assoc($data_answer)) {
                $is_correct_checked = ($data['is_correct'] == 1) ? "checked" : "";
                if ($data_question['type'] == "single_choice") {
            ?>
                    <div class="form-check p-3">
                        <input class="form-check-input" name="flag" type="radio" <?php echo $is_correct_checked; ?>>
                        <label class="form-check-label text-break"><?= $data['answer_name'] ?></label>
                    </div>
                <?php
                } elseif ($data_question['type'] == "fill") {
                ?>
                    <div class='input-group py-3 pe-3'>
                        <div class='input-group-text'>
                            <input name='' value='' checked type='checkbox' readonly>
                        </div>
                        <input name='' type='text' class='form-control' value='<?= $data['answer_name'] ?>' readonly>
                    <?php
                } elseif ($data_question['type'] == "multiplechoice") {

                    ?>
                        <div class='form-check p-3'>
                            <input class="form-check-input" value='' type='checkbox' <?php echo $is_correct_checked; ?>>
                            <label class='form-check-label text-break' value=''><?= $data['answer_name'] ?></label>
                        </div>
                <?php
                }
            }

                ?>
                    </div>
        </div>
    </div>

    </form>
</div>


<?php include 'footer.php' ?>