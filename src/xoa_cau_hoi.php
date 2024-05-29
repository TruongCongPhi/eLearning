<?php
include '../connectdb.php';
include '../function.php';

if (isset($_GET['question_id'])) {
    $old_path = get('lecture_questions', "id={$_GET['question_id']}")['image'];
    if ($old_path != null) {
        unlink($old_path); // Xóa file cũ
    }
    $delete_question = delete('lecture_questions', 'id=' . $_GET['question_id'] . '');
    if ($delete_question) {
        header("location: bien_tap.php?course_id={$_GET['course_id']}&lecture_id={$_GET['lecture_id']}");
    }
}
