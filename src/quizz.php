<?php include 'navbar.php'   ?>
<!-- nut back -->
<div class="que">
    <a class="btn btn-primary" href="bai_giang.php?course_id=<?= $_GET['course_id'] ?>">Trở lại</a>
</div>
<!-- Khung hien thi cau hoi quizz -->

<form action="" method="post">
    <div class="d-flex align-items-center justify-content-center m-auto p-3 my-3 bg-purple rounded shadow" style="width: 60%;">
        <!-- Your content goes here -->
        <?php
        $data = getArray('lecture_questions', 'lecture_id=' . $_GET['lecture_id']);
        ?>
        <div class="row">

            <?php $i = 1;
            foreach ($data as $question) :
            ?>
                <div class="col-12 mb-3">
                    <div class="card rounded-4 p-3">
                        <!-- HIen thi cau hoi -->
                        <h5 class="card-title">Câu <?= $i++ ?>: <?= $question["question_name"] ?></h5>

                        <!-- Anh cau hoi -->
                        <div class="form-group">
                            <img src='<?= (!is_null($question['image'])) ? $question['image'] : '' ?>' height='200px'>
                        </div>

                        <?php
                        $data_answer = getArray('answers', 'question_id=' . $question["id"] . '');
                        while ($data2 = mysqli_fetch_assoc($data_answer)) {
                            // dap an dung                           
                            if ($question['type'] == "single_choice") {
                        ?>
                                <div class="form-check p-3">
                                    <!-- gan cho moi dap an 1 value la id trong bang answer  -->
                                    <input class="form-check-input" name="choice_<?= $question['id'] ?>" type="radio" value="<?= $data2['id'] ?>">
                                    <label class="form-check-label text-break"><?= $data2['answer_name'] ?></label>
                                </div>
                            <?php
                            } elseif ($question['type'] == "multiplechoice") {
                            ?>

                                <div class='form-check p-3'>
                                    <input class="form-check-input" name="choice_<?= $question['id'] ?>[]" value="<?= $data2['id'] ?>" type='checkbox'>
                                    <label class='form-check-label text-break' value=''><?= $data2['answer_name'] ?></label>
                                </div>

                            <?php
                            } else { ?>
                                <div class="form-check p-3">
                                    <!-- gan cho moi dap an 1 value la id trong bang answer  -->
                                    <label class='form-label'>Nhập đáp án:</label>
                                    <input class="form-control" name="fill_<?= $question['id'] ?>" type="text">

                                </div><?php
                                    }
                                } ?>


                    </div>
                </div>


            <?php endforeach; ?>
        </div>
    </div>
    <input style="position: fixed;left: 90%;top: 50vh;" id="nopBaiQuiz" type="submit" class="btn btn-info" name="submit" value="Nộp bài">
</form>


<?php include 'footer.php' ?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    foreach ($_POST as $key => $value) {

        if (strpos($key, "choice_") !== false) {
            $question_id = substr($key, 7); // Lấy id của câu hỏi từ tên trường
            $user_answer = is_array($value) ? implode(",", $value) : $value; // Nếu là multiple choice, chuyển thành chuỗi

            // Truy vấn để kiểm tra xem câu trả lời có đúng hay không
            $lecture_data = get('lecture_questions', "id={$question_id} ");


            $sql = "SELECT * FROM answers WHERE question_id = $question_id AND id IN ($user_answer)";
            $result = $conn->query($sql);

            $tong = countt('answers', "question_id={$question_id} AND is_correct = 1");
            $i = 0;
            // Kiểm tra câu trả lời và xử lý kết quả
            while ($row = $result->fetch_assoc()) {

                if ($row["is_correct"] == 1) {
                    $check = true;
                    $i++;
                } else {
                    $check = false;
                    break;
                }
            }

            if ($i != $tong) {
                $check = false;
            }

            if ($check) {
                echo "Câu hỏi" . $question_id . "đúng<br>";
            } else  echo "Câu hỏi" . $question_id . "sai<br>";
        } elseif (strpos($key, "fill_") !== false) {
            $question_id = substr($key, 5); // Lấy id của câu hỏi từ tên trường
            $user_answer = $value;

            $check_fill = get('answers', "question_id = $question_id AND answer_name = '$user_answer'");
            if (is_null($check_fill)) {
                echo "Câu hỏi $question_id: sai<br>";
            } else {
                echo "Câu hỏi $question_id: đúng<br>";
            }
        }
    }

    // Đóng kết nối
    $conn->close();
}
?>