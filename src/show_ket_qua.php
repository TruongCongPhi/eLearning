<?php include 'navbar.php'; ?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['form_submitted'] = false;
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $time_finish = date('H:i:s d-m-Y');
    $score = 0;
    $lecture_id = $_POST['lecture_id'];
    $quizz_session = [];
    foreach ($_POST as $key => $value) {

        if (strpos($key, "choice_") !== false) {
            $question_id = substr($key, 7); // Lấy id của câu hỏi từ tên trường
            $user_answer = is_array($value) ? implode(",", $value) : $value; // Nếu là multiple choice, chuyển thành chuỗi
            $quizz_session[$question_id] = $user_answer;

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
                $score++;
            }
            // echo "Câu hỏi" . $question_id . "sai<br>"; 
        } elseif (strpos($key, "fill_") !== false) {
            $question_id = substr($key, 5); // Lấy id của câu hỏi từ tên trường
            $user_answer = $value;
            $quizz_session[$question_id] = $user_answer;

            $check_fill = get('answers', "question_id = $question_id AND answer_name = '$user_answer'");
            if (!is_null($check_fill)) {
                $score++;
            }
        }
    }
    $_SESSION['quizz_session'] = $quizz_session;


    $score = $score * 10;


    $lich_su = [
        'score' => $score,
        'time_finish' => $time_finish,
    ];
    update('history_quizz', $lich_su, "id={$_POST['history_id']}");
}


?>
<div>
    <!-- thông báo  -->

    <?php
    if ($score < 80) {
        echo "<div class='alert alert-warning d-flex align-items-center' role='alert'>
        Bạn chưa đủ điểm đạt. Hãy tích cực luyện tập thêm!!
    </div>
    <a class='d-flex align-items-center m-auto '>
    <img src='https://i.pinimg.com/originals/01/51/0f/01510f97f42f144d58466893c66501f1.gif' alt='#' style='min-width: 10%;' class='m-auto'>
    </a>
    ";
    } else {
        echo " <div class='alert alert-success  'role='alert'>
    Chúc mừng bạn đã hoàn thành bài quizz!
    </div>
<a class='d-flex align-items-center m-auto '>
    <img src='https://i.pinimg.com/originals/02/43/1b/02431b9af1165bb2c241ee899ca76953.gif' alt='#' style='min-width: 10%;' class='m-auto'>
</a>";
    }
    ?>



    <div class="align-items-center p-3 my-3 bg-purple rounded shadow m-auto" style="width: 60%;">
        <div class="vstack gap-3">
            <div class="p-2">Họ và tên: <?= $_SESSION["username"] ?></div>
            <div class="p-2">Điểm số: <?= $score ?>%</div>
            <div class="p-2">Thời gian nộp bài: <?= $lich_su['time_finish'] ?></div>
        </div>

        <div class="p-3 d-flex">

            <a href="chi_tiet_dap_an.php?course_id=<?= $_GET['course_id'] ?>&lecture_id=<?= $_GET['lecture_id'] ?>" class="btn btn-info" name="detail">Xem chi tiết</a>


            <a href="lich_su_quizz.php?course_id=<?= $_GET['course_id'] ?>&lecture_id=<?= $_GET['lecture_id'] ?>" class="btn btn-danger" name="cancel">Thoát</a>

        </div>
    </div>
</div>

<?php include 'footer.php'; ?>