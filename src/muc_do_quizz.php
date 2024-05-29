<?php
include 'navbar.php';
$data_quizz = get('materials', "id={$_GET['quizz_id']}");
$sl_de = countt('lecture_questions', "lecture_id={$_GET['lecture_id']} AND status=1 AND level = 1");
$sl_vua = countt('lecture_questions', "lecture_id={$_GET['lecture_id']} AND status=1 AND level = 2");
$sl_kho = countt('lecture_questions', "lecture_id={$_GET['lecture_id']} AND status=1 AND level = 3");
?>
<!-- điều hướng -->
<a href="lich_su_quizz.php?course_id=<?= $_GET['course_id'] ?>&lecture_id=<?= $_GET['lecture_id'] ?>&quizz_id=<?= $_GET['quizz_id'] ?>"
    class="btn btn-primary">Trở
    lại</a>
<h1>Tùy chỉnh mức độ</h1>

<p>Số câu làm: <?= $data_quizz['count_questions'] ?></p>
<div>Số câu dễ: <?= $sl_de ?></div>
<div>Số câu vừa: <?= $sl_kho ?></div>
<div>Số câu khó: <?= $sl_vua ?></div>
<form method="post" action="">
    <div class="row">
        <div class="col-3">
            <div class="input-group">
                <span class="input-group-text">dễ:</span>
                <input type="number" class="form-control"
                    value="<?= isset($_POST['level1']) ? htmlspecialchars($_POST['level1']) : '' ?>" min="0"
                    name="level1" required>
            </div>
        </div>
        <div class="col-3">
            <div class="col-3 input-group">
                <span class="input-group-text">vừa:</span>
                <input type="number" class="form-control"
                    value="<?= isset($_POST['level2']) ? htmlspecialchars($_POST['level2']) : '' ?>" min="0"
                    name="level2" required>
            </div>

        </div>
        <div class="col-3">
            <div class="col-3 input-group">
                <span class="input-group-text">khó:</span>
                <input type="number" class="form-control"
                    value="<?= isset($_POST['level3']) ? htmlspecialchars($_POST['level3']) : '' ?>" min="0"
                    name="level3" required>
            </div>

        </div>

    </div>

    <button class="btn btn-success mt-3" name="submit" type="submit">Lưu</button>
</form>



<?php
if (isset($_POST['submit'])) {

    $de = $_POST['level1'];
    $vua = $_POST['level2'];
    $kho = $_POST['level3'];
    $count = $de + $vua + $kho;

    // if ($de == 0 || $vua == 0 || $kho == 0) {
    //     echo '<div class="alert alert-warning" role="alert">Yêu cầu phải có đầy đủ 3 mức độ</div>';
    //     return;
    // }
    if ($de > $sl_de) {
        echo '<div class="alert alert-warning" role="alert">Mức độ dễ vượt quá số lượng hiện có</div>';
        return;
    }
    if ($vua > $sl_vua) {
        echo '<div class="alert alert-warning" role="alert">Mức độ Vừa vượt quá số lượng hiện có</div>';
        return;
    }
    if ($kho > $sl_kho) {
        echo '<div class="alert alert-warning" role="alert">Mức độ Khó vượt quá số lượng hiện có</div>';
        return;
    }

    if ($count != $data_quizz['count_questions']) {
        // tổng mức độ != với tổng câu hỏi làm thì bao lỗi
        echo "<div class='alert alert-warning' role='alert'>tỷ lệ mức độ không đúng, yêu cầu tổng 3 mức độ bằng với số câu làm: {$data_quizz['count_questions']}!</div>";
        return;
    } else {
        $check = countt('custom_quizz', "username='{$username}'");
        if ($check > 0) {
            // kiểm tra đã có csdl thì update
            update('custom_quizz', "quizz_id={$_GET['quizz_id']}", ['username' => $username, 'count_lv1' => $de, 'count_lv2' => $vua, 'count_lv3' => $kho]);
            echo '<div class="alert alert-success" role="alert">Lưu thành công!</div>';
        } else {
            //chưa có csdl thì insert 
            insert('custom_quizz', ['username' => $username, 'quizz_id' => $_GET['quizz_id'], 'count_lv1' => $de, 'count_lv2' => $vua, 'count_lv3' => $kho]);
            echo '<div class="alert alert-success" role="alert">Lưu thành công!</div>';
        }
    }
}
?>

<?php include 'footer.php' ?>