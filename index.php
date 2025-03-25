<?php
include_once "System.php";
$menu = new System();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <title>FilmZone</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/b-1.6.1/b-html5-1.6.1/b-print-1.6.1/datatables.min.css"/>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/b-1.6.1/b-html5-1.6.1/b-print-1.6.1/datatables.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
</head>

<body>
<?php
$menu->generujHlavicku();
?>

<div class="container">
<hr>
    <form id="hladajFormular" class="form-inline" >
        <label for="email2" class="mb-2 mr-sm-2">Nazov:</label>
        <input type="text" class="form-control mb-2 mr-sm-2" id="hladaj" placeholder="Zadajte nazov filmu" name="hladaj">
        <input data-toggle="tooltip"type="checkbox" title="Vyhladavaj aj v popise filmu!" id="checkboxPopis"  data-toggle='tooltip' data-placement='top'  class='checkbox mb-2 mr-sm-2'/>

        <button type="submit" class="btn mb-2 mr-sm-2">
            <i class="fa fa-search"></i>
        </button>

        <label for="pismeno" class="mb-2 mr-sm-2">Pismeno:</label>
        <select class="form-control mb-2 mr-sm-2" id="pismeno" name="pismeno">
            <option value="" ></option>
            <?php
            foreach (range(0, 9) as $cislo) {
                echo "<option>$cislo</option>";
            }
            foreach (range('A', 'Z') as $pismeno) {
                echo "<option>$pismeno</option>";
            }
            ?>
        </select>

        <label for="kategoria" class="mb-2 mr-sm-2">Kategoria:</label>
        <select class="form-control mb-2 mr-sm-2" id="kategoria" name="kategoria">
            <?php
                      foreach($menu->getZoznamKategorii() as $kategoria) {
                          echo "<option>$kategoria</option>";
                      }
                      ?>
                              </select>
                  <div class=" mb-2 mr-sm-2 custom-switch">
                      <input type="checkbox" class="custom-control-input" id="switch" name="switch">
                      <label class="custom-control-label" for="switch">Okna/Tabulka</label>
                  </div>
              </form>
              <hr>
          </div>

          <div class="container">
              <div  id="okno"   >
                  <div  id="zobrazenieOkna"  class="row justify-content-md-center text-center" >
                  </div>

                        <div id="oknoTabulka"class="text-center">
                                    <div class="table responsive ">
                                          <table class="table table-striped table-hover" id="tabulka" name="tabulka">
                                             <thead class="thead-dark">
                                              <tr >
                                                      <th>Nazov filmu</th>
                                                     <th>Popis filmu</th>
                                                     <th>Kategoria</th>
                                                      <th>Datum premiery SR</th>
                                                  </tr>
                                              </thead>
                                              <tbody>
                                              </tbody>
                                          </table>
                                    </div>
                        </div>

</body>
              </div>
    </div>

</div>
<br>

<footer  class="bg-dark text-white-50">
    <div  class="container text-center">
        <small>Made by Michal Balik 2020 </small>
    </div>
</footer>
</div>

    <script>
        $(document).on('submit', '#hladajFormular', function(){
            var hladane=$("#hladaj").val();
            $("#kategoria").val("");
            $("#hladaj").val();
            if ($('#checkboxPopis').is(":checked"))
            {
               var keyword = "sp="+hladane;
                zobrazData(keyword);
            }
            else{
                var keyword = "s="+hladane;
                zobrazData(keyword);

            }
            keyword = "s="+hladane;
            $("#pismeno").val("");
            return false;
        });

        var Table = {};
        $( document ).ready(function() {

            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            });


            Table.table =  $('#tabulka').DataTable({
                "searching": false,
                dom: 'Btflrp',
                buttons: [
                    {
                        extend: 'pdf',
                        text: 'Vytvor PDF',
                        exportOptions: {
                            modifier: {
                                page: 'all',
                                order: 'current',
                                search: 'applied'
                            }
                        }
                    },
                    {
                        extend: 'print',
                        text: 'Tlac',
                        exportOptions: {
                            modifier: {
                                page: 'all',
                                order: 'current',
                                search: 'applied'
                            }
                        }
                    },
                    {
                        extend: 'csv',
                        text: 'CSV',
                        exportOptions: {
                            modifier: {
                                page: 'all',
                                order: 'current',
                                search: 'applied'
                            }
                        }
                    }
                ],
                "language": {
                    "lengthMenu": "Zobraz _MENU_ filmov na stranke",
                    "zeroRecords": "Podla zvoleneho kriteria sa nenašli žiadne filmy",
                    "info": "Stranka _PAGE_ z _PAGES_",
                    "infoEmpty": "Ziadne zaznamy najdene",
                    "infoFiltered": "(filtered from _MAX_ total records)",
                    "search": "Hladaj:",
                    "paginate": {
                        first:      "Prva",
                        previous:   "Predošla",
                        next:       "Dalšia"

                    },
                }
            });

            let params = new URLSearchParams(location.search);
            if(params.has("hladaj")){
                var hladane = "s="+params.get('hladaj');

                zobrazData(hladane);
                $("#hladaj").val(params.get('hladaj'));
            }
            else{
                zobrazData("");
            }


            $("#pismeno").change(function(){
               var hladane = "s="+$( "#pismeno" ).val();

                zobrazData(hladane);
                $("#hladaj").val("");
                $("#kategoria").val("");

            });

            $("#kategoria").change(function(){
                var hladane = "s="+$( "#kategoria" ).val();
                 zobrazData(hladane);
                $("#hladaj").val("");
                $("#pismeno").val("");


            });


        });

    function zmazFormular(){
        $("#hladaj").val("");
        $("#pismeno").val("");


    }

        function zobrazData($keyword){

            hladaj = $keyword;

            $("#zobrazenieOkna").removeClass("alert-danger");
            $.ajax({
                url: "api/film/search.php",
                type : "GET",
                contentType : 'application/json',
                data : hladaj,
                success : function(result){

                    txt ="";
                    if(!$('#switch').prop('checked')){
                        $("#oknoTabulka").hide();
                        $("#zobrazenieOkna").show();

                        for (x in result.records) {
                            if(result.records[x].stav == "zobrazene"){
                            txt += "<div class=\"card card col-sm-2   text-center  \" style=\"width:100px\">"
                            txt += `<img class=\"card-img-top\" src=\"${result.records[x].url}\" alt=\"Card image\" style=\"width:100%\">`;
                            txt += "<div class=\"card-img-overlay\">";
                            txt+=`<div class="card-footer"><a href=\"./zobraz2.php?id=${result.records[x].id}\" class=\"stretched-link\"></a></div>`;
                            txt +="</div>";
                            txt +="</div>";
                            document.getElementById("zobrazenieOkna").innerHTML = txt;
                            }
                        }

                    }
                    else{
                        $("#oknoTabulka").show();
                        $("#okno").removeClass("row");
                        $("#zobrazenieOkna").hide();



                        Table.table.clear();
                        for (x in result.records) {
                            if(result.records[x].stav == "zobrazene"){

                            Table.table.row.add( $(`<tr onclick="window.location='./zobraz2.php?id=${result.records[x].id}';" ><td>${result.records[x].nazovFilmu}</td><td>${result.records[x].popisFilmu}</td><td>${result.records[x].kategoria}</td><td>${result.records[x].datumPremierySR}</td></tr>`)[0] ).draw();



                        }
                    }


                    }

                },
                error: function(xhr, resp, text){

                    $("#zobrazenieOkna").text("Zadanemu vyhladavaniu nevyhovuje ziaden zaznam v databaze");
                    $("#zobrazenieOkna").addClass("alert-danger");
                    $("#tabulka > tbody").html("");
                }
            });

        }
    </script>
</body>

    </html>