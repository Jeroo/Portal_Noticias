<?php

/* Parámetros de conexión con la base de datos. */
define('HOST', 'localhost');
define('USER', 'user_ejercicio');
define('PASS', 'pass_ejercicio');
define('DBASE', 'db_ejercicio');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

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
    public function modificaNoticia(string $noticia,string $titulo,int $noticiaId):bool {
		$query = "update noticias SET texto='$noticia',titulo='$titulo' where noticiaId='$noticiaId'";
        $stmt = $this->conn->prepare($query);
		//$stmt->bind_param('sss', $noticia,$titulo,$noticiaId);
        return $stmt->execute();
    }

     /**
     * Borrar la noticia
     */
    public function eliminarNoticia(int $noticiaId):bool {
		$query = "delete from noticias where noticiaId=?";
        $stmt = $this->conn->prepare($query);
		$stmt->bind_param('s', $noticiaId);
        return $stmt->execute();
    }

     /**
     * Añadir una noticia
     */
    public function agregarNoticia(string $noticia,string $titulo):int {       
		$query = "INSERT INTO noticias (texto,titulo) VALUES(?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ss', $noticia, $titulo);
        $stmt->execute();
        $LAST_ID = $this->conn->insert_id; 
        return $LAST_ID;
    }

       /**
     * obtener una noticia
     */
    public function obtenerNoticias(int $noticiaId):array {     
        
        $noticias = [];
        $sql="SELECT * FROM noticias WHERE noticiaId=$noticiaId";
        $query = $this->conn->query($sql);
 
         while ($row = $query->fetch_assoc()) {
 
             array_push($noticias, $row);     
         }
 
       return $noticias;
 
      }
	
    /**
     * Refresco de la noticia
     */
    public function refrescaNoticia():array {
        $noticias = [];
       // $sql="SELECT n.noticiaId,n.titulo,n.texto,count(c.noticiaId) as totalComentarios FROM noticias n LEFT join comentarios c on c.noticiaId = n.noticiaId";
       $sql="SELECT * FROM noticias";
        $query = $this->conn->query($sql);
        while ($row = $query->fetch_assoc()) {
            array_push($noticias, $row);

        }
        
        return $noticias;
    }

    /**
     * Refresco de los comentarios
     */
    public function refrescaComentarios(int $noticiaId):array {
        $comentarios = [];
		$sql="SELECT * FROM comentarios where noticiaId=$noticiaId ORDER BY tiempo DESC LIMIT 10";
        $query = $this->conn->query($sql);
        while ($row = $query->fetch_assoc()) {
            array_push($comentarios, $row);
        }
        return $comentarios;
    }
	
	
    /**
     * Nuevo Comentario
     */
    public function nuevoComentario(string $texto,string $nombre,int $noticiaId):bool {

        $query = "INSERT INTO comentarios(nombre, texto, tiempo, noticiaId) VALUES(?, ?, ?, ?)";		
        $stmt = $this->conn->prepare($query);
        $tiempo =  date ("Y-m-d H:i:s", time());
		$stmt->bind_param('ssss', $nombre, $texto,$tiempo, $noticiaId);
        return $stmt->execute();
    }

     /**
     * Agregar imagenes
     */

    //https://manuais.iessanclemente.net/index.php/Almacenamiento_de_im%C3%A1genes_en_bases_de_datos_con_PHP     
    public function agregarImagen(string $data,string $tipo,int $noticiaId):bool {     
       // Insertamos en la base de datos.
        $query = "INSERT INTO noticiasimagenes(imagen, tipo_imagen, noticiaId) VALUES(?, ?, ?)";		
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('sss', $data, $tipo, $noticiaId);
        return $stmt->execute();
    }

    public function obtenerImagen(int $noticiaId):array {     
       // Consulta de búsqueda de la imagen.
       $mensajes = [];
       $sql="SELECT * FROM noticiasimagenes WHERE noticiaId=$noticiaId";
       $query = $this->conn->query($sql);

        while ($row = $query->fetch_assoc()) {

            array_push($mensajes, $row);     
        }

      return $mensajes;

     }

	
}

$db = new BaseDatos();


/* Autenticación. */
if (isset($_POST['action']) && $_POST['action'] === "autenticar") {

    if($db->autenticar($_POST['usuario'], $_POST['password']) == "true"){

         $_SESSION['login_user'] = $_POST['usuario'];
         
        //header("location: ../vistas/administracion.php");

        print $db->autenticar($_POST['usuario'], $_POST['password']);

    }else {
        print $db->autenticar($_POST['usuario'], $_POST['password']);
       // echo("<script>javascript:alert('usuario o contraseña incorrectos');window.location='../vistas/login.php';</script>");
       
     }
   
    
}

/* Agregar una noticia. */
if (isset($_POST['action']) && $_POST['action'] === "agregarNoticia") {

     $idNoticia = $db->agregarNoticia($_POST['texto'],$_POST['titulo']);

    if ($idNoticia > 0) {

        $_SESSION['idNoticia'] = $idNoticia;
        print $idNoticia;

    } else {
        
        http_response_code(400);
        die("{ 'status': 'error' }");
    }
}


/* Salir de administración */
if (isset($_GET['action']) && $_GET['action'] === "logout") {

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    unset($_SESSION["login_user"]);  
    session_unset();
    session_destroy();
    ob_start();
    header("location: ../index.php");
    ob_end_flush(); 
    include './inidex.php';
    //include 'home.php';
    exit();
}

/* Modificación de la noticia. */
if (isset($_POST['action']) && $_POST['action'] === "modificaNoticia") {

	
		if (!$db->modificaNoticia($_POST['texto'],$_POST['titulo'],$_POST['noticiaId'])) {
            
            http_response_code(400);
            die("{ 'status': 'error' }");
            
		} else {
			print("true");
        }
    
}


/* Nuevo Comentario. */
if (isset($_POST['action']) && $_POST['action'] === "nuevoComentario") {
	if (!$db->nuevoComentario($_POST['texto'],$_POST['nombre'],$_POST['noticiaId'])) {
		http_response_code(400);
		die("{ 'status': 'error' }");
	} else {
		print("true");
	}
}


/* Refresco de la noticia. */
if (isset($_GET['action']) && $_GET['action'] === "refrescaNoticia") {	
    print json_encode($db->refrescaNoticia());
    exit();
}


/* Refresco de los comentarios. */
if (isset($_GET['action']) && $_GET['action'] === "refrescaComentarios") {	
    print json_encode($db->refrescaComentarios($_GET['noticiaId']));
    exit();
}

/* Obtener imagen. */
if (isset($_GET['action']) && $_GET['action'] === "obtenerimagen") {
    $datos =$db->obtenerImagen($_GET['noticiaId']);
    $imagen =$datos[0]['imagen']; // Datos binarios de la imagen.

  // 
  
//  print $imagen;
   //echo $imagen;
    print json_encode(base64_encode($imagen));
}

/* vamos a una noticia en particular*/
if (isset($_GET['action']) && $_GET['action'] === "noticiaparticular") {	
   // echo "yendo a la noticia... ID: ".$_GET['id'];

    header("location: ../Vistas/detalleNoticia.php?id=".$_GET['id']);

    exit();
}


/* Refresco de los comentarios. */

if (isset($_POST['action']) && $_POST['action'] === "cargarImagen") {

    // Verificamos si el tipo de archivo es un tipo de imagen permitido.
    // y que el tamaño del archivo no exceda los 16MB
    $permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
    $limite_kb = 16384;
    //$idNoticia = 2;
    $idNoticia = $_SESSION['idNoticia'];

    //foreach($_FILES["imagen"]["tmp_name"] as $key=>$tmp_name)
    for ($i = 0; $i < count($_FILES['imagen']['name']); $i++) 
    {
        $file_name=$_FILES["imagen"]["name"][$i];
        $file_tmp=$_FILES["imagen"]["tmp_name"][$i];
        //$ext=pathinfo($file_name,PATHINFO_EXTENSION);

        if (in_array($_FILES['imagen']['type'][$i], $permitidos) && $_FILES['imagen']['size'][$i] <= $limite_kb * 1024)
        {            

            // Archivo temporal
            $imagen_temporal = $_FILES['imagen']['tmp_name'][$i];

            // Tipo de archivo
            $tipo = $_FILES['imagen']['type'][$i];

            // Leemos el contenido del archivo temporal en binario.
            $fp = fopen($imagen_temporal, 'r+b');
            $data = fread($fp, filesize($imagen_temporal));
            fclose($fp);

            if ($db->agregarImagen($data,$tipo,$idNoticia))
            {
               print "El archivo ha sido copiado exitosamente.";
            }
            else
            {
               print "Ocurrió algun error al copiar el archivo.";
            }
        }
        else
        {
            print "Formato de archivo no permitido o excede el tamaño límite de $limite_kb Kbytes.";
        }
    }
  //}
}

?>