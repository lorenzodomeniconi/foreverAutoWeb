<?php
class DatabaseHelper {
    /**
     * @var mysqli $db: Connessione al database
     */
    private $db;

    /**
     * Costruttore della classe DatabaseHelper
     * @param string $hostname: Hostname del database
     * @param string $username: Nome utente del database
     * @param string $password: Password del database
     * @param string $dbname: Nome del database
     * @param int $port: Porta del database
     */
    public function __construct($hostname, $username, $password, $dbname, $port) {
        $this->db = new mysqli($hostname, $username, $password, $dbname, $port);
        if($this->db->connect_error) {
            die("La connessione al database non è riuscita: ".$this->db->connect_error);
        }
    }

    /**
     * Ottiene l'utente in base alle credenziali fornite
     * @param string $username: Nome utente
     * @param string $password: Password dell'utente
     * @return array|null Un array contenente le informazioni dell'utente se le credenziali sono corrette, altrimenti null
     */
    function getUtenteByCredenziali($username, $password) {
        // Prendo la password criptata dal DB
        $stmt = $this->db->prepare("SELECT password FROM credenziali WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $res = $stmt->get_result();
        
        if ($res->num_rows == 0) return null;
        
        $row = $res->fetch_assoc();
        $hashedPassword = $row['password'];
    
        // Verifica la password inserita
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
        
    /**
     * Ottiene i veicoli in base ai filtri applicati
     * @param string $search: Termini di ricerca per marca o modello
     * @param string $categoria: Categoria del veicolo
     * @param string $disponibilita: Disponibilità del veicolo (venduto o disponibile)
     * @return array Un array di veicoli che soddisfano i criteri di ricerca
     */
    public function getVehicles($search = 'aaa', $categoria = '', $disponibilita = '') {
        $query = "SELECT numTelaio, marca, modello, alimentazione, prezzo, kilometri, venduto 
                  FROM veicoli 
                  WHERE 1=1 ";
        $types = '';
        $params = [];
        $addSearchFilter = false;
    
        if (!empty($search)) {
            $search = trim($search);
    
            // Rimuove % _ and spaces to check if the search is meaningful
            $searchCheck = str_replace(['%', '_', ' '], '', $search);
    
            if ($searchCheck !== '') { 
                $addSearchFilter = true;
                // Escape % and _ for LIKE
                $search = str_replace(['%', '_'], ['\%', '\_'], $search);
            }
        }
    
        if ($addSearchFilter) {
            $query .= " AND (marca LIKE ? ESCAPE '\\\' OR modello LIKE ? ESCAPE '\\\')";
            $types .= 'ss';
            $params[] = "%" . $search . "%";
            $params[] = "%" . $search . "%";
        }
    
        // Add category filter
        if (!empty($categoria)) {
            $query .= " AND categoria = ?";
            $types .= 's';
            $params[] = $categoria;
        }
    
        // Add availability filter
        if ($disponibilita !== '') {
            $query .= " AND venduto = ?";
            $types .= 'i';
            $params[] = $disponibilita;
        }
    
        $stmt = $this->db->prepare($query);
    
        if (!empty($types)) {
            $stmt->bind_param($types, ...$params);
        }
    
        $stmt->execute();
        $result = $stmt->get_result();
    
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Ottiene le categorie di veicoli disponibili
     * @return array Un array di categorie
     */
    public function getCategories() {
        $stmt = $this->db->prepare("SELECT tipo FROM categorie");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Ottiene i veicoli di una concessionaria specifica
     * @param string $piva: Partita IVA della concessionaria
     * @return array Un array di veicoli associati alla concessionaria
     */
    public function getVehiclesByDealer($piva) {
        $stmt = $this->db->prepare("SELECT numTelaio, marca, modello, alimentazione, prezzo, kilometri, venduto 
            FROM veicoli 
            WHERE concessionaria = ? ");

        $stmt->bind_param("s", $piva);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Ottiene o crea un carrello per l'utente specificato
     * @param string $username: Nome utente per il quale ottenere o creare il carrello
     * @return int Il codice del carrello
     */
    public function getOrCreateCarrello($username) {
        $stmt = $this->db->prepare("SELECT codCarrello 
            FROM carrelli 
            WHERE username = ? AND chiuso = 0 
            LIMIT 1");

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result && $result->num_rows > 0) {
            $res = $result->fetch_assoc();
            $stmt->close();
            return $res['codCarrello'];
        }
        $stmt->close();

        $stmt = $this->db->prepare("INSERT INTO carrelli (username, chiuso) VALUES (?, 0)");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $newCodCarrello = $stmt->insert_id;
        $stmt->close();
    
        return $newCodCarrello;
    }

}