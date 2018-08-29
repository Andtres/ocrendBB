<?php
/*
    EL NÚCLEO DE LA APLICACION
*/
    session_start();
//Constantes de conexion
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'ocrendbd');
//constantes de la app
    define('HTML_DIR', 'html/');
    define('APP_TITLE', 'OcreandBB');
    define('APP_COPY', 'Copyright &copy; ' . date('Y',time()) . ' Ocreand Software. ');//año actual
    define('APP_URL', 'http://localhost/OCrendbb2/');

//constantes  de php mailer
    define('PHPMAILER_HOST', 'p3plcpnl0173.prod.phx3.secureserver.net');
    define('PHPMAILER_USER', 'public@ocrend.com');
    define('PHPMAILER_PASS', 'Prinick2016');
    define('PHPMAILER_PORT', 465);
//Estructura
    require('vendor/autoload.php');
    require('core/models/class.Conexion.php');
    require('core/bin/functions/Encrypt.php');
    require('core/bin/functions/Users.php');
    require('core/bin/functions/EmailTemplate.php');
    
    $users = Users();   