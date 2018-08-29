<?php
    require('core/core.php');
    if ($_GET['view']) {
        //verifica,os que extia un archivo con ese nombre del get en el controlador
        if(file_exists('core/controllers/' . strtolower($_GET['view']) . 'Controller.php')){
            include('core/controllers/' . strtolower($_GET['view']) . 'Controller.php');
        }else{
            include('core/controllers/errorController.php');
        }
    } else {
        include('core/controllers/indexController.php');
    }
    