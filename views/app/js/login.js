function goLogin() {
    var connect, form, response, result, user, pass, sesion;
    user= __('user_login').value;
    pass= __('pass_login').value;
    sesion=__('session_login').cheked ? true : false;
    //los valores son encriptados
    form='user=' + user + '&pass=' + pass + '&session=' + sesion;
    connect = window.XMLHttpRequest ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
    connect.onreadystatechange = function (){
        if(connect.readyState == 4 && connect.status == 200){
            if(connect.responseText == 1){
                result = '<div class="alert alert-dismissible alert-success">';
                result +='<h4>Conenctado</h4>';
                result +='<p class="mb-0"><strong>Estamos redireccionandote...</strong>';
                result +='</p>';
                result +='</div>';
                __('_AJAX_LOGIN_').innerHTML = result;
                 location.reload();
            }else{
                __('_AJAX_LOGIN_').innerHTML = connect.responseText;
            }
            console.log(connect.responseText)
        } else if (connect.readyState != 4){
            result = '<div class="alert alert-dismissible alert-warning">';
            result +=' <button type="button" class="close" data-dismiss="alert">x</button>';
            result +='<h4>Procesando...</h4>';
            result +='<p><strong>Estamos intentando Logearte....</strong>';
            result +='</p>';
            result +='</div>'; 
            __('_AJAX_LOGIN_').innerHTML = result;  
        }
    }
    connect.open('POST', 'ajax.php?mode=login', true);
    connect.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    connect.send(form);
}
function runScriptLogin(e) {
    if (e.keyCode == 13) {
        goLogin();
    }
}