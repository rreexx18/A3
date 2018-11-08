<?php
    
    $error = 0;
    
    if( isset($_POST['go-register']) ){
        header("Location: index.php");
    }
    
    if( isset($_COOKIE['user_id']) ){
        header("Location: pages/home.php");
    }
    
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
    
    if( !empty($_POST["name"]) && !empty($_POST["passwd"]) && isset($_POST['login']) ){
        $login = validar_usuario();
        if( is_numeric ( $login ) ){
            $_SESSION['user_id'] = $login;
            setcookie('user_id', $login, time()+6000, "/");
            header('Location: pages/home.php');
        }else{
            $error = 2;
        }
    }else{
        $error = 1;
    }
    
    if( ( empty($_POST['name']) && !empty($_POST['passwd']) ) || ( !empty($_POST['name']) && empty($_POST['passwd']) ) && isset($_POST['login']) ){
        $error = 1;
    }
    
    if( isset($_POST['login']) ){
        switch($error){
            case 1:
                echo "<div class='error'>No se han rellenado todos los campos</div><br>";
                break;
            case 2:
                echo "<div class='error'>El usuario o contraseña es incorrecto</div><br>";
                break;
        }
    }
?>
<form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
    <div class="login">
        <label for="name">Nombre</label>
        <input type="text" name="name" id="name">
        <label for="passwd">Contraseña</label>
        <input type="password" name="passwd" id="passwd">
    </div>
    <div><br><input type="submit" name="login" id="button" class="login-register" value="Iniciar sessión"></div>
    <div><br> Si no estas registrado pulsa aqui</div>
    <div><br><input type="submit" name="go-register" id="go-register" class="login-register" value="Registrate"></div>
</form>