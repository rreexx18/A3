<?php

    $error = 0;
     
    if( !empty($_POST['rname']) && !empty($_POST['remail']) && !empty($_POST['rpasswd']) ){
        $register = register_user();
        if( $register ){
            header('Location: index.php');
        }else{
            $error = 2;
        }
        
    }else{
        $error = 1;
    }
    
    if( empty($_POST['rname']) || empty($_POST['remail']) || empty($_POST['rpasswd']) ){
        $error = 1;
    }
    if( isset($_POST['register']) ){
        switch($error){
            case 1:
                echo "<div class='error'>No se han rellenado todos los campos</div><br>";
                break;
            case 2:
                echo "<div class='error'>El usuario esta repetido</div><br>";
                break;
        }
    }
?>
<form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
    <div class="login register">
        <label for="rname">Nombre</label>
        <input type="text" name="rname" id="rname">
        <label for="remail">Email</label>
        <input type="email" name="remail" id="remail">
        <label for="rpasswd">Contraseña</label>
        <input type="password" name="rpasswd" id="rpasswd">
    </div>
    <div><br><input type="submit" name="register" id="rbutton" class="login-register" value="Registrarse"></div>
    <div><br> Si ya estas registrado pulsa aqui</div>
    <div><br><input type="submit" name="go-login" id="go-login" class="login-register" value="Iniciar sessión"></div>
</form>