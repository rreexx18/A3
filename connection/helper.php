<?php

function conect_to_db( $config ){
    return mysqli_connect($config['host'], $config['user'], $config['password'], $config['database']);
}

function validar_usuario(){
    $config =(array) json_decode(file_get_contents('connection/configDB.json'));
    if( is_array($config) && !empty($config) ){
        $link = conect_to_db($config);
        $query = "SELECT * FROM users";
        $result = mysqli_query($link, $query);
        while($row = mysqli_fetch_assoc($result)){
            if( $row['name'] == $_POST['name'] && $row['passwd'] == $_POST['passwd'] ){
                return $row['id_user'];
            }
        }
        return false;
    }
}

function register_user(){
    $config =(array) json_decode(file_get_contents('connection/configDB.json'));
    if( is_array($config) && !empty($config) ){
        $link = conect_to_db($config);
        $query = "SELECT * FROM users";
        $result = mysqli_query($link, $query);
        while($row = mysqli_fetch_assoc($result)){
            if( $row['name'] == $_POST['rname'] ){
                return false;
            }
        }
        
        $sql = "INSERT INTO users (name, passwd, email) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($link, $sql);
        mysqli_stmt_bind_param( $stmt, 'sss', $_POST['rname'], $_POST['rpasswd'], $_POST['remail'] );
        mysqli_execute($stmt);
        mysqli_stmt_close($stmt);

        return true;
    }
}

function create_task( $user_id ){
    $config =(array) json_decode(file_get_contents('../connection/configDB.json'));
    if( is_array($config) && !empty($config) ){
        $link = conect_to_db($config);
        $sql = "INSERT INTO tasks (name, description, status, date_start, id_user) VALUES (?, ?, 'pendiente', now(),". $user_id .")";
        $stmt = mysqli_prepare($link, $sql);
        mysqli_stmt_bind_param( $stmt, 'ss', $_POST['task-name'], $_POST['task-description'] );
        mysqli_execute($stmt);
        $result_rows = mysqli_stmt_affected_rows($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($link);
        
        if( $result_rows <= 0 ){
            return false;
        }else{
            return true;
        }
    }
}

function complete_task( $task_id ){
    $config =(array) json_decode(file_get_contents('../connection/configDB.json'));
    if( is_array($config) && !empty($config) ){
        $link = conect_to_db($config);
        $sql = "UPDATE tasks SET status='completada',date_finish=now() WHERE id_task=".$task_id ." AND status<>'completada'";
        $stmt = mysqli_prepare($link, $sql);
        mysqli_execute($stmt);
        $result_rows = mysqli_stmt_affected_rows($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($link);
        
        if( $result_rows <= 0 ){
            return false;
        }else{
            return true;
        }
    }
}

function delete_task( $task_id ){
    $config =(array) json_decode(file_get_contents('../connection/configDB.json'));
    if( is_array($config) && !empty($config) ){
        $link = conect_to_db($config);
        $sql = "DELETE FROM tasks WHERE id_task=".$task_id;
        $stmt = mysqli_prepare($link, $sql);
        mysqli_execute($stmt);
        $result_rows = mysqli_stmt_affected_rows($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($link);
        
        if( $result_rows <= 0 ){
            return false;
        }else{
            return true;
        }
    }
}

function delete_tasks_completed(){
    $config =(array) json_decode(file_get_contents('../connection/configDB.json'));
    if( is_array($config) && !empty($config) ){
        $link = conect_to_db($config);
        $sql = "DELETE FROM tasks WHERE status='completada'";
        $stmt = mysqli_prepare($link, $sql);
        mysqli_execute($stmt);
        $result_rows = mysqli_stmt_affected_rows($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($link);
        
        if( $result_rows <= 0 ){
            return false;
        }else{
            return true;
        }
    }
}

function show_tasks_home( $user_id ){
    $config =(array) json_decode(file_get_contents('../connection/configDB.json'));
    
    if( is_array($config) && !empty($config) ){
        $link = conect_to_db($config);
        $query = "SELECT * FROM tasks WHERE id_user=". $user_id ." ORDER BY date_start DESC";
        $result = mysqli_query($link, $query);
        $tasks = 0;
        echo "<table class='home-tasks'>";
        echo "<theader><td>Número</td><td>Nombre</td><td>Descripción</td><td>Estado</td><td>Fecha inicio</td><td>Fecha fin</td></theader><tbody>";
        while($row = mysqli_fetch_assoc($result)){
            if(empty($row['date_finish'])){
                $date_finish = "---";
            }else{
                $date_finish = $row['date_finish'];
            }
            
            if( $tasks == 3 ){
                break;
            }
            $tasks ++;
            echo "<tr>";
                echo "<td>". $tasks ."</td>";
                echo "<td>". $row['name'] ."</td>";
                echo "<td>". $row['description'] ."</td>";
                echo "<td>". $row['status'] ."</td>";
                echo "<td>". $row['date_start'] ."</td>";
                echo "<td>". $date_finish ."</td>";
            echo "</tr>";
        }
        echo "</tbody></table>";
        
        mysqli_close($link);
        
        if ($tasks == 0) {
            return false;
        } else {
            return true;
        }
    }
}

function show_tasks( $user_id ){
    $config =(array) json_decode(file_get_contents('../connection/configDB.json'));
    
    if( is_array($config) && !empty($config) ){
        $link = conect_to_db($config);
        $query = "SELECT * FROM tasks WHERE id_user=". $user_id ." ORDER BY date_start DESC";
        $result = mysqli_query($link, $query);
        $tasks = 0;
        echo "<table class='home-tasks'>";
        echo "<tr>"
                . "<td>Número</td>"
                . "<td>Nombre</td>"
                . "<td>Descripción</td>"
                . "<td>Estado</td>"
                . "<td>Fecha inicio</td>"
                . "<td>Fecha fin</td>"
                . "<td>Operaciones</td>"
            . "</tr>";
        while($row = mysqli_fetch_assoc($result)){
            $tasks ++;
            
            if(empty($row['date_finish'])){
                $date_finish = "---";
            }else{
                $date_finish = $row['date_finish'];
            }
            
            echo "<tr>";
                echo "<td>". $tasks ."</td>";
                echo "<td>". $row['name'] ."</td>";
                echo "<td>". $row['description'] ."</td>";
                echo "<td>". $row['status'] ."</td>";
                echo "<td>". $row['date_start'] ."</td>";
                echo "<td>". $date_finish ."</td>";
                //ICONOS PARA LOS BOTONES
                // https://fontawesome.com/icons/check?style=solid
                // https://fontawesome.com/icons/trash-alt?style=solid
                // COMO USARLO CON CSS
                // https://fontawesome.com/how-to-use/on-the-web/advanced/css-pseudo-elements
                echo "<td>";
                    echo "<form class='single-task' action='". $_SERVER['PHP_SELF'] ."' method='POST'>";
                        echo "<input type='hidden' name='task-id' value='". $row['id_task'] ."'>";
                        echo "<input type='submit' name='complet-task' id='complet-task' title='Completar tarea' value=''>";
                        echo "<input type='submit' name='delete-task' id='delete-task' title='Borrar tarea' value=''>";
                    echo "</form>";
                echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        mysqli_close($link);
        
        if ($tasks == 0) {
            return false;
        } else {
            return true;
        }
    }
}