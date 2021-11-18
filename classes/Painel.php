<?php 
    class Painel{
        public static $cargos = [
            0 => "Usuario",
            1 => "Editor",
            2 => "Administrador"
        ];

        public static function load_js($js_file, $url2){
            $path = INCLUDE_PATH_PAINEL;
            if($_GET['url'] == "$url2"){
                foreach ($js_file as $key => $value) {
                    echo "<script src='$path/js/$value'></script>";
                }   
            }
        }

        public static function logado(){
            return isset($_SESSION['login']) ? true : false;
        }

        public static function loggout(){
            session_destroy();
            setcookie("lembrar", true, time() - 1, "/");
        }

        public static function redirect(){
            header("Location: ". INCLUDE_PATH_PAINEL);
            die();
        }

        public static function cargo_converter($cargo){
            $arr = [
                0 => "Usuario",
                1 => "Editor",
                2 => "Administrador"
            ];
            return $arr[$cargo];
        }

        public static function carregar_pagina(){
            if(isset($_GET['url'])){
                $url = explode("/", $_GET["url"]);
                if(file_exists('pages/'.$url[0].'.php')){
                    include('pages/'.$url[0].'.php');
                }else{
                    header("Location: ".INCLUDE_PATH_PAINEL);
                }
            }else{
                include("pages/home.php");
            }
            return $url;
        }

        public static function listar_usuarios_usuarios(){
            self::limpar_usuarios_online();
            $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.online`");
            $sql->execute();
            return $sql->fetchAll();
        }

        public static function limpar_usuarios_online(){
            $date = date("Y-m-d H:i:s");
            $sql = MySql::conectar()->exec("DELETE FROM `tb_admin.online` WHERE ultima_acao < '$date' - INTERVAL 1 MINUTE");
        }

        public static function alerta($tipo, $mensagem){
            if($tipo == "sucesso"){ 
                echo "<div class='box-alert sucesso'><i class='fa fa-check'></i> ".$mensagem."</div>";
            }else if($tipo == "erro"){
                echo "<div class='box-alert erro'><i class='fa fa-times'></i> ".$mensagem."</div>";
            }else if($tipo == "atencao"){
                echo "<div class='box-alert atencao'><i class='fa fa-warning'></i> ".$mensagem."</div>";
            }
        }

        public static function alerta_js($msg){
            echo "<script>alert('$msg');</script>";
        }

        public static function imagem_valida($imagem){
            if($imagem["type"] == "image/jpeg" || $imagem["type"] == "image/jpg" || $imagem["type"] == "image/png"){
                $tamanho = intval($imagem["size"] / 1024);
                if($tamanho < 350){
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }

        public static function upload_file($file){
            $formato_arquivo = explode(".",$file["name"]);
            $imagem_nome = uniqid().".".$formato_arquivo[count($formato_arquivo) - 1];
            if(move_uploaded_file($file["tmp_name"], BASE_DIR."/uploads/".$imagem_nome)){
                return $imagem_nome;
            }else{
                return false;
            }
        }

        public static function delete_file($file){
            @unlink("uploads/".$file);
        }

        public static function get_higher_order_id($table, $where = "", $arr = array()){
            $sql = MySql::conectar()->prepare("SELECT order_id FROM `$table` $where GROUP BY order_id DESC LIMIT 1");
            $sql->execute($arr);
            $sql = $sql->fetch();
            if($sql != false)
                return $sql;
            return 0;
        }

        public static function already_exists($table, $name_clm, $content){
            $sql = MySql::conectar()->prepare("SELECT * FROM `$table` WHERE $name_clm = ?");
            $sql->execute(array($content));
            if($sql->rowCount() != 0)
                return true;
            return false;
        }

        public static function insert($arr){
            $certo = true;
            $nome_tabela = $arr["nome_tabela"];
            $query = "INSERT INTO `$nome_tabela` VALUES (null";
            foreach($arr as $key => $value){
                $nome = $key;
                $valor = $value;
                if($nome == "acao" || $nome == "nome_tabela"){
                    continue;
                }
                if($value == ""){
                    $certo = false;
                    break;
                }
                $query.=",?";
                $parametros[] = $value;
            }
            $query.=",?";
            $parametros[] = self::get_higher_order_id($nome_tabela)["order_id"] + 1;
            $query.=")";
            if($certo == true){
                $sql = MySql::conectar()->prepare($query);
                $sql->execute($parametros);
            }
            return $certo;
        }

        public static function select_all($table, $order_id = true, $start = null, $end = null){
            if($order_id == false){
                $sql = MySql::conectar()->prepare("SELECT * FROM 
                `$table` ");
            }
            else{
                if($start == null && $end == null){
                    $sql = MySql::conectar()->prepare("SELECT * FROM 
                    `$table` ORDER BY order_id");
                }else{
                    $sql = MySql::conectar()->prepare("SELECT * FROM 
                    `$table` ORDER BY order_id LIMIT $start, $end");
                }
            }
            $sql->execute();
            return $sql->fetchAll();
        }

        public static function deletar($table, $id){
            try {
                $sql = MySql::conectar()->prepare("DELETE FROM `$table` WHERE id=?");
                $sql->execute(array($id));
                return true;
            } catch (\Throwable $th) {
                echo $th;
                return false;
            }
        }

        public static function redirect_to($url=""){
            echo "<script>location.href='$url'</script>";
            die();
        }

        public static function select($table, $condition, $arr, $fetchAll = false, $order_id = false){
            if($order_id)
                $order_id = "ORDER BY order_id";
            else
                $order_id = "";
            $sql = MySql::conectar()->prepare("SELECT * FROM `$table` WHERE $condition $order_id");
            $sql->execute($arr);
            if($fetchAll)
                return $sql->fetchAll();
            return $sql->fetch();
            
        }

        public static function update($arr, $id){
            $certo = true;
            $nome_tabela = $arr['nome_tabela'];
            $query = "UPDATE `$nome_tabela` SET ";
            $i = 0;
            foreach ($arr as $nome => $valor) {
                if($nome == "acao" || $nome == "nome_tabela"){
                    continue;
                }
                if($valor == ""){
                    $certo = false;
                    break;
                }
                if($i == 0){
                    $query .= "$nome=?";    
                }else{
                    $query .= ", $nome=?";
                }
                $parametros[] = $valor;
                $i++;
            }
            $query .= " WHERE id=?";
            $parametros[] = $id;
            if($certo == true){
                $sql = MySql::conectar()->prepare($query);
                $sql->execute($parametros);
            }
            return $certo;
        }

        public static function order_item($table, $order, $id, $where="", $arr = array()){
            if($order == "up"){
                $info_item_atual = Painel::select($table, "id=?", array($id));
                $order_id = $info_item_atual["order_id"];
                
                $item_before = MySql::conectar()->prepare("SELECT * FROM `$table` WHERE order_id = $order_id -1 $where LIMIT 1");
                
                $item_before->execute($arr);
                if($item_before->rowCount() == 0)
                    return;
                $item_before = $item_before->fetch();

                Painel::update(array("nome_tabela" => $table, "order_id" => $info_item_atual["order_id"]), $item_before["id"]);
                Painel::update(array("nome_tabela" => $table, "order_id" => $item_before["order_id"]), $info_item_atual["id"]);
            }
            else if($order == "down"){
                $info_item_atual = Painel::select($table, "id=?", array($id));
                $order_id = $info_item_atual["order_id"];
                
                $item_after = MySql::conectar()->prepare("SELECT * FROM `$table` WHERE order_id = $order_id +1 $where LIMIT 1");
                
                $item_after->execute($arr);
                if($item_after->rowCount() == 0)
                    return;
                $item_after = $item_after->fetch();

                Painel::update(array("nome_tabela" => $table, "order_id" => $info_item_atual["order_id"]), $item_after["id"]);
                Painel::update(array("nome_tabela" => $table, "order_id" => $item_after["order_id"]), $info_item_atual["id"]);
            }
        }

        public static function generate_slug($str){
			$str = mb_strtolower($str);
			$str = preg_replace('/(â|á|ã)/', 'a', $str);
			$str = preg_replace('/(ê|é)/', 'e', $str);
			$str = preg_replace('/(í|Í)/', 'i', $str);
			$str = preg_replace('/(ú)/', 'u', $str);
			$str = preg_replace('/(ó|ô|õ|Ô)/', 'o',$str);
			$str = preg_replace('/(_|\/|!|\?|#)/', '',$str);
			$str = preg_replace('/( )/', '-',$str);
			$str = preg_replace('/ç/','c',$str);
			$str = preg_replace('/(-[-]{1,})/','-',$str);
			$str = preg_replace('/(,)/','-',$str);
			$str=strtolower($str);
			return $str;
		}

        public static function get_category($category_id){
            $sql = MySql::conectar()->prepare("SELECT `nome` FROM `tb_site.categorias` WHERE id=?");
            $sql->execute(array($category_id));
            return $sql->fetch()["nome"];
        }
    }

?>