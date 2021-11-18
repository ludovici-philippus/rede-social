<?php 
    class Site{
        public static function update_usuario_online(){
            $hora_atual = date("Y-m-d H:i:s");
            if(isset($_SESSION["online"])){
                $token = $_SESSION["online"];

                $check = MySql::conectar()->prepare("SELECT `id` FROM `tb_admin.online` WHERE token = ?");
                $check->execute(array($token));

                if($check->rowCount() == 1){
                    $sql = MySql::conectar()->prepare("UPDATE `tb_admin.online` SET ultima_acao = ? WHERE token = ?");

                    $sql->execute(array($hora_atual, $token));
                }
                else{
                    $token = $_SESSION["online"];
                    $ip = $_SERVER["REMOTE_ADDR"];

                    $sql = MySql::conectar()->prepare("INSERT INTO `tb_admin.online` VALUES (null, ?, ?, ?)");

                    $sql->execute(array($ip, $hora_atual, $token));    
                }
            } else{
                $_SESSION["online"] = uniqid();
                $token = $_SESSION["online"];
                $ip = $_SERVER["REMOTE_ADDR"];

                $sql = MySql::conectar()->prepare("INSERT INTO `tb_admin.online` VALUES (null, ?, ?, ?)");

                $sql->execute(array($ip, $hora_atual, $token));
            }
        }

        public static function contador(){
            if(!isset($_COOKIE["visita"])){
                setcookie("visita", "true", time()  + (60*60*24*7));
                $ip = $_SERVER["REMOTE_ADDR"];
                $dia = date("Y-m-d");

                $sql = MySql::conectar()->prepare("INSERT INTO `tb_admin.visitas` VALUES (null, ?, ?)");

                $sql->execute(array($ip, $dia));
            }
        }

        public static function pegar_visitas($type){
            if($type == 1){
                $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.visitas`");
                $sql->execute();
                return count($sql->fetchAll());
            }else{
                $dia = date("Y-m-d");
                $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.visitas` WHERE dia = ?");
                $sql->execute(array($dia));

                return count($sql->fetchAll());
            }
        }
    }

?>