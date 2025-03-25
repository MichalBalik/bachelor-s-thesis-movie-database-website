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
    <title>Vloz Film</title>
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
    <div class="col-md-6" id="podklad" >
        <hr>
        <div id="vysledok"></div>
        <hr>
        <form  id="formularFilm">
            <div class="form-group">
                <label for="nazovFilmu">Nazov filmu</label>
                <textarea class="form-control" name="nazovFilmu" id="nazovFilmu" rows="1" required ></textarea>
            </div>
            <div class="form-group">
                <label for="popisFilmu">Popis filmu</label>
                <textarea class="form-control" name="popisFilmu" id="popisFilmu" rows="3" required ></textarea>
            </div>
            <div class="form-group">
                <label for="kategoria">Vyberte kategoriu vtipu</label>
                <select class="form-control" name="kategoria" id="kategoria" required>
                    <?php
                    foreach($menu->getZoznamKategorii() as $kategoria) {
                        echo "<option>$kategoria</option>";
                    }
                    ?>
                </select>
            </div>


            <div class="form-group">
                <label >Datum premierySR</label>
                <input type="date" name="datumPremierySR" id="datumPremierySR" max="3000-12-31" min="1900-01-01" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="url">URL obrazka</label>
                <textarea class="form-control" name="url" id="url" rows="1" required ></textarea>
            </div>
            <div class="form-group">
                <input type="hidden" id="stav" name="stav" value="neschvalene">
            </div>
        <div class="form-group">
            <input type="hidden" id="idAutora" name="idAutora" value="<?php echo $_SESSION["idPouzivatela"]?>">
        </div>

            <button type="submit"  id="uloz" value="Submit" class="btn btn-primary" >Ulož</button>



        </form>


    </div>

</div>
<footer  class="bg-dark text-white-50">
    <div  class="container text-center">
        <small>Made by Michal Balik 2020 </small>
    </div>
</footer>
<script>
    $(document).on('submit', '#formularFilm', function(){

        var data=`{"nazovFilmu":"${$("#nazovFilmu").val()}","popisFilmu":"${$("#popisFilmu").val()}","kategoria":"${$("#kategoria").val()}","datumPremierySR":"${$("#datumPremierySR").val()}","url":"${$("#url").val()}","stav":"${$("#stav").val()}","idAutora":"${$("#idAutora").val()}"}`;

        $.ajax({
            url: "api/film/create.php",
            type : "POST",
            contentType : 'application/json',
            data : data,
            success : function(result) {
                $( "#vysledok" ).text('Pridanie filmu prebehlo úspešne. O chvilu budete presmerovany na hlavnu stranku.');
                setTimeout(function(){ window.location.replace("./index.php");; }, 5000);

                $( "#podklad" ).removeClass("alert-danger").addClass("alert-success");

            },
            error: function(xhr, resp, text){

                $( "#podklad" ).addClass("alert-danger");
                $( "#vysledok" ).text('Pridanie filmu prebehlo neúspešne.Prosim skontrolujte zadane hodnoty');
            }
        });

        return false;
    });


</script>


</body>
</html>
