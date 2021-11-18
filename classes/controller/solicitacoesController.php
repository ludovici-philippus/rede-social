<?php 
    namespace controller;

    class solicitacoesController{
        public function index(){
            if(!isset($_SESSION['email-membro'])){
                \Painel::redirect_to(INCLUDE_PATH);
            }
            if(isset($_GET['sair'])){
                session_unset();
                session_destroy();
                \Painel::redirect_to(INCLUDE_PATH);
            }else if(isset($_GET['aceita'])){
                $id_amigo = $_GET['aceita'];
                $sql = \MySql::conectar()->prepare("UPDATE `tb_site.solicitacoes` SET status = 1 WHERE id_from = ? AND id_to = ?");
                $sql->execute(array($id_amigo, $_SESSION['id-membro']));
                \Painel::alerta_js("Solicitação de amizade aceita!");
                \Painel::redirect_to(INCLUDE_PATH."solicitacoes");
            }else if(isset($_GET["rejeita"])){
                $id_amigo = $_GET['rejeita'];
                $sql = \MySql::conectar()->prepare("DELETE FROM `tb_site.solicitacoes` WHERE id_from = ? AND id_to = ?");
                $sql->execute(array($id_amigo, $_SESSION['id-membro']));
                \Painel::alerta_js("Solicitação de amizade rejeitada!");
                \Painel::redirect_to(INCLUDE_PATH."solicitacoes");
            }
            \views\mainView::render("pages/solicitacoes.php", ["controller"=>$this], "pages/includes/headerLogado.php");
        }

        
    }
    
?>