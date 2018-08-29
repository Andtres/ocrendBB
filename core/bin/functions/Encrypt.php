<?php
    function Encrypt($string){
        $long = strlen($string);//obtenemos la longitud de la cadena
        $str ='';
        for($x = 0; $x < $long; $x++){//recorremos cada pocision 
            $str .= ($x % 2)!=0 ? md5($string[$x]) : $x;
        }
        return md5($str);
    }