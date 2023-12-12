<?php include 'navbar.php';
isLogin2();
checkKhoaHoc();

$data = get('courses', 'id=' . $_GET['course_id'] . '');
$lecture_data = getArray('lectures', 'course_id=' . $data['id'] . '');
// $data2 = get('lecture_questions', 'id=' . $_GET['lecture_id'] . '');


?>

<!-- truy van lay id_lecture -->
<?php
    $lecture = get('lecture_questions', '');

    ?>

<div class="d-flex align-items-center p-3 my-3 bg-purple rounded shadow">
    <div class="lh-1">
        <h2 class="mb-0 lh-1">Khóa học: <?= $data['course_title'] ?></h2>
        <p class="mt-2"><?= $data['course_desc'] ?></p>
        <!-- nut back -->
    <div class="que">
        <a class="btn btn-primary" href="khoa_hoc.php">Trở lại</a>
    </div>
    </div>

    
</div>

<?php
if ($lecture_data && $lecture_data->num_rows > 0) {
    while ($row_lecture = mysqli_fetch_assoc($lecture_data)) {
?>
        <div class="my-3 p-3 bg-body border rounded shadow-sm">
            <h4 class="border-bottom pb-2 mb-0"><?= $row_lecture['lecture_title'] ?></h4>
            <?php
            $material_data =  getArray('materials', 'lecture_id=' . $row_lecture['id'] . '');
            if ($material_data && $material_data->num_rows > 0) {
                while ($row_material = mysqli_fetch_assoc($material_data)) {
                    switch ($row_material['type']) {
                        case "pdf":
                            $srcIcon = "../images/powerpoint-24.svg";
                            break;
                        case "quizz":
                            $srcIcon = "../images/quizz.svg";
                            break;
                    }
            ?>
                    <div class="d-flex text-body-secondary border-bottom pt-3">
                        <a href="quizz.php?lecture_id=<?= $lecture["lecture_id"] ?>&course_id=<?= $_GET['course_id']?>">
                            <img class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" src="<?= $srcIcon ?>" alt="Placeholder: 32x32" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false">
                        </a>
                        <div class="pb-4 mt-2 mb-0 small lh-sm w-100">
                            <div class="d-flex justify-content-between">
                                <a href="view_bai_giang.php" class="text-dark text-decoration-none"><?= (isset($row_material['material_title']) ? $row_material['material_title'] : '') ?>
                                </a>

                                <div>

                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                // Handle case where there are no materials
                echo '<p>Chưa có học liệu</p>';
            }
            ?>
            <small class="d-block text-end mt-3">
                <a href="bien_tap.php?course_id=<?= $_GET['course_id'] ?>&lecture_id=<?= $row_lecture['id'] ?>" class="btn btn-outline-primary btn-sm">Đóng góp</a>
            </small>
        </div>
<?php
    }
} else {
    echo '<p>chưa tải bài giảng lên .</p>';
}
?>

<?php include 'footer.php'; ?>