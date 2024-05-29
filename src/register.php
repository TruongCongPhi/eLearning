<?php
include '../function.php';
    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $rePassword = $_POST['repassword'];
        $errorMessage = '';

        // Kiểm tra đăng ký
        if (checkRegister($username, $password, $rePassword, $errorMessage)) {
            header("location: login.php");
        }
    }

    function checkRegister($username, $password, $rePassword, &$errorMessage)
    {
        include '../connectdb.php';
        
        

        // Kiểm tra tên tài khoản và mật khẩu không trống
        if (empty($username) || empty($password) || empty($rePassword)) {
            $errorMessage = '<div class="alert alert-warning text-center" role="alert">Vui lòng điền đầy đủ thông tin</div>';
            return false;
        }

        // Kiểm tra mật khẩu và nhập lại mật khẩu khớp nhau
        if ($password !== $rePassword) {
            $errorMessage = '<div class="alert alert-warning text-center" role="alert">Mật khẩu và nhập lại mật khẩu không khớp</div>';
            return false;
        }

        // Kiểm tra tên tài khoản đã tồn tại hay chưa
        $result =get('users', 'username="' . $username . '"');
        
        if ($result) {
            $errorMessage = '<div class="alert alert-danger text-center" role="alert">Tên tài khoản đã tồn tại</div>';
            return false;
        }

        // Thêm tài khoản mới vào cơ sở dữ liệu
        $hashedPassword = md5($password);
        $insert_query = insert("users",['username'=>$username, 'password' => $hashedPassword, 'role' => 0]);
        if ($insert_query) {
            $errorMessage = '<div class="alert alert-success text-center" role="alert">Đăng ký thành công.</div>';
            return true;
        } else {
            $errorMessage = '<div class="alert alert-danger text-center" role="alert">Đăng ký không thành công. Vui lòng thử lại sau</div>';
            return false;
        }
    }
    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <!-- Begin bootstrap cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- End bootstrap cdn -->

</head>

<body>

    <!-- <div class="alert alert-danger text-center" role="alert">Mẫu:Tài khoản hoặc mật khẩu không chính xác</div> -->
    <?php if (!empty($errorMessage)) {
        echo $errorMessage;
    } ?>

    
<section class="vh-100 bg-image">
  <div class="mask d-flex align-items-center h-100 gradient-custom-3">
    <div class="container h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-9 col-lg-7 col-xl-6">
          <div class="card" style="border-radius: 15px;">
            <div class="card-body p-5">
              <h2 class="text-uppercase text-center mb-5">Đăng ký</h2>

              <form method="post">

                <div data-mdb-input-init class="form-outline mb-4">
                  <input type="text" name="username" id="form3Example1cg" class="form-control form-control-lg" placeholder="Tên tài khoản" />
                </div>

                <div data-mdb-input-init class="form-outline mb-4">
                  <input type="password" name="password" id="form3Example4cg" class="form-control form-control-lg" placeholder="Mật khẩu" />
                </div>

                <div data-mdb-input-init class="form-outline mb-4">
                  <input type="password" name="repassword" id="form3Example4cdg" class="form-control form-control-lg" placeholder="Nhập lại mật khẩu " />
                </div>

                <div class="d-flex justify-content-center">
                  <button  type="submit" name="submit" data-mdb-button-init
                    data-mdb-ripple-init class="btn btn-success btn-block btn-lg gradient-custom-4 text-body">Đăng ký</button>
                </div>

                <p class="text-center text-muted mt-5 mb-0">Bạn đã có tài khoản <a href="login.php"
                    class="fw-bold text-body"><u>Đăng nhập</u></a></p>

              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</body>



</html>

