<?php
include 'connectdb.php';
session_start();
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
				$user_role_all = get('users', 'username="' . $username . '"')['role'];


				$_SESSION['username'] = $username;
				$_SESSION['role_all'] = $user_role_all;
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

// check Khóa học
function checkKhoaHoc()
{
	if (!isset($_GET['course_id'])) {
		header("location: khoa_hoc.php");
		exit();
	}
}

// check quyền khóa học
function checkRoleCourse($course_id, $username)
{
	$condition = "course_id={$course_id} AND username='{$username}";
	$user_role_course = get('course_management', $condition)['role'];
	return $user_role_course;
}

// lấy một
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

//lấy danh sách 
function getArray($tableName, $condition)
{
	global $conn;
	if (empty($condition)) {
		$query = "SELECT * FROM $tableName";
	} else {
		$query = "SELECT * FROM $tableName WHERE $condition";
	}
	//var_dump($query);
	$result = mysqli_query($conn, $query);
	if ($result && $result->num_rows > 0) {
		return $result;
	} else {
		return null;
	}
}

//lấy từ nhiều bảng lk
function getJoin($selectFields, $fromTable, $joins, $conditions)
{
	global $conn;
	$select = implode(', ', $selectFields);
	$from = $fromTable;
	$join = implode(' ', $joins);
	$where = !empty($conditions) ? "WHERE " . implode(' AND ', $conditions) : '';

	$query = "SELECT $select FROM $from $join $where";
	$result = mysqli_query($conn, $query);

	if ($result && $result->num_rows > 0) {
		$data = array();
		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
		return $data;
	} else {
		return null;
	}
}

//lấy danh sách sắp xép
function getArrayOrder($tableName, $condition1, $condition2, $limit)
{
	global $conn;

	if (!empty($condition1)) {
		$query = "SELECT * FROM $tableName WHERE $condition1 ORDER BY $condition2 LIMIT $limit";
	} else {
		$query = "SELECT * FROM $tableName ORDER BY $condition2 LIMIT $limit";
	}
	//var_dump($query);
	$result = mysqli_query($conn, $query);
	if ($result && $result->num_rows > 0) {
		return $result;
	} else {
		return null;
	}
}

//insert
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
function update($tableName, $condition, $columnValueArray = [])
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

//count 
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

//tìm kiếm người dùng
function searchUser($name)
{
	global $conn;
	$sql = "SELECT * FROM users WHERE username LIKE '%$name%'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		return $result;
	} else {
		return null;
	}
}
// check Ảnh
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

function uploadFile($file)
{
	$targetDirectory = "../uploads/";
	$imgFileType = strtolower(pathinfo($file, PATHINFO_EXTENSION));

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
}
