<?php 
    class Usuario{
        public function atualizar_usuario($nome, $senha, $img){
            $sql = MySql::conectar()->prepare("UPDATE `tb_admin_usuarios` SET nome = ?, password = ?, img = ? WHERE user = ?");
            if($sql->execute(array($nome, $senha, $img, $_SESSION["user"]))){
                return true;
            }
            else{
                return false;
            }
        }

        public static function user_exists($user){
            $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin_usuarios` WHERE user = ?");
            $sql->execute(array($user));
            if($sql->rowCount() > 0){
                return true;
            }
            return false;
        }

        public static function cadastrar_usuario($user, $senha, $imagem, $nome, $cargo){
            $sql = MySql::conectar()->prepare("INSERT INTO `tb_admin_usuarios` VALUES (null, ?, ?, ?, ?, ?)");

            

            $sql->execute(array($user, md5($senha), $imagem, $nome, $cargo));

        }
    }
?>