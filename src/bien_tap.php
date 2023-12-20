 <?php
    include 'navbar.php';
    checkKhoaHoc();
    checkTuan();
    $data_course = get('courses', 'id=' . $_GET['course_id'] . '');
    $data_lecture = get('lectures', 'id=' . $_GET['lecture_id'] . '');
    ?>
 <!-- điều hướng -->
 <nav aria-label="breadcrumb">
     <ol class="breadcrumb">
         <li class="breadcrumb-item"><a class="link-dark link-opacity-50 link-opacity-100-hover link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="khoa_hoc.php">Trang chủ</a></li>
         <li class="breadcrumb-item"><a class="link-dark link-opacity-50 link-opacity-100-hover link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="bai_giang.php?course_id=<?= $_GET['course_id'] ?>">Khóa học:
                 <?= $data_course['course_title'] ?></a>
         </li>

         <li class="breadcrumb-item"><a class="link-dark link-opacity-50 link-opacity-100-hover link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="bai_giang.php?course_id=<?= $_GET['course_id'] ?>"><?= $data_lecture['lecture_title'] ?></a></li>
         <li class="breadcrumb-item text-dark active" aria-current="page">Biên tập</li>
     </ol>
 </nav>
 <!-- thông tin khóa học -->
 <div class="d-flex align-items-center p-3 my-3 bg-purple rounded shadow">
     <div class="lh-1">
         <h2 class="mb-0 lh-1">Khóa học: <?= $data_course['course_title'] ?></h2>
         <p class="fw-medium fs-5 mt-2"><?= $data_lecture['lecture_title'] ?></p>
     </div>
 </div>
 <div class="dropdown show">
     <a class="btn btn-primary" href="bai_giang.php?course_id=<?= $_GET['course_id'] ?>">Trở lại</a>
     <a class="btn btn-outline-primary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         Thêm Câu hỏi
     </a>
     <div class="dropdown-menu">
         <a class="dropdown-item" href="cau_hoi_mot_dap_an.php?course_id=<?= $_GET['course_id'] ?>&lecture_id=<?= $_GET['lecture_id'] ?>" target="">Câu hỏi 1 đáp án</a>
         <a class="dropdown-item" href=' cau_hoi_nhieu_dap_an.php?course_id=<?= $_GET['course_id'] ?>&lecture_id=<?= $_GET['lecture_id'] ?>' target="">Câu hỏi nhiều đáp án đáp án</a>
         <a class="dropdown-item" href="cau_hoi_dien.php?course_id=<?= $_GET['course_id'] ?>&lecture_id=<?= $_GET['lecture_id'] ?>" target="">Câu hỏi điền</a>
     </div>
 </div>
 <br><br>

 <h2>Các câu hỏi đã đóng góp:</h2><br>
 <div class="">
     <table class="table table-striped table-bordered " id="myTable1">
         <thead>
             <tr>
                 <th title='Số thứ tự'>STT</th>
                 <th>Tên câu hỏi</th>
                 <th>Loại câu hỏi</th>
                 <th>Mức độ</th>
                 <?= ($role_course == 1 || $role_all > 0) ? "<th>Tác giả</th>" : '' ?>
                 <th>Trạng thái</th>
                 <th>Thời gian</th>
                 <th>Thao tác</th>
             </tr>
         </thead>
         <tbody class='table-group-divider'>
             <?php
                if ($role_course == 1 || $role_all > 0) {
                    $data_question = getArray('lecture_questions', "lecture_id={$_GET['lecture_id']}");
                } else {
                    $data_question = getArray('lecture_questions', "lecture_id={$_GET['lecture_id']} AND added_by= '{$_SESSION['username']}'");
                }
                ?>
             <?php
                $stt = 1;
                if ($data_question !== null) {
                    foreach ($data_question as $data) : ?>
                     <tr>
                         <td><?= $stt ?></td>
                         <td class='text-break' style='width:30%'><?= $data['question_name'] ?><br><img width='80%' alt='' src='<?= $data['image'] ?>'></td>
                         <td><?= $data['type'] ?></td>
                         <td><?php if ($data['level'] == 1) : echo 'Dễ';
                                elseif ($data['level'] == 2) : echo 'Bình thường';
                                elseif ($data['level'] == 3) : echo 'Khó';
                                endif; ?>
                         </td>
                         <?= ($role_course == 1 || $role_all > 0) ? '<td>' . $data['added_by'] . '</td>' : '' ?>
                         <td><?= ($data['status'] == 0) ? 'Chưa duyệt' : 'Đã duyệt' ?></td>
                         <td><?= date("H:i:s - d/m/y", strtotime($data['created_at'])) ?></td>

                         <td>
                             <div class="btn-group btn-group-sm">
                                 <a class='btn btn-sm btn-info me-1' href='xem_truoc_cau_hoi.php?course_id=<?= $_GET['course_id'] ?>&lecture_id=<?= $_GET['lecture_id'] ?>&question_id=<?= $data['id'] ?>' role='button'>Xem
                                     trước</a>
                                 <?php if ($role_course == 1 || $role_all > 0) {
                                        if ($data['status'] == 0) {
                                    ?>
                                         <a class='btn btn-sm btn-success me-1' href='duyet_cau_hoi.php?course_id=<?= $_GET['course_id'] ?>&lecture_id=<?= $_GET['lecture_id'] ?>&question_id=<?= $data['id'] ?>&task=confirm' role='button'>Duyệt</a>
                                     <?php
                                        } else {
                                        ?>
                                         <a class='btn btn-sm btn-warning me-1' href='duyet_cau_hoi.php?course_id=<?= $_GET['course_id'] ?>&lecture_id=<?= $_GET['lecture_id'] ?>&question_id=<?= $data['id'] ?>&task=cancel_confirm' role='button'>Hủy duyệt</a>
                                     <?php
                                        } ?>
                                     <a class='btn btn-sm btn-danger' href='xoa_cau_hoi.php?course_id=<?= $_GET['course_id'] ?>&lecture_id=<?= $_GET['lecture_id'] ?>&question_id=<?= $data['id'] ?>' role='button'>Xóa</a>
                                 <?php } ?>
                             </div>
                         </td>

                     </tr>
                 <?php
                        $stt++;
                    endforeach;
                } else { ?>
                 <td <?= ($role_course == 1 || $role_all > 0) ? 'colspan=8' : 'colspan=7' ?> align="center">Chưa có đóng
                     góp
                     câu hỏi nào</td>
             <?php } ?>
         </tbody>
     </table>
 </div>



 <?php include 'footer.php' ?>

 <script>
     $(document).ready(function() {
         $('#myTable1').DataTable({
             responsive: true
         });
     });
 </script>