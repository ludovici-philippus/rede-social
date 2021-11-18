<?php 
    namespace models;

    class meModel{
        public static function listar_amigos(){
            $sql = \MySql::conectar()->prepare("SELECT * FROM `tb_site.solicitacoes` WHERE (id_to = ? AND status = 1) OR (id_from = ? AND status = 1)");
            $sql->execute(array($_SESSION['id-membro'], $_SESSION['id-membro']));
            $sql = $sql->fetchAll();
            $arr = [];
            $id_membro = $_SESSION['id-membro'];
            foreach ($sql as $membros) {
                if($membros['id_from'] == $id_membro){
                    $arr[] = $membros['id_to'];
                }else{
                    $arr[] = $membros['id_from'];
                }
            }
            return $arr;
        }
    }
?>