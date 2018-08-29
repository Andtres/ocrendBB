<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    $db = new Conexion();
    $pass=  Encrypt($_POST['pass']);
    $user = $db->real_escape_string($_POST['user']);
    $email= $db->real_escape_string($_POST['email']);
    //verificamos si ya hay email registrado
    $sql= $db->query("SELECT `user` FROM `users` WHERE `user`='$user' OR `email`='$email' LIMIT 1;");
    
    if($db->rows($sql) == 0){//si no tienen resultados 

        $keyreg= md5(time());
        $link= APP_URL . '?view=activar$key=' . $keyreg;
        //-----------------------------------------------------------------------  
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    try {
            //Server settings
            $mail->chartset = 'utf8';
            $mail->Encoding='quoted-printable';
            $mail->SMTPDebug = 2;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = PHPMAILER_HOST;  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = PHPMAILER_USER;                 // SMTP username
            $mail->Password = PHPMAILER_PASS;                           // SMTP password
            $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = PHPMAILER_PORT;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom(PHPMAILER_USER, APP_TITLE);   //quien manda el correo
            $mail->addAddress($email, $user);     // a quien le llega
            
            

               // Optional name

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Activacion de tu cuenta';
            $mail->Body    = EmailTemplate($user, $link);
            $mail->AltBody = 'Hola ' . $user . ' para activar tu cuenta accede alsiguiente enlace: ' . $link ;
            
            $mail->send();
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            //como solo se ejecuta no es necasrio crear una variable 
            $db-query("INSERT INTO users (user, email, pass, keyreg) VALUES ('$user', '$email', '$pass', '$keyreg');");
            $sql_2=$db->query("SELECT MAX(id) AS id FROM users;");//ultima id seleccionada
            $_SESSION['app_id'] = $db->recorrer($sql_2)[0];
                $db->liberar($sql_2);
            $html= 1;
        } catch (Exception $e) {
            
            $html= '<div class="alert alert-dismissible alert-danger">
            <button type="button" class="close" data-dismiss="alert">x</button>
            <strong>Error</strong> '.$mail->ErrorInfo.'.
            </div>';
        }
        //$html='ok';

        //sino significa que sis tiene una consulta
    }else{
        $usuario = $db->recorrer($sql)['user'];//valor del usuario
        if(strtolower($user) == strtolower($usuario)){//signifa que ya existe el usuario
            $html= '<div class="alert alert-dismissible alert-danger">
            <button type="button" class="close" data-dismiss="alert">x</button>
            <strong>Error</strong> EL usuario ingresado ya existe.
            </div>';
        }else{//si no significa que el email es el que coincide
            $html= '<div class="alert alert-dismissible alert-danger">
            <button type="button" class="close" data-dismiss="alert">x</button>
            <strong>Error</strong> El email ingresado ya existe.
            </div>';
        }
    }
    $db->liberar($sql); 
    $db->close();

    echo $html;