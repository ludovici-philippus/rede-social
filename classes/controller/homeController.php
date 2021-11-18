<?php 
    namespace controller;

    class homeController{
        public function index(){
            if(isset($_SESSION['login-membro']) && $_SESSION['login-membro'] == true){
                \Painel::redirect_to(INCLUDE_PATH."me");
            }
            if(isset($_POST['login'])){
                $email = $_POST['email'];
                $senha = sha1($_POST['senha']);
                $sql = \MySql::conectar()->prepare("SELECT * FROM `tb_site.membro` WHERE email = ? AND senha = ?");
                $sql->execute(array($email, $senha));
                if($sql->rowCount() == 1){
                    \Painel::alerta_js("Logado com sucesso!");
                    $info = $sql->fetch();
                    $_SESSION['login-membro'] = true;
                    $_SESSION['id-membro'] = $info['id'];
                    $_SESSION['nome-membro'] = $info['nome'];
                    $_SESSION['email-membro'] = $email;
                    $_SESSION['senha-membro'] = $senha;
                    $_SESSION["img-membro"] = $info['imagem'];
                    \Painel::redirect_to(INCLUDE_PATH."me");
                }else{
                    \Painel::alerta_js("E-mail ou senha incorretos!");
                    \Painel::redirect_to(INCLUDE_PATH);
                }
            }
            if(isset($_POST['cadastro'])){
                $nome = $_POST['nome'];
                $email = $_POST['email'];
                $senha = sha1($_POST['senha']);
                $imagem = $_FILES['imagem'];
                if($nome === "")
                    \Painel::alerta_js("O campo nome não pode estar vazio!");
                else if(filter_var($email, FILTER_VALIDATE_EMAIL) == false)
                    \Painel::alerta_js("O e-mail digitado é inválido!");
                else if($senha === "")
                    \Painel::alerta_js("O campo senha não pode estar vazio!");
                else if(\Painel::imagem_valida($imagem) == false)
                    \Painel::alerta_js("A imagem é inválida!");
                else{
                    $verifica = \MySql::conectar()->prepare("SELECT email FROM `tb_site.membro` WHERE email = ?");
                    $verifica->execute(array($email));
                    if($verifica->rowCount() == 1){
                        \Painel::alerta_js("E-mail já está cadastrado, por favor use outro!");
                        die(\Painel::redirect_to(INCLUDE_PATH));
                    }

                    $id_imagem = \Painel::upload_file($imagem);
                    $sql = \MySql::conectar()->prepare("INSERT INTO `tb_site.membro` VALUES (null, ?, ?, ?, ?)");
                    $sql->execute(array($nome, $email, $senha, $id_imagem));
                    \Painel::alerta_js("O cadastro foi realizado com sucesso!");
                }

            }
            \views\mainView::render("pages/home.php");
        }
    }
    
?>