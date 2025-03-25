<?php
include_once "System.php";
include_once "PDF.php";



if(!isset($_GET["id"])||!is_numeric($_GET["id"])){
    header( "refresh:3;url=index.php" );
    exit("Zle zadana URL coskoro budete presmerovany na hlavnu stranku");

}else{
    //$url="http://fra207d.fri.uniza.sk:1234/balikbc/bakalarka/api/film/read_one.php?id=".$_GET["id"];
    $url="http://balik.6f.sk/bakalarka/api/film/read_one.php?id=".$_GET["id"];
    $product_arr = file_get_contents($url);
    $product_arr = json_decode($product_arr, true);
}

if(ISSET($_GET["akcia"])&&$_GET["akcia"]=="pdf"){
    $pdf=new PDF();
    $pdf->generujPDF($product_arr);
}

$menu = new System();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>FilmZone</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
</head>

<body>
<?php
$menu->generujHlavicku();
?>

<div class="row justify-content-md-center text-center">
    <div class="col-md-8 text-center">
        <h1 class="text-center"><?=$product_arr["nazovFilmu"]; ?></h1>
        <hr>
        <img class="mx-auto img-fluid text-center" src="<?=$product_arr["url"]; ?>" alt="Chania" width="280" height="165 ">
        <hr>
        <p class="text-right"><?="Kategoria: ".$product_arr["kategoria"]."//"."Datum premiery SR ".$product_arr["datumPremierySR"];?></p>
        <hr>
        <h3>Popis filmu</h3>
        <p><?=  $product_arr["popisFilmu"];?></p>
        <hr>
        <?php
        if(!empty($_SESSION["email"])){
            echo '<fieldset class="border p-2 " id="vkladanieObsadeniaOkno">
            <legend  class="w-auto"><h3 >Obsadenie</h3></legend>
            <div id="vysledokVkladania"></div>

            <form class="form-inline justify-content-md-center text-center " id="pridajObsadenie" name="pridajObsadenie">
            <label for="pozicia" class="mr-sm-2">Pozicia</label>
            <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Zadajte poziciu" id="pozicia" name="pozicia">
            <label for="meno" class="mr-sm-2">Meno:</label>
            <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Zadajte meno" id="meno" name="meno">
                <label for="priezvisko" class="mr-sm-2">Priezvisko:</label>
                <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Zadajte priezvisko" id="priezvisko" name="priezvisko">
                <input type="hidden" class="form-control mb-2 mr-sm-2" placeholder="" id="idFilmu" name="idFilmu" readonly>
            <button type="submit" class="btn btn-primary mb-2">Submit</button>
        </fieldset>
        </form>';
        }else{
            echo '<h3 >Obsadenie</h3>';
        }
        ?>
            <div class="text-center">
            <div class="table responsive ">
                <table class="table table-striped" id="tabulka" name="tabulka">
                    <thead class="thead-dark">
                    <tr >
                        <th>#</th>
                        <th>Pozicia</th>
                        <th>Meno a priezvisko</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?
                    foreach ($product_arr["Obsadenie"] as $value) {
                        ?>
                         <tr>
                        <td><?php echo $value["idObsadenia"]?></td>
                             <td><?php echo $value["pozicia"]?></td>
                             <td><?php echo $value["meno"].$value["priezvisko"]?></td>
                         </tr>
                    <?
                    }
                    ?>
                    </tbody>
                </table>
            </div>
                <a href="?id=<?= $product_arr["id"] ?>&akcia=pdf" target="_blank" class="nav-link">Tvorba PDF REPORTU</a>
        </div>
    </div>
</div>

<footer  class="bg-dark text-white-50">
    <div  class="container text-center">
        <small>Made by Michal Balik 2020 </small>
    </div>
</footer>
<script>
    $(document).ready(function() {
        $('#tabulka').DataTable({
            "searching": false,
            "language": {
                "lengthMenu": "Zobraz _MENU_ filmov na stranke",
                "zeroRecords": "Podla zvoleneho kriteria sa nenašli žiadne filmy",
                "info": "Stranka _PAGE_ z _PAGES_",
                "infoEmpty": "No records available",
                "infoFiltered": "(filtered from _MAX_ total records)"
            }
        });
        let params = new URLSearchParams(location.search);
        $("#idFilmu").val(params.get('id'));


    });
    $(document).on('submit', '#pridajObsadenie', function(){
        var data=`{"pozicia":"${$("#pozicia").val()}","meno":"${$("#meno").val()}","priezvisko":"${$("#priezvisko").val()}","idFilmu":"${$("#idFilmu").val()}"}`;

        $.ajax({
            url: "api/film/create.php",
            type : "POST",
            contentType : 'application/json',
            data : data,
            success : function(result) {
                $( "#vysledokVkladania" ).text('Pridanie obsadenia prebehlo úspešne.');
                $( "#vkladanieObsadeniaOkno" ).removeClass("alert-danger").addClass("alert-success");
            },
            error: function(xhr, resp, text){
                $( "#vysledokVkladania" ).text('Pridanie obsadenia prebehlo neúspešne.Prosim skontrolujte zadane hodnoty');
                $( "#vkladanieObsadeniaOkno" ).removeClass("alert-success").addClass("alert-danger");
            }
        });
        return false;
    });


</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>