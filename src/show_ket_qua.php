<?php include 'navbar.php';
$_SESSION['form_submitted'] = true;
$quizz_data = get('history_quizz', "id={$_GET['id_quizz']}");
?>

<div>
    <!-- thông báo  -->
    <?php
    if ($quizz_data['score'] < 80) {
        echo "<div class='alert alert-warning d-flex align-items-center' role='alert'>
        Bạn chưa đủ điểm đạt. Hãy tích cực luyện tập thêm!!
    </div>
    ";
    } else {
        echo " <div class='alert alert-success  'role='alert'>
    Chúc mừng bạn đã hoàn thành bài quizz!
    </div>
";
    }
    ?>



    <div class="align-items-center p-3 my-3 bg-purple rounded shadow m-auto" style="width: 60%;">
        <div class="vstack gap-3">
            <div class="p-2">Họ và tên: <?= $_SESSION["username"] ?></div>
            <div class="p-2">Điểm số: <?= $quizz_data['score'] ?>%</div>
            <div class="p-2">Thời gian nộp bài:
                <?= $quizz_data['time_finish'] ?></div>
        </div>
        <div class="p-3 d-flex">
            <a href="chi_tiet_dap_an.php?id_quizz=<?= $_GET['id_quizz'] ?>" class="btn btn-info me-2">Xem chi tiết</a>
            <a href="lich_su_quizz.php?id_quizz=<?= $_GET['id_quizz'] ?>" class="btn btn-danger">Thoát</a>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>