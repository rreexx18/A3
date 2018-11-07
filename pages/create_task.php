<?php    
    include '../lib/header.php';
    include '../connection/helper.php';

    var_dump($_COOKIE);
    
    if( isset($_POST['logout']) ){
        setcookie('user_id', "", time()-60, "/");
        header('Location: ../index.php');
    }
    
    if( !isset($_COOKIE['user_id']) ){
        header('Location: ../index.php');
    }
?>
    
    <section>
        <h2 class="title">Crear tarea</h2>
        <article>
            <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="login register">
                <label for=""></label>
                <input type="text" name="" id="">
                <label for=""></label>
                <input type="text" name="" id="">
                <label for=""></label>
                <input type="text" name="" id="">
            </div>
            <div><br><input type="submit" name="create-task" id="create-task" value="Crear tarea"></div>
        </form>
        </article>
    </section>
    
<?php

    include '../lib/footer.php'; 