       <?php
             $servico = new ClassServico();
             if(isset($_GET['id']))
             {
                 $dados = $servico->GetServico($_GET['id']); 
             }
              else 
              {
                  echo "<script>location.href='?pagina=consultar-servico'</script>"; 
              }
             
            ?>
        <div id="page-wrapper">

            <div class="container-fluid">
                
                       <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                          Atualização de serviço
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i><a href="?pagina=admin">Dashboard </a>/Serviço/Atualização
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
                
                
               
                
                     <!-- formulario-->
                    <form  method="post"  role="form">
                    <div class="row"> 
                                 <?php
            
             $ClassServico = new ClassServico();
             if(isset($_POST['ataulizar_valor']))
             $ClassServico->updateValor($_GET['id'],$_POST['valor']);
             
             
            ?>
                        <div class="col-md-4">
                    
                            <div class="form-group">
                                <label>Tipo</label>
                                 <select class="form-control" readonly name="tipo" id="tipo" required>
                                    

                                   <?php
                       
                                     if(isset($dados['TIPO']))
                                      echo "<option value='".$dados['TIPO']."'>";
                                      echo $dados['TIPO'];
                                      echo "</option>";
                                  ?>
                                  <option value="MENSAL">MENSAL</option>
                                  <option value="TRIMESTRAL">TRIMESTRAL</option>
                                  
                                 </select>
                            </div>
                        </div>
                        
                     
                        <div class="col-md-6">
                           <div class="form-group">
                                <label>Descrição</label>
                                <input   type="text" class="form-control" readonly name="descricao" placeholder="Descrição" maxlength="100" value="<?php echo utf8_encode($dados['DESCRICAO']); ?>">
                            </div>
                        </div>
                        
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Valor</label>
                                <input  type="text" class="form-control" name="valor" id="valor" onkeyup="mascara(this,mfloat)" placeholder="Valor" maxlength="11" value="<?php echo $dados['VALOR']; ?>" required>
                            </div>
                        </div>
                    </div><!-- /.row -->
                        
                
                <input type="submit" class="btn btn-primary" name="ataulizar_valor" value="Atualizar"><br><br>   
                            
                          
                         
                         
                         
           
                        
                    
                    
                    
             </form> <!-- /.formulario -->
                
                   
            </div><!--container-fluidr-->
        </div><!--page-wrapper-->