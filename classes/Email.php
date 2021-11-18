<?php 
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    
    class Email{
        private $mailer;

        function __construct($host, $username, $password, $name){
            $this->mailer = new PHPMailer(true);

            try {
                //Server settings
                $this->mailer->isSMTP();
                $this->mailer->Host       = $host;
                $this->mailer->SMTPAuth   = true;
                $this->mailer->Username   = $username;
                $this->mailer->Password   = $password;
                $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $this->mailer->Port       = 465;

                //Recipients
                $this->mailer->setFrom($username, $name);
                
                $this->mailer->isHTML(true);

                $this->mailer->CharSet = "UTF-8";

                
             } catch (Exception $e) {
                echo "<script>alert('Erro ao enviar o email!');</script>";
            }
        }

        public function addAddress($email, $nome){
            $this->mailer->addAddress($email, $nome);
 
        }

        public function formatEmail($info){
            $this->mailer->Subject = $info["assunto"];
            $this->mailer->Body    = $info["corpo"];
            $this->mailer->AltBody = strip_tags($info["corpo"]);

        }

        public function sendEmail(){
            echo "<script>console.log({$this->mailer->ErrorInfo});</script>";
            try{
                $this->mailer->send();
                return true;
            }
            catch (Exception $e){
                echo "Message could not be sent. Mailer Error: {$this->mailer->ErrorInfo}";
                return false;
            }
        }
    }
?>