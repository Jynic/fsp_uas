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
    
    <div id='container-home'>
        <div class='card_generalkiri'>
            <div class="ceritaku">
                <h2>Ceritaku</h2><br>
                <button id="new">Buat Cerita Baru</button>
            </div>
            <div class="cerita_saya">
                <?php 
                if(isset($_GET['limitcer'])){
                    $limitcer = $_GET['limitcer'];
                }else{
                    $limitcer = "4";
                }
                
                $limit = "2";
                if(isset($_GET['limit'])){
                    $limit = $_GET['limit'];
                }else{
                    $limit = "2";
                }
                ?>
            </div>
        
        </div>
        <div id='garis_vertikal'></div>
        <div class='card_generalkanan'>
            <div class="ceritaku">
                <h2 >Kumpulan Cerita</h2>
            </div>
            <div class="kumpulan_cerita">
                <?php 
                $stmt = $con->prepare("select c.idcerita, c.judul, c.idusers_pembuat_awal, count(p.idparagraf) as jumlah_paragraf 
                from cerita c right join paragraf p on c.idcerita = p.idcerita where c.idusers_pembuat_awal not like ? group by c.idcerita limit ? ;");   
                $idusers = "160421054";
                // $limitcer = "%";
                
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
            </div>
            
        </div>
    </div>
    <div id='Hide-Container'>
        <br>
        <p>Ketegori : </p>
        <select name="cboKategori" id="cbokategori"> 
            <option id='optKumpulancerita' value="kumpulancerita">Kumpulan Cerita</option>
            <option id='optCeritaku' value="ceritaku">Ceritaku</option>
        </select>
        <div id='Container-Kecil'>
            <!-- <h1>Kumpulan Cerita</h1> -->
            <div id="title">

            </div>
            <div id='card_cerita'>
            </div>
            <button id='btnTampilKumpulanCerita'>Tampilkan Cerita Selanjutnya</button>
            <?php 
                if(isset($_GET['limitcer'])){
                    $limitcer = $_GET['limitcer'];
                }else{
                    $limitcer = "4";
                }
                
                $limit = "2";
                if(isset($_GET['limit'])){
                    $limit = $_GET['limit'];
                }else{
                    $limit = "2";
                }
                ?>
        </div>
    </div>
    
</body>
</html>

<script>
        var id = "<?php echo $idusers; ?>";
        var limit = "<?php echo $limit; ?>";
        var limitcer = "<?php echo $limitcer; ?>";

        // alert(limitcer);

        $.post('ajax_paging_kiri.php', {iduser:id, limit:limit}).done(function
        (data){
            var ceritas2 = JSON.parse(data);
            $.each(ceritas2, function(i, item){
                $(".cerita_saya").append("<div id='"+item.idcerita+"' class='card_cerbung'><h2 class='judulCeritaku'>"+item.judul+"</h2><p class='isicard'>Jumlah Paragraf : "+item.jumlah_paragraf+"</p><a href='read.php?idcerita=" + item.idcerita + "&iduser=" + id + "' class='isicard' id='yes'>Baca Lebih Lanjut</a></div>");
            });
            $(".card_generalkiri").append("<button id='btnTampilkanCeritaku'>Tampilkan Cerita Selanjutnya</button>");
            $("#btnTampilkanCeritaku").click(function(){
                limit =parseInt(limit) + 2;
                window.location.href = "home.php?limit="+limit+"&limitcer="+limitcer;
            });   
                 
            
        });

        
        $.post('ajax_paging_kanan.php', {iduser:id, limit:limitcer}).done(function
        (data){
            var ceritas1 = JSON.parse(data);
            $.each(ceritas1, function(i, item){
                $(".kumpulan_cerita").append("<div id='"+item.idcerita+"' class='card_cerbung2'><h2 class='judulCeritaku'>"+item.judul+"</h2><p class='isicard'>Pemilik : "+item.nama+"</p><br><p class='isicard'>Jumlah Paragraf : "+item.jumlah_paragraf+"</p><a href='read.php?idcerita=" + item.idcerita + "&iduser=" + id + "' class='isicard'>Baca Lebih Lanjut</a></div>");
            });
            $(".card_generalkanan").append("<button id='btnTampilKumpulanCerita'>Tampilkan Cerita Selanjutnya</button>");
            $("#btnTampilKumpulanCerita").click(function(){
                limitcer = parseInt(limitcer) + 2;

                // alert(limitcer); 
                // $.post('ajax_paging_kanan.php', {iduser:id, newLimit:limit}).done(function
                // (data){
                //     var ceritas = JSON.parse(data);
                //     $.each(ceritas, function(i, item){
                //         $(".kumpulan_cerita").append("<div id='"+item.idcerita+"' class='card_cerbung2'><h2 class='judulCeritaku'>"+item.judul+"</h2><p class='isicard'>Pemilik : "+item.nama+"</p><br><p class='isicard'>Jumlah Paragraf : "+item.jumlah_paragraf+"</p><a href class='isicard'>Baca Lebih Lanjut</a></div>");
                //     });
                // });
                window.location.href = "home.php?limit="+limit+"&limitcer="+limitcer;
            });
        });

        $("#cbokategori").change(function(){
            var limit = "<?php echo $limit; ?>";
            var limitcer = 4;
            var kategori = $(this).val();

            if(kategori == "kumpulancerita"){
                
                document.getElementById("title").innerHTML = "";
                document.getElementById("card_cerita").innerHTML = "";

                $("#title").append("<h1>Kumpulan Cerita</h1>");

                $.post('ajax_paging_kanan.php', {iduser:id, limit:limitcer}).done(function
                (data){
                    var ceritas1 = JSON.parse(data);
                    $.each(ceritas1, function(i, item){
                        $("#card_cerita").append("<div id='"+item.idcerita+"' class='card_cerbung_kecil'><h2 class='judulCeritaku'>"+item.judul+"</h2><p class='isicard'>Pemilik : "+item.nama+"</p><br><p class='isicard'>Jumlah Paragraf : "+item.jumlah_paragraf+"</p><a href='read.php?idcerita=" + item.idcerita + "&iduser=" + id + "' class='isicard'>Baca Lebih Lanjut</a></div>");
                    });
                    // $("#card_cerita").append("<button id='btnTampilKumpulanCerita'>Tampilkan Cerita Selanjutnya</button>");
                    
                });
            } else{

                document.getElementById("card_cerita").innerHTML = "";
                document.getElementById("title").innerHTML = "";

                $("#title").append("<h1>Kumpulan Cerita</h1>");

                $.post('ajax_paging_kiri.php', {iduser:id, limit:limit}).done(function
                (data){
                    var ceritas1 = JSON.parse(data);
                    $.each(ceritas1, function(i, item){
                        $("#card_cerita").append("<div id='"+item.idcerita+"' class='card_cerbung_kecil'><h2 class='judulCeritaku'>"+item.judul+"</h2><p class='isicard'>Pemilik : "+item.nama+"</p><br><p class='isicard'>Jumlah Paragraf : "+item.jumlah_paragraf+"</p><a href='read.php?idcerita=" + item.idcerita + "&iduser=" + id + "' class='isicard'>Baca Lebih Lanjut</a></div>");
                    });
                    // $("#card_cerita").append("<button id='btnTampilKumpulanCerita'>Tampilkan Cerita Selanjutnya</button>");
                    
                });
            }
        });

        $("#btnTampilKumpulanCerita").click(function(){
            var limit = 2;

            $.post('ajax_paging_kanan.php', {iduser:id, limit:limit}).done(function
            (data){
                var ceritas1 = JSON.parse(data);
                $.each(ceritas1, function(i, item){
                    $("#card_cerita").append("<div id='"+item.idcerita+"' class='card_cerbung_kecil'><h2 class='judulCeritaku'>"+item.judul+"</h2><p class='isicard'>Pemilik : "+item.nama+"</p><br><p class='isicard'>Jumlah Paragraf : "+item.jumlah_paragraf+"</p><a href='read.php?idcerita=" + item.idcerita + "&iduser=" + id + "' class='isicard'>Baca Lebih Lanjut</a></div>");
                });
                
            });
            
        });

        $("#new").click(function() {
            window.location.href = "new.php?id="+id;
        });


</script>