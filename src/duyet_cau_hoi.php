<?php
include '../connectdb.php';
include '../function.php';
if ($_GET['task'] == 'confirm') {
    update('lecture_questions', ['status' => 1], 'id=' . $_GET['question_id'] . '');
    header("location: bien_tap.php?course_id={$_GET['course_id']}&lecture_id={$_GET['lecture_id']}");
} else {
    update('lecture_questions', ['status' => 0], 'id=' . $_GET['question_id'] . '');
    header("location: bien_tap.php?course_id={$_GET['course_id']}&lecture_id={$_GET['lecture_id']}");
}
