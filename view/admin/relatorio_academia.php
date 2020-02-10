<div id="page-wrapper">

    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Consulta de Faturamento
                </h1>
                <ol class="breadcrumb">
                    <li class="active">
                        <i class="fa fa-dashboard"></i><a href="?pagina=admin">Dashboard </a>/Faturamento
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.row -->
        <?php

        $ClassConsulta = new \Model\Consulta();
        $classAcademia = new \Model\Academia();


        ?>

        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-signal fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?PHP
                                    if (isset($_POST['relatorio_academia']))
                                        echo $ClassConsulta->get_relatorio_Acadmia_soma_mensaL($_POST["dataI"], $_POST["dataF"], $_POST["academia"]);
                                    else
                                        echo $ClassConsulta->get_relatorio_Acadmia_soma_mensaL();
                                    ?></div>
                                <div>Faturamento Mensal</div>
                            </div>
                        </div>
                    </div>
                    <a href="#">
                        <div class="panel-footer">
                            <span class="pull-left">Detalhes</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-signal fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?PHP
                                    if (isset($_POST['relatorio_academia']))
                                        echo $ClassConsulta->get_relatorio_Acadmia_soma_trimestral($_POST["dataI"], $_POST["dataF"], $_POST["academia"]);
                                    else
                                        echo $ClassConsulta->get_relatorio_Acadmia_soma_trimestral();
                                    ?></div>
                                <div>Faturamento Trimestral</div>
                            </div>
                        </div>
                    </div>
                    <a href="#">
                        <div class="panel-footer">
                            <span class="pull-left">Detalhes</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-thumbs-up fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?PHP
                                    if (isset($_POST['relatorio_academia']))
                                        echo $ClassConsulta->get_relatorio_Acadmia_soma_total($_POST["dataI"], $_POST["dataF"], $_POST["academia"]);
                                    else
                                        echo $ClassConsulta->get_relatorio_Acadmia_soma_total();
                                    ?></div>
                                <div>Faturamento Bruto</div>
                            </div>
                        </div>
                    </div>
                    <a href="#">
                        <div class="panel-footer">
                            <span class="pull-left">Detalhes</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- /.row -->

        <div class='panel panel-default'>
            <div class='panel-heading'>
                <h3 class='panel-title'><i class='fa fa-list-alt fa-fw'></i>Filtro</h3>
            </div>
            <div class='panel-body'>
                <!-- formulario-->
                <form method="post" role="form">

                    <div class="form-group col-md-4">
                        <label>Academia</label>
                        <select class="form-control" name="academia" id="tipo" >
                            <?php

                            $dados = $classAcademia->retun_Academia();
                            ?>

                            <option value="">--</option>

                            <?php
                            while ($d = $dados->fetch_assoc()):
                                ?>

                                <option value="<?= $d["NOME"]; ?>" <?= !empty($_POST["academia"]) && $_POST["academia"] == $d["NOME"] ? "selected" : "" ?>><?= $d["NOME"]; ?></option>
                            <?php endwhile; ?>
                        </select>


                    </div>

                    <div class="form-group col-md-4">
                        <label>Data Inicial</label>
                        <input type="date" class="form-control" name="dataI"
                               value="<?php if (isset($_POST["dataI"])) echo $_POST["dataI"]; ?>" required>
                    </div>


                    <div class="form-group col-md-4">
                        <label>Data Final</label>
                        <input type="date" class="form-control" name="dataF"
                               value="<?php if (isset($_POST["dataF"])) echo $_POST["dataF"]; ?>" required>
                    </div>
                    <div class="col-md-12">

                        <input type="submit" class="btn btn-primary" name="relatorio_academia" value="Consultar">
                    </div>

                </form>
            </div>
        </div>
        <?php
        if (isset($_POST["relatorio_academia"]))
            $dados = $ClassConsulta->relatorioAcadmia($_POST["dataI"], $_POST["dataF"], $_POST["academia"]);
        else
            $dados = $ClassConsulta->relatorioAcadmia();
        // var_dump($dados);
        ?>

        <div class='panel panel-default'>
            <div class='panel-heading'>
                <h3 class='panel-title'><i class='fa fa-list-alt fa-fw'></i> Recebimentos</h3>
            </div>
            <div class='panel-body'>
                <div class='table-responsive'>
                    <table class='table table-bordered table-hover '>
                        <thead>
                        <tr>

                            <th>ACADEMIA</th>
                            <th>TIPO</th>
                            <th>SERVIÇO</th>
                            <th>VALOR</th>
                            <th>DATA PAGAMENTO</th>

                        </tr>
                        </thead>
                        <tbody>

                        <?php

                        while ($d = $dados->fetch_assoc()):?>
                            <tr>
                                <td><?= $d["NOME"]; ?></td>
                                <td><?= $d["TIPO"]; ?></td>
                                <td><?= $d["DESCRICAO"]; ?></td>
                                <td><?= "R$ " . number_format($d["VALOR"], '2', ',', '.'); ?></td>
                                <td><?= $d["DATA_PAG"]; ?></td>

                            </tr>

                        <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

