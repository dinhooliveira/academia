<?php
$contrato = new \Model\Contrato();

?>
<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Cadastro de Contrato
                    <?php
                    $aluno = new \Model\Aluno();
                    $dados = $aluno->GetAluno($_GET['id']);
                    if (isset($dados['NOME'])) echo "<br>" . $dados['NOME'];
                    ?>
                </h1>
                <ol class="breadcrumb">
                    <li class="active">
                        <i class="fa fa-dashboard"></i><a href="?pagina=admin">Dashboard </a>/Contrato/Cadastro
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.row -->


        <!-- formulario-->
        <form method="post" role="form">
            <div class="row">

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Academia</label>
                        <select class="form-control" name="academia" id="tipo" required>


                            <?php
                            $contrato->GetAcademia();
                            ?>


                        </select>
                    </div>
                </div>

                <input type="hidden" name="id" value="<?php if (isset($_GET['id'])) echo $_GET['id']; ?>">
                <input type="hidden" name="cpf" value="<?php if (isset($dados['CPF'])) echo $dados['CPF']; ?>">

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Dependente</label>
                        <select class="form-control" name="dependente" id="tipo" required>
                            <option value="0">--</option>

                            <?php
                            $id_aluno = (!empty($_GET['id']) ? $_GET['id'] : null);
                            $dep = $aluno->dependentes($id_aluno);
                            if (!empty($dep)) :
                                while ($row = $dep->fetch_assoc()) {

                                    ?>
                                    <option value="<?= $row['id'] ?>"><?= $row['nome'] ?></option>
                                    <?php
                                }
                            endif;
                            ?>

                        </select>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="form-group">
                        <label>Serviço</label>
                        <select class="form-control" name="servicos" id="tipo" required>


                            <?php
                            $contrato->GetServico();
                            ?>


                        </select>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label>Dia de pagamento</label>

                        <select class="form-control" name="vencimento" required>
                            <?php if (isset($_POST['vencimento'])) echo "<option value='" . $_POST['vencimento'] . "'>" . $_POST['vencimento'] . "</option>" ?>

                            <?php
                            for ($x = 1; $x < 30; $x++)

                                echo "<option value='" . $x . "'>" . $x . "</option>";

                            ?>

                        </select>

                    </div>
                </div>


            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <h1>Selecione os dias de aula</h1>
                        <lable class="checkbox-inline">
                            <input type="checkbox" name="seg" value="1">Segunda
                        </lable>
                        <lable class="checkbox-inline">
                            <input type="checkbox" name="ter" value="1">Terça
                        </lable>
                        <lable class="checkbox-inline">
                            <input type="checkbox" name="qua" value="1">Quarta
                        </lable>
                        <lable class="checkbox-inline">
                            <input type="checkbox" name="qui" value="1">Quinta
                        </lable>
                        <lable class="checkbox-inline">
                            <input type="checkbox" name="sex" value="1">Sexta
                        </lable>
                        <lable class="checkbox-inline">
                            <input type="checkbox" name="sab" value="1">Sabado
                        </lable>

                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">

                        <label>Horario</label>

                        <select class="form-control" name="horario" required>
                            <option value="08:00">08:00</option>
                            <option value="09:00">09:00</option>
                            <option value="10:00">10:00</option>
                            <option value="11:00">11:00</option>
                            <option value="18:00">18:00</option>
                            <option value="19:00">19:00</option>
                            <option value="20:00">20:00</option>
                            <option value="21:00">21:00</option>
                        </select>

                    </div>


                </div>

                <div class="col-md-6">
                    <div class="form-group">

                        <label>Observações</label>

                        <textarea class="form-control" name="observacao"></textarea>


                    </div>
                </div>

                <div class="col-md-12">

                    <input type="submit" class="btn btn-primary" name="cadastrar_academia" value="Salvar"><br><br>
                </div>
            </div><!-- /.row -->


            <?php
            $contrato = new \Model\Contrato();

            if (isset($_POST['cadastrar_academia'])) {
                if (!isset($_POST['seg'])) $_POST['seg'] = 0;
                if (!isset($_POST['ter'])) $_POST['ter'] = 0;
                if (!isset($_POST['qua'])) $_POST['qua'] = 0;
                if (!isset($_POST['qui'])) $_POST['qui'] = 0;
                if (!isset($_POST['sex'])) $_POST['sex'] = 0;
                if (!isset($_POST['sab'])) $_POST['sab'] = 0;

                $contrato->CadastrarContrato($_POST['id'], $_POST['servicos'], $_POST['vencimento'], $_POST['cpf'], $_POST['academia'], $_POST['seg'], $_POST['ter'], $_POST['qua'], $_POST['qui'], $_POST['sex'], $_POST['sab'], $_POST['horario'], $_POST['observacao'], $_POST['dependente']);
            }
            ?>


        </form> <!-- /.formulario -->


    </div><!--container-fluidr-->

</div><!--page-wrapper-->