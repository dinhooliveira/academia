<div id="page-wrapper">

<div class="container-fluid"> 
          <!-- Page Heading -->
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
                <!-- /.row -->
                          <?php 
                            
                            $ClassConsulta = new ClassConsulta();
                            $classAcademia = new ClassAcademia();
                            $ClassServico = new ClassServico();
                           
                            ?>

              
    
                <!-- /.row -->
                
                   <!-- formulario-->
                    <form  method="post"  role="form">
                    <div class="row"> 
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Academia</label>
                                <select class="form-control" name="academia" id="tipo" >
                                    <?php
                                    
                                    $dados = $classAcademia->retun_Academia();
                                    if(isset($_POST["academia"]))
                                    {
                                        echo  "<option value='".$_POST["academia"]."'>".$_POST["academia"]."</option>";
                                    }
                                    ?>
                                    
                                     <option value="">--</option>
                                     
                                    <?php
                                    while($d = $dados->fetch_assoc()):
                                    ?>
                                    
                                    <option value="<?=$d["NOME"];?>"><?=$d["NOME"];?></option>
                                      <?php endwhile; ?>
                                 </select>
                                
                               
                            </div>
                        </div>
                        
                        <div class="col-md-2">
                                 <label>Horário</label>
                                 <select class="form-control" name="horario" >
                                    
                                     <?php
                                    
                                    
                                    if(isset($_POST["horario"]))
                                    {
                                        echo  "<option value='".$_POST["horario"]."'>".$_POST["horario"]."</option>";
                                    }
                                    ?>
                                    <option value="">--</option>
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
                        
                        <div class="col-md-2">
                               <label>Dia da Semana</label>
                                 <select class="form-control" name="semana" required>
                                     
                                    <?php
                                    
                                    
                                    if(isset($_POST["semana"]))
                                    {
                                        echo  "<option value='".$_POST["semana"]."'>".$_POST["semana"]."</option>";
                                    }
                                    ?>
                                    <option value="seg">seg</option>
                                    <option value="ter">ter</option>
                                    <option value="qua">qua</option>
                                    <option value="qui">qui</option>
                                    <option value="sex">sex</option>
                                    <option value="sab">sab</option>
                                    
                                </select>
                        </div>
                        
                        
                    </div>  
                   <div class="row">
                     <div class="col-md-6">
                           <div class="form-group">
                                <label>Serviço</label>
                                <select class="form-control" name="servico" id="tipo">
                                    

                                  <?php
                                    
                                    $dados= $ClassServico->returnServico();
                                    if(isset($_POST["servico"]))echo $_POST["servico"];
                                    {
                                        echo  "<option value='".$_POST["servico"]."'>".$_POST["servico"]."</option>";
                                    }
                                    ?>
                                    
                                     <option value="">--</option>
                                     
                                    <?php
                                    while($d = $dados->fetch_assoc()):
                                    ?>
                                    
                                     <option value="<?=$d["DESCRICAO"];?>"><?= utf8_encode($d["DESCRICAO"]);?></option>
                                      <?php endwhile; ?>
                                  
                                  
                                 </select>
                            </div>
                    </div>
                   </div>
                     <div class="col-md-12">
                          
                       <input type="submit" class="btn btn-primary" name="relatorio_academia" value="Consultar"><br><br> 
                     </div>
                </div><!-- /.row -->
                    </form>
           <?php 
                if(isset($_POST["relatorio_academia"]))
                 $dados= $ClassConsulta->consultaAlunos ($_POST['horario'], $_POST['semana'], $_POST['academia'],$_POST['servico']);
                 else
                $dados= $ClassConsulta->consultaAlunos();
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
                                                 <th>TIPO</th>
                                                 <th>SERVIÇO</th>
                                                 <th>HORÁRIO</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            <?php 
                                             
                                            while($d =$dados->fetch_assoc()):?>
                                            <tr>
                                                <td><?= $d["ACADEMIA"];?></td>
                                                <td><?= $d["NOME"];?></td>
                                                <td><?= $d["DESCRICAO"];?></td>
                                                <td><?= $d["horario"];?></td>
                                            </tr>
                                            
                                            <?php endwhile; ?>
                                            </tbody>
                                    </table>
                                </div>
                                <div class='text-right'>
                                    <a href='#'><i class='fa fa-arrow-circle-right'></i></a>
                                </div>
                            </div>
                        </div>
</div>
</div>


