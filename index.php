<?php 
// <- UNTUK DAFTAR SALT
$con = new mysqli("localhost", "root", "", "fsp_uas");
// $salt = str_shuffle("project uas");      
// $md5pass = md5("160421054");
// $combinepass = $md5pass.$salt;
// $finalpass = md5($combinepass);
// $stmt = $con->prepare("update users set salt=?, password=? where idusers = '160421054';");
// $stmt->bind_param("ss", $salt, $finalpass);
// $stmt->execute();
// if($stmt->error){
//     echo "<script type='text/JavaScript'>";
//     echo "alert('Gagal Tambah Data')";
//     echo "</script>";
// }else{
//     echo "<script type='text/JavaScript'>";
//     echo "alert('Registrasi Succesfull')";
//     echo "</script>";
//     echo "Final pass : $finalpass";
//     echo "Salt : $salt<br>";
// }

$stmt = $con->prepare("select * from users where idusers=?");   
    $iduser = "160421054";
	$stmt->bind_param("s", $iduser);
	$stmt->execute();
	$res = $stmt->get_result();
	if($row = $res->fetch_assoc()){
		$salt = $row['salt'];
		$md5pass = md5("160421054");
		$combinepass = $md5pass.$salt;
		$finalpass = md5($combinepass);
		if($row['password']===$finalpass){
			echo "<script type='text/JavaScript'>";
			echo "alert('Login Sukses')";
			echo "</script>";
		}
		else{
			echo "<script type='text/JavaScript'>";
			echo "alert('Gagal Login! Password/Username Salah!')";
			echo "</script>";
            echo "Password : ".$row['password']."<br>";
            echo "Pembamding : $finalpass";
		}

	}
	else{
		echo "<script type='text/JavaScript'>";
		echo "alert('Tidak ada data!')";
		echo "</script>";
		
	}
?>