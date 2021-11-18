<?php 
    if(isset($_COOKIE["lembrar"])){
        $user = $_COOKIE["user"];
        $password = $_COOKIE["password"];
        $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin_usuarios` WHERE user = ? AND password = ?");
        $sql->execute(array($user, md5($password)));

        if($sql->rowCount() == 1){
            $info = $sql->fetch();
            $_SESSION["login"] = true;
            $_SESSION["user"] = $user;
            $_SESSION["password"] = $password;
            $_SESSION['id_user'] = $info['id'];
            $_SESSION["cargo"] = $info["cargo"];
            $_SESSION["nome"] = $info["nome"];
            $_SESSION["img"] = $info["img"];
            header("Location: ".INCLUDE_PATH_PAINEL);
            die();
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php INCLUDE_PATH_PAINEL?>css/style.css">
    <title>Painel de controle</title>
</head>
<body>
    <div class="box-login">
        <?php 
            if(isset($_POST["acao"])){
                $user = $_POST["user"];
                $password = $_POST["password"];

                $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin_usuarios` WHERE user = ? AND password = ?");
                $sql->execute(array($user, md5($password)));

                if($sql->rowCount() == 1){
                    $info = $sql->fetch();
                    $_SESSION["login"] = true;
                    $_SESSION["user"] = $user;
                    $_SESSION["password"] = $password;
                    $_SESSION['id_user'] = $info['id'];
                    $_SESSION["cargo"] = $info["cargo"];
                    $_SESSION["nome"] = $info["nome"];
                    $_SESSION["img"] = $info["img"];
                    if(isset($_POST["lembrar"])){
                        setcookie("lembrar", true, time()+(60*60*24*7), "/");
                        setcookie("user", $user, time()+(60*60*24*7), "/");
                        setcookie("password", $password, time()+(60*60*24*7), "/");
                    }
                    header("Location: ".INCLUDE_PATH_PAINEL);
                    die();
                }else{
                    echo "<script>alert('Usuário ou senha incorreto!');</script>";
                }
            }
        ?>
        <h2>Efetue o login:</h2>
        <form method="post">
            <input type="text" name="user" placeholder="Login..." required>

            <input type="text" name="password" placeholder="Senha..." required>

            <div class="form-group-login left">
                <input type="submit" value="Logar" name="acao">
            </div>

            <div class="form-group-login right">
                <label>Lembrar login</label>
                <input type="checkbox" name="lembrar">
            </div>
            <div class="clear"></div>
        </form>
    </div>
</body>
</html>