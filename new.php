<?php 
// if(isset($_POST['iduser'])){
//    continue; 
// }else{
//     header("location:home.php");
// }
$iduser = "160421054";
if(isset($_POST['submit'])){
    $judul = $_POST['txtJudul'];
    $para = $_POST['txtParagraf'];
    $con = new mysqli("localhost", "root", "", "fsp_uas");
    $stmt = $con->prepare("INSERT INTO cerita (judul, idusers_pembuat_awal) VALUES (?, ?)");
    if (!$stmt) {
        die("Gagal mempersiapkan pernyataan cerita: " . $con->error);
    }

    $stmt->bind_param("ss", $judul, $iduser);
    if (!$stmt->execute()) {
        die("Gagal menjalankan pernyataan cerita: " . $stmt->error);
    }

    $ceritaId = $con->insert_id;

    $stmt = $con->prepare("INSERT INTO paragraf (idusers, idcerita, isiparagraf) VALUES (?, ?, ?)");
    if (!$stmt) {
        die("Gagal mempersiapkan pernyataan paragraf: " . $con->error);
    }

    $stmt->bind_param("sis", $iduser, $ceritaId, $para);
    if (!$stmt->execute()) {
        die("Gagal menjalankan pernyataan paragraf: " . $stmt->error);
    }
    echo "<script>alert('Tambah Data Berhasil')</script>";
    header("location:home.php");
}


?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.7.0.js"></script>
	<title>Insert Movie</title>
</head>
<body>
	<h1>Insert</h1>
<form method='POST' action='new.php' enctype="multipart/form-data">
	<fieldset>
		<legend>Required</legend>
		<p>
			<label>Masukan Judul : </label>
			<input type="text" name="txtJudul">
		</p>
		<p>
			<label>Masukan Paragraf Pertama : </label>
			<input type="text" name="txtParagraf">
		</p>
		
		<input type="submit" name="submit" value="Submit">
		<input type="hidden" name='Create'>
	</fieldset>
</form>
<script type="text/javascript">
</script>
</body>
</html>