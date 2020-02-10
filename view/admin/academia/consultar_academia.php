<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Consulta de Academia
                </h1>
                <ol class="breadcrumb">
                    <li class="active">
                        <i class="fa fa-dashboard"></i><a href="?pagina=admin">Dashboard </a>/Academia/Consultar
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.row -->


        <div class="row">
            <div class="col-md-2">
                <a href="?pagina=cadastrar-academia" Class="btn btn-primary">Nova Academia</a><br><br>
            </div>

            <form method="get">
                <div class="col-md-4">
                    <div class="form-group">

                        <input type="text" class="form-control" name="search" placeholder="consulta" maxlength="100"
                               value="<?php if (isset($_GET['search'])) echo $_GET['search']; ?>">

                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <button type="submit" Class="btn btn-primary">
                            <span class="glyphicon glyphicon-search"></span>Consultar
                        </button>
                    </div>
                </div>
                <input type="hidden" name="pagina" value="consultar-academia"/>

            </form>

        </div>

        <div class="container-fluid" style="max-height: 500px">
            <?php
            $academia = new \Model\Academia();

            if (isset($_GET['p']))
                $pagina = $_GET['p'];
            else
                $pagina = 1;

            if (isset($_GET['search']))
                $consulta = $_GET['search'];
            else
                $consulta = "";

            $academia->ListarAcademia($pagina, $consulta, 'consultar-academia');

            if (isset($_GET['search']))
                $consulta = $_GET['search'];
            else
                $consulta = "";

            if (isset($_POST['bt_status']))

                $academia->AtivarAcademia($_POST['id'], $_POST['status']);
            ?>


        </div><!-- /.row -->


    </div><!--container-fluidr-->
</div><!--page-wrapper-->