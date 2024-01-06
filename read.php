<?php
$con = new mysqli("localhost", "root", "", "fsp_uas");
$uid = $_GET['iduser'];
$idcerita = $_GET['idcerita'];

$stmt = $con->prepare("select * from cerita where idcerita = ?");
$stmt->bind_param("i", $idcerita);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
echo "<h1>".$row['judul']."</h1>";

$stmt = $con->prepare("select * from paragraf where idcerita=?");
$stmt->bind_param("i", $idcerita);
$stmt->execute();
$result = $stmt->get_result();
while($row=$result->fetch_assoc()){
    echo "<p>".$row['isiparagraf']."</p>";
}

echo "<form action='read.php?idcerita=$idcerita&iduser=$uid' method='post'>";

echo "<br>";
echo "<p>Tambah Paragraf</p>";
echo "<textarea value='test' name='tambahpar' rows='7' cols='25'> </textarea>";
echo "<input type='text' name='idcerita' value='".$idcerita."' hidden>";
echo "<input type='text' name='uid' value='".$uid."' hidden>";
echo "<br>";
echo "<br>";
echo "<input type='submit' id='btn' name='btnSimpan' value='Simpan'>";
echo "<br>";
echo "<br>";

echo "<a href='home.php?uid=$uid'><< Kembali ke Halaman Awal</a>";

echo "</form>";

if(isset($_POST['btnSimpan'])){
    $para = $_POST['tambahpar'];
    $stmt = $con->prepare("insert into paragraf (idusers, idcerita, isiparagraf) values(?,?,?)");
    $stmt->bind_param("sis", $uid, $idcerita, $para);
    $stmt->execute();
    header("location:read.php?idcerita=$idcerita&iduser=$uid");
    exit();
}

?>
<html>
    <script>
        // $("#btn").click(function(){
        //     document.addEventListener('DOMContentLoaded', function() {
        //     // Bersihkan data formulir setelah halaman dimuat
        //     document.getElementById("idcerita").value = "";
        //     });
        // });
    </script>
</html>