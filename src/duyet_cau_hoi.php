<?php
include '../function.php';
if ($_GET['task'] == 'confirm') {
    update('lecture_questions', 'id=' . $_GET['question_id'] . '', ['status' => 1]);
    header("location: bien_tap.php?course_id={$_GET['course_id']}&lecture_id={$_GET['lecture_id']}");
} else {
    update('lecture_questions', 'id=' . $_GET['question_id'] . '', ['status' => 0]);
    header("location: bien_tap.php?course_id={$_GET['course_id']}&lecture_id={$_GET['lecture_id']}");
}
