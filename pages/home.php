<?php    
    include '../lib/header.php';
    include '../connection/helper.php';
    
    if( isset($_POST['logout']) ){
        setcookie('user_id', "", time()-60, "/");
        header('Location: ../index.php');
    }
    
    if( isset($_POST['all-tasks']) ){
        header('Location: tasks_list.php');
    }
    
    if( !isset($_COOKIE['user_id']) ){
        header('Location: ../index.php');
    }
?>
    
    <section>
        <h2 class="title">Pagina home</h2>
        <article>
            <?php 
                $home_tasks = show_tasks_home($_COOKIE['user_id']);
                if( $home_tasks != true ){
                    echo "<p class='not-found'>No se han encontrado tareas.</p>";
                }
            ?>
            <form class="home-form" action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
                <input type="submit" name="all-tasks" id="all-tasks" value="Todas las tareas">
            </form>
        </article>
    </section>
    
<?php

    include '../lib/footer.php'; 