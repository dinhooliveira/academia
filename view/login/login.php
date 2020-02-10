<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Academia</title>

    <?php
    $config = new \Model\Configuracao();
    ?>

    <link rel="stylesheet" href="<?= $config->URL ?>/public/login/css/style.css">
    <!-- Bootstrap Core CSS -->
    <link href="<?= $config->URL ?>/public/admin/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?= $config->URL ?>/public/admin/css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="<?= $config->URL ?>/public//admin/css/plugins/morris.css" rel="stylesheet">

</head>

<body>

<div class="container">
    <section id="content">
    <form method="post">
    
        <h1>
        <img src="<?= $config->URL ?>/public//img/logo.png" width="30%">
        </h1>
        <div>
            <input
                type="text" 
                name="login" 
                placeholder="cpf/email" 
                required="" 
                value="<?= !empty($_POST['login'])?$_POST['login']:''; ?>"
                id="username"
            />
        </div>
        <div>
            <input 
                type="password" 
                name="senha" 
                placeholder="Senha" 
                required="" 
                value="<?= !empty($_POST['senha'])?$_POST['senha']:''; ?>"
                id="password"
            />
        </div>
        <div class="button">
            <input  type="submit" name="logar" value="Acessar"/>
        </div><!-- button -->
        </form><!-- form -->
    </section><!-- content -->
</div><!-- container -->

<?php

$login = new \Model\Login();

if (isset($_POST['logar']))
    $login->login($_POST['login'], $_POST['senha']);
?>

<script src="<?= $config->URL ?>/public/login/js/index.js"></script>

</body>
</html>
