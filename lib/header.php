<!DOCTYPE html>
<html>
    <head>
        <title>M7 A3</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <header>
            <h1>TODO TASK</h1>
            <?php if( !empty($_COOKIE['user_id']) ){ ?>
                <form class="header-form" action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
                    <input type="submit" name="logout" id="logout" value="Cerrar sessión">
                </form>
            <?php } ?>
        </header>