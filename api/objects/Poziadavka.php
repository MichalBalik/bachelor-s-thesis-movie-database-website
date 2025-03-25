<?php


class Poziadavka
{
    private $conn;
    private $idPoziadavky;
    private $nazovPozadovanehoFilmu;
    private $popis;
    private $odpovedAdmina;
    private $idAdmina;
    private $emailPozadovatela;

    public function __construct($db){
        $this->conn = $db;
    }

    /**
     * @return mixed
     */
    public function getConn()
    {
        return $this->conn;
    }

    /**
     * @param mixed $conn
     */
    public function setConn($conn)
    {
        $this->conn = $conn;
    }

    /**
     * @return mixed
     */
    public function getIdPoziadavky()
    {
        return $this->idPoziadavky;
    }

    /**
     * @param mixed $idPoziadavky
     */
    public function setIdPoziadavky($idPoziadavky)
    {
        $this->idPoziadavky = $idPoziadavky;
    }

    /**
     * @return mixed
     */
    public function getNazovPozadovanehoFilmu()
    {
        return $this->nazovPozadovanehoFilmu;
    }

    /**
     * @param mixed $nazovPozadovanehoFilmu
     */
    public function setNazovPozadovanehoFilmu($nazovPozadovanehoFilmu)
    {
        $this->nazovPozadovanehoFilmu = $nazovPozadovanehoFilmu;
    }

    /**
     * @return mixed
     */
    public function getPopis()
    {
        return $this->popis;
    }

    /**
     * @param mixed $popis
     */
    public function setPopis($popis)
    {
        $this->popis = $popis;
    }

    /**
     * @return mixed
     */
    public function getOdpovedAdmina()
    {
        return $this->odpovedAdmina;
    }

    /**
     * @param mixed $odpovedAdmina
     */
    public function setOdpovedAdmina($odpovedAdmina)
    {
        $this->odpovedAdmina = $odpovedAdmina;
    }

    /**
     * @return mixed
     */
    public function getIdAdmina()
    {
        return $this->idAdmina;
    }

    /**
     * @param mixed $idAdmina
     */
    public function setIdAdmina($idAdmina)
    {
        $this->idAdmina = $idAdmina;
    }

    /**
     * @return mixed
     */
    public function getEmailPozadovatela()
    {
        return $this->emailPozadovatela;
    }

    /**
     * @param mixed $emailPozadovatela
     */
    public function setEmailPozadovatela($emailPozadovatela)
    {
        $this->emailPozadovatela = $emailPozadovatela;
    }



    function create(){


        $query = "INSERT INTO balikdb.poziadavka SET balikdb.poziadavka.nazovPozadovanehoFilmu=:nazovPozadovanehoFilmu, balikdb.poziadavka.popis=:popis, balikdb.poziadavka.emailPozadovatela =:emailPozadovatela";


        $stmt = $this->conn->prepare($query);


        $this->nazovPozadovanehoFilmu=htmlspecialchars(strip_tags($this->nazovPozadovanehoFilmu));
        $this->popis=htmlspecialchars(strip_tags($this->popis));
        $this->emailPozadovatela=htmlspecialchars(strip_tags($this->emailPozadovatela));




        $nazovPozadovanehoFilmu = $this->getNazovPozadovanehoFilmu();
        $popis = $this->getPopis();
        $emailPozadovatela = $this->getEmailPozadovatela();


        $stmt->bindParam(":nazovPozadovanehoFilmu", $nazovPozadovanehoFilmu);
        $stmt->bindParam(":popis", $popis);
        $stmt->bindParam(":emailPozadovatela", $emailPozadovatela);



        if($stmt->execute()){
            return true;
        }

        return false;

    }
    function getZoznamPoziadavok($keyword){
        if($keyword =="NEVYBAVENE" ||$keyword == ""){
            $query = "SELECT * from balikdb.poziadavka where idAdmina is null";


        }
        elseif($keyword =="VSETKYPOZIADAVKY"){
            $query = "SELECT * from balikdb.poziadavka";

        }
        else{
        $query = "SELECT * from balikdb.poziadavka where nazovPozadovanehoFilmu Like ? OR idPoziadavky LIKE ?";

    }

        $stmt = $this->conn->prepare($query);

        $keywords=htmlspecialchars(strip_tags($keyword));
        $keywords = "$keywords";
        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords);

        $stmt->execute();

        return $stmt;

    }

    function update(){

        $query = " UPDATE balikdb.poziadavka set balikdb.poziadavka.nazovPozadovanehoFilmu =:nazovPozadovanehoFilmu, balikdb.poziadavka.popis = :popis, balikdb.poziadavka.odpovedAdmina = :odpovedAdmina, balikdb.poziadavka.idAdmina = :idAdmina, balikdb.poziadavka.emailPozadovatela = :emailPozadovatela where idPoziadavky= :idPoziadavky";

        $stmt = $this->conn->prepare($query);


        $this->idPoziadavky=htmlspecialchars(strip_tags($this->idPoziadavky));
        $this->nazovPozadovanehoFilmu=htmlspecialchars(strip_tags($this->nazovPozadovanehoFilmu));
        $this->popis=htmlspecialchars(strip_tags($this->popis));
        $this->odpovedAdmina=htmlspecialchars(strip_tags($this->odpovedAdmina));
        $this->idAdmina=htmlspecialchars(strip_tags($this->idAdmina));
        $this->emailPozadovatela=htmlspecialchars(strip_tags($this->emailPozadovatela));



        $stmt->bindParam(':idPoziadavky', $this->idPoziadavky);

        $nazovPozadovanehoFilmu=$this->getNazovPozadovanehoFilmu();
        $popis= $this->getPopis();
        $odpovedAdmina = $this->getOdpovedAdmina();
        $idAdmina = $this->getIdAdmina();
       $emailPozadovatela= $this->getEmailPozadovatela();


        $stmt->bindParam(":nazovPozadovanehoFilmu",$nazovPozadovanehoFilmu);
        $stmt->bindParam(":popis", $popis);
        $stmt->bindParam(":odpovedAdmina", $odpovedAdmina);
        $stmt->bindParam(":idAdmina", $idAdmina);
        $stmt->bindParam(":emailPozadovatela", $emailPozadovatela);


        if($stmt->execute()){
            return true;
        }

        return false;
    }
    function delete(){

        $query = "DELETE FROM  balikdb.poziadavka  WHERE idPoziadavky = ?";

        $stmt = $this->conn->prepare($query);


        $this->idPoziadavky=htmlspecialchars(strip_tags($this->idPoziadavky));

        $stmt->bindParam(1, $this->idPoziadavky);


        if($stmt->execute()){
            return true;
        }


        return false;
    }
}