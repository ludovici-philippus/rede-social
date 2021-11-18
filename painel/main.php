<?php 
    if(isset($_GET["loggout"])){
        Painel::loggout();
        Painel::redirect();
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" href="<?php echo INCLUDE_PATH_PAINEL;?>jquery-ui.min.css">
    <link rel="stylesheet" href="<?php INCLUDE_PATH_PAINEL; ?>css/style.css">
    <script src="https://kit.fontawesome.com/53f10bde57.js" crossorigin="anonymous"></script>
    <title>Painel de Controle</title>
    <script src="https://cdn.tiny.cloud/1/ryfrlrf9b187a2ca3ol1tw3il7venwgdolh2egh66un8rk0t/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
    tinymce.init({
      selector: '.tinymce',
      plugins: 'a11ychecker advcode casechange export formatpainter linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments tinymcespellchecker',
      toolbar: 'a11ycheck addcomment showcomments casechange checklist code export formatpainter pageembed permanentpen table',
      toolbar_mode: 'floating',
      tinycomments_mode: 'embedded',
      tinycomments_author: 'Author name',
   });
  </script>
</head>
<body>
    <base base="<?php echo INCLUDE_PATH_PAINEL;?>">
    <aside class="left">
        <div class="menu-wraper">
            <div class="box-usuario">
                <div class="avatar-usuario">
                    <?php
                        if($_SESSION["img"] == ""){
                    ?>
                    <i class="fa fa-user"></i>
                    <?php  } else{?>
                    <img src="<?php echo INCLUDE_PATH_PAINEL;?>/uploads/<?php echo $_SESSION['img'];?>">
                    <?php }?>
                </div>
            
                <div class="nome-usuario">
                    <p><?php echo $_SESSION["nome"]; ?></p>
                    <p><?php echo Painel::cargo_converter($_SESSION["cargo"]); ?></p>
                </div>

                <div class="botoes">
                    <p>Cadastro</p>
                    <a href="<?php echo INCLUDE_PATH_PAINEL; ?>cadastrar-depoimento">Cadastrar Depoimento</a>
                    <a href="<?php echo INCLUDE_PATH_PAINEL; ?>cadastrar-servico">Cadastrar Serviço</a>
                    <a href="">Cadastrar Banner</a>
                    <p>Gestão</p>
                    <a href="<?php echo INCLUDE_PATH_PAINEL ?>listar-depoimentos">Listar Depoimentos</a>
                    <a href="<?php echo INCLUDE_PATH_PAINEL; ?>listar-servicos">Listar Serviços</a>
                    <a href="">Listar Banners</a>
                    <p>Administração do painel</p>
                    <a href="<?php echo INCLUDE_PATH_PAINEL ?>editar-usuario">Editar Usuário</a>
                    <a <?php verifica_permissao_menu(2); ?>  href="<?php echo INCLUDE_PATH_PAINEL ?>adicionar-usuario">Adicionar Usuários</a>
                    <p>Configuração Geral</p>
                    <a href="">Editar</a>
                    <p>Gestão de Notícias</p>
                    <a href="<?php echo INCLUDE_PATH_PAINEL;?>cadastrar-categoria">Cadastrar Categoria</a>
                    <a href="<?php echo INCLUDE_PATH_PAINEL;?>gerenciar-categorias">Gerenciar Categorias</a>
                    <a href="<?php echo INCLUDE_PATH_PAINEL;?>cadastrar-noticia">Cadastrar Notícia</a>
                    <a href="<?php echo INCLUDE_PATH_PAINEL;?>gerenciar-noticias">Gerenciar Notícias</a>
                    <p>Gestão de clientes</p>
                    <a href="<?php echo INCLUDE_PATH_PAINEL;?>cadastrar-clientes">Cadastrar clientes</a>
                    <a href="<?php echo INCLUDE_PATH_PAINEL;?>gerenciar-clientes">Gerenciar cliente</a>
                    <p>Controle Financeiro</p>
                    <a href="<?php echo INCLUDE_PATH_PAINEL;?>visualizar-pagamentos">Visualizar Pagamentos</a>
                    <p>Controle de Estoque</p>
                    <a href="<?php echo INCLUDE_PATH_PAINEL;?>cadastrar-produtos">Cadastrar Produtos</a>
                    <a href="<?php echo INCLUDE_PATH_PAINEL;?>visualizar-produtos">Visualizar Produtos</a>
                    <p>Gestão Imóveis</p>
                    <a href="<?php echo INCLUDE_PATH_PAINEL;?>cadastrar-empreendimento">Cadastrar Empreendimento</a>
                    <a href="<?php echo INCLUDE_PATH_PAINEL;?>listar-empreendimentos">Listar Empreendimentos</a>
                    <p>Gestão EAD</p>
                    <a href="<?php echo INCLUDE_PATH_PAINEL;?>novo-aluno">Novo Aluno</a>
                    <a href="<?php echo INCLUDE_PATH_PAINEL;?>novo-modulo">Novo Módulo</a>
                    <a href="<?php echo INCLUDE_PATH_PAINEL;?>nova-aula">Nova Aula</a>
                </div>
            </div>
        </div>
    </aside>
    <header class="left">
        <div class="center">
            <div class="menu-btn left btn">
                <i class= "fa fa-bars"></i>
            </div>
            <div class="btn btn-home">
                <a href="<?php echo INCLUDE_PATH_PAINEL; ?>calendario"><i class="fa fa-calendar"></i></a>
            </div>
            <span class="texto-home"><a href="<?php echo INCLUDE_PATH_PAINEL; ?>calendario">Calendário</a></span>
            <div class="btn btn-home">
                <a href="<?php echo INCLUDE_PATH_PAINEL; ?>chat"><i class="fa fa-comments-o"></i></a>
            </div>
            <span class="texto-home"><a href="<?php echo INCLUDE_PATH_PAINEL; ?>chat">Chat Online</a></span>
            <div class="btn-home btn">
                <a href="<?php echo INCLUDE_PATH_PAINEL; ?>home"><i class="fa fa-home"></i></a>
            </div> 
            <span class="texto-home"><a href="<?php echo INCLUDE_PATH_PAINEL; ?>home">Página Inicial</a></span>
            <a class='right loggout btn' href="<?php echo INCLUDE_PATH_PAINEL?>?loggout">    
                <div>X</div>
            </a>
            <?php echo "<div class='right user'>".ucfirst($_SESSION["user"])."</div>" ?> 
            <div class="clear"></div>
        </div>
    </header>
    <main class="left">
        <?php $url = Painel::carregar_pagina(); ?>
    </main>
    <div class="clear"></div>
    <?php print_r($url);?>
<script src="<?php echo INCLUDE_PATH;?>js/jquery.js"></script>
<script src="<?php echo INCLUDE_PATH;?>js/constants.js"></script>
<script src="<?php echo INCLUDE_PATH_PAINEL;?>js/jquery.ajaxform.js"></script>
<script src="<?php echo INCLUDE_PATH_PAINEL;?>js/jquery-ui.min.js"></script>
<script src="<?php echo INCLUDE_PATH_PAINEL;?>js/boxes-moviment.js"></script>
<script src="<?php echo INCLUDE_PATH_PAINEL;?>js/main.js"></script>
<script src="<?php echo INCLUDE_PATH_PAINEL;?>js/vanilla_mask.js"></script>
<script src="<?php echo INCLUDE_PATH_PAINEL;?>js/mask.js"></script>
<?php Painel::load_js(array("chat.js"), "chat");?>
<?php Painel::load_js(array("calendario.js"), "calendario");?>
</body>
</html>