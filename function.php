<?php
include 'connectdb.php';

// Begin Login function
function isLogin()
{
	// hàm kiểm tra đã đăng nhập chưa cho trang index
	return isset($_SESSION['username']);
}
function isLogin2()
{
	// hàm kiểm tra đã đăng nhập chưa cho các trang khác
	if (!isLogin()) {
		header("location: dang_nhap.php");
		exit();
	}
}


// begin checkLogin
function checkLogin($username, $password)
{
	// hàm kiểm tra tài khoản nhập đã đúng chưa
	include 'connectdb.php';
	$query = "SELECT * FROM users WHERE username = '$username'";
	$result = mysqli_query($conn, $query);
	if ($result) {
		$row = mysqli_fetch_assoc($result);
		if ($row > 0) {
			if ($username == $row['username'] && md5($password) == $row['password']) {
				session_start();
				$_SESSION['username'] = $username;
				if ($username == 'admin') {
					$_SESSION['quyen'] = 1;
				} else {
					$_SESSION['quyen'] = 0;
				}
				return true;
			} else {
				return false;
			}
		}
	}
}
// end checkLogin

// check vào Khóa học
function checkKhoaHoc()
{
	if (!isset($_GET['course_id'])) {
		header("location: khoa_hoc.php");
		exit();
	}
}


function get($table, $condition)
{
	global $conn;
	if (empty($condition)) {
		$query = "SELECT * FROM $table";
	} else {
		$query = "SELECT * FROM $table WHERE $condition";
	}
	//var_dump($query);
	$result = mysqli_query($conn, $query);
	if ($result->num_rows > 0) {
		return $result->fetch_assoc();
	} else {
		return null;
	}
}

//lấy nhiều bản ghi, mặc định là 50
function getArray($tableName, $condition, $limit = 50)
{
	global $conn;
	if (empty($condition)) {
		$query = "SELECT * FROM $tableName LIMIT $limit";
	} else {
		$query = "SELECT * FROM $tableName WHERE $condition LIMIT $limit";
	}
	//var_dump($query);
	$result = mysqli_query($conn, $query);
	if ($result && $result->num_rows > 0) {
		return $result;
	} else {
		return null;
	}
}
function getArrayOrder($tableName, $condition, $limit)
{
	global $conn;

	$query = "SELECT * FROM $tableName ORDER BY $condition LIMIT $limit";
	//var_dump($query);
	$result = mysqli_query($conn, $query);
	if ($result && $result->num_rows > 0) {
		return $result;
	} else {
		return null;
	}
}

//post
function insert($tableName, $columnValueArray = [])
{
	global $conn;
	$columns = array_keys($columnValueArray);
	$values = array_values($columnValueArray);
	$columnString = implode(", ", $columns);
	$valueString = implode("', '", $values);
	$query = "INSERT INTO $tableName($columnString) VALUES ('$valueString')";
	//var_dump($query);
	$result = mysqli_query($conn, $query);
	if ($result)
		return true;
	else
		return false;
}
//update
function update($tableName, $columnValueArray = [], $condition)
{
	global $conn;
	$statement = '';
	foreach ($columnValueArray as $key => $value) {
		$statement .= "$key='$value', ";
	}
	$statement = substr($statement, 0, -2);
	$query = "UPDATE $tableName SET $statement WHERE $condition";
	//var_dump($query);
	$result = mysqli_query($conn, $query);
	if ($result)
		return true;
	else
		return false;
}

//delete
function delete($tableName, $condition)
{
	global $conn;
	$query = "DELETE FROM $tableName WHERE $condition";

	$result = mysqli_query($conn, $query);
	if ($result) {
		return true;
	} else {
		return false;
	}
}

//count : đếm số lượng bản ghi trong bảng
function countt($tableName, $condition)
{
	global $conn;
	if (!empty($condition)) {
		$query = "SELECT * FROM $tableName WHERE $condition";
	} else {
		$query = "SELECT * FROM $tableName";
	}
	$result = mysqli_query($conn, $query);
	return $result->num_rows;
}

function checkImage($file)
{
	$targetDirectory = "../uploads/";
	$imgFileType = strtolower(pathinfo($file, PATHINFO_EXTENSION));
	$imgType = array("jpg", "jpeg", "png", "gif");

	if (in_array($imgFileType, $imgType)) {
		$i = 1;
		$newFileName = $file;
		while (file_exists($targetDirectory . $newFileName)) {
			$newFileName = pathinfo($file, PATHINFO_FILENAME) . "($i)." . $imgFileType;
			$i++;
		}

		$uploadOk = move_uploaded_file($_FILES['anh']['tmp_name'], $targetDirectory . $newFileName);

		if ($uploadOk) {
			$imgPath = $targetDirectory . $newFileName;
			return $imgPath;
		} else {
			return false;
		}
	} else {
		return false;
	}
}