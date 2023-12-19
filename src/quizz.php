<?php include 'navbar.php';
checkKhoaHoc();

unset($_SESSION['ds_question']); //xóa ds id câu hỏi quizz cũ

$data_course = get('courses', 'id=' . $_GET['course_id'] . '');
$data_lecture = get('lectures', 'id=' . $_GET['lecture_id'] . '');

if (isset($_SESSION['form_submitted']) && $_SESSION['form_submitted'] == true) { //đã nộp bài không cho quay lại show 404
    include '404_error.php';
} else {
    date_default_timezone_set('Asia/Ho_Chi_Minh'); // lấy mũi giờ thời gian 
    $time_begin = date('Y-m-d H:i:s');

    $lich_su = [
        'lecture_id' =>  $_GET['lecture_id'],
        'username' => $username,
        'score' => 0,
        'time_begin' => $time_begin
    ];
    //lưu csdl thông tin khi bắt đầu làm bài
    insert('history_quizz', $lich_su);
    $id = mysqli_insert_id($conn); // lấy id của quizz đang làm
?>
    <!-- Thông tin khóa học -->
    <div class="d-flex align-items-center p-3 my-3 bg-purple rounded shadow">
        <div class="lh-1">
            <h2 class="mb-0 lh-1">Khóa học: <?= $data_course['course_title'] ?></h2>
            <p class="fw-medium fs-5 mt-2"><?= $data_lecture['lecture_title'] ?></p>
        </div>
    </div>
    <!-- Bắt đầu Khung hien thi cau hoi quizz -->
    <?php
    $data = getArray('lecture_questions', "lecture_id={$_GET['lecture_id']} AND status=1 ORDER BY RAND()", 5);
    if ($data && $data->num_rows >= 5) {
    ?>
        <form id="id_form" action="update_quizz.php?course_id=<?= $_GET['course_id'] ?>&lecture_id=<?= $_GET['lecture_id'] ?>" method="post">
            <div class="d-flex align-items-center justify-content-center m-auto p-3 my-3 bg-purple rounded shadow" style="width: 60%;">
                <!-- gán id quizz truyền qua form -->
                <input type="hidden" name="history_id" value="<?= $id ?>">
                <div class="row">
                    <?php
                    $i = 1; //stt
                    $ds_question = []; // mảng lưu danh sách id câu hỏi quizz hiện tại
                    foreach ($data as $question) :
                        $ds_question[] = $question['id']; // add từng id câu hỏi vào mảng lưu danh sách câu hỏi
                    ?>
                        <div class="col-12 mb-3">
                            <div class="card rounded-4 p-3">
                                <h5 class="card-title">Câu <?= $i++ ?>: <?= $question["question_name"] ?></h5>

                                <div class="form-group">
                                    <img src='<?= $question['image'] ?>' height='200px'>
                                </div>
                                <?php
                                $data_answer = getArray('answers', 'question_id=' . $question["id"] . '');
                                while ($data2 = mysqli_fetch_assoc($data_answer)) {
                                    if ($question['type'] == "single_choice") { // dạng là 1 lựa chọn kiểu: radio
                                ?>
                                        <div class="form-check p-3">
                                            <input class="form-check-input" name="choice_<?= $question['id'] ?>" type="radio" value="<?= $data2['id'] ?>">
                                            <label class="form-check-label text-break"><?= $data2['answer_name'] ?></label>
                                        </div>
                                    <?php
                                    } elseif ($question['type'] == "multiplechoice") { // dạng nhiều lựa chọn kiểu:checkbox
                                    ?>
                                        <div class='form-check p-3'>
                                            <input class="form-check-input" name="choice_<?= $question['id'] ?>[]" value="<?= $data2['id'] ?>" type='checkbox'>
                                            <label class='form-check-label text-break' value=''><?= $data2['answer_name'] ?></label>
                                        </div>

                                    <?php
                                    } else { // dạng điền : input text
                                    ?>
                                        <div class="form-check p-3">
                                            <label class='form-label'>Nhập đáp án:</label>
                                            <input class="form-control" name="fill_<?= $question['id'] ?>" type="text">
                                        </div><?php
                                            }
                                        } ?>
                            </div>
                        </div>

                    <?php
                        $_SESSION['ds_question'] = $ds_question; // lưu mảng d.sach c.hoi vào session
                    endforeach;

                    ?>
                </div>
            </div>
            <div style="position: fixed;left: 87%;top: 40vh;" id="countdown"></div>
            <button style="position: fixed;left: 90%;top: 50vh;" data-bs-toggle="modal" data-bs-target="#cf" type="button" class="btn btn-info">Nộp
                bài</button>
            <!-- Modal confirm nộp bài -->
            <div class="modal" id="cf" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Nộp bài</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Bạn sẽ không thể thay đổi sau khi nộp bài</p>
                        </div>
                        <div class="modal-footer justify-content-between mx-5">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Quay lại</button>
                            <button type="submit" class="btn btn-success" data-bs-dismiss="modal">Nộp bài</button>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    <?php
    } else { ?>
        <p>Số lượng câu hỏi không đủ</p>
        <a class="btn btn-primary" href="bai_giang.php?course_id=<?= $_GET['course_id'] ?>&lecture_id=<?= $_GET['lecture_id'] ?>">Trở lại</a>
<?php }
}
?>

<?php include 'footer.php' ?>
<script>
    window.addEventListener('beforeunload', function(e) {
        <?php if (!$_SESSION['form_submitted']) : ?>
            <?php $_SESSION['form_submitted'] = false; ?>
        <?php endif; ?>
    });

    // Thời gian bắt đầu làm bài:  phút
    var thoiGianLamBai = 20; // đơn vị là giây
    var target_date = new Date().getTime() + thoiGianLamBai * 1000; // thời điểm kết thúc làm bài

    var countdown = document.getElementById('countdown');

    setInterval(function() {

        var current_date = new Date().getTime(); //thời gian hiện tại
        var seconds_left = Math.max(0, Math.floor((target_date - current_date) /
            1000)); // đảm bảo không hiển thị số âm

        var minutes = Math.floor(seconds_left / 60);
        var seconds = seconds_left % 60;
        if (seconds_left <= 0) {
            document.getElementById('id_form').submit();
        }
        countdown.innerHTML = '<span class="fs-4 fw-bold"> Thời gian: ' + minutes + ":" + seconds + '</span>';
    }, 1000);
</script>