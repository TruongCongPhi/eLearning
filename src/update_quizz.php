<?php
include '../function.php';
// session_start();
unset($_SESSION['quizz_session']); // xóa ds câu hỏi ng dùng cũ
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $time_finish = date('Y-m-d H:i:s');
    $score = 0;
    $lecture_id = $_GET['lecture_id'];
    $quizz_session = [];
    foreach ($_POST as $key => $value) {
        if (strpos($key, "choice_") !== false) {
            $question_id = substr($key, 7); // Lấy id của câu hỏi từ tên trường
            $user_answer = is_array($value) ? implode(",", $value) : $value; // Nếu là multiple choice, chuyển thành chuỗi


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
                $quizz_session[$question_id . ',1'] = $user_answer;
                $score++;
            } else $quizz_session[$question_id . ',0'] = $user_answer;
            // echo "Câu hỏi" . $question_id . "sai<br>"; 
        } elseif (strpos($key, "fill_") !== false) {
            $question_id = substr($key, 5); // Lấy id của câu hỏi từ tên trường
            $user_answer = $value;


            $check_fill = get('answers', "question_id = $question_id AND answer_name = '$user_answer'");
            if (!is_null($check_fill)) {
                $score++;
                $quizz_session[$question_id . ',1'] = $user_answer;
            } else $quizz_session[$question_id . ',0'] = $user_answer;
        }
    }
    $score = $score * 20;



    $lich_su = [
        'score' => $score,
        'time_finish' => $time_finish,
    ];
    $_SESSION['quizz_session'] = $quizz_session;


    $update_quizz = update('history_quizz', "id={$_POST['history_id']}", $lich_su);
    if ($update_quizz) {

        header("location: show_ket_qua.php?course_id={$_GET['course_id']}&lecture_id={$_GET['lecture_id']}&id_quizz={$_POST['history_id']}");
    }
}