<?php
include 'navbar.php';
checkKhoaHoc();
checkTuan();

$_SESSION['form_submitted'] = false; // dùng session theo dõi đã nộp bài chưa

$data_course = get('courses', 'id=' . $_GET['course_id'] . '');
$data_lecture = get('lectures', 'id=' . $_GET['lecture_id'] . '');
$count_quizz = countt('history_quizz', "username ='{$_SESSION["username"]}'");
$stt = 1;
$data_quizz = get('materials', "id={$_GET['quizz_id']}");
if ($data_quizz['count_quizz'] == -1) {
    $luotlam = "không giới hạn";
} elseif ($data_quizz['count_quizz'] == 0) {
    $luotlam = "không được phép";
} else {
    $luotlam = $data_quizz['count_quizz'];
}

?>
<!-- điều hướng -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a
                class="link-dark link-opacity-50 link-opacity-100-hover link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"
                href="khoa_hoc.php">Trang chủ</a></li>
        <li class="breadcrumb-item"><a
                class="link-dark link-opacity-50 link-opacity-100-hover link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"
                href="bai_giang.php?course_id=<?= $_GET['course_id'] ?>">Khóa học:
                <?= $data_course['course_title'] ?></a>
        </li>

        <li class="breadcrumb-item"><a
                class="link-dark link-opacity-50 link-opacity-100-hover link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"
                href="bai_giang.php?course_id=<?= $_GET['course_id'] ?>"><?= $data_lecture['lecture_title'] ?></a></li>
        <li class="breadcrumb-item text-dark active" aria-current="page">Lịch sử quizz</li>
    </ol>
</nav>
<!-- thông tin khóa học -->
<div class="d-flex align-items-center p-3 my-3 bg-purple rounded shadow">
    <div class="lh-1">
        <h2 class="mb-0 lh-1">Khóa học: <?= $data_course['course_title'] ?></h2>
        <p class="fw-medium fs-5 mt-2"><?= $data_lecture['lecture_title'] ?></p>
    </div>
</div>

<?php if ($role_course == 1 || $role_all > 0) : ?>
<a class="btn btn-primary"
    href="tuy_chinh_quizz.php?course_id=<?= $_GET['course_id'] ?>&lecture_id=<?= $_GET['lecture_id'] ?>&quizz_id=<?= $_GET['quizz_id'] ?>">Tùy
    chỉnh Quizz</a>
<?php endif; ?>
<a class="btn btn-success"
    href="muc_do_quizz.php?course_id=<?= $_GET['course_id'] ?>&lecture_id=<?= $_GET['lecture_id'] ?>&quizz_id=<?= $_GET['quizz_id'] ?>">Tùy
    chỉnh mức độ</a>


<div class="align-items-center p-3 my-3 bg-purple rounded shadow">

    <p class="fs-4 fw-bold">Câu hỏi trắc nghiệm</p>
    <p class="fs-5">Số lần làm bài cho phép: <?= $luotlam ?> </p>

    <p class="fs-5">Số lượt bạn đã làm: <?php echo $count_quizz ?></p>
    <?php
    $score_max = 0;
    if ($count_quizz > 0) {
        $quizz_data = getArray('history_quizz', "username ='{$_SESSION["username"]}'");

        while ($row_quizz = $quizz_data->fetch_assoc()) {
            for ($i = 1; $i <= $count_quizz; $i++) {

                if ($row_quizz['score'] > $score_max) {
                    $score_max = $row_quizz['score'];
                }
            }

    ?>
    <p class="fs-5">Điểm làm bài lần <?= $stt ?> : <?= $row_quizz['score'] ?>%
        <?php
            $time_finish = new DateTime($row_quizz['time_finish']); // thời gian kết thúc quizz
            $time_finish->modify('+90 day'); // cộng 3 tháng (hạn là 3 tháng)
            $time_now = new DateTime(); // thời gian hiện tại

            // echo $time_now;
            if (($time_finish < $time_now)) {
                echo 'Đã hết hạn xem lại!!</p>';
            } else {
                echo '<a class=" ms-5 btn btn-sm btn-warning me-1" href="xem_lai_dap_an.php?course_id=' . $_GET["course_id"] . '&lecture_id=' . $_GET["lecture_id"] . '&id_quizz_detail=' . $row_quizz["id"] . '&quizz_id=' . $_GET['quizz_id'] . '">Xem chi tiết</a> 
           ';
                $interval = $time_now->diff($time_finish);

                // Hiển thị thời gian còn lại theo ngày
                echo "<span class='fs-6'>Còn " . $interval->format('%a ngày để xem lại') . "</span></p>";
            }
            $stt++;
        }
    } ?>
    <p class="fs-5 fw-medium">Điểm cao nhất: <?= $score_max ?>% </p>
    <?php
            $check_edit = get('custom_quizz', "username='{$username}'");
            if ($count_quizz >= $data_quizz['count_quizz'] && $data_quizz['count_quizz'] != -1) :
                // số lần làm vượt quá số quizz cho phép
            ?>
    <p> Bạn đã hết lượt làm bài cho phép</p>

    <?php
            elseif ($check_edit != null) : ?>
    <a type="button" class="btn btn-info"
        href="quizz.php?course_id=<?= $_GET['course_id'] ?>&lecture_id=<?= $_GET['lecture_id'] ?>&quizz_id=<?= $_GET['quizz_id'] ?>">Bắt
        đầu</a>

    <?php else : ?>
    <p class="fs-4 text-warning"> Vui lòng tùy chỉnh mức độ để bắt đầu</p>

    <?php
            endif; ?>
</div>