<?php
    /**
     * Autor: Carlos Clemente
     * Correo: cclemente1998@gmail.com
     */
    class Database{
        private $con;
        private $dbhost = "127.0.0.1";
        private $dbuser = "root";
        private $dbpass = "root";
        private $dbname = "parking";

        function __construct(){
            $this->connect_db();
        }

        public function connect_db(){
            $this->con = mysqli_connect($this->dbhost, $this->dbuser, $this->dbpass, $this->dbname);
            if(mysqli_connect_error()){
                die("Conexión a la base de datos falló " . mysqli_connect_error() . mysqli_connect_errno());
            }
        }

        public function sanitize($var){
            $return = mysqli_real_escape_string($this->con, $var);
            return $return;
        }

        public function createUsuarios($idUsuario, $pass, $tipo, $nombre){
            $sql = "INSERT INTO usuarios (idUsuario, pass, tipo, nombre) VALUES ('$idUsuario', '$pass', '$tipo', '$nombre')";
            $res = mysqli_query($this->con, $sql);
            if ($res) {
                return true;
            } else {
                return false;
            }
        }

        public function createRegistroEntrada($idUsuario, $nombre, $tipo){
            $sql = "INSERT INTO registro_entradas (idUsuario, nombre, tipo, fecha) VALUES ('$idUsuario', '$nombre', '$tipo', NOW())";
            $res = mysqli_query($this->con, $sql);
            if ($res) {
                return true;
            } else {
                return false;
            }
        }

        public function read($idUsuario, $pass){
            $sql = "SELECT idUsuario, nombre, tipo FROM usuarios WHERE idUsuario = '$idUsuario' AND pass = '$pass'";

            $res = mysqli_query($this->con, $sql);
            return $res;
        }

        public function readAllUsers(){
            $sql = "SELECT * FROM usuarios";

            $res = mysqli_query($this->con, $sql);
            return $res;
        }

        public function readAllEntries(){
            $sql = "SELECT * FROM registro_entradas";

            $res = mysqli_query($this->con, $sql);
            return $res;
        }
    }
?>
