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
                        <i class="fa fa-dashboard"></i><a href="?pagina=admin">Dashboard </a>/Aluno/Cadastro
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.row -->




        <!-- formulario-->
        <form  method="post" enctype='multipart/form-data' role="form">
            <div class="row"> 

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Adicionar foto</label>
                        <input type='file'class="form-control" name='foto' >

                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nome</label>
                        <input type="text" class="form-control" name="nome" placeholder="Nome" maxlength="100" value="<?php if (isset($_POST['nome'])) echo $_POST['nome']; ?>" required>
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="form-group">
                        <label>RG</label>
                        <input   type="text" class="form-control" name="rg" placeholder="RG" maxlength="15" value="<?php if (isset($_POST['rg'])) echo $_POST['rg']; ?>">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>CPF</label>
                        <input  type="text" class="form-control" name="cpf" id="cpf" onkeyup="mascara(this, mnum)" placeholder="CPF" maxlength="11" value="<?php if (isset($_POST['cpf'])) echo $_POST['cpf']; ?>" required>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>E-mail</label>
                        <input  type="email" class="form-control" name="email" id="email" placeholder="E-mail" maxlength="250" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" required>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label>Nascimento</label>
                        <input  type="date" class="form-control" name="nascimento" placeholder="Nascimento" value="<?php if (isset($_POST['nascimento'])) echo $_POST['nascimento']; ?>" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Celular</label>
                        <input  type="text" class="form-control" onkeyup="return mascara(this, mCel);" name="celular" maxlength="15" placeholder="(DDD)numero" value="<?php if (isset($_POST['celular'])) echo $_POST['celular']; ?>" required>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label>CEP</label>
                        <input  type="text" class="form-control" name="cep" id="cep" onblur="pesquisacep(this.value)" onkeyup="mascara(this, mnum)" placeholder="CEP" maxlength="8" value="<?php if (isset($_POST['cep'])) echo $_POST['cep']; ?>" required>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Logradouro</label>
                        <input  type="text" class="form-control" name="logradouro"  id="logradouro" placeholder="Logradouro" maxlength="100" value="<?php if (isset($_POST['logradouro'])) echo $_POST['logradouro']; ?>" readonly required>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label>Numero</label>
                        <input  type="text" class="form-control" name="numero" id="numero" onkeyup="mascara(this, mnum)" placeholder="Numero" maxlength="9" value="<?php if (isset($_POST['numero'])) echo $_POST['numero']; ?>" required>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Complemento</label>
                        <input  type="text" class="form-control" name="complemento" placeholder="Complemento" maxlength="100" value="<?php if (isset($_POST['complemento'])) echo $_POST['complemento']; ?>">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Bairro</label>
                        <input  type="text" class="form-control" name="bairro" id="bairro" placeholder="Bairro" maxlength="50"  value="<?php if (isset($_POST['bairro'])) echo $_POST['bairro']; ?>" readonly required>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Cidade</label>
                        <input  type="text" class="form-control" name="cidade"  id="cidade" placeholder="Cidade" maxlength="50" value="<?php if (isset($_POST['cidade'])) echo $_POST['cidade']; ?>" readonly  required>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label>UF</label>
                        <input type="text" class="form-control" name="uf" id="uf" placeholder="UF"  value="<?php if (isset($_POST['uf'])) echo $_POST['uf']; ?>" readonly required>
                        <!--<select class="form-control" name="uf" id="uf" readonly required>
                            
                        <?php
                        /* if(isset($_POST['uf']))
                          echo "<option value='".$_POST['uf']."'>";
                          echo $_POST['uf'];
                          echo "</option>"; */
                        ?>
                          <option value="AC">AC</option>
                          <option value="AL">AL</option>
                          <option value="AP">AP</option>
                          <option value="AM">AM</option>
                          <option value="BA">BA</option>
                          <option value="DF">DF</option>
                          <option value="ES">ES</option>
                          <option value="GO">GO</option>
                          <option value="MA">MA</option>
                          <option value="MT">MT</option>
                          <option value="MS">MS</option>
                          <option value="MG">MG</option>
                          <option value="PR">PR</option>
                          <option value="PB">PB</option>
                          <option value="PA">PA</option>
                          <option value="PE">PE</option>
                          <option value="PI">PI</option>
                          <option value="RJ">RJ</option>
                          <option value="RN">RN</option>
                          <option value="RS">RS</option>
                          <option value="RO">RO</option>
                          <option value="RR">RR</option>
                          <option value="SC">SC</option>
                          <option value="SE">SE</option>
                          <option value="SP">SP</option>
                          <option value="TO">TO</option>
                          

                            
                        </select>-->
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Data de Inscrição</label>
                        <input  type="date" class="form-control" name="inscricao" placeholder="Inscrição" value="<?php if (isset($_POST['inscricao'])) echo $_POST['inscricao']; ?>" required>
                    </div>
                </div>
            </div>  






    </div><!-- /.row -->

    <input type="submit" class="btn btn-primary" name="cadastrar_aluno" value="Salvar"><br><br>   





    <?php
    $aluno = new ClassAluno();
    if ((isset($_POST["cadastrar_aluno"])) && (strlen($_FILES['foto']['name'])>0)) {
        $aluno->CadastrarAluno($_POST['nome'], $_POST['nascimento'], $_POST['cep'], $_POST['logradouro'], $_POST['numero'], $_POST['complemento'], $_POST['bairro'], $_POST['cidade'], $_POST['uf'], $_POST['inscricao'], $_POST['cpf'], $_POST['rg'], $_POST['email'], $_POST['celular'], $_FILES['foto']);
    }else{
        $aluno->CadastrarAluno($_POST['nome'], $_POST['nascimento'], $_POST['cep'], addslashes($_POST['logradouro']), $_POST['numero'], $_POST['complemento'], $_POST['bairro'], $_POST['cidade'], $_POST['uf'], $_POST['inscricao'], $_POST['cpf'], $_POST['rg'], $_POST['email'], $_POST['celular']);
    }
    ?>




    </form> <!-- /.formulario -->


</div><!--container-fluidr-->

</div><!--page-wrapper-->