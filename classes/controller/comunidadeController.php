<?php 
    namespace controller;

    class comunidadeController{
        public function index(){
            if(isset($_GET['addFriend'])){
                $id_amigo = (int)$_GET['addFriend'];
                if($this->is_amigo($id_amigo) == false || $this->amigo_pendente($id_amigo) == false){
                    $this->solicitar_amizade($id_amigo);
                }
                else{
                    \Painel::alerta_js("Você já enviou uma solicitação de amizade para este perfil!");
                    \Painel::redirect_to(INCLUDE_PATH."comunidade");
                }

            }
            if(!isset($_SESSION['email-membro'])){
                \Painel::redirect_to(INCLUDE_PATH);
            }
            if(isset($_GET['sair'])){
                session_unset();
                session_destroy();
                \Painel::redirect_to(INCLUDE_PATH);
            }
            \views\mainView::render("pages/comunidade.php", ["controller"=>$this], "pages/includes/headerLogado.php");
        }

        public function solicitar_amizade($id_amigo){
            $sql = \MySql::conectar()->prepare("INSERT INTO `tb_site.solicitacoes` VALUES (null, ?, ?, 0)");
            $sql->execute(array($_SESSION['id-membro'], $id_amigo));
            \Painel::alerta_js("Solicitação de amizade enviada com sucesso!");
            \Painel::redirect_to(INCLUDE_PATH."comunidade");
        }

        public function amigo_pendente($id_amigo){
            $verifica = \MySql::conectar()->prepare("SELECT id FROM `tb_site.solicitacoes` WHERE (id_from = ? AND id_to = ? AND status = 0) OR (id_from = ? AND id_to = ? AND status = 0)");
            $verifica->execute(array($_SESSION['id-membro'], $id_amigo, $id_amigo, $_SESSION['id-membro']));
            if($verifica->rowCount() == 0){
                return false;
            }
            return true;
        }

        public function is_amigo($id_amigo){
            $verifica = \MySql::conectar()->prepare("SELECT id FROM `tb_site.solicitacoes` WHERE (id_from = ? AND id_to = ? AND status != 0) OR (id_from = ? AND id_to = ? AND status != 0)");
            $verifica->execute(array($_SESSION['id-membro'], $id_amigo, $id_amigo, $_SESSION['id-membro']));
            if($verifica->rowCount() == 0){
                return false;
            }
            return true;
        }
    }
    
?>