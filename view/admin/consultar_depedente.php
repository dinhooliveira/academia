
<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Consulta de Dependente
                </h1>
                <ol class="breadcrumb">
                    <li class="active">
                        <i class="fa fa-dashboard"></i><a href="?pagina=admin">Dashboard </a>/Aluno/Dependente/Consultar
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.row -->



        <div class="row">
           

            <form method="post">
                <div class="col-md-4">
                    <div class="form-group">

                        <input type="text" class="form-control" name="consulta" placeholder="consulta" maxlength="100" value="<?php if (isset($_POST['consulta'])) echo $_POST['consulta']; ?>" >

                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <button type="submit" Class="btn btn-primary" name="bt_consultar" ><span class="glyphicon glyphicon-search"></span>Consultar</button>
                    </div>
                </div>

            </form>

        </div>

        <div class="row"> 
            <?php
            $aluno = new ClassAluno();

            if (isset($_GET['p']) && is_numeric($_GET['p']))
                $pagina = $_GET['p'];
            else
                $pagina = 1;

             $id_aluno = (!empty($_GET['id'])?$_GET['id']:null);

            if (isset($_POST['consulta']))
                $consulta = $_POST['consulta'];
            else
                $consulta = "";
            
            if($id_aluno!=null)
            $aluno->ListarDependente($pagina, $consulta, $id_aluno);
            ?>


        </div><!-- /.row -->


    </div><!--container-fluidr-->
</div><!--page-wrapper-->