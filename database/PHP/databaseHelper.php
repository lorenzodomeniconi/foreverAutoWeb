<?php
class DatabaseHelper {
    // Connessione al db
    private $db;

    // metodo costruttore per stabilire la connessione al database
    public function __construct($hostname, $username, $password, $dbname, $port) {
        $this->db = new mysqli($hostname, $username, $password, $dbname, $port);
        if($this->db->connect_error) {
            die("La connessione al database non è riuscita: ".$this->db->connect_error);
        }
    }

    // Metodo di login
    function getUtenteByCredenziali($username, $password) {
        // Prendo la password hashata dal DB
        $stmt = $this->db->prepare("SELECT password FROM credenziali WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $res = $stmt->get_result();
        
        if ($res->num_rows == 0) return null;
        
        $row = $res->fetch_assoc();
        $hashedPassword = $row['password'];
    
        // Verifico la password inserita
        if (!password_verify($password, $hashedPassword)) return null;        
    
        // Verifica se è un acquirente
        $stmt = $this->db->prepare("SELECT nome, cognome, username FROM acquirenti WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $res = $stmt->get_result();
    
        if ($res->num_rows > 0) {
            $utente = $res->fetch_assoc();
            $utente["role"] = Roles::BUYER;
            return $utente;
        }
    
        // Verifica se è una concessionaria
        $stmt = $this->db->prepare("SELECT partitaIva, ragSociale, username FROM concessionarie WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $res = $stmt->get_result();
    
        if ($res->num_rows > 0) {
            $utente = $res->fetch_assoc();
            $utente["role"] = Roles::DEALER;
            return $utente;
        }
    
        return null;
    }

}