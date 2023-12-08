<?php
include '../connectdb.php';
if (isset($_GET['id_cau_hoi'])) {
    $id_cau_hoi_xoa = $_GET['id_cau_hoi'];
    $query_update_trang_thai = "DELETE FROM cau_hoi WHERE id_cau_hoi = $id_cau_hoi_xoa";
    mysqli_query($conn, $query_update_trang_thai);
    header("location: bien_tap.php?id_khoa_hoc={$_GET['id_khoa_hoc']}");
}
