<?php
class DatabaseHelper {
    // connessione al db
    private $db;

    // metodo costruttore per stabilire la connessione al database
    public function __construct($hostname, $username, $password, $dbname, $port) {
        $this->db = new mysqli($hostname, $username, $password, $dbname, $port);
        if($this->db->connect_error) {
            die("La connessione al database non è riuscita: ".$this->db->connect_error);
        }
    }
}