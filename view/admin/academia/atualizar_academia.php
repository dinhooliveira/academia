<?php
$aluno = new ClassAcademia();
if (isset($_GET['id'])) {
    $dados = $aluno->GetAcademia($_GET['id']);
} else {
    echo "<script>location.href='?pagina=consultar-aluno'</script>";
}

?>
<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Atualização de academia
                </h1>
                <ol class="breadcrumb">
                    <li class="active">
                        <i class="fa fa-dashboard"></i><a href="?pagina=admin">Dashboard </a>/Academia/Atualização
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
                <form method="post" role="form">

                    <div class="form-group col-md-4">
                        <label>Nome</label>
                        <input type="text" class="form-control" name="nome" placeholder="Nome" maxlength="100"
                               value="<?php echo $dados['NOME']; ?>" required>
                    </div>

                    <div class="form-group col-md-2">
                        <label>CEP</label>
                        <input type="text" class="form-control" name="cep" id="cep" onblur="pesquisacep(this.value)"
                               onkeyup="mascara(this,mnum)" placeholder="CEP" maxlength="8"
                               value="<?php echo $dados['CEP']; ?>" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Logradouro</label>
                        <input type="text" class="form-control" name="logradouro" id="logradouro"
                               placeholder="Logradouro" maxlength="100" value="<?php echo $dados['LOGRADOURO']; ?>"
                               readonly required>
                    </div>

                    <div class="form-group col-md-2">
                        <label>Numero</label>
                        <input type="text" class="form-control" name="numero" id="numero" onkeyup="mascara(this,mnum)"
                               placeholder="Numero" maxlength="9" value="<?php echo $dados['NUMERO']; ?>" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Complemento</label>
                        <input type="text" class="form-control" name="complemento" placeholder="Complemento"
                               maxlength="100" value="<?php echo $dados['COMPLEMENTO']; ?>">
                    </div>

                    <div class="form-group col-md-4">
                        <label>Bairro</label>
                        <input type="text" class="form-control" name="bairro" id="bairro" placeholder="Bairro"
                               maxlength="50" value="<?php echo $dados['BAIRRO']; ?>" readonly required>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Cidade</label>
                        <input type="text" class="form-control" name="cidade" id="cidade" placeholder="Cidade"
                               maxlength="50" value="<?php echo $dados['CIDADE']; ?>" readonly required>
                    </div>

                    <div class="form-group col-md-2">
                        <label>UF</label>
                        <input type="text" class="form-control" name="uf" id="uf" placeholder="UF"
                               value="<?php echo $dados['UF']; ?>" readonly required>
                    </div>


                    <div class="col-md-12">
                        <input type="submit" class="btn btn-primary" name="atualizar_academia" value="Atualizar">
                    </div>
                </form> <!-- /.formulario -->
            </div>
        </div>


        <?php
        $aluno = new ClassAcademia();

        if (isset($_POST['atualizar_academia']))
            $aluno->AtualizarAcademia($_GET['id'], $_POST['nome'], $_POST['cep'], $_POST['logradouro'], $_POST['numero'], $_POST['complemento'], $_POST['bairro'], $_POST['cidade'], $_POST['uf']);

        ?>


    </div><!--container-fluidr-->
</div><!--page-wrapper-->