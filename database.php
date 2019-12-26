<?php
/**
 * Created by PhpStorm.
 * User: vladislavakopalova
 * Date: 11.12.17
 * Time: 16:32
 */
class database{
    private $spojenie;
    private $host;
    private $pouzivatel;
    private $heslo;
    private $nazovDB;
    private $lastId;

    public function __construct()
    {
        $this->spojenie=null;
        $this->host="localhost";
        $this->pouzivatel="root";
        $this->heslo="";
        $this->nazovDB="AdaptivnySystem";
    }

    public function pripoj()
    {
        if ($this->spojenie == null) {
            $this->spojenie = new mysqli($this->host, $this->pouzivatel,
                $this->heslo, $this->nazovDB);

            if ($this->spojenie->connect_error) {
                die("Spojenie zlyhalo: " . $this->spojenie->connect_error);
            }
        }
    }

    public function odpoj()
    {
        if ($this->spojenie != null) { // Odpojit len ak spojenie existuje
            //$this->spojenie->close();
            mysqli_close($this->spojenie);
            $this->spojenie = null;
        }
    }

    public function posliPoziadavku($sqlRetazec)
    {
        if ($this->spojenie != null) {
            $result = mysqli_query($this->spojenie, $sqlRetazec);
            $this->lastId= mysqli_insert_id($this->spojenie);
            return $result;

            //return $this->spojenie->query($sqlRetazec);
        } else {
            return null;
        }
    }

    public function getLastId()
    {
        return $this->lastId;
    }
}


?>