<?php include 'navbar.php';
if (!isset($_GET['id_quizz_detail'])) {
    header('location: khoa_hoc.php');
    exit();
}
?>


<a class="btn btn-primary mt-3 " href="lich_su_quizz.php?course_id=<?= $_GET['course_id'] ?>&lecture_id=<?= $_GET['lecture_id'] ?>&quizz_id=<?= $_GET['quizz_id'] ?>">Trở
    lại</a>




<h4 class="text-center">Xem chi tiết</h4>
<div class="d-flex align-items-center justify-content-center m-auto p-3 my-3 bg-purple rounded shadow" id="id_form" style="width: 60%;">

    <!-- Your content goes here -->
    <div class="row">
        <?php
        $quizz_detail_result = getArray('history_quizz', "id={$_GET['id_quizz_detail']}");
        $quizz_detail = $quizz_detail_result->fetch_assoc();
        $quizz_detail['id_question_quizz'] = json_decode($quizz_detail['id_question_quizz'], true); // chuyển từ chuỗi JSON trong CSDL sang mảng PHP
        $quizz_detail['answer'] = json_decode($quizz_detail['answer'], true); // chuyển từ chuỗi JSON trong CSDL sang mảng PHP
        $i = 1;

        foreach ($quizz_detail['id_question_quizz'] as $key => $id_question) { // lấy ra đáp án từ bảng
            $is_correct_checked = "border border-danger";
            $selected_answer_id = '';

            foreach ($quizz_detail['answer'] as $id_check => $answer_id_user) {
                $id_ques_user = explode(',', $id_check)[0]; // chia chuỗi id_check thành mảng cách nhau dấu , rồi lấy ptu có chỉ số 0
                if ($id_question == $id_ques_user) { //nếu đáp án người dùng chọn = với dáp án
                    $selected_answer_id = $answer_id_user;
                    $correct_question = explode(',', $id_check)[1];
                    $is_correct_checked = ($correct_question == 1) ? "border border-success" : "border border-danger";
                }
            }
            $question_data = get('lecture_questions', "lecture_id={$_GET['lecture_id']} AND id={$id_question}");

        ?>

            <div class="col-12 mb-3">
                <div class="card rounded-4 p-3 mb-3 <?= $is_correct_checked ?>">
                    <!-- Kiển tra xem nếu đúng in ra khung xanh/ sai khung đỏ-->
                    <!-- HIen thi cau hoi -->
                    <h5 class="card-title">Câu <?= $i++ ?>: <?= $question_data["question_name"] ?></h5>

                    <!-- Anh cau hoi -->
                    <div class="form-group">
                        <img src='<?= (!is_null($question_data['image'])) ? $question_data['image'] : '' ?>' height='200px'>
                    </div>

                    <?php
                    $data_answer = getArray('answers', 'question_id=' . $id_question . '');
                    while ($row_answer = mysqli_fetch_assoc($data_answer)) {

                        (!is_null($selected_answer_id) && is_string($selected_answer_id)) ? $multiplechoice_user_answer = explode(',', $selected_answer_id) : $selected_answer_id;
                        // dap an dung                           
                        if ($question_data['type'] == "single_choice") {
                    ?>
                            <div class="form-check p-3">
                                <input class="form-check-input" name="flag<?= $key ?>" type="radio" <?= ($selected_answer_id == $row_answer['id']) ? "checked" : '' ?> disabled>
                                <label class="form-check-label text-break <?= ($key == $row_answer['id']) ? "fs-3" : '' ?>"><?= $row_answer['answer_name'] ?></label>
                            </div>
                        <?php
                        } elseif ($question_data['type'] == "multiplechoice") {
                        ?>
                            <div class="form-check p-3  ">
                                <input class="form-check-input" name="flag<?= $key ?>[]" value='' type='checkbox' <?= (in_array($row_answer['id'], $multiplechoice_user_answer)) ? "checked" : '' ?> disabled>
                                <label class='form-check-label text-break' value=''><?= $row_answer['answer_name'] ?></label>
                            </div>
                        <?php
                        } elseif ($question_data['type'] == "fill") { ?>

                            <input name='' type='text' class='form-control' value='<?= $selected_answer_id ?>' readonly>
                    <?php
                        }
                    }
                    ?>

                </div>
            </div>
        <?php
        }
        ?>
    </div>

</div>

<div style="position: fixed;left: 80%;top: 40vh;" id="countdown"></div>