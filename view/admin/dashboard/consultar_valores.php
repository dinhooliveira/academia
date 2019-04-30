            
<div id="page-wrapper">

<div class="container-fluid"> 
          <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                          Consulta de Serviço
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
                            
                            ?>

                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-signal fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?=$ClassConsulta->getValorAlunoMensal();?></div>
                                        <div>Alunos Mensais</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                                <div class="panel-footer">
                                    <span class="pull-left">Detalhes</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-signal fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?=$ClassConsulta->getValorAlunoTrimestral()?></div>
                                        <div>Alunos Trimestrais!</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                                <div class="panel-footer">
                                    <span class="pull-left">Detalhes</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-thumbs-up fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?="Qtd.<br>".$ClassConsulta->get_Qtd_Em_Dia();?></div>
                                        <div>Alunos em dia</div>
                                    </div>
                                </div>
                            </div>
                            <a href="?pagina=alunos-em-dia">
                                <div class="panel-footer">
                                    <span class="pull-left">Detalhes</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-info fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?="Qtd.<br>".$ClassConsulta->get_Qtd_Em_Vencer();?></div>
                                        <div>Alunos a vencer</div>
                                    </div>
                                </div>
                            </div>
                    
                            <a href="?pagina=alunos-a-vencer">
                                <div class="panel-footer">
                                    <span class="pull-left">Detalhes</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                            
                            
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-thumbs-down fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?="Qtd.<br>".$ClassConsulta->get_Qtd_Em_Atraso();?></div>
                                        <div>Alunos em Atraso</div>
                                    </div>
                                </div>
                            </div>
                    
                            <a href="?pagina=alunos-em-atraso">
                                <div class="panel-footer">
                                    <span class="pull-left">Detalhes</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                            
                            
                        </div>
                    </div>
                </div>
    
                <!-- /.row -->
 <div class='panel panel-default'>
     
    <div class='panel-heading'>
        <h3 class='panel-title'><i class='fa fa-list-alt fa-fw'></i> Relatório de Vencimentos</h3>
    </div>
     
        <div class='panel-body'>
            <div class='table-responsive'>
                 <table class='table table-bordered table-hover '>
                    <thead>
                        <tr>
                            <th>Aluno</th>
                             <th>Academia</th>
                             <th>Tipo</th>
                            <th>Situação</th>
                            <th>Vencimento em dias</th>
                            <th>Histórico</th>
                        </tr>
                    </thead>
                    
                    <tbody>

       <?php
            $result = $ClassConsulta->ConsultarVencimentos();
            while ($row = $result->fetch_assoc()):            //recebe o ultimo pagamento do aluno     
        
                //Encontra a diferença da data atual para o ultimo vencimento
                //se a diferença for  maior que 10 está em dia 
                if ($row['vencimento'] > 10) {
                    $situacao = "Em Dia";
                    echo "<tr class='bg-success'>";
                }


                //se a diferença for  menor ou igual  10 está à vencer
                if ($row['vencimento']<= 10 && $row['vencimento'] > 0) {
                    $situacao = "À vencer";
                    echo "<tr class='bg-warning'>";
                }
                //se a diferença for  menor   10 está atrasado
                if ($row['vencimento'] <= 0) {
                    $situacao = "Em Atraso";
                    echo "<tr class='bg-danger'>";
                }
        ?>
 
                <td><?=$row["NOME"];?></td>
                <td><?=$row["academia"];?></td>
                <td><?=$row["TIPO"]?></td>
                <td><b><?=$situacao?></b></td>
                <td><?=$row['vencimento']?></td>
                <td><a href="?pagina=historico-pagamento&id=<?=$row['COD_CONTRATO']?>">Detalhes</a></td>
               <?php if ($row['vencimento'] <= 0): ?>
                <form method="post">
                <td><button type="submit" class="btn btn-primary" name="inativar" value="<?=$row['COD_CONTRATO']?>">Inativar contrato</button></td>
                </form>
                <?php endif; ?>
             </tr>

        <?php endwhile;?>
           </tbody>
        </table>
    </div>

</div>
</div>
           <?php 
                 $classpagamentos = new ClassPagamentos();
                 //$classpagamentos->gerarPagamentoALunoTrimestral();
                 $ClassConsulta->relatorioAcadmia();
                 
                 $contrato = new ClassContrato();
                  if(isset($_POST['inativar']))
                             $contrato->AtivarContrato($_POST['inativar'],1);
           ?>
</div>
</div>
