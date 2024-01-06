<?php

$idcerita = $_GET['idcerita'];
$uid = $_GET['uid'];
$result = $cerita->GetCerita($idcerita);


echo "<form action='addstory_proses.php' method='post'>";

echo "<br>";
echo "<p>Tambah Paragraf</p>";
echo "<textarea value='test' name='tambahpar' rows='7' cols='25'> </textarea>";
echo "<input type='text' name='idcerita' value='".$idcerita."' hidden>";
echo "<input type='text' name='uid' value='".$uid."' hidden>";
echo "<br>";
echo "<br>";
echo "<input type='submit' value='Simpan'>";
echo "<br>";
echo "<br>";

echo "<a href='home.php?uid=$uid'><< Kembali ke Halaman Awal</a>";

echo "</form>";

?>