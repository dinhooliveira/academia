<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Cadastro de aluno
                </h1>
                <ol class="breadcrumb">
                    <li class="active">
                        <i class="fa fa-dashboard"></i><a href="?pagina=admin">Dashboard </a>/Aluno/Cadastro/Dependente
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.row -->




        <!-- formulario-->
        <form  method="post" enctype='multipart/form-data' role="form">
            
            <div class="row">
                <div class="col-xs-6 col-md-3">
                    <a href="#" class="thumbnail">
                        <img  id="form_imagem"></img>
                    </a>
                </div>
            </div> 
            
            <div class="row"> 
                     
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Adicionar foto</label>
                        <input type='file'class="form-control" name='foto'  onchange="imagem(this)" >

                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nome</label>
                        <input type="text" class="form-control" name="nome" placeholder="Nome" maxlength="100" value="<?php if (isset($_POST['nome'])) echo $_POST['nome']; ?>" required>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Nascimento</label>
                        <input  type="date" class="form-control" name="nascimento" placeholder="Nascimento" value="<?php if (isset($_POST['nascimento'])) echo $_POST['nascimento']; ?>" required>
                    </div>
                </div>
               
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Data de Inscrição</label>
                        <input  type="date" class="form-control" name="inscricao" placeholder="Inscrição" value="<?php if (isset($_POST['inscricao'])) echo $_POST['inscricao']; ?>" required>
                    </div>
                </div>
                
                <input  type="hidden" class="form-control" name="reponsavel" value="<?php if (isset($_GET['id'])) echo $_GET['id']; ?>" required>

            </div>  






    </div><!-- /.row -->

    <input type="submit" class="btn btn-primary" name="cadastrar_dependente" value="Salvar"><br><br>   





    <?php
    $aluno = new ClassAluno();
    if (isset($_POST["cadastrar_dependente"])){
        
       //echo $_FILES['foto']['name']="";
       if(!empty($_FILES['foto']['name']))
         $aluno->CadastrarDependente($_POST['nome'], $_POST['nascimento'], $_POST['inscricao'],$_POST['reponsavel'], $_FILES['foto']);
        else
         $aluno->CadastrarDependente($_POST['nome'], $_POST['nascimento'], $_POST['inscricao'],$_POST['reponsavel']);
    }
    ?>




    </form> <!-- /.formulario -->


</div><!--container-fluidr-->

</div><!--page-wrapper-->


<script type="text/javascript">


         imagem('');
         function imagem(x){
               var img =  <?="'view/upload/semfoto.png'"; ?>

               if(typeof x !== 'object')
                document.getElementById('form_imagem').src = img;
               else
                document.getElementById('form_imagem').src = window.URL.createObjectURL(x.files[0]);

         }

</script>