<?php 
$idusers = $_POST['iduser'];
$limit = $_POST['limit'];

$con = new mysqli("localhost", "root", "", "fsp_uas");
$sql = "select c.idcerita, c.judul, c.idusers_pembuat_awal, count(p.idparagraf) as jumlah_paragraf 
from cerita c right join paragraf p on c.idcerita = p.idcerita where c.idusers_pembuat_awal like ? group by c.idcerita limit ? ;";
$stmt = $con->prepare($sql);
$stmt->bind_param("si", $idusers, $limit);
$stmt->execute();
$result = $stmt->get_result();
while($row=$result->fetch_assoc()){
	$idcerita = $row['idcerita'];
	$judul = $row['judul'];
    $iduser = $row['idusers_pembuat_awal'];
    $jumlah_paragraf = $row['jumlah_paragraf'];
	$ceritas = array('idcerita'=>"$idcerita", 'judul'=>"$judul", 'iduser'=>"$iduser", 'jumlah_paragraf'=>"$jumlah_paragraf");
	$data_cerita[] = $ceritas;

}
echo json_encode($data_cerita);

 ?>