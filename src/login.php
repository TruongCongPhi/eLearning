<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <!-- Begin bootstrap cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="	sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <!-- End bootstrap cdn -->

</head>

<body>
    <?php
    include '../function.php';
    if (isset($_SESSION['username'])) {
        header('location: khoa_hoc.php');
    }

    if (isset($_POST['submitLogin'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $errorMessge = false;
        if (checkLogin($username, $password) == true) {
            header("location: khoa_hoc.php");
        } else {
            $errorMessge = '<div class="alert alert-danger text-center" role="alert">Tài khoản hoặc mật khẩu không chính xác</div>';
        }
    }

    ?>

    <!-- <div class="alert alert-danger text-center" role="alert">Mẫu:Tài khoản hoặc mật khẩu không chính xác</div> -->
    <?php if (isset($errorMessge)) {
        echo $errorMessge;
    } else {
        echo "";
    } ?>

    
    <main class="mt-5" style="min-height: 100vh; position: relative;">
        <!-- Toast -->
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 5">
            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
                <div class="toast-header">
                    <img style="height: 50px; " src="../images/hiToast.gif" class="rounded me-2" alt="...">
                    <strong class="me-auto">NHÓM 13-K71 CNTT</strong>
                    <small class="text-body-secondary">1 phút trước</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    Trương Công Phi và Bùi Hải Nam xin chào các bạn!
                </div>
            </div>
        </div>

        <!-- Form Login -->
        <div class="d-flex justify-content-center">
            <h1>Đăng nhập</h1>
        </div>
        <div class="d-flex justify-content-center">
            <form class="w-25" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Nhập username"
                        required>
                </div>
                <div class="mb-3">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                    <div class="col">
                        <input type="password" class="form-control" id="inputPassword" placeholder="Nhập Password"
                            name="password" required>
                    </div>
                </div>
                <input type="submit" class="btn btn-primary" name="submitLogin" value="Đăng nhập">
                <p class="text-center text-muted mt-3 mb-0">Bạn chưa có tài khoản <a href="register.php"
                    class="fw-bold text-body"><u>Đăng ký</u></a></p>
            </form>
        </div>
        


    </main>
    <?php include 'footer.php'; ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const toastEl = new bootstrap.Toast(document.querySelector('.toast'));
        toastEl.show();
    });
    </script>
</body>



</html>