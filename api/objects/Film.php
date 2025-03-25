<?php


class Film
{
    private $conn;
    private $id;
    private $idAutora;
    private $nazovFilmu;
    private $popisFilmu;
    private $kategoria;
    private $datumPremierySR;
    private $url;
    private $zoznamObsadenia;
    private $stav;
    /**
     * @return mixed
     */
    public function getStav()
    {
        return $this->stav;
    }

    /**
     * @return mixed
     */
    public function getPopisFilmu()
    {
        return $this->popisFilmu;
    }

    /**
     * @return mixed
     */
    public function getIdAutora()
    {
        return $this->idAutora;
    }

    /**
     * @param mixed $idAutora
     */
    public function setIdAutora($idAutora)
    {
        $this->idAutora = $idAutora;
    }

    /**
     * @return array
     */
    public function getZoznamObsadenia()
    {
        return $this->zoznamObsadenia;
    }

    /**
     * @param array $zoznamObsadenia
     */
    public function setZoznamObsadenia($zoznamObsadenia)
    {
        $this->zoznamObsadenia = $zoznamObsadenia;
    }

    /**
     * @param mixed $popisFilmu
     */
    public function setPopisFilmu($popisFilmu)
    {
        $this->popisFilmu = $popisFilmu;
    }

    /**
     * @param mixed $stav
     */
    public function setStav($stav)
    {
        $this->stav = $stav;
    }
    /**
     * @return mixed
     */
    public function getKategoria()
    {
        return $this->kategoria;
    }

    /**
     * @param mixed $kategoria
     */
    public function setKategoria($kategoria)
    {
        $this->kategoria = $kategoria;
    }

    /**
     * @return mixed
     */
    public function getDatumPremierySR()
    {
        return $this->datumPremierySR;
    }

    /**
     * @param mixed $datumPremierySR
     */
    public function setDatumPremierySR($datumPremierySR)
    {
        $this->datumPremierySR = $datumPremierySR;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getNazovFilmu()
    {
        return $this->nazovFilmu;
    }

    /**
     * @param mixed $nazovFilmu
     */
    public function setNazovFilmu($nazovFilmu)
    {
        $this->nazovFilmu = $nazovFilmu;
    }




    public function __construct($db){
        $this->conn = $db;
        $this->zoznamObsadenia=array();
    }





    function delete(){
        $query = "DELETE FROM  balikdb.obsadenie  WHERE idFilmu = ?";
        $stmt = $this->conn->prepare($query);
        $this->id=htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $query = "DELETE FROM  balikdb.film  WHERE id = ?";

        $stmt = $this->conn->prepare($query);


        $this->id=htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(1, $this->id);


        if($stmt->execute()){
            return true;
        }


        return false;
    }


    function update(){

        $query = " UPDATE balikdb.film set balikdb.film.nazovFilmu =:nazovFilmu, balikdb.film.popisFilmu = :popisFilmu, balikdb.film.kategoria = :kategoria, balikdb.film.datumPremierySR = :datumPremierySR, balikdb.film.url = :url, balikdb.film.stav = :stav where id= :id";

        $stmt = $this->conn->prepare($query);


        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->nazovFilmu=htmlspecialchars(strip_tags($this->nazovFilmu));
        $this->popisFilmu=htmlspecialchars(strip_tags($this->popisFilmu));
        $this->kategoria=htmlspecialchars(strip_tags($this->kategoria));
        $this->datumPremierySR=htmlspecialchars(strip_tags($this->datumPremierySR));
        $this->url=htmlspecialchars(strip_tags($this->url));
        $this->stav=htmlspecialchars(strip_tags($this->stav));


        $stmt->bindParam(':id', $this->id);

        $nazovFilmu=$this->getNazovFilmu();
        $popisFilmu= $this->getPopisFilmu();
        $kategoria = $this->getKategoria();
        $datumPremierySR = $this->getDatumPremierySR();
        $url= $this->getUrl();
        $stav = $this->getStav();

        $stmt->bindParam(":nazovFilmu",$nazovFilmu);
        $stmt->bindParam(":popisFilmu", $popisFilmu);
        $stmt->bindParam(":kategoria", $kategoria);
        $stmt->bindParam(":datumPremierySR", $datumPremierySR);
        $stmt->bindParam(":url", $url);
        $stmt->bindParam(":stav", $stav);

        if($stmt->execute()){
            return true;
        }

        return false;
    }

    function search($keywords){

        $query = "SELECT * from balikdb.film where nazovFilmu Like ?  OR kategoria LIKE ?";

        $stmt = $this->conn->prepare($query);

        $keywords=htmlspecialchars(strip_tags($keywords));

        $stmt->bindParam(2, $keywords);

        if(strlen($keywords ) ==1){

            $keywords = "{$keywords}%";

        }else{
            $keywords = "%{$keywords}%";

        }



        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords);


        $stmt->execute();

        return $stmt;
    }
    function searchPopis($keywords){

        $query = "SELECT * from balikdb.film where nazovFilmu Like ? OR popisFilmu LIKE ?";

        $stmt = $this->conn->prepare($query);

        $keywords=htmlspecialchars(strip_tags($keywords));

        $keywords = "%{$keywords}%";

        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords);


        $stmt->execute();

        return $stmt;
    }
    function pridajObsadenie($film_item){
            array_push($this->zoznamObsadenia,$film_item );

    }

    function getAllObsadenie($keywords){


        $query = "SELECT * from balikdb.obsadenie";



        $stmt = $this->conn->prepare($query);


        $keywords=htmlspecialchars(strip_tags($keywords));

        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords);

        $stmt->execute();

        return $stmt;




}


    function readOne(){


        $query = "select * from balikdb.film where balikdb.film.id = ? ";

        $stmt = $this->conn->prepare( $query );


        $stmt->bindParam(1, $this->id);

        $stmt->execute();


        $row = $stmt->fetch(PDO::FETCH_ASSOC);


        $this->setId($row['id']);
        $this->setNazovFilmu($row['nazovFilmu']);
        $this->setPopisFilmu($row['popisFilmu']);
        $this->setKategoria($row['kategoria']);
        $this->setDatumPremierySR($row['datumPremierySR']);
        $this->setUrl($row['url']);
        $this->setStav($row['stav']);



        $query2 = "select * from balikdb.obsadenie where balikdb.obsadenie.idFilmu = ? and balikdb.obsadenie.stavObsadenia ='zobrazene'";
        $stmt = $this->conn->prepare( $query2 );


        $stmt->bindParam(1, $this->id);

        $stmt->execute();


        if($stmt->rowCount()>0) {

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                extract($row);

                $film_item = array(
                    "idObsadenia" => $idObsadenia,
                    "pozicia" => $pozicia,
                    "meno" => $meno,
                    "priezvisko" => $priezvisko
                );

                array_push($this->zoznamObsadenia, $film_item);
            }
        }


    }


    function create(){


        $query = "INSERT INTO balikdb.film SET balikdb.film.idAutora=:idAutora, balikdb.film.nazovFilmu=:nazovFilmu, balikdb.film.popisFilmu=:popisFilmu, balikdb.film.kategoria =:kategoria ,balikdb.film.datumPremierySR =:datumPremierySR, balikdb.film.url=:url,balikdb.film.stav=:stav";


        $stmt = $this->conn->prepare($query);

        $this->idAutora=htmlspecialchars(strip_tags($this->idAutora));
        $this->nazovFilmu=htmlspecialchars(strip_tags($this->nazovFilmu));
        $this->popisFilmu=htmlspecialchars(strip_tags($this->popisFilmu));
        $this->kategoria=htmlspecialchars(strip_tags($this->kategoria));
        $this->datumPremierySR=htmlspecialchars(strip_tags($this->datumPremierySR));
        $this->url=htmlspecialchars(strip_tags($this->url));
        $this->stav=htmlspecialchars(strip_tags($this->stav));


        $id = $this->getId();
        $idAutora = $this->getIdAutora();
        $nazovFilmu = $this->getNazovFilmu();
        $popisFilmu = $this->getPopisFilmu();
        $kategoria = $this->getKategoria();
        $datumPremierySR = $this->getDatumPremierySR();
        $url= $this->getUrl();
        $stav =$this->getStav();
        $stmt->bindParam(":idAutora", $idAutora);
        $stmt->bindParam(":nazovFilmu", $nazovFilmu);
        $stmt->bindParam(":popisFilmu", $popisFilmu);
        $stmt->bindParam(":kategoria", $kategoria);
        $stmt->bindParam(":datumPremierySR", $datumPremierySR);
        $stmt->bindParam(":url", $url);
        $stmt->bindParam(":stav", $stav);


        if($stmt->execute()){
            return true;
        }

        return false;

    }

    function vlozObsadenie(){


        $query = "INSERT INTO balikdb.obsadenie SET balikdb.obsadenie.pozicia=:pozicia, balikdb.obsadenie.meno=:meno, balikdb.obsadenie.priezvisko =:priezvisko ,balikdb.obsadenie.idFilmu =:idFilmu";


        $stmt = $this->conn->prepare($query);


        $obsadenie =end($this->zoznamObsadenia);

        $obsadenie["pozicia"] = htmlspecialchars(strip_tags($obsadenie["pozicia"]));
        $obsadenie["meno"] = htmlspecialchars(strip_tags($obsadenie["meno"]));
        $obsadenie["priezvisko"] = htmlspecialchars(strip_tags($obsadenie["priezvisko"]));
        $obsadenie["idFilmu"] = htmlspecialchars(strip_tags($obsadenie["idFilmu"]));


        $stmt->bindParam(":pozicia", $obsadenie["pozicia"]);
        $stmt->bindParam(":meno", $obsadenie["meno"]);
        $stmt->bindParam(":priezvisko", $obsadenie["priezvisko"]);
        $stmt->bindParam(":idFilmu", $obsadenie["idFilmu"]);

        if($stmt->execute()){
            return true;
        }

        return false;

    }

}