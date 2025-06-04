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
     * Restituisce le informazioni dell'acquirente tramite username
     * @param string $username: username dell'acquirente ricercato
     * @return array: tutti i dati dell'acquirente che rispetta il criterio di ricerca
     */
    public function getAcquirente($username) {
        $query = "SELECT codFiscale, nome, cognome, email FROM acquirenti WHERE username = ? LIMIT 1 ";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s',$username);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC)[0] ?? []; // Restituisce un array vuoto se non trovato
    }

    /**
     * Restituisce le informazioni della concessionaria tramite partita IVA
     * @param string $partitaIva: partita IVA della concessionaria ricercata
     * @return array: tutti i dati della concessionaria che rispetta il criterio di ricerca
     */
    public function getConcessionaria($partitaIva) {
        $query = "SELECT partitaIva, ragSociale, sede, email FROM concessionarie WHERE partitaIva = ? LIMIT 1 ";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s',$partitaIva);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC)[0] ?? []; // Restituisce un array vuoto se non trovato
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
     * Ottiene il veicolo richiesto tramite numero di telaio
     * @param string $numTelaio: Termine di ricerca per numero di telaio
     * @return array Un array contenente i dati del veicolo che soddisfa il criterio di ricerca
     */
    public function getVehicleByNumTelaio($numTelaio) {
        $query = "SELECT v.numTelaio, v.marca, v.modello, v.descrizione, v.alimentazione, 
                         v.prezzo, v.kilometri, v.proprietariPrecedenti, c.ragSociale, 
                         v.venduto, v.concessionaria 
                  FROM veicoli v JOIN concessionarie c ON v.concessionaria = c.partitaIva 
                  WHERE numTelaio = ?";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s',$numTelaio);
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
    public function getOrCreateCart($username) {
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

    /**
     * Inserisce un nuovo veicolo nel database
     * @param string $numTelaio: numero di telaio del veicolo che si vuole inserire e le altre informazioni necessarie
     * @return int per indicare se l'inserimento è andato a buon fine
     */
    public function insertVehicle($numTelaio, $marca, $modello, $descrizione, $alimentazione, $prezzo, $categoria, $concessionaria, $kilometri, $proprietariPrecedenti) {
        $query = "INSERT INTO veicoli (numTelaio, marca, modello, descrizione, alimentazione, prezzo, categoria, concessionaria, kilometri, proprietariPrecedenti, venduto) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('sssssissii',$numTelaio, $marca, $modello, $descrizione, $alimentazione, $prezzo, $categoria, $concessionaria, $kilometri, $proprietariPrecedenti);
        $stmt->execute();
        return $stmt->insert_id;
    }

    /**
     * Elimina il veicolo con il corrispondente numero di telaio
     * @param string $numTelaio: numero di telaio del veicolo che si vuole eliminare
     * @return int per indicare se l'eliminazione è andata a buon fine
     */
    public function deleteVehicle($numTelaio) {
        $stmt = $this->db->prepare("DELETE FROM veicoli WHERE numTelaio = ?");
        $stmt->bind_param("s", $numTelaio);
        $stmt->execute();
        return $stmt->affected_rows;
    }

    /**
     * Inserisce un veicolo all'interno di un carrello
     * @param int $codCarrello: codice del carrello in cui si vuole inserire il veicolo
     * @param string $numTelaio: numero di telaio del veicolo del veicolo che si vuole aggiungere al carrello
     * @return string: ritorna un messaggio di errore se quel determinato veicolo è già presente in quel determinato carrello
     */
    public function insertVehicleInCart($codCarrello, $numTelaio) {
        $carrello = $this->getVehicleInCart($codCarrello);

        // Controlla se il veicolo è già presente nel carrello        
        foreach ($carrello as $veicolo) {
            if ($veicolo['numTelaio'] == $numTelaio) {
                // Veicolo già presente nel carrello
                return ' Veicolo già presente nel carrello'; 
            }
        }

        $stmt = $this->db->prepare("INSERT INTO carrelliSpecifici (codCarrello, numTelaio) VALUES (?, ?)");
        $stmt->bind_param("is", $codCarrello, $numTelaio);
        $res = $stmt->execute();
        if(isset($res)) {
            return '';
        }
        return '';
    }

    /**
     * Restituisce i veicoli all'interno di uno specifico carrello
     * @param int $codCarrello: codice del carrello di cui si vuole visualizzare il contenuto
     * @return array: array contenente tutti i veicoli presenti nel carrello richiesto
     */
    public function getVehicleInCart($codCarrello) {
        $stmt = $this->db->prepare("
            SELECT v.numTelaio, v.marca, v.modello, v.prezzo, v.venduto
            FROM veicoli v
            INNER JOIN carrelliSpecifici cs ON v.numTelaio = cs.numTelaio
            WHERE cs.codCarrello = ?");
        $stmt->bind_param("i", $codCarrello);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Crea un nuovo utente all'interno del database
     * @param string $numTelaio: numero di telaio del veicolo di cui si vogliono modificare i dati e i dati aggiornati
     * @return void
     */
    public function updateVehicle($numTelaio, $marca, $modello, $prezzo, $descrizione, $proprietariPrecedenti, $kilometri, $alimentazione, $venduto) {
        $query = "UPDATE veicoli SET marca = ?, modello = ?, prezzo = ?, descrizione = ?, proprietariPrecedenti = ?, kilometri = ?, alimentazione = ?, venduto = ? WHERE numTelaio = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ssisiisis", $marca, $modello, $prezzo, $descrizione, $proprietariPrecedenti, $kilometri, $alimentazione, $venduto, $numTelaio);
        $stmt->execute();
    }

    /**
     * Rimuove un veicolo dal carrello di un utente
     * @param int $codCarrello: codice dal carrello da cui si vuole eliminare il veicolo
     * @param string $numTelaio: numero di telaio del veicolo che si vuole eliminare
     * @return void
     */
    public function deleteVehicleFromCart($codCarrello, $numTelaio) {
        $stmt = $this->db->prepare("DELETE FROM carrelliSpecifici WHERE codCarrello = ? AND numTelaio = ?");
        $stmt->bind_param("is", $codCarrello, $numTelaio);
        $stmt->execute();
    }

    /**
     * Crea un nuovo utente all'interno del database
     * @param array $data: Array nel quale sono contenute le informazioni inserite dall'utente
     * in fase di registrazione
     * @param string $ruolo: Indica se l'utente è una concessionaria o un acquirente
     * @return bool per indicare se la registrazione è andata a buon fine
     */
    public function createNewUtente($data, $ruolo) {
        // Registro le credenziali
        $hashedPassword = password_hash($data["password"], PASSWORD_DEFAULT);
        
        $stmt = $this->db->prepare("INSERT INTO `credenziali` (`username`, `password`) VALUES (?, ?)");
        $stmt->bind_param("ss", $data["username"], $hashedPassword);
        $stmt->execute();
        // Collego l'username all'utente
        if($ruolo == "acquirente") {
            // Creo un nuovo utente acquirente
            $stmt = $this->db->prepare("INSERT INTO `acquirenti` (`codFiscale`, `nome`, `cognome`, `username`, `email`) VALUES (?,?,?,?,?)");
            $stmt->bind_param("sssss", $data["codFiscale"], $data["nome"], $data["cognome"], $data["username"], $data["email"]);
            $stmt->execute();
            return true;
        } else if($ruolo == "concessionaria") {
            // Creo un nuovo utente venditore
            $partitaIva = (int) $data["partitaIva"];
            $stmt = $this->db->prepare("INSERT INTO `concessionarie` (`partitaIva`, `ragSociale`, `sede`, `email`, `username`) VALUES (?,?,?,?,?)");
            $stmt->bind_param("issss", $partitaIva, $data["ragSociale"], $data["sede"], $data["email"], $data["username"]);
            $stmt->execute();
            return true;
        }
        return false;
    }

    // Invio notifica ad username con messaggio
    public function sendNotify($username, $messaggio) {
        $stmt = $this->db->prepare("INSERT INTO notifiche (dataOra, messaggio, destinatario, nuova) VALUES (?, ?, ?, 1)");
        $dataOra = date("Y-m-d H:i:s");
        $stmt->bind_param("sss", $dataOra, $messaggio, $username);
        $stmt->execute();
    }

    // Ritorna le notifiche associate a un certo username
    public function getNotifiesByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM notifiche WHERE destinatario = ? ORDER BY dataOra DESC");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Elimina una notifica
    public function deleteNotify($codNotifica) {
        $query = "DELETE FROM notifiche WHERE codNotifica = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $codNotifica);
        $stmt->execute();
    }

    // Segna come letta una notifica
    public function markNotifyAsRead($codNotifica) {
        $query = "UPDATE notifiche SET nuova = 0 WHERE codNotifica = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $codNotifica);
        $stmt->execute();
    }

    // Chiusura del carrello, chiusura vendita, modifica stato dei veicoli coinvolti e invio notifiche ai diretti interessati
    public function closeCartAndPay($codCarrello) {
        // Segna come venduti i veicoli presenti nel carrello
        $query1 = "
            UPDATE veicoli 
            SET venduto = 1 
            WHERE numTelaio IN (
                SELECT numTelaio 
                FROM carrelliSpecifici 
                WHERE codCarrello = ?
            )";
        $stmt1 = $this->db->prepare($query1);
        $stmt1->bind_param("i", $codCarrello);
        $stmt1->execute();
    
        // Chiude il carrello
        $query2 = "UPDATE carrelli SET chiuso = 1 WHERE codCarrello = ?";
        $stmt2 = $this->db->prepare($query2);
        $stmt2->bind_param("i", $codCarrello);
        $stmt2->execute();

        // Inserisce la vendita nella tabella vendite
        $dataOra = date("Y-m-d H:i:s");
        $stmtVendita = $this->db->prepare("INSERT INTO vendite (codCarrello, dataOra) VALUES (?, ?)");
        $stmtVendita->bind_param("is", $codCarrello, $dataOra);
        $stmtVendita->execute();
    
        // Recupera lo username associato al carrello per mandare una notifica all'acquirente
        $stmtUser = $this->db->prepare("SELECT username FROM carrelli WHERE codCarrello = ?");
        $stmtUser->bind_param("i", $codCarrello);
        $stmtUser->execute();
        $resultUser = $stmtUser->get_result();
        $user = $resultUser->fetch_all(MYSQLI_ASSOC);
    
        $username = $user[0]['username'];
    
        // Recupera tutti i veicoli nel carrello con anche la concessionaria in modo da poter mandare una notifica alle concessionarie che hanno venduto il loro veicolo
        $stmtVeicoli = $this->db->prepare("
            SELECT v.numTelaio, v.marca, v.modello, v.concessionaria 
            FROM veicoli v 
            JOIN carrelliSpecifici cs ON v.numTelaio = cs.numTelaio 
            WHERE cs.codCarrello = ?
        ");
        $stmtVeicoli->bind_param("i", $codCarrello);
        $stmtVeicoli->execute();
        $resVeicoli = $stmtVeicoli->get_result();
        $veicoli = $resVeicoli->fetch_all(MYSQLI_ASSOC);
    
        // Per ogni veicolo invia una notifica a chi ha acquistato e chi ha venduto
        foreach ($veicoli as $veicolo) {
            $marca = $veicolo['marca'];
            $modello = $veicolo['modello'];
            $partitaIVA = $veicolo['concessionaria'];
    
            $messaggioUtente = "Hai completato con successo l'acquisto di $marca $modello.";
            $this->sendNotify($username, $messaggioUtente);
    
            // Recupera lo username della concessionaria a partire dalla partita Iva
            $stmtConcessionario = $this->db->prepare("SELECT username FROM concessionarie WHERE partitaIva = ?");
            $stmtConcessionario->bind_param("s", $partitaIVA);
            $stmtConcessionario->execute();
            $resConcessionario = $stmtConcessionario->get_result();
            $rows = $resConcessionario->fetch_all(MYSQLI_ASSOC);
            
            $usernameConcessionaria = $rows[0]['username'];
            $messaggioVenditore = "Il tuo veicolo $marca $modello è stato venduto.";
            $this->sendNotify($usernameConcessionaria, $messaggioVenditore);
        }
    }

}