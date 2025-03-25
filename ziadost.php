<?php
include "System.php";

$menu = new System();
if(empty($_SESSION["funkcia"]))
{
    header( "refresh:3;url=login.php" );
    exit("Pred vkladanim sa musite prihlasiť");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Vloz poziadavku</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>

<?php
$menu->generujHlavicku();
?>

<div class="row justify-content-md-center text-center">
    <div class="col-md-4" id="podklad" >
        <hr>
        <div id="vysledok"> Formular na vloženie požiadavky</div>
        <hr>

        <form  id="formularPoziadavka" >

        <div class="form-group">
            <label for="nazovPozadovanehoFilmu">Nazov požadovaneho filmu</label>
            <textarea class="form-control" name="nazovPozadovanehoFilmu" id="nazovPozadovanehoFilmu" rows="1" placeholder="Zadajte nazov požadovaneho filmu" required ></textarea>
        </div>
        <div class="form-group">
            <label for="popis">Popis požadovaneho filmu</label>
            <textarea class="form-control" name="popis" id="popis" rows="3" placeholder="Zadajte popis filmu alebo odkaz pre jednoduchšiu identifikaciu" required ></textarea>
        </div>
        <div class="form-group">
            <input type="hidden" id="emailPozadovatela" name="emailPozadovatela" value="<?php echo $_SESSION["email"]?>">
        </div>
        <div class="form-group">
            <input type="hidden" id="akcia" name="akcia" value="poziadavka">
        </div>
        <button type="submit"  id="uloz" value="Submit" class="btn btn-primary" >Send</button>
        </form>
    </div>
    <div class="col-md-4" id="zoznam">
        <h2>Zoznam nevybavených požiadaviek</h2>
        <div id="zoznamPoziadaviek" class="list-group">
            <li class="list-group-item   justify-content-between align-items-center active">
                Zoznam požiadaviek
                <span id="pocetPoziadavok" class="badge badge-success badge-pill"></span>
            </li>
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
        var pocet =0;
        $.ajax({
            url: "api/film/search.php?p=NEVYBAVENE",
            type : "GET",
            contentType : 'application/json',
            success : function(result){
                    for (x in result.records) {
                        $('.list-group').append(`<a href="#" class="list-group-item list-group-item-action">${result.records[x].nazovPozadovanehoFilmu}</a>`);
                        pocet++;
                    }
                    $("#pocetPoziadavok").text(pocet);
            },
            error: function(xhr, resp, text){
            }
        });

        $("#pocetPoziadavok").text(pocet);

    });

    $(document).on('submit', '#formularPoziadavka', function(){
        var data=`{"nazovPozadovanehoFilmu":"${$("#nazovPozadovanehoFilmu").val()}","emailPozadovatela":"${$("#emailPozadovatela").val()}","popis":"${$("#popis").val()}","akcia":"${$("#akcia").val()}"}`;
        $.ajax({
            url: "api/film/create.php",
            type : "POST",
            contentType : 'application/json',
            data : data,
            success : function(result) {
                $( "#vysledok" ).text('Pridanie poziadavky prebehlo úspešne.');
                setTimeout(function(){
                    window.location.reload(); }, 3000
                );
                $( "#podklad" ).removeClass("alert-danger").addClass("alert-success");

            },
            error: function(xhr, resp, text){

                $( "#podklad" ).addClass("alert-danger");
                $( "#vysledok" ).text('Pridanie poziadavky prebehlo neúspešne.Prosim skontrolujte zadane hodnoty');
            }
        });

        return false;
    });
</script>
</body>
</html>
