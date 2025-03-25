<?php


class Obsadenie
{
    private $conn;
    private $idObsadenia;
    private $pozicia;
    private $meno;
    private $priezvisko;
    private $idFilmu;
    private $stavObsadenia;

    public function __construct($db){
        $this->conn = $db;
    }

    function delete(){

        $query = "DELETE FROM  balikdb.obsadenie  WHERE idObsadenia = ?";

        $stmt = $this->conn->prepare($query);

        $this->idObsadenia=htmlspecialchars(strip_tags($this->idObsadenia));

        $stmt->bindParam(1, $this->idObsadenia);

        if($stmt->execute()){
            return true;
        }

        return false;
    }


    function update(){
        $query = " UPDATE balikdb.obsadenie set balikdb.obsadenie.pozicia =:pozicia, balikdb.obsadenie.meno = :meno, balikdb.obsadenie.priezvisko = :priezvisko, balikdb.obsadenie.stavObsadenia = :stavObsadenia where idObsadenia= :idObsadenia";

        $stmt = $this->conn->prepare($query);


        $this->idObsadenia=htmlspecialchars(strip_tags($this->idObsadenia));
        $this->pozicia=htmlspecialchars(strip_tags($this->pozicia));
        $this->meno=htmlspecialchars(strip_tags($this->meno));
        $this->priezvisko=htmlspecialchars(strip_tags($this->priezvisko));

        $this->idFilmu=htmlspecialchars(strip_tags($this->idFilmu));

        $this->stavObsadenia=htmlspecialchars(strip_tags($this->stavObsadenia));


        $idObsadenia = $this->getIdObsadenia();
        $pozicia = $this->getPozicia();
        $meno = $this->getMeno();
        $priezvisko = $this->getPriezvisko();
        $stavObsadenia =$this->getStavObsadenia();


        $stmt->bindParam(":idObsadenia",  $idObsadenia);
        $stmt->bindParam(":pozicia", $pozicia );
        $stmt->bindParam(":meno", $meno);
        $stmt->bindParam(":priezvisko", $priezvisko);
        $stmt->bindParam(":stavObsadenia", $stavObsadenia);


        if($stmt->execute()){
            return true;
        }

        return false;
    }


    /**
     * @return mixed
     */
    public function getIdObsadenia()
    {
        return $this->idObsadenia;
    }

    /**
     * @param mixed $idObsadenia
     */
    public function setIdObsadenia($idObsadenia)
    {
        $this->idObsadenia = $idObsadenia;
    }

    /**
     * @return mixed
     */
    public function getPozicia()
    {
        return $this->pozicia;
    }

    /**
     * @param mixed $pozicia
     */
    public function setPozicia($pozicia)
    {
        $this->pozicia = $pozicia;
    }

    /**
     * @return mixed
     */
    public function getMeno()
    {
        return $this->meno;
    }

    /**
     * @param mixed $meno
     */
    public function setMeno($meno)
    {
        $this->meno = $meno;
    }

    /**
     * @return mixed
     */
    public function getPriezvisko()
    {
        return $this->priezvisko;
    }

    /**
     * @param mixed $priezvisko
     */
    public function setPriezvisko($priezvisko)
    {
        $this->priezvisko = $priezvisko;
    }

    /**
     * @return mixed
     */
    public function getIdFilmu()
    {
        return $this->idFilmu;
    }

    /**
     * @param mixed $idFilmu
     */
    public function setIdFilmu($idFilmu)
    {
        $this->idFilmu = $idFilmu;
    }

    /**
     * @return mixed
     */
    public function getStavObsadenia()
    {
        return $this->stavObsadenia;
    }

    /**
     * @param mixed $stavObsadenia
     */
    public function setStavObsadenia($stavObsadenia)
    {
        $this->stavObsadenia = $stavObsadenia;
    }


}