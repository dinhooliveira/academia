
        <div id="page-wrapper">

            <div class="container-fluid">
                
                       <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                          Consulta de Contrato
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i><a href="?pagina=admin">Dashboard </a>/Contrato/Consultar
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
                
                
               
                   <div class="row">
                      <!-- <div class="col-md-2">
                           <a href="?pagina=cadastrar-contrato" Class="btn btn-primary">Novo Contrato</a><br><br>
                       </div>-->
                      
                           <form method="post">
                            <div class="col-md-4">
                            <div class="form-group">
           
                                <input type="text" class="form-control" name="consulta" placeholder="consulta" maxlength="100" value="<?php if(isset($_POST['consulta'])) echo $_POST['consulta']; ?>" >
                                
                            </div>
                             </div>
                               
                           <div class="col-md-4">
                            <div class="form-group">
                           <button type="submit" Class="btn btn-primary" name="bt_consultar" ><span class="glyphicon glyphicon-search"></span>Consultar</button>
                            </div>
                           </div>
                           
                          </form>

                   </div>
                     
                    <div class="row"> 
                        <?php 
                        $contrato = new ClassContrato();
                         
                         if(isset($_GET['p']))
                             $pagina=$_GET['p']; 
                           else 
                            $pagina=1;
                           
                         if(isset($_POST['consulta']))
                             $consulta=$_POST['consulta'];
                         else
                             $consulta="";
                         
                         $contrato->ListarContrato($pagina, $consulta);
                         
                         
                               if(isset($_POST['bt_consulta']))
                             $consulta=$_POST['consulta'];
                         else
                             $consulta="";
                         
                          if(isset($_POST['bt_status']))
                         
                             $contrato->AtivarContrato($_POST['id'], $_POST['status']);
                        ?>
                        
                        
                </div><!-- /.row -->
            
             
            </div><!--container-fluidr-->
        </div><!--page-wrapper-->