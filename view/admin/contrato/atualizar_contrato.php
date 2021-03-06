
<?php
  $contrato = new \Model\Contrato();
  $aula = new \Model\Aulas();

?>
<div id="page-wrapper">

            <div class="container-fluid">
                
                       <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                          Atualização de Contrato
                          <?php
                           
                            $dados = $contrato->GetDadosContrato($_GET['id']);
                            if(isset($dados['NOME']))echo "<br>".$dados['NOME'] ;
                            
                            $dados_aula = $aula->return_Aulas($_GET['id']);
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
                    <form  method="post"  role="form">
                    <div class="row"> 
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Academia</label>
                                <select class="form-control" name="academia" id="tipo" required>
                                    <?php if(isset($dados['ID_ACADEMIA'])) 
                                        echo"<option value='".$dados['ID_ACADEMIA']."'>".$dados['ACADEMIA']."</option>";
                                    ?>

                                   <?php
                                    
                                     $contrato->GetAcademia();
                                   ?>
                                  
                                  
                                 </select>
                            </div>
                        </div>
                        
                        <input type="hidden" name="id" value="<?php if(isset($_GET['id'])) echo $_GET['id'];?>" >
                         <input type="hidden" name="aluno" value="<?php if(isset($dados['ID_ALUNO'])) echo $dados['ID_ALUNO'];?>" >
                    
                    <!--<div class="col-md-6">
                           <div class="form-group">
                                <label>Aluno</label>
                                <select class="form-control" name="aluno" id="tipo" required>
                                    

                                   <?php
                                     /*$contrato->GetAluno();*/
                                   ?>
                                  
                                  
                                 </select>
                            </div>
                    </div>-->
                    
                   
                    
                    <div class="col-md-6">
                           <div class="form-group">
                                <label>Serviço</label>
                                <select class="form-control" name="servicos" id="tipo" required>
                                    
                                    <?php if(isset($dados['ID_SERVICO'])) 
                                    echo"<option value='".$dados['ID_SERVICO']."'>  ".$dados['TIPO']." ".$dados['DESCRICAO']."  - R$ ".$dados['VALOR']."</option>";
                                     ?>
                                    
                                   <?php
                                     $contrato->GetServico();
                                  
                                   ?>
                                  
                                  
                                 </select>
                            </div>
                    </div>
                        
                    <div class="col-md-2">
                           <div class="form-group">
                                <label>Dia Vencimento</label>
                                
                                 <select class="form-control" name="vencimento" required>
                                    <?php if(isset($dados['DATA_VENC'])) echo"<option value='".$dados['DATA_VENC']."'>".$dados['DATA_VENC']."</option>" ?>
                                    
                                    <?php
                                     for($x=1;$x<30;$x++)
                                     
                                    echo"<option value='".$x."'>".$x."</option>";
                                    
                                 ?>
                                    
                                </select>
                           </div>
                    </div>
                    
                    <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <h1>Selecione os dias de aula</h1>
                            <lable class="checkbox-inline">
                                <input type="checkbox" name="seg" value="1" <?php if($dados_aula['seg']==1) echo "checked"; ?>>Segunda
                            </lable>
                             <lable class="checkbox-inline">
                                 <input type="checkbox" name="ter" value="1" <?php if($dados_aula['ter']==1) echo "checked"; ?>>Terça
                            </lable>
                            <lable class="checkbox-inline">
                                <input type="checkbox" name="qua" value="1" <?php if($dados_aula['qua']==1) echo "checked"; ?>>Quarta
                            </lable>
                            <lable class="checkbox-inline">
                                <input type="checkbox" name="qui" value="1" <?php if($dados_aula['qui']==1) echo "checked"; ?>>Quinta
                            </lable>
                            <lable class="checkbox-inline">
                                <input type="checkbox" name="sex" value="1" <?php if($dados_aula['sex']==1) echo "checked"; ?>>Sexta
                            </lable>
                             <lable class="checkbox-inline">
                                <input type="checkbox" name="sab" value="1" <?php if($dados_aula['sab']==1) echo "checked"; ?>>Sabado
                            </lable>
                            
                        </div>
                    </div>
                        
                         <div class="col-md-2">
                           <div class="form-group">
                               
                                <label>Horario</label>
                                
                                <select class="form-control" name="horario" required>
                                    <?php 
                                           echo "<option value='".$dados_aula['horario']."'>".$dados_aula['horario']."</option>";
                                     ?>  
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
                                
                                <textarea class="form-control" name="observacao" ><?=$dados['OBSERVACAO'];?></textarea>
                                 
                                
                           </div>
                    </div>
                    
                     <?PHP 
                     //var_dump($dados);
                     //echo $dados['DATA_VENC'];
                     ?>
                    
                    </div>  
                    
                       <input type="submit" class="btn btn-primary" name="atualizar_contrato" value="Salvar"><br><br> 

                </div><!-- /.row -->
            
                 
                            
                          
                         
                         
                         
                      <?php
             $contrato = new \Model\Contrato();
             
             if(isset($_POST['atualizar_contrato']))
             
               $contrato->AtualizarContrato ($_POST['id'], $_POST['academia'], $_POST['servicos'], $_POST['vencimento'])
             
             
            ?>
                        
                    
                    
                    
             </form> <!-- /.formulario -->
                
                   
            </div><!--container-fluidr-->
           
        </div><!--page-wrapper-->
