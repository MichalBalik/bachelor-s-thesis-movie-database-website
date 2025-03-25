<?php
session_start();

include_once 'api/objects/User.php';
class System
{
    private $zoznamKategorii;
    private $zoznamStavomFilm;
    private $zoznamStavovObsadenie;
    private $zoznamFunkcii;

    /**
     * @return array
     */
    public function getZoznamKategorii()
    {
        return $this->zoznamKategorii;
    }

    /**
     * @param array $zoznamKategorii
     */
    public function setZoznamKategorii($zoznamKategorii)
    {
        $this->zoznamKategorii = $zoznamKategorii;
    }

    /**
     * @return array
     */
    public function getZoznamStavomFilm()
    {
        return $this->zoznamStavomFilm;
    }

    /**
     * @param array $zoznamStavomFilm
     */
    public function setZoznamStavomFilm($zoznamStavomFilm)
    {
        $this->zoznamStavomFilm = $zoznamStavomFilm;
    }

    /**
     * @return array
     */
    public function getZoznamStavovObsadenie()
    {
        return $this->zoznamStavovObsadenie;
    }

    /**
     * @param array $zoznamStavovObsadenie
     */
    public function setZoznamStavovObsadenie($zoznamStavovObsadenie)
    {
        $this->zoznamStavovObsadenie = $zoznamStavovObsadenie;
    }

    /**
     * @return array
     */
    public function getZoznamFunkcii()
    {
        return $this->zoznamFunkcii;
    }

    /**
     * @param array $zoznamFunkcii
     */
    public function setZoznamFunkcii($zoznamFunkcii)
    {
        $this->zoznamFunkcii = $zoznamFunkcii;
    }



    public function __construct()
    {
        $this->zoznamKategorii = array("","Komedia", "Horor", "Scifi", "Krimi", "Western", "Dokument",);

        $this->zoznamStavomFilm = array("","neschvalene","zobrazene");
        $this->zoznamStavovObsadenie = array("","neschvalene","zobrazene");

        $this->zoznamFunkcii = array("","user","admin");

        if(isset($_COOKIE['jwt'])) {

    $jwt =$_COOKIE['jwt'];

    $curl = curl_init();

    $data = array("jwt"=>$jwt);
    $data=json_encode($data);

    $url ='http://balik.6f.sk/bakalarka/api/validate_token.php';
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS,$data );
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $vysledok = curl_exec($curl);
    $vysledok =  json_decode($vysledok);

    curl_close($curl);

              $_SESSION["idPouzivatela"] = $vysledok->data->idPouzivatela;
              $_SESSION["firstname"] = $vysledok->data->firstname;
              $_SESSION["lastname"] = $vysledok->data->lastname;
              $_SESSION["email"] = $vysledok->data->email;
              $_SESSION["funkcia"] = $vysledok->data->funkcia;

        }

    }

    public function __destruct()
    {
    }


public function generujHlavicku(){


        echo "<nav class=\"navbar navbar-expand-lg navbar-dark bg-dark\">
  <a class=\"navbar-brand\" href=\"./index.php\">FilmZone</a>
  <button class=\"navbar-toggler\" type=\"button\" data-toggle=\"collapse\" data-target=\"#navbarSupportedContent\" aria-controls=\"navbarSupportedContent\" aria-expanded=\"false\" aria-label=\"Toggle navigation\">
    <span class=\"navbar-toggler-icon\"></span>
  </button>

  <div class=\"collapse navbar-collapse\" id=\"navbarSupportedContent\">
    <ul class=\"navbar-nav mr-auto\">
      <li class=\"nav-item active\">
        <a class=\"nav-link\" href=\"./index.php\">Home <span class=\"sr-only\">(current)</span></a>
      </li>
      <li class=\"nav-item active\">
      </li>
      <li class=\"nav-item active dropdown\">
        <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"navbarDropdown\" role=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
          Menu
        </a>
        <div class=\"dropdown-menu\" aria-labelledby=\"navbarDropdown\">";

        if(empty($_SESSION["email"])){
           echo" <a class=\"dropdown-item\" href=\"./login.php\">Prihlasenie</a>
 
          <a class=\"dropdown-item\" href=\"./registracia.php\">Registracia</a>
        </div>
      </li>";
        }else {
            echo"         
          <a class=\"dropdown-item\" href=\"./vlozFilm.php\">Vlož návrh film</a>
           <a class=\"dropdown-item\" href=\"./ziadost.php\">Vlož požiadavku na film</a>";
           if(!empty($_SESSION["funkcia"])&&$_SESSION["funkcia"]=="admin"){
            echo" <a class=\"dropdown-item\" href=\"./administracia.php\">Administracia</a>";}
echo"
                      <div class=\"dropdown-divider\"></div>
 <a class=\"dropdown-item\" href=\"./logout.php\">Odhlasenie</a>
        </div>
      </li>";
        }
      echo"
    </ul>
    <form class=\"form-inline my-2 my-lg-0\" action=\"./index.php\" method=\"get\">
      <input class=\"form-control mr-sm-2\" type=\"search\" placeholder=\"Zadaj film\" aria-label=\"Search\" id=\"site-search\" name=\"hladaj\">
      <button class=\"btn btn-outline-success my-2 my-sm-0\" type=\"submit\">Hladaj</button>
    </form>
  </div>
</nav>";
}


}
?>







