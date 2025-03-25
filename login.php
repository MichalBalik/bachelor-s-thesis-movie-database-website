<?php
include "System.php";

// Odstranenie predosleho jwt
setcookie('jwt', null, -1, '/');

$menu = new System();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <title>Title</title>
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

<div class="row justify-content-md-center ">

    <div id ="okno" class="col-md-6 " >
        <div id ="stav" ></div>
        <form id="formularlogin" ">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email"  name="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Zadajte email ">
                <small id="emailHelp" class="form-text text-muted">ZADAJTE EMAIL KTORYM STE SA REGISTROVALi</small>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Heslo</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Zadajte Heslo">
            </div>



            <div class=" row justify-content-center">

                <a href="./registracia.php" >Ak ešte nemaš účet - klikni sem</a>


            </div>
            <div class=" row justify-content-center">
            <button type="submit"  value="Submit" class="btn btn-primary" >Login</button>
            </div>

        </form>
    </div>
</div>


<script>



    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        var expires = "expires="+ d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    $(document).on('submit', '#formularlogin', function(){
        var data=`{"email":"${$("#email").val()}","h":"${$("#email").val()}","password":"${$("#password").val()}"}`;

        $.ajax({
            url: "api/login.php",
            type : "POST",
            contentType : 'application/json',
            data : data,
            success : function(result){

                setCookie("jwt", result.jwt, 1);

                window.location.replace("./index.php");

                $('#okno').html("<div class='alert alert-success'>Úspešne prihlasenie.</div>");

            },
            error: function(xhr, resp, text){

                $('#stav').html("<div class='alert alert-danger'>Prihlasenie zlyhalo. Skontrolujte zadane údaje.</div>");
            }        });
        return false;
    });

</script>
</body>
</html>