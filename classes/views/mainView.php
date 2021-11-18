<?php 
    namespace views;

    class mainView{
        public static function render($fileName, $arr = [],$header = "pages/includes/header.php", $footer = "pages/includes/footer.php"){
            include($header);
            include($fileName);
            include($footer);

            die();
        }
    }
?>