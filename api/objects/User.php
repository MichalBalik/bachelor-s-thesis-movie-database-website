<?php

class User{
    private $conn;
    private $idPouzivatela;
    private $firstname;
    private $lastname;
    private $email;
    private $password;
    private $funkcia;


    public function __construct($db){
        $this->conn = $db;
    }


    /**
     * @return mixed
     */
    public function getIdPouzivatela()
    {
        return $this->idPouzivatela;
    }

    /**
     * @param mixed $idPouzivatela
     */
    public function setIdPouzivatela($idPouzivatela)
    {
        $this->idPouzivatela = $idPouzivatela;
    }

    /**
     * @return mixed
     */
    public function getFunkcia()
    {
        return $this->funkcia;
    }

    /**
     * @param mixed $funkcia
     */
    public function setFunkcia($funkcia)
    {
        $this->funkcia = $funkcia;
    }


    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }



    function create(){


        $query = "INSERT INTO balikdb.pouzivatelia SET firstname = :firstname, lastname = :lastname, email = :email, password = :password";
        $stmt = $this->conn->prepare($query);


        $this->firstname=htmlspecialchars(strip_tags($this->firstname));
        $this->lastname=htmlspecialchars(strip_tags($this->lastname));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->password=htmlspecialchars(strip_tags($this->password));


        $stmt->bindParam(':firstname', $this->firstname);
        $stmt->bindParam(':lastname', $this->lastname);
        $stmt->bindParam(':email', $this->email);


        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $password_hash);


        if($stmt->execute()){
            return true;
        }

        return false;
    }


    function emailExists(){


        $query = "SELECT * FROM balikdb.pouzivatelia WHERE email = ? LIMIT 0,1";
        $stmt = $this->conn->prepare( $query );


        $this->email=htmlspecialchars(strip_tags($this->email));

        $stmt->bindParam(1, $this->email);

        $stmt->execute();

        $num = $stmt->rowCount();

        if($num>0){

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->idPouzivatela = $row['idPouzivatela'];
            $this->firstname = $row['firstname'];
            $this->lastname = $row['lastname'];
            $this->password = $row['password'];
            $this->funkcia = $row['funkcia'];


            return true;
        }


        return false;
    }

    function getAllUsers(){

        $query = "SELECT balikdb.pouzivatelia.idPouzivatela,balikdb.pouzivatelia.firstname,balikdb.pouzivatelia.lastname, balikdb.pouzivatelia.email,balikdb.pouzivatelia.funkcia from balikdb.pouzivatelia ";



        $stmt = $this->conn->prepare($query);


        $stmt->execute();

        return $stmt;

}


        public function update(){



            $query = "UPDATE balikdb.pouzivatelia
            SET
                firstname = :firstname,
                lastname = :lastname,
                funkcia = :funkcia,
                email = :email
                
                
            WHERE idPouzivatela = :idPouzivatela";


            $stmt = $this->conn->prepare($query);

            $this->firstname=htmlspecialchars(strip_tags($this->firstname));
            $this->lastname=htmlspecialchars(strip_tags($this->lastname));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->funkcia=htmlspecialchars(strip_tags($this->funkcia));


            $stmt->bindParam(':firstname', $this->firstname);
            $stmt->bindParam(':lastname', $this->lastname);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':funkcia', $this->funkcia);


            if(!empty($this->password)){
                $this->password=htmlspecialchars(strip_tags($this->password));
                $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
                $stmt->bindParam(':password', $password_hash);
            }

            $stmt->bindParam(':idPouzivatela', $this->idPouzivatela);

            if($stmt->execute()){
                return true;
            }

            return false;
        }


    }

