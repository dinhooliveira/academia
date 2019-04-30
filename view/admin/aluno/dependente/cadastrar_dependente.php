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

        <div class='panel panel-default'>
            <div class='panel-heading'>
                <h3 class='panel-title'><i class='fa fa-list-alt fa-fw'></i>Formulário</h3>
            </div>
            <div class='panel-body'>
                <!-- formulario-->
                <form method="post" enctype='multipart/form-data' role="form">

                    <div class="col-md-12">
                        <div class="col-xs-6 col-md-3">
                            <a class="thumbnail">
                                <img id="form_imagem" width="150"/>
                            </a>
                        </div>
                    </div>


                    <div class="form-group col-md-4">
                        <label>Adicionar foto</label>
                        <input type='file' class="form-control" name='foto' onchange="imagem(this)">

                    </div>

                    <div class="form-group col-md-4">
                        <label>Nome</label>
                        <input type="text" class="form-control" name="nome" placeholder="Nome" maxlength="100"
                               value="<?php if (isset($_POST['nome'])) echo $_POST['nome']; ?>" required>
                    </div>

                    <div class="form-group col-md-3">
                        <label>Nascimento</label>
                        <input type="date" class="form-control" name="nascimento" placeholder="Nascimento"
                               value="<?php if (isset($_POST['nascimento'])) echo $_POST['nascimento']; ?>" required>
                    </div>

                    <div class="form-group col-md-3">
                        <label>Data de Inscrição</label>
                        <input type="date" class="form-control" name="inscricao" placeholder="Inscrição"
                               value="<?php if (isset($_POST['inscricao'])) echo $_POST['inscricao']; ?>" required>
                    </div>

                    <input type="hidden" class="form-control" name="reponsavel"
                           value="<?php if (isset($_GET['id'])) echo $_GET['id']; ?>" required>
                    <div class="col-md-12">
                        <input type="submit" class="btn btn-primary" name="cadastrar_dependente" value="Salvar"><br><br>

                    </div>


                </form> <!-- /.formulario -->
            </div>
        </div>


        <?php
        $aluno = new ClassAluno();
        if (isset($_POST["cadastrar_dependente"])) {

            //echo $_FILES['foto']['name']="";
            if (!empty($_FILES['foto']['name']))
                $aluno->CadastrarDependente($_POST['nome'], $_POST['nascimento'], $_POST['inscricao'], $_POST['reponsavel'], $_FILES['foto']);
            else
                $aluno->CadastrarDependente($_POST['nome'], $_POST['nascimento'], $_POST['inscricao'], $_POST['reponsavel']);
        }
        ?>

    </div><!--container-fluidr-->

</div><!--page-wrapper-->


<script type="text/javascript">


    imagem('');

    function imagem(x) {
        var img =  <?="'{$aluno->URL}/public/upload/semfoto.png'"; ?>

        if (typeof x !== 'object')
            document.getElementById('form_imagem').src = img;
        else
            document.getElementById('form_imagem').src = window.URL.createObjectURL(x.files[0]);

    }

</script>