<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Consulta de Serviço
                </h1>
                <ol class="breadcrumb">
                    <li class="active">
                        <i class="fa fa-dashboard"></i><a href="?pagina=admin">Dashboard </a>/Serviço/Consultar
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.row -->



        <div class="row">
            <!--<div class="col-md-2">
               <a href="?pagina=cadastrar-aluno" Class="btn btn-primary">Novo Aluno</a><br><br>
           </div>-->

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

        <div class="container-fluid" style="max-height: 500px">
            <?php
            $servico = new ClassServico();

            if (isset($_GET['p']) && is_numeric($_GET['p']) && $_GET['p'] > 0) {
                $pagina = $_GET['p'];
            } else {
                $pagina = 1;
            }

            if (isset($_POST['bt_consultar']))
                $consulta = $_POST['consulta'];
            else
                $consulta = "";

            $servico->ListarServico($pagina, $consulta);

            if (isset($_POST['bt_status']))
                $servico->AtivarServicos($_POST['id'], $_POST['status']);
            ?>


        </div><!-- /.row -->


    </div><!--container-fluidr-->
</div><!--page-wrapper-->