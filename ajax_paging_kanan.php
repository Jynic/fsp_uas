<?php 
$idusers = $_POST['iduser'];
$limit = $_POST['limit'];

$con = new mysqli("localhost", "root", "", "fsp_uas");
$sql = "select c.idcerita, c.judul, u.nama, count(p.idparagraf) as jumlah_paragraf 
from cerita c right join paragraf p on c.idcerita = p.idcerita inner join users u on c.idusers_pembuat_awal=u.idusers where c.idusers_pembuat_awal not like ? group by c.idcerita limit ? ;";
$stmt = $con->prepare($sql);
$stmt->bind_param("si", $idusers, $limit);
$stmt->execute();
$result = $stmt->get_result();
while($row=$result->fetch_assoc()){
	$idcerita = $row['idcerita'];
	$judul = $row['judul'];
    $nama = $row['nama'];
    $jumlah_paragraf = $row['jumlah_paragraf'];
	$ceritas = array('idcerita'=>"$idcerita", 'judul'=>"$judul", 'nama'=>"$nama", 'jumlah_paragraf'=>"$jumlah_paragraf");
	$data_cerita[] = $ceritas;

}
echo json_encode($data_cerita);

 ?>