<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Academia</title>
  
  
  
      <link rel="stylesheet" href="view/login/css/style.css">
       <!-- Bootstrap Core CSS -->
    <link href="view/admin/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="view/admin/css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="view/admin/css/plugins/morris.css" rel="stylesheet">
  
</head>

<body>
  
<div class="container">
	<section id="content">
		<form method="post">
                    <h1><img src="./View/img/logo.png" width="30%"></h1>
                        
                        <?php if(isset($_POST['logar'])):?>
			<div>
                            <input type="text" name="login" placeholder="cpf/email" required="" value="<?=$_POST['login'];?>" id="username" />
			</div>
			<div>
				<input type="password" name="senha" placeholder="Senha" required="" value="<?=$_POST['login'];?>" id="password" />
			</div>
			<div>
				<input type="submit" name="logar" value="Acessar" />
				<a href="#">Lost your password?</a>
				<a href="#">Register</a>
			</div
                     <?php else: ?>
                        
                        <div>
                            <input type="text" name="login" placeholder="cpf/email" required=""  id="username" />
			</div>
			<div>
				<input type="password" name="senha" placeholder="Senha" required="" id="password" />
			</div>
			<div>
				<input type="submit" name="logar" value="Acessar" />
				<a href="#">Lost your password?</a>
				<a href="#">Register</a>
			</div
                        
                     <?php endif ?> 
		</form><!-- form -->
		<div class="button">
			
		</div><!-- button -->
	</section><!-- content -->
</div><!-- container -->

        <?php 
        
          $login = new ClassLogin();
          
          if(isset($_POST['logar']))
              $login->login($_POST['login'], $_POST['senha']);
        ?>
  
    <script src="view/login/js/index.js"></script>

</body>
</html>