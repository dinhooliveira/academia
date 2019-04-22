<div id="page-wrapper">

            <div class="container-fluid">
                
                       <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                          Cadastro de Academia
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i><a href="?pagina=admin">Dashboard </a>/Academia/Cadastro
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
                
                
               
                
                     <!-- formulario-->
                    <form  method="post"  role="form">
                    <div class="row"> 
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Nome</label>
                                <input type="text" class="form-control" name="nome" placeholder="Nome" maxlength="100" value="<?php if(isset($_POST['nome'])) echo $_POST['nome']; ?>" required>
                            </div>
                        </div>
                        
                         
                  
                    
                    <div class="col-md-2">
                           <div class="form-group">
                                <label>CEP</label>
                                <input  type="text" class="form-control" name="cep" id="cep" onblur="pesquisacep(this.value)" onkeyup="mascara(this,mnum)" placeholder="CEP" maxlength="8" value="<?php if(isset($_POST['cep'])) echo $_POST['cep']; ?>" required>
                            </div>
                    </div>
                    
                    <div class="col-md-4">
                             <div class="form-group">
                                <label>Logradouro</label>
                                <input  type="text" class="form-control" name="logradouro"  id="logradouro" placeholder="Logradouro" maxlength="100" value="<?php if(isset($_POST['logradouro'])) echo $_POST['logradouro']; ?>" readonly required>
                            </div>
                    </div>
                    
                    <div class="col-md-2">
                           <div class="form-group">
                                <label>Numero</label>
                                <input  type="text" class="form-control" name="numero" id="numero" onkeyup="mascara(this,mnum)" placeholder="Numero" maxlength="9" value="<?php if(isset($_POST['numero'])) echo $_POST['numero']; ?>" required>
                            </div>
                    </div>
                    
                    <div class="col-md-4">
                           <div class="form-group">
                                <label>Complemento</label>
                                <input  type="text" class="form-control" name="complemento" placeholder="Complemento" maxlength="100" value="<?php if(isset($_POST['complemento'])) echo $_POST['complemento']; ?>">
                            </div>
                    </div>
                        
                    <div class="col-md-4">
                           <div class="form-group">
                                <label>Bairro</label>
                                <input  type="text" class="form-control" name="bairro" id="bairro" placeholder="Bairro" maxlength="50"  value="<?php if(isset($_POST['bairro'])) echo $_POST['bairro']; ?>" readonly required>
                            </div>
                    </div>
                        
                    <div class="col-md-4">
                            <div class="form-group">
                                <label>Cidade</label>
                                <input  type="text" class="form-control" name="cidade"  id="cidade" placeholder="Cidade" maxlength="50" value="<?php if(isset($_POST['cidade'])) echo $_POST['cidade']; ?>" readonly  required>
                            </div>
                    </div>
                    
                    <div class="col-md-2">
                            <div class="form-group">
                                <label>UF</label>
                                <input type="text" class="form-control" name="uf" id="uf" placeholder="UF"  value="<?php if(isset($_POST['uf'])) echo $_POST['uf']; ?>" readonly required>
                                <!--<select class="form-control" name="uf" id="uf" readonly required>
                                    
                                  <?php
                                   /*if(isset($_POST['uf']))
                                   echo "<option value='".$_POST['uf']."'>";
                                   echo $_POST['uf'];
                                   echo "</option>";*/
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
                    
                    </div>  
                    
                       <input type="submit" class="btn btn-primary" name="cadastrar_academia" value="Salvar"><br><br> 

                </div><!-- /.row -->
            
                 
                            
                          
                         
                         
                         
                      <?php
             $academia = new ClassAcademia();
             
             if(isset($_POST['cadastrar_academia']))
             $academia->CadastrarAcademia($_POST['nome'],$_POST['cep'], $_POST['logradouro'], $_POST['numero'], $_POST['complemento'], $_POST['bairro'], $_POST['cidade'], $_POST['uf']);
             
            ?>
                        
                    
                    
                    
             </form> <!-- /.formulario -->
                
                   
            </div><!--container-fluidr-->
           
        </div><!--page-wrapper-->