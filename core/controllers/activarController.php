<?php
    if (isset($_GET['key']) and $_SESSION['app_id']) {
        $db = new Conexion();
        $id= $_SESSION['app_id'];
        $sql=$db->query("SELECT id FROM users WHERE id='$id' and keyreg='$key' LIMIT 1;");
        if ($db->rows($sql)>0) {
            $db->query("UPDATE users SET activo='1', keyreg='' WHERE id='$id';");
            header('location:?view=index&success=false');
        } else {
            header('location:?view=index&error=true');
        }
        
        $db->liberar($sql);
        $key=$db->real_escape_string($_GET['key']);
        $db->close();
    }else{
        include('html/public/loquearte.php');
    }