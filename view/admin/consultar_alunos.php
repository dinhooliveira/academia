<div id="page-wrapper">

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Consulta de Alunos
                </h1>
                <ol class="breadcrumb">
                    <li class="active">
                        <i class="fa fa-dashboard"></i><a href="?pagina=admin">Dashboard </a>/Serviço/Consultar
                    </li>
                </ol>
            </div>
        </div>
        <?php

        $ClassConsulta = new ClassConsulta();
        $classAcademia = new ClassAcademia();
        $ClassServico = new ClassServico();

        ?>

        <div class='panel panel-default'>
            <div class='panel-heading'>
                <h3 class='panel-title'><i class='fa fa-list-alt fa-fw'></i>Filtro</h3>
            </div>
            <div class='panel-body'>
                <form method="post" role="form">
                    <div class="form-group col-md-4">
                        <label>Academia</label>
                        <select class="form-control" name="academia" id="tipo">
                            <?php

                            $dados = $classAcademia->retun_Academia();
                            ?>

                            <option value="">--</option>

                            <?php
                            while ($d = $dados->fetch_assoc()):
                                ?>

                                <option value="<?= $d["NOME"]; ?>" <?= !empty($_POST["academia"]) ? "selected" : "" ?>><?= $d["NOME"]; ?></option>
                            <?php endwhile; ?>
                        </select>


                    </div>

                    <div class="col-md-2">
                        <label>Horário</label>
                        <select class="form-control" name="horario">
                            <option value="">--</option>
                            <option value="08:00" <?= !empty($_POST["horario"]) && $_POST["horario"] == "08:00" ? "selected" : "" ?>>
                                08:00
                            </option>
                            <option value="09:00" <?= !empty($_POST["horario"]) && $_POST["horario"] == "09:00" ? "selected" : "" ?>>
                                09:00
                            </option>
                            <option value="10:00" <?= !empty($_POST["horario"]) && $_POST["horario"] == "10:00" ? "selected" : "" ?>>
                                10:00
                            </option>
                            <option value="11:00" <?= !empty($_POST["horario"]) && $_POST["horario"] == "11:00" ? "selected" : "" ?>>
                                11:00
                            </option>
                            <option value="18:00" <?= !empty($_POST["horario"]) && $_POST["horario"] == "18:00" ? "selected" : "" ?>>
                                18:00
                            </option>
                            <option value="19:00" <?= !empty($_POST["horario"]) && $_POST["horario"] == "19:00" ? "selected" : "" ?>>
                                19:00
                            </option>
                            <option value="20:00" <?= !empty($_POST["horario"]) && $_POST["horario"] == "20:00" ? "selected" : "" ?>>
                                20:00
                            </option>
                            <option value="21:00" <?= !empty($_POST["horario"]) && $_POST["horario"] == "21:00" ? "selected" : "" ?>>
                                21:00
                            </option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label>Dia da Semana</label>
                        <select class="form-control" name="semana">

                            <option value="">--</option>
                            <option value="seg" <?= !empty($_POST["semana"]) && $_POST["semana"] == "seg" ? "selected" : "" ?>>
                                seg
                            </option>
                            <option value="ter" <?= !empty($_POST["semana"]) && $_POST["semana"] == "ter" ? "selected" : "" ?>>
                                ter
                            </option>
                            <option value="qua" <?= !empty($_POST["semana"]) && $_POST["semana"] == "qua" ? "selected" : "" ?>>
                                qua
                            </option>
                            <option value="qui" <?= !empty($_POST["semana"]) && $_POST["semana"] == "qui" ? "selected" : "" ?>>
                                qui
                            </option>
                            <option value="sex" <?= !empty($_POST["semana"]) && $_POST["semana"] == "sex" ? "selected" : "" ?>>
                                sex
                            </option>
                            <option value="sab" <?= !empty($_POST["semana"]) && $_POST["semana"] == "sab" ? "selected" : "" ?>>
                                sab
                            </option>
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Serviço</label>
                        <select class="form-control" name="servico" id="tipo">


                            <?php

                            $dados = $ClassServico->returnServico();
                            ?>

                            <option value="">--</option>
                            <?php
                            while ($d = $dados->fetch_assoc()):
                                ?>

                                <option value="<?= $d["DESCRICAO"]; ?>" <?= !empty($_POST['servico']) &&  $_POST['servico'] == $d["DESCRICAO"] ? "selected" : "" ?>><?= $d["DESCRICAO"]; ?></option>
                            <?php endwhile; ?>


                        </select>
                    </div>

                    <div class="col-md-12">
                        <input type="submit" class="btn btn-primary" name="relatorio_academia"
                               value="Consultar"><br><br>
                    </div>
                </form>
            </div>
        </div>
        <?php
        if (isset($_POST["relatorio_academia"]))
            $dados = $ClassConsulta->consultaAlunos($_POST['horario'], $_POST['semana'], $_POST['academia'], $_POST['servico']);
        else
            $dados = $ClassConsulta->consultaAlunos();
        // var_dump($dados);
        ?>

        <div class='panel panel-default'>
            <div class='panel-heading'>
                <h3 class='panel-title'><i class='fa fa-list-alt fa-fw'></i> Relatório de Vencimentos</h3>
            </div>
            <div class='panel-body'>
                <div class='table-responsive'>
                    <table class='table table-bordered table-hover '>
                        <thead>
                        <tr>

                            <th>ACADEMIA</th>
                            <th>ALUNO</th>
                            <th>TIPO</th>
                            <th>SERVIÇO</th>
                            <th>DIA/SEM</th>
                            <th>HORÁRIO</th>

                        </tr>
                        </thead>
                        <tbody>

                        <?php

                        while ($d = $dados->fetch_assoc()):?>
                            <tr>
                                <td><?= $d["ACADEMIA"]; ?></td>
                                <td><?= $d["NOME"]; ?></td>
                                <td><?= $d["TIPO"]; ?></td>
                                <td><?= $d["DESCRICAO"]; ?></td>
                                <td><?= $d["semana"]; ?></td>
                                <td><?= $d["horario"]; ?></td>
                            </tr>

                        <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>


