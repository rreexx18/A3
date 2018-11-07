<section>
    <?php if( isset($_POST['go-register']) ){ ?>
        <h2 class="title">Registrarse</h2>
        <br>
        <article>
           <?php include 'lib/register.php'; ?>
        </article>
    <?php }else{ ?>
        <h2 class="title">Iniciar sessión</h2>
        <br>
        <article>
           <?php include 'lib/form.php'; ?>
        </article>
    <?php } ?>
</section>