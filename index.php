<?php include('config.php');?>
<?php require('./vendor/autoload.php')?>
<?php Site::update_usuario_online();
Site::contador();

$homeController = new controller\homeController();
$perfilController = new controller\perfilController();
$comunidadeController = new controller\comunidadeController();
$solicitacoesController = new controller\solicitacoesController();

Router::get('/', function() use ($homeController){
    $homeController->index();
});

Router::get('/me', function() use ($perfilController){
    $perfilController->index();
});

Router::get("/comunidade", function() use ($comunidadeController){
    $comunidadeController->index();
});

Router::get("/solicitacoes", function() use ($solicitacoesController){
    $solicitacoesController->index();
});
?>
