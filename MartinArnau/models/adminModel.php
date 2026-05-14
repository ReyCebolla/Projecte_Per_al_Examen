<?php
/*
class adminModel {
    private $db;

    public function __construct() {
        // Dades de configuració
        $host = "localhost";
        $dbname = "webbooks";
        $user = "bookadmin";
        $pass = "1111";

        try {
            // Creem la connexió PDO (DSN: Data Source Name)
            $this->db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
            
            // Configurem PDO perquè llanci excepcions en cas d'error
            // Això ens ajuda molt a detectar fallades de sintaxi o connexió
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch (PDOException $e) {
            // Si hi ha un error de connexió, el capturem aquí
            die("Error de connexió: " . $e->getMessage());
        }
    }

    //Llista els clients
    public function llistaClients() {
        try {
            // 1. Preparem la sentència. 
            // Fem servir "paràmetres amb nom" (:usu i :pas), que és més clar que els "?"
            $sql = "SELECT * FROM client";
            $stmt = $this->db->prepare($sql);

            // 2. Executem passant un array amb les dades.
            // PDO s'encarrega automàticament de netejar les dades (Seguretat SQL Injection)
            $stmt->execute();

            // Retornem un array associatiu amb tots els resultats
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }
    


}
*/



class adminModel {
    private $db;

    public function __construct() {
        // Dades de configuració
        $host = "localhost";
        $dbname = "webbooks";
        $user = "root";
        $pass = "";

        $this->db = mysqli_connect("localhost", $user, $pass, $dbname);
    }

    //Llista els clients
    public function llistaClients() {
 
        $sql = "SELECT * FROM client";
        $stmt = mysqli_prepare($this->db, $sql);
        
        mysqli_stmt_execute($stmt);
        
        $resultat = mysqli_stmt_get_result($stmt);
        
        // Creem un array per guardar totes les files
        $dades = array();
        while ($fila = mysqli_fetch_assoc($resultat)) {
            $dades[] = $fila;
        }
        return $dades;
    }
    

        //Llista els clients
    public function esborraClients($ids) {
        $sql = "DELETE FROM client WHERE id = ?";
        $stmt = mysqli_prepare($this->db, $sql);
        
        // Codi per caçar errors si la columna no es diu 'id'
        if (!$stmt) {
            die("Error SQL esborrant client: " . mysqli_error($this->db));
        }

        foreach ($ids as $id) {
            mysqli_stmt_bind_param($stmt, "i", $id); 
            mysqli_stmt_execute($stmt);
        }
        return true;
    }
    
    //Actualitzar clients
    public function actualitzaClients($clients) {
        $sql = "UPDATE client SET nom=?, adreca=?, ciutat=? WHERE id=?";
        $stmt = mysqli_prepare($this->db, $sql);
        
        foreach ($clients as $c) {
            mysqli_stmt_bind_param($stmt, "sssi", $c['nom'], $c['adreca'], $c['ciutat'], $c['id']); 
            mysqli_stmt_execute($stmt);
        }
        return true;
    }
    
    //LLIBRES
    //Llista els llibres
    public function llistaLlibres() {
        $sql = "SELECT * FROM llibre";
        $stmt = mysqli_prepare($this->db, $sql);
        mysqli_stmt_execute($stmt);
        $resultat = mysqli_stmt_get_result($stmt);
        
        $dades = array();
        while ($fila = mysqli_fetch_assoc($resultat)) {
            $dades[] = $fila;
        }
        return $dades;
    }
    
    //Esborrar llibres
    public function esborraLlibres($isbns) {
        $sql = "DELETE FROM llibre WHERE isbn = ?";
        $stmt = mysqli_prepare($this->db, $sql);
        
        foreach ($isbns as $isbn) {
            mysqli_stmt_bind_param($stmt, "s", $isbn); 
            mysqli_stmt_execute($stmt);
        }
        return true;
    }
    
    //Actualitzar llibres
    public function actualitzaLlibres($llibres) {
        $sql = "UPDATE llibre SET autor=?, titol=?, preu=? WHERE isbn=?";
        $stmt = mysqli_prepare($this->db, $sql);
        
        foreach ($llibres as $ll) {
            mysqli_stmt_bind_param($stmt, "ssds", $ll['autor'], $ll['titol'], $ll['preu'], $ll['isbn']);
            mysqli_stmt_execute($stmt);
        }
        return true;
    }


}





?>