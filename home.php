<?php 
$con = new mysqli("localhost", "root", "", "fsp_uas");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type='text/css' href="uas.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <title>HOME</title>
</head>
<body>
    <h1>CERBUNG</h1>
    <h3>Cerita Bersambung</h3>
    <div id='Container-Home'>
        <div class='card_generalkiri'>
            <h2>Ceritaku</h2><br>
            <?php 
            $idusers = "160421054";
            $limit = "%";
            if(isset($_GET['limit'])){
                $limit = $_GET['limit'];
            }else{
                $limit = "2";
            }
            ?>
            <script>
                var id = "<?php echo $idusers; ?>";
                var limit = "<?php echo $limit; ?>";
                $.post('ajax_paging_kiri.php', {iduser:id, limit:limit}).done(function
                (data){
                    var ceritas = JSON.parse(data);
                    $.each(ceritas, function(i, item){
                        $(".card_generalkiri").append("<div id='"+item.idcerita+"' class='card_cerbung'><h2 class='judulCeritaku'>"+item.judul+"</h2><p class='isicard'>Jumlah Paragraf : "+item.jumlah_paragraf+"</p><a href class='isicard'>Baca Lebih Lanjut</a></div>");
                    });
                    $(".card_generalkiri").append("<button id='btnTampilkanCeritaku'>Tampilkan Cerita Selanjutnya</button>");
                    $("#btnTampilkanCeritaku").click(function(){
                window.location.href = "home.php?limit=100";
                });
            
            
                });
            </script>
        
        </div>
        <div id='garis_vertikal'></div>
        <div class='card_generalkanan'>
            <h2>Kumpulan Cerita</h2><br>
            <?php 
            $stmt = $con->prepare("select c.idcerita, c.judul, c.idusers_pembuat_awal, count(p.idparagraf) as jumlah_paragraf 
            from cerita c right join paragraf p on c.idcerita = p.idcerita where c.idusers_pembuat_awal not like ? group by c.idcerita limit ? ;");   
            $idusers = "160421054";
            $limit = "%";
            if(isset($_GET['limitcer'])){
                $limit = $_GET['limitcer'];
            }else{
                $limit = "8";
            }
            // $stmt->bind_param("si", $idusers, $limit);
            // $stmt->execute();
            // $res = $stmt->get_result();
            // while($row = $res->fetch_assoc()){
            //     echo "<div id='".$row['idcerita']."' class='card_cerbung'>
            //     <h2 class='judulCeritaku'>".$row['judul']."</h2>
            //     <p class='isicard'>Jumlah Paragraf : ".$row['jumlah_paragraf']."</p>
            //     <a href class='isicard'>Baca Lebih Lanjut</a>
            //     </div>";
            // }
            ?>
            <script>
            var id = "<?php echo $idusers; ?>";
            var limit = "<?php echo $limit; ?>";
            $.post('ajax_paging_kanan.php', {iduser:id, limit:limit}).done(function
            (data){
                var ceritas = JSON.parse(data);
                $.each(ceritas, function(i, item){
                    $(".card_generalkanan").append("<div id='"+item.idcerita+"' class='card_cerbung2'><h2 class='judulCeritaku'>"+item.judul+"</h2><p class='isicard'>Pemilik : "+item.nama+"</p><br><p class='isicard'>Jumlah Paragraf : "+item.jumlah_paragraf+"</p><a href class='isicard'>Baca Lebih Lanjut</a></div>");
                });
                $(".card_generalkanan").append("<button id='btnTampilKumpulanCerita'>Tampilkan Cerita Selanjutnya</button>");
                $("#btnTampilKumpulanCerita").click(function(){
            window.location.href = "home.php?limitcer=100";
            });
            
            
            });
        
            </script>
            
        </div>
    </div>
    <div id='Hide-Container'>
        <br>
        <p>Ketegori : </p>
        <select name="cboKategori" id="cbokategori"> 
            <option id='optKumpulancerita slc' value="kumpulancerita">Kumpulan Cerita</option>
            <option id='optCeritaku' value="ceritaku">Ceritaku</option>
        </select>
        <div id='Container-Kecil'>
            <h1>Kumpulan Cerita</h1>
            <div id='card_cerita'>
                <div class='card_cerbung_kecil'>
                    <h2 class='judulCeritaku'>CERIAKU</h2>
                    <p class='item_kecil'>penulis : Dummy</p>
                    <p class='item_kecil'>jumlah par : 2</p>
                </div>
                <?php 
                $idusers = "160421054";
                $limit = "%";
                if(isset($_GET['limitkecil'])){
                    $limit = $_GET['limitkecil'];
                }else{
                    $limit = "4";
                }
                
                ?>
                <script>
                    
                var id = "<?php echo $idusers; ?>";
                var limit = "<?php echo $limit; ?>";
                $.post('ajax_paging_kanan.php', {iduser:id, limit:limit}).done(function
                (data){
                    var ceritas = JSON.parse(data);
                    $.each(ceritas, function(i, item){
                        $("#card_cerita").append("<div id='"+item.idcerita+"' class='card_cerbung_kecil'><h2 class='judulCeritaku'>"+item.judul+"</h2><p class=''>Pemilik : "+item.nama+"</p><br><p class=''>Jumlah Paragraf : "+item.jumlah_paragraf+"</p><a href class='isicard'>Baca Lebih Lanjut</a></div>");
                    });
                    $(".card_cerita").append("<button id='btnTampilKumpulanCerita'>Tampilkan Cerita Selanjutnya</button>");
                    $("#btnTampilKumpulanCerita").click(function(){
                window.location.href = "home.php?limitkecil=100";
                });
                
                
                });
            
                </script>
            </div>
        </div>
    </div>
    <script>
        
        $("#btnTampilKumpulanCerita").click(function(){
            window.location.href = "home.php?limitcer=100";
        });
    </script>
</body>
</html>