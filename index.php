<?php 

if(isset($_POST['submit'])){
	if (isset($_POST['iduser'])) {
        $iduser = $_POST['iduser'];
        $pass = $_POST['pass'];
        echo "<script type='text/JavaScript'>";
        echo "alert('ID User: $iduser')";
        echo "alert('ID User: $pass')";
        echo "</script>";
    }
}
session_start()

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Index</title>
</head>
<body>
	<form method="POST" action="index.php">
        id: <input type="text" name="iduser"><br>
        password: <input type="password" name="pass"><br>
        <?php 
            if(isset($_GET['redirect'])){
                $url = $_GET['redirect'];
                echo "<input type='hidden' name='redirect' value='$url'>";
            }
        ?>
        <input type="submit" name="submit" value="login">
    </form>
</body>
</html>

<?php 
// <- UNTUK DAFTAR SALT
if(isset($_POST['submit'])){
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
    $iduser = $_POST['iduser'];
    $pass = $_POST['pass'];
	$stmt->bind_param("s", $iduser);
	$stmt->execute();
	$res = $stmt->get_result();
	if($row = $res->fetch_assoc()){
		$salt = $row['salt'];
		$md5pass = md5($pass);
		$combinepass = $md5pass.$salt;
		$finalpass = md5($combinepass);
		if($row['password']===$finalpass){
			$_POST['user'] = $row['idusers'];
            $_POST['nama'] = $row['nama'];
			echo "<script type='text/JavaScript'>";
			echo "alert('Login Sukses')";
			echo "</script>";
			if(isset($_GET['redirect'])){
                header("location: ".$_POST['redirect']);
                }
            else{
                header("location: home.php");
            }
		}
		else{
			echo "<script type='text/JavaScript'>";
			echo "alert('Gagal Login! Password/Username Salah!')";
			echo "</script>";
            echo "Password : ".$row['password']."<br>";
            echo "Pembanding : $finalpass";
		}

	}
	else{
		echo "<script type='text/JavaScript'>";
		echo "alert('Tidak ada data!')";
		echo "</script>";
		
	}
	$con->close();
	$stmt->close();
}
?>