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
        $data = getArray('lecture_questions', 'lecture_id=' . $_GET['lecture_id'] . ' ORDER BY RAND()', 1);

        ?>
        <div class="row">
            <?php $i = 1 ?>
            <?php foreach ($data as $question) : ?>


                <?php
                $id_answer = "";
                if (isset($_POST['submit']) && isset($_POST['name_' . $question["id"]])) {
                    $id_answer = $_POST['name_' . $question["id"]];
                }
                ?>
                <div class="col-12 mb-3">
                    <div class="card rounded-4 p-3">

                        <p class="fw-bold fs-5">Câu <?= $i++ ?>: </p>
                        <!-- HIen thi cau hoi -->
                        <h5 class="card-title"><?= $question["question_name"] ?></h5>

                        <!-- Anh cau hoi -->
                        <div class="form-group">
                            <img src='<?= (!is_null($question['image'])) ? $question['image'] : '' ?>' height='200px'>
                        </div><br>

                        <!-- Dieu kien cau hoi  -->

                        <!-- hien thi dap an -->



                        <!-- kiem tra gia tri ton tai cua dap an da chon -->


                        <?php
                        $data_answer = getArray('answers', 'question_id=' . $question["id"] . '');


                        while ($data2 = mysqli_fetch_assoc($data_answer)) {
                            // dap an dung
                            $data_dap_an = get_correct_answer($question['id']);
                            if ($question['type'] == "single_choice") {

                        ?>
                                <div class="form-check p-3">
                                    <!-- gan cho moi dap an 1 value la id trong bang answer  -->
                                    <input class="form-check-input" name="answer_<?= $question['id'] ?>" type="radio" value="<?= $data2['id'] ?>" <?= ($id_answer == $data2['id']) ? 'checked' : '' ?>>
                                    <label class="form-check-label text-break"><?= $data2['answer_name'] ?></label>
                                </div>
                        <?php
                            }
                        } ?>

                    </div>


                </div>


            <?php endforeach; ?>



        </div>


    </div>

    <input style="position: fixed;left: 90%;top: 50vh;" id="nopBaiQuiz" type="submit" class="btn btn-info" name="submit" value="Nộp bài">





</form>

<?php

if (isset($_POST['submit'])) {
    foreach ($data_dap_an as $dap_an) {
$question = $data_dap_an['id'];
        if (in_array($id_answer, $data_dap_an)) { 

            echo $question. "Dung";
        
        } else { 
            echo $question."sai";
        }
    }
    ?>


<?php
}

?>













<script>
    document.getElementById('nopBaiQuiz').addEventListener('click', function(event) {
        event.preventDefault(); // Ngăn chặn mặc định hành vi của nút submit

        // Hiển thị thông báo
        var notificationDiv = document.getElementById('notification');
        notificationDiv.style.display = 'block';
       
    });
</script>
<script src=" https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<?php include 'footer.php' ?>