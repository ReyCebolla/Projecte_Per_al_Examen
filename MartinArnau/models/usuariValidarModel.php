<?php
/*
class usuariValidarModel {
    private $db;

    public function __construct() {
        // Millor fer la connexió aquí o rebre-la per paràmetre
        $this->db = mysqli_connect("localhost", "bookusers", "bookusers", "webbooks");
    }

    public function validarCredencials($usuari, $password) {
        // Fem servir una consulta preparada per seguretat
        $sql = "SELECT count(*) as total FROM credencials WHERE usuari = ? AND contrassenya = ?";
        $stmt = mysqli_prepare($this->db, $sql);
        
        mysqli_stmt_bind_param($stmt, "ss", $usuari, $password);
        mysqli_stmt_execute($stmt);
        
        $resultat = mysqli_stmt_get_result($stmt);
        $fila = mysqli_fetch_assoc($resultat);
        
        return $fila['total'] > 0; // Retorna true si existeix, false si no
    }
}
*/

class usuariValidarModel {
    private $db;

    public function __construct() {
        // Dades de configuració
        $host = "localhost";
        $dbname = "webbooks";
        $user = "root";
        $pass = "";

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

    //Valida les credencials de l'usuari

    public function validarCredencials($usuari, $password) {
        try {
            // 1. Preparem la sentència. 
            // Fem servir "paràmetres amb nom" (:usu i :pas), que és més clar que els "?"
            $sql = "SELECT count(*) FROM credencials WHERE usuari = :usu AND contrassenya = :pas";
            $stmt = $this->db->prepare($sql);

            // 2. Executem passant un array amb les dades.
            // PDO s'encarrega automàticament de netejar les dades (Seguretat SQL Injection)
            $stmt->execute(array(
                ':usu' => $usuari,
                ':pas' => $password
            ));

            // 3. Obtenim el resultat. 
            // fetchColumn() és ideal per a un SELECT count(*) perquè retorna directament el número.
            $count = $stmt->fetchColumn();

            return $count > 0; // Retorna true si l'usuari existeix

        } catch (PDOException $e) {
            // Si la consulta falla (per exemple, si la taula no existeix)
            return false;
        }
    }

}

?>