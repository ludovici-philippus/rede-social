<?php 
    namespace models;

    class homeModel{
        public static function listar_solicitacoes(){
            $sql = \MySql::conectar()->prepare("SELECT * FROM `tb_site.solicitacoes` WHERE id_to = ? AND status = 0");
            $sql->execute(array($_SESSION['id-membro']));
            return $sql->fetchAll();
        }

        public static function get_membro_by_id($id){
            $sql = \MySql::conectar()->prepare("SELECT * FROM `tb_site.membro` WHERE id = ?");
            $sql->execute(array($id));
            return $sql->fetch();
        }
    }
?>