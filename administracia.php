<?php
include_once "System.php";

$menu = new System();
if(empty($_SESSION["funkcia"])||$_SESSION["funkcia"]!="admin")
{
    header( "refresh:3;url=index.php" );
    exit("Nedostacujuca funkcia");
}
$menu->generujHlavicku();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Administracia</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<style>

    .row.content {
        height: 800px
    }
    .sidenav {
        background-color: #f1f1f1;
        height: 100%;
    }
    footer {
        background-color: #555;
        color: white;
        padding: 15px;
    }
    @media screen and (max-width: 767px) {
        .sidenav {
            height: auto;
            padding: 15px;
        }
        .row.content {
            height: auto;
        }
    }
</style>

<body>
<div class="container-fluid">
    <div class="row content">
        <div class=" col-md-2 sidenav">
            <h4>Administracia</h4>
            <ul class="nav nav-pills flex-column">
                <li class="active nav-item"><a href="?druh=film" class="nav-link">Administracia filmu</a>
                </li>
                <li class="nav-item"><a href="?druh=obsadenie" class="nav-link">Administracia obsadenia</a>
                </li>
                <li class="nav-item"><a href="?druh=pouzivatel" class="nav-link">Administracia pouzivatela</a>
                </li>
                <li class="nav-item"><a href="?druh=poziadavka" class="nav-link">Administracia poziadaviek</a>
                </li>
            </ul>

        </div>
        <div class="col-md-10"  >
            <div class="text-center">
                <form   id="updateFilm" ">

                <div class="form-group">
                    <input type="hidden" id="id" name="id" value="">
                </div>


                <div class="form-group">
                    <label for="nazovFilmu">Nazov filmu</label>
                    <textarea class="form-control" name="nazovFilmu" id="nazovFilmu" rows="1"  required ></textarea>
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
                            echo "<option value='$kategoria'>$kategoria</option>";
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
                    <label for="kategoria">Stav filmu</label>
                    <select class="form-control" name="stav" id="stav" required>
                        <?php
                        foreach($menu->getZoznamStavomFilm() as $stav) {
                            echo "<option value='$stav'>$stav</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <input type="hidden" id="jwt" name="jwt" value="<?php echo $_COOKIE['jwt']?>">
                </div>
                <div class="btn-group">
                    <button type="submit"  id="aktualizuj" value="Submit" class="btn btn-primary" >Aktualizuj</button>
                    <button type="button"  id="zmaz"  value="zmaz" class="btn btn-primary" >Zmaz</button>
                </div>
                </form>

                <form   id="updateObsadenie">

                    <div class="form-group">
                        <input type="hidden" id="idObsadenia" name="idObsadenia" value="">
                    </div>
                    <div class="form-group">
                        <input type="hidden" id="jwt" name="jwt" value="<?php echo $_COOKIE['jwt']?>">
                    </div>

                    <div class="form-group">
                        <label for="pozicia">Pozicia</label>
                        <textarea class="form-control" name="pozicia" id="pozicia" rows="1"  required ></textarea>
                    </div>
                    <div class="form-group">
                        <label for="meno">Meno</label>
                        <textarea class="form-control" name="meno" id="meno" rows="1" required ></textarea>
                    </div>

                    <div class="form-group">
                        <label for="priezvisko">Priezvisko</label>

                        <textarea class="form-control" name="priezvisko" id="priezvisko" rows="1" required ></textarea>
                    </div>


                    <div class="form-group">
                        <input type="hidden" id="idFilmu" name="idFilmu" value="">
                    </div>
                    <div class="form-group">
                        <label for="stav">Stav obsadenia</label>
                        <select class="form-control" name="stavObsadenia" id="stavObsadenia" required>
                            <?php
                            foreach($menu->getZoznamStavovObsadenie() as $stav) {
                                echo "<option value='$stav'>$stav</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="btn-group">
                        <button type="submit"  id="aktualizuj" value="Submit" class="btn btn-primary" >Aktualizuj</button>
                        <button type="button"  id="zmazObsadenie"  value="zmazObsadenie" class="btn btn-primary" >Zmaz</button>
                    </div>
                </form>

                <form   id="updatePouzivatel" >

                    <div class="form-group">
                        <input type="hidden" id="idPouzivatela" name="idPouzivatela" value="">
                    </div>


                    <div class="form-group">
                        <label for="firstname">Meno</label>
                        <textarea class="form-control" name="firstname" id="firstname" rows="1"  required ></textarea>
                    </div>
                    <div class="form-group">
                        <label for="lastname">Priezvisko</label>
                        <textarea class="form-control" name="lastname" id="lastname" rows="1" required ></textarea>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>

                        <textarea class="form-control" name="email" id="email" rows="1" required ></textarea>
                    </div>
                    <div class="form-group">

                        <input type="hidden" id="jwt" name="jwt" value="<?php echo $_COOKIE['jwt']?>">
                    </div>
                    <div class="form-group">
                        <label for="funkcia">Funkcia</label>
                        <select class="form-control" name="funkcia" id="funkcia" required>
                            <?php
                            foreach($menu->getZoznamFunkcii() as $funkcia) {
                                echo "<option value='$funkcia'>$funkcia</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="btn-group">
                        <button type="submit"  id="aktualizuj" value="Submit" class="btn btn-primary" >Aktualizuj</button>
                    </div>
                </form>
                <form   id="updatePoziadavka">

                    <div class="form-group">
                        <input type="hidden" id="idPoziadavky" name="idPoziadavky" value="">
                    </div>
                    <div class="form-group">
                        <input type="hidden" id="jwt" name="jwt" value="<?php echo $_COOKIE['jwt']?>">
                    </div>

                    <div class="form-group">
                        <label for="pozicia">Nazov požadovaneho filmu</label>
                        <textarea class="form-control" name="nazovPozadovanehoFilmu" id="nazovPozadovanehoFilmu" rows="1"  required ></textarea>
                    </div>
                    <div class="form-group">
                        <label for="meno">Popis</label>
                        <textarea class="form-control" name="popis" id="popis" rows="1" required ></textarea>
                    </div>

                    <div class="form-group">
                        <label for="odpovedAdmina">Vyjadrenie admina</label>
                        <textarea class="form-control" name="odpovedAdmina" id="odpovedAdmina" rows="3" required ></textarea>
                    </div>


                    <div class="form-group">
                        <input type="hidden" id="idAdmina" name="idAdmina" value="<?php echo $_SESSION["idPouzivatela"]?>">
                    </div>
                    <div class="form-group">
                        <input type="hidden" id="emailPozadovatela" name="emailPozadovatela" value="">
                    </div>

                    <div class="btn-group">
                        <button type="submit"  id="aktualizuj" value="Submit" class="btn btn-primary" >Aktualizuj</button>
                        <button type="button"  id="zmazPoziadavku"  value="zmazPoziadavku" class="btn btn-primary" >Zmaz požiadavku</button>
                    </div>
                </form>


                <div class="table responsive ">
                    <table class="table table-striped" id="tabulka" name="tabulka">
                        <?php

                        if(!empty($_GET['druh'])&&$_GET['druh']=="obsadenie"){

                            echo '<thead class="thead-dark">
                        <tr >
                            <th>#</th>
                            <th>Pozicia</th>
                            <th>Meno</th>
                            <th>Priezvisko</th>
                            <th>idFilmu</th>
                            <th>Stav</th>
                        </tr>
                        </thead>

                        <tfoot class="thead-dark">
                        <tr >
                            <th>#</th>
                            <th>Pozicia</th>
                            <th>Meno</th>
                            <th>Priezvisko</th>
                            <th>idFilmu</th>
                            <th>Stav</th>
                        </tr>
                        </tfoot>';

                        }
                        elseif (!empty($_GET['druh'])&&$_GET['druh']=="pouzivatel"){
                            echo '<thead class="thead-dark">
                        <tr >
                            <th>#</th>
                            <th>Meno</th>
                            <th>Priezvisko</th>
                            <th>email</th>
                            <th>funkcia</th>
                        </tr>
                        </thead>

                        <tfoot class="thead-dark">
                        <tr >
                            <th>#</th>
                            <th>Meno</th>
                            <th>Priezvisko</th>
                            <th>email</th>
                            <th>funkcia</th>
                        </tr>
                        </tfoot>';

                        }
                        elseif (!empty($_GET['druh'])&&$_GET['druh']=="poziadavka"){
                            echo '<thead class="thead-dark">
                        <tr >
                            <th>#</th>
                            <th>nazov</th>
                            <th>popis</th>
                            <th>odpoved Admina</th>
                            <th>idAdmina</th>
                            <th>emailPozadovatela</th>
                        </tr>
                        </thead>

                        <tfoot class="thead-dark">
                        <tr >
                            <th>#</th>
                            <th>nazov</th>
                            <th>popis</th>
                            <th>odpoved Admina</th>
                            <th>idAdmina</th>
                            <th>emailPozadovatela</th>
                        </tr>
                        </tfoot>';

                        }

                        else{
                            echo '<thead class="thead-dark">
                        <tr >
                            <th>#</th>
                            <th>Nazov filmu</th>
                            <th>Popis filmu</th>
                            <th>Kategoria</th>
                            <th>DatumPremierySR</th>
                            <th>URL</th>
                            <th>Stav</th>
                        </tr>
                        </thead>

                        <tfoot class="thead-dark">
                        <tr >
                            <th>#</th>
                            <th>Nazov filmu</th>
                            <th>Popis filmu</th>
                            <th>Kategoria</th>
                            <th>DatumPremierySR</th>
                            <th>URL</th>
                            <th>Stav</th>
                        </tr>
                        </tfoot>';}
                        ?>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    function resetFormulara() {
        //RESETNUTIE ALL INPUTOV
        $('#updateFilm').get(0).reset();
        $('#updatePouzivatel').get(0).reset();
        $('#updateObsadenie').get(0).reset();

        $('#updatePoziadavka').get(0).reset();

        //RESETOVANIE ALL TEXTAREA
        $('textarea').text("");
    }

    $(document).ready(function() {

        $("#updateFilm").hide();
        $("#updateObsadenie").hide();
        $("#updatePouzivatel").hide();
        $("#updatePoziadavka").hide();

        let params = new URLSearchParams(location.search);
        if(params.has("hladaj")){
        }
        if(params.get('druh')=="obsadenie"){
            var table =    $('#tabulka').DataTable({
                ajax: {
                    url: 'api/film/search.php?o=""',
                    dataSrc: 'records'
                },

                responsive: true,
                columns: [
                    { data: 'idObsadenia'},
                    { data: 'pozicia'},
                    { data: 'meno'},
                    { data: 'priezvisko'},
                    { data: 'idFilmu'},
                    { data: 'stavObsadenia'}

                ],



                "language": {
                    "lengthMenu": "Zobraz _MENU_ filmov na stranke",
                    "zeroRecords": "Podla zvoleneho kriteria sa nenašli žiadne filmy",
                    "info": "Stranka _PAGE_ z _PAGES_",
                    "infoEmpty": "No records available",
                    "infoFiltered": "(filtered from _MAX_ total records)",
                    "search": "Hladaj:",
                    "paginate": {
                        first:      "Prva",
                        previous:   "Predošla",
                        next:       "Dalšia"

                    },
                },
                "lengthMenu": [ 5,10,15 ]
            });

        }
        else if (params.get('druh')=="pouzivatel"){

            var table =    $('#tabulka').DataTable({
                ajax: {
                    url: 'api/search.php',
                    dataSrc: 'records'
                },

                responsive: true,
                columns: [
                    { data: 'idPouzivatela'},
                    { data: 'firstname'},
                    { data: 'lastname'},
                    { data: 'email'},
                    { data: 'funkcia'}

                ],



                "language": {
                    "lengthMenu": "Zobraz _MENU_ filmov na stranke",
                    "zeroRecords": "Podla zvoleneho kriteria sa nenašli žiadne filmy",
                    "info": "Stranka _PAGE_ z _PAGES_",
                    "infoEmpty": "No records available",
                    "infoFiltered": "(filtered from _MAX_ total records)",
                    "search": "Hladaj:",
                    "paginate": {
                        first:      "Prva",
                        previous:   "Predošla",
                        next:       "Dalšia"

                    },
                },
                "lengthMenu": [ 5,10,15 ]
            });



        }
        else if (params.get('druh')=="pouzivatel"){

            var table =    $('#tabulka').DataTable({
                ajax: {
                    url: 'api/search.php',
                    dataSrc: 'records'
                },

                responsive: true,
                columns: [
                    { data: 'idPouzivatela'},
                    { data: 'firstname'},
                    { data: 'lastname'},
                    { data: 'email'},
                    { data: 'funkcia'}

                ],



                "language": {
                    "lengthMenu": "Zobraz _MENU_ filmov na stranke",
                    "zeroRecords": "Podla zvoleneho kriteria sa nenašli žiadne filmy",
                    "info": "Stranka _PAGE_ z _PAGES_",
                    "infoEmpty": "No records available",
                    "infoFiltered": "(filtered from _MAX_ total records)",
                    "search": "Hladaj:",
                    "paginate": {
                        first:      "Prva",
                        previous:   "Predošla",
                        next:       "Dalšia"

                    },
                },
                "lengthMenu": [ 5,10,15 ]
            });



        }
        else if (params.get('druh')=="poziadavka"){

            var table =    $('#tabulka').DataTable({
                ajax: {
                    url: 'api/film/search.php?p=VSETKYPOZIADAVKY',
                    dataSrc: 'records'
                },

                responsive: true,
                columns: [
                    { data: 'idPoziadavky'},
                    { data: 'nazovPozadovanehoFilmu'},
                    { data: 'popis'},
                    { data: 'odpovedAdmina'},
                    { data: 'idAdmina'},
                    { data: 'emailPozadovatela'}
                ],



                "language": {
                    "lengthMenu": "Zobraz _MENU_ filmov na stranke",
                    "zeroRecords": "Podla zvoleneho kriteria sa nenašli žiadne filmy",
                    "info": "Stranka _PAGE_ z _PAGES_",
                    "infoEmpty": "No records available",
                    "infoFiltered": "(filtered from _MAX_ total records)",
                    "search": "Hladaj:",
                    "paginate": {
                        first:      "Prva",
                        previous:   "Predošla",
                        next:       "Dalšia"

                    },
                },
                "lengthMenu": [ 5,10,15 ]
            });



        }

        else{
            var table =    $('#tabulka').DataTable({
                ajax: {
                    url: 'api/film/search.php',
                    dataSrc: 'records'
                },

                responsive: true,
                columns: [
                    { data: 'id'},
                    { data: 'nazovFilmu'},
                    { data: 'popisFilmu'},
                    { data: 'kategoria'},
                    { data: 'datumPremierySR'},
                    { data: 'url'},
                    { data: 'stav'}

                ],
                "columnDefs": [ {
                    "targets": -2,
                    "searchable": false,
                    "visible":false
                },
                    {
                        "targets": 2,
                        "searchable": true,
                        "visible":false
                    },
                ],


                "language": {
                    "lengthMenu": "Zobraz _MENU_ filmov na stranke",
                    "zeroRecords": "Podla zvoleneho kriteria sa nenašli žiadne filmy",
                    "info": "Stranka _PAGE_ z _PAGES_",
                    "infoEmpty": "No records available",
                    "infoFiltered": "(filtered from _MAX_ total records)",
                    "search": "Hladaj:",
                    "paginate": {
                        first:      "Prva",
                        previous:   "Predošla",
                        next:       "Dalšia"

                    },
                },
                "lengthMenu": [ 5,10,15 ]
            });

        }


        $("#zmazObsadenie").click(function(){

            var id = `{"idObsadenia":"${$("#idObsadenia" ).val()}","jwt":"${$("#jwt" ).val()}"}`;
            $.ajax({
                url: "api/film/delete.php",
                type : "POST",
                contentType : 'application/json',
                data : id,
                success : function(result) {
                    alert("DELETE prebehol uspesne");
                    $("#updateObsadenie").hide(800);
                    table.ajax.reload();
                    resetFormulara();
                },
                error: function(xhr, resp, text){
                    alert("DELETE NEPREBEHOL USPESNE");
                }
            });

            return false;

        });
        $("#zmazPoziadavku").click(function(){

            var id = `{"idPoziadavky":"${$("#idPoziadavky" ).val()}","jwt":"${$("#jwt" ).val()}"}`;
            $.ajax({
                url: "api/film/delete.php",
                type : "POST",
                contentType : 'application/json',
                data : id,
                success : function(result) {
                    alert("DELETE prebehol uspesne");
                    $("#updatePoziadavka").hide(800);

                    table.ajax.reload();

                    resetFormulara();

                },
                error: function(xhr, resp, text){
                    alert("DELETE NEPREBEHOL USPESNE");
                }
            });

            return false;

        });

        $("#zmaz").click(function(){

            var id = `{"id":"${$("#id" ).val()}","jwt":"${$("#jwt" ).val()}"}`;

            $.ajax({
                url: "api/film/delete.php",
                type : "POST",
                contentType : 'application/json',
                data : id,
                success : function(result) {
                    alert("DELETE prebehol uspesne");
                    $("#updateFilm").hide(800);
                    table.ajax.reload();
                    resetFormulara();
                },
                error: function(xhr, resp, text){
                    alert("DELETE NEPREBEHOL USPESNE");
                }
            });

            return false;

        });




        $('#tabulka tbody').on('click', 'tr', function () {
            var data = table.row( this ).data();

            let params = new URLSearchParams(location.search);
            if(params.get('druh')=="obsadenie"){
                $("#updateObsadenie").show(800);
                $('#idObsadenia').val(data.idObsadenia);
                $('#pozicia').text(data.pozicia);
                $('#meno').text(data.meno);
                $('#priezvisko').text(data.priezvisko);
                $('#idFilmu').val(data.idFilmu);
                $('#stavObsadenia option:contains('+data.stavObsadenia+')').prop('selected', true);



            }else if (params.get('druh')=="pouzivatel"){
                $("#updatePouzivatel").show(800);
                $('#idPouzivatela').val(data.idPouzivatela);
                $('#firstname').text(data.firstname);
                $('#lastname').text(data.lastname);
                $('#email').text(data.email);
                $('#funkcia option:contains('+data.funkcia+')').prop('selected', true);




            }
            else if (params.get('druh')=="poziadavka"){
                $("#updatePoziadavka").show(800);
                resetFormulara();
                $('#idPoziadavky').val(data.idPoziadavky);
                $('#nazovPozadovanehoFilmu').text(data.nazovPozadovanehoFilmu);
                $('#popis').text(data.popis);
                $('#odpovedAdmina').text(data.odpovedAdmina);
                $('#idAdmina').text(data.idAdmina);
                $('#emailPozadovatela').val(data.emailPozadovatela);


                $('#funkcia option:contains('+data.funkcia+')').prop('selected', true);




            }
            else
            {
                $("#updateFilm").show(800);

                $('#id').val(data.id);
                $('#nazovFilmu').text(data.nazovFilmu);
                $('#popisFilmu').text(data.popisFilmu);

                $('#kategoria option:contains('+data.kategoria+')').prop('selected', true);
                $('#url').text(data.url);
                $('#datumPremierySR').val(data.datumPremierySR);

                $('#stav option:contains('+data.stav+')').prop('selected', true);
            }
            $('html, body').animate({ scrollTop: 0 }, 'fast');
        } );


        $(document).on('submit', '#updateObsadenie', function(){
            var data=`{"idObsadenia":"${$("#idObsadenia").val()}","pozicia":"${$("#pozicia").val()}","meno":"${$("#meno").val()}","priezvisko":"${$("#priezvisko").val()}","idFilmu":"${$("#idFilmu").val()}","url":"${$("#url").val()}","stavObsadenia":"${$("#stavObsadenia").val()}","jwt":"${$("#jwt").val()}"}`;
            $.ajax({
                url: "api/film/update.php",
                type : "POST",
                contentType : 'application/json',
                data : data,
                success : function(result) {
                    alert("Update obsadenia prebehol uspešne");
                    $("#updateObsadenie").hide(800);
                    table.ajax.reload();
                    resetFormulara();
                },
                error: function(xhr, resp, text){

                    alert("Update obsadenia prebehol neuspešne");

                }
            });

            return false;
        });


        $(document).on('submit', '#updateFilm', function(){

            var data=`{"id":"${$("#id").val()}","nazovFilmu":"${$("#nazovFilmu").val()}","popisFilmu":"${$("#popisFilmu").val()}","kategoria":"${$("#kategoria").val()}","datumPremierySR":"${$("#datumPremierySR").val()}","url":"${$("#url").val()}","stav":"${$("#stav").val()}","jwt":"${$("#jwt").val()}"}`;


            $.ajax({
                url: "api/film/update.php",
                type : "POST",
                contentType : 'application/json',
                data : data,
                success : function(result) {
                    alert("Update filmu prebehol uspešne");
                    $("#updateFilm").hide(800);

                    table.ajax.reload();
                    resetFormulara();
                },
                error: function(xhr, resp, text){
                    alert("Update filmu prebehol neuspesne");
                }
            });

            return false;
        });
        $(document).on('submit', '#updatePouzivatel', function(){


            var data=`{"idPouzivatela":"${$("#idPouzivatela").val()}","firstname":"${$("#firstname").val()}","lastname":"${$("#lastname").val()}","email":"${$("#email").val()}","funkcia":"${$("#funkcia").val()}","jwt":"${$("#jwt").val()}"}`;
            $.ajax({
                url: "api/update.php",
                type : "POST",
                contentType : 'application/json',
                data : data,
                success : function(result) {
                    alert("Update  prebehol uspešne");
                    $("#updatePouzivatel").hide(800);

                    table.ajax.reload();

                    resetFormulara();



                },
                error: function(xhr, resp, text){
                    alert("Update  prebehol neuspesne");

                    table.ajax.reload();
                    $("#updatePouzivatel").hide(800);

                }
            });

            return false;
        });
        $(document).on('submit', '#updatePoziadavka', function(){
            var data=`{"idPoziadavky":"${$("#idPoziadavky").val()}","nazovPozadovanehoFilmu":"${$("#nazovPozadovanehoFilmu").val()}","popis":"${$("#popis").val()}","odpovedAdmina":"${$("#odpovedAdmina").val()}","idAdmina":"${$("#idAdmina").val()}","emailPozadovatela":"${$("#emailPozadovatela").val()}","jwt":"${$("#jwt").val()}"}`;


            $.ajax({
                url: "api/film/update.php",
                type : "POST",
                contentType : 'application/json',
                data : data,
                success : function(result) {
                    alert("Update poziadavky prebehol uspešne");
                    $("#updatePoziadavka").hide(800);
                    table.ajax.reload();
                    resetFormulara();

                },
                error: function(xhr, resp, text){
                    alert("Update poziadavky prebehol neuspešne");
                }
            });

            return false;
        });


    });



</script>
</body>

</html>