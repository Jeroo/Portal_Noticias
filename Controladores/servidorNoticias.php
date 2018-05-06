<?php

/* Parámetros de conexión con la base de datos. */
define('HOST', 'localhost');
define('USER', 'user_ejercicio');
define('PASS', 'pass_ejercicio');
define('DBASE', 'db_ejercicio');

class BaseDatos {
    
    private $conn;

    /**
     * Nuevo intento de conexión con el sistema.
     */
    public function __construct() {
        $this->conn = new mysqli(HOST, USER, PASS, DBASE);
        if ($this->conn->connect_errno) {
            throw new Exception("Error de conexión con la base de datos");
        }
    }

    /**
     * Autenticación
     */
    public function autenticar(string $usuario, string $password):string {
        $mensajes = [];
	    $sql = "select password from login where usuario = '$usuario' && password = '$password';";
        return $query = $this->conn->query($sql)->num_rows > 0 ? "true" : "false";
    }

    /**
     * Edición de la noticia
     */
    public function modificaNoticia(string $noticia):bool {
		$query = "update noticias SET texto=?";
        $stmt = $this->conn->prepare($query);
		$stmt->bind_param('s', $noticia);
        return $stmt->execute();
    }
	
    /**
     * Refresco de la noticia
     */
    public function refrescaNoticia():array {
        $mensajes = [];
		$sql="SELECT * FROM noticias";
        $query = $this->conn->query($sql);
        while ($row = $query->fetch_assoc()) {
            array_push($mensajes, $row);
        }
        return $mensajes;
    }

    /**
     * Refresco de los comentarios
     */
    public function refrescaComentarios():array {
        $mensajes = [];
		$sql="SELECT * FROM comentarios ORDER BY tiempo DESC LIMIT 10";
        $query = $this->conn->query($sql);
        while ($row = $query->fetch_assoc()) {
            array_push($mensajes, $row);
        }
        return $mensajes;
    }
	
	
    /**
     * Nuevo Comentario
     */
    public function nuevoComentario(string $json):bool {
		$comentario = json_decode($json,true);
        $nombre=$comentario['nombre'];
        $texto=$comentario['texto'];
        $query = "INSERT INTO comentarios(nombre, texto, tiempo) VALUES(?, ?, ?)";		
        $stmt = $this->conn->prepare($query);
		$stmt->bind_param('sss', $nombre, $texto, date ("Y-m-d H:i:s", time()));
        return $stmt->execute();
    }
	
}

$db = new BaseDatos();


/* Autenticación. */
if (isset($_POST['action']) && $_POST['action'] === "autenticar") {
	print $db->autenticar($_POST['usuario'], $_POST['password']);
}


/* Modificación de la noticia. */
if (isset($_POST['action']) && $_POST['action'] === "modificaNoticia") {
	if($db->autenticar($_POST['usuario'], $_POST['password']) == "true"){
		if (!$db->modificaNoticia($_POST['noticia'])) {
			http_response_code(400);
			die("{ 'status': 'error' }");
		} else {
			print("true");
		}
	}
}


/* Nuevo Comentario. */
if (isset($_POST['action']) && $_POST['action'] === "nuevoComentario") {
	if (!$db->nuevoComentario($_POST['comentario'])) {
		http_response_code(400);
		die("{ 'status': 'error' }");
	} else {
		print("true");
	}
}


/* Refresco de la noticia. */
if (isset($_GET['action']) && $_GET['action'] === "refrescaNoticia") {	
	print json_encode($db->refrescaNoticia());
}


/* Refresco de los comentarios. */
if (isset($_GET['action']) && $_GET['action'] === "refrescaComentarios") {	
	print json_encode($db->refrescaComentarios());
}

?>