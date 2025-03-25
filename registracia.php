<?php

include "System.php";
$menu = new System();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Registrácia</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
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

<main>
    <div class="container">
        <div class="row">
            <div id="podklad" class="col-sm-12  ">
                <hr>
                <div id="vysledok"></div>
            <hr>
                <form id="formularRegistracie" method="get">

                    <div class="form-group">
                        <label for="krstneMeno">Krstne meno</label>
                        <input type="text" class="form-control" id="krstneMeno" name="krstneMeno" placeholder="Krstne meno" required >
                    </div>
                    <div class="form-group">
                        <label for="priezvisko">Priezvisko</label>
                        <input type="text" class="form-control" id="priezvisko" name="priezvisko" placeholder="Priezvisko" required >
                    </div>

                    <div class="form-group">
                        <label for="email"> Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required >
                    </div>
                    <div class="form-group">
                        <label for="heslo">Heslo</label>
                        <input type="password" class="form-control" id="heslo" name="heslo" placeholder="Heslo">
                    </div>
                    <button type="submit" class="btn btn-primary">Registrovat</button>
                    <hr>
                </form>
            </div>

        </div>





    </div>

</main>
<script>
    $(document).on('submit', '#formularRegistracie', function(){
        var data=`{"krstneMeno":"${$("#krstneMeno").val()}","priezvisko":"${$("#priezvisko").val()}","email":"${$("#email").val()}","heslo":"${$("#heslo").val()}"}`;

        $.ajax({
            url: "api/create_user.php",
            type : "POST",
            contentType : 'application/json',
            data : data,
            success : function(result) {
                $( "#vysledok" ).text("Registracia prebehla uspesne Prihlaste sa .");
                setTimeout(function(){ window.location.replace("./login.php");; }, 3000);
                $( "#podklad" ).removeClass("alert-danger").addClass("alert-success");
            },
            error: function(xhr, resp, text){

                $( "#podklad" ).removeClass("alert-success").addClass("alert-danger");
                $( "#vysledok" ).text("Chyba pri registracii skontrolujte zadane udaje");
            }
        });

        return false;
    });

</script>

</body>
</html>