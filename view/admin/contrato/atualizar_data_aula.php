
<?php
  $contrato = new ClassContrato();
  $aula = new ClassAulas();

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
                        
                        
                            <div class="form-group">
                               
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
                    
                       <input type="submit" class="btn btn-primary" name="atualizar_aulas" value="Salvar"><br><br> 

                </div><!-- /.row -->
               
                  </form> <!-- /.formulario -->
                            
                          
                         
                         
                         
                      <?php
             $contrato = new ClassContrato();
             
             if(isset($_POST['atualizar_aulas']))
             {
             if(!isset($_POST['seg']))$_POST['seg']=0;
             if(!isset($_POST['ter']))$_POST['ter']=0;
             if(!isset($_POST['qua']))$_POST['qua']=0;
             if(!isset($_POST['qui']))$_POST['qui']=0;
             if(!isset($_POST['sex']))$_POST['sex']=0;
             if(!isset($_POST['sab']))$_POST['sab']=0;
              $aula->update_Aulas($_GET['id'],$_POST['seg'],$_POST['ter'],$_POST['qua'],$_POST['qui'],$_POST['sex'],$_POST['sab'],$_POST['horario']);            
              $contrato->update_observacao($_GET['id'], $_POST['observacao']);
              
             }
            ?>
                        
                    
                    
                    
            
                
                   
            </div><!--container-fluidr-->
           
        </div><!--page-wrapper-->