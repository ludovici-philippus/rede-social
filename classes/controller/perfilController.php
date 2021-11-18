<?php 
    namespace controller;

    class perfilController{
        public function index(){
            if(!isset($_SESSION['email-membro'])){
                \Painel::redirect_to(INCLUDE_PATH);
            }
            if(isset($_GET['sair'])){
                session_unset();
                session_destroy();
                \Painel::redirect_to(INCLUDE_PATH);
            }

            if(isset($_POST['postar'])){
                $mensagem = strip_tags($_POST['mensagem']);
                if($mensagem == ""){
                    \Painel::alerta_js("Sua mensagem não pode ser vazias");
                    \Painel::redirect_to(INCLUDE_PATH."me");
                }else{
                    $sql = \MySql::conectar()->prepare("INSERT INTO `tb_site.feed` VALUES (null, ?, ?)");
                    $sql->execute(array($_SESSION['id-membro'], $mensagem));
                }
            }
            \views\mainView::render("pages/me.php", [], "pages/includes/headerLogado.php");
        }
    }
    
?>