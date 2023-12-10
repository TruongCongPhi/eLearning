<?php
$breadcrumb = [];
include 'navbar.php';

?>


<div class="" style="text-align: center;">
    <h2>Khóa học</h2>
</div>
<div class="row row-cols-1 row-cols-md-3 g-4" style="margin: 0 auto; width: 80%;">
    <!-- begin khóa học -->

    <?php
    $username = $_SESSION['username'];
    if ($username == 'admin') {
        $courses = getArray('courses', '');
    } else {
        $query = "SELECT courses.*
				FROM courses
				JOIN course_management ON courses.id = course_management.course_id
				WHERE course_management.username = '$username' ";
        $result = mysqli_query($conn, $query);
        if ($result && $result->num_rows > 0) {
            $courses = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $courses[] = $row;
            }
        }
    }
    ?>
    <div class="row row-cols-1 row-cols-md-3 g-4" style="margin: 0 auto; width: 80%;">
        <!-- Display courses -->
        <?php foreach ($courses as $course) : ?>
            <div class="col">
                <div class="card">
                    <img src="../images/khoahoc.jpg" class="card-img-top" alt="Course Image">
                    <div class="card-body">
                        <h5 class="card-title"><?= $course["course_title"] ?></h5>
                        <a class="btn btn-primary" href="bai_giang.php?course_id=<?= $course["id"] ?>">Truy cập</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <!-- end khóa học -->


</div>

<?php include 'footer.php'; ?>