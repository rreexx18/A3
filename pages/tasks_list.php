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
    
    if( isset($_POST["back"]) ){
        header('Location: home.php');
    }
    
    if( isset($_POST["complet-task"]) ){
        if( isset($_POST["task-id"]) ){
            $completed = complete_task( $_POST["task-id"] );
            
            if( $completed == 1 ){
                echo "<div class='success'>Tarea actualizada correctamente.</div><br>";
            }else{
                echo "<div class='error'>Ha ocurrido un error al actualizar la tarea o la tarea ya esta completada.</div><br>";
            }
        }
    }
    
    if( isset($_POST["delete-task"]) ){
        if( isset($_POST["task-id"]) ){
            $deleted = delete_task( $_POST["task-id"] );
            
            if( $deleted ){
                echo "<div class='success'>Tarea borrada correctamente.</div><br>";
            }else{
                echo "<div class='error'>Ha ocurrido un error al borrar la tarea.</div><br>";
            }
        }
    }
    
    if( isset($_POST["delete-completed"]) ){
        $deleted = delete_tasks_completed();

        if( $deleted ){
            echo "<div class='success'>Tareas borradas correctamente.</div><br>";
        }else{
            echo "<div class='error'>Ha ocurrido un error al borrar las tareas o no tienes tareas completadas.</div><br>";
        }
    }
    
    if( isset($_POST["create-task"]) ){
        if( isset($_COOKIE["user_id"]) ){
            $created = create_task( $_COOKIE["user_id"] );

            if( $created ){
                echo "<div class='success'>Tarea creada correctamente.</div><br>";
            }else{
                echo "<div class='error'>Ha ocurrido un error al crear la tarea.</div><br>";
            }
        }
    }

?>
    <section>
        <h2 class="title">Todas las tareas</h2>
        <form class="all-tasks-form" action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
            <input type="submit" name="back" value="Volver">
            <input type="submit" name="delete-completed" value="Borrar tareas completadas">
        </form>
        <article>
            <?php 
                $all_tasks = show_tasks($_COOKIE['user_id']);
                if( $all_tasks != true ){
                    echo "<p class='not-found'>No se han encontrado tareas rellena la fila de abajo para crear una.</p>";
                }
            ?>
            <form class="create-task-form" action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
                <table>
                    <tr>
                        <td>#</td>
                        <td><input type="text" name="task-name" placeholder="Nombre de la nueva tarea"></td>
                        <td><input type="text-area" name="task-description" placeholder="Descripción de la nueva tarea"></td>
                        <td><input type="text" name="task-status" value="pendiente"></td>
                        <td><input type="text" name="task-date-start" value="yyyy/mm/dd"></td>
                        <td><input type="text" name="task-date-end" value="---"></td>
                        <td><input type="submit" name="create-task" value="Crear Tarea"></td>
                    </tr>
                </table>
            </form>
        </article>
        <form class="all-tasks-form" action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
            <input type="submit" name="back" value="Volver">
            <input type="submit" name="delete-completed" value="Borrar tareas completadas">
        </form>
    </section>
<?php

    include '../lib/footer.php';

