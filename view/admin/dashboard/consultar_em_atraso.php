<div id="page-wrapper">

<div class="container-fluid"> 
          <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                          Consulta de Alunos em atraso
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
                            $funcoes = new ClassFuncoes();
                            
                            ?>
     
    <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list-alt fa-fw"></i> Relatório de Vencimentos</h3>
    </div>
     
        <div class="panel-body">
            
            <div class="table-responsive">
                 <table id="exportdata" class='table table-bordered table-hover '>
                    <thead>
                        <tr>
                            <th>Nome</th>
                             <th>E-mail</th>
                             <th>Telefone</th>
                            <th>Nascimento</th>
                            <th>Vencimento em dias</th>
                            <th>Data Vencimento</th>
                            <th>
                                <button class="btn btn-success" onclick="ExportToExcel();"> 
                               <span class="glyphicon glyphicon-list-alt"> Excel</span> 
                               </button>
                            </th>
                        </tr>
                    </thead>
                    
                    <tbody>

       <?php
            $result = $ClassConsulta->get_Em_Atraso();
            while ($row = $result->fetch_assoc()):            //recebe o ultimo pagamento do aluno                     
        ?>
            <tr class="bg-danger">
                <td><?=$row["NOME"];?></td>
                <td><?=$row["EMAIL"];?></td>
                <td><?=$row["CELULAR"]?></td>
                <td><?=$row['NASCIMENTO']?></td>
                <td><?=$row['vencimento']?></td>
                <td><b><?=$row['DT_VENCIMENTO']?></b></td>
                <td><a href="?pagina=historico-pagamento&id=<?=$row['COD_CONTRATO']?>">Detalhes</a></td>
            </tr>

        <?php endwhile;?>
           </tbody>
        </table>
    </div>
    <div class='text-right'>
        <a href='#'>View All Transactions <i class='fa fa-arrow-circle-right'></i></a>
    </div>
</div>
</div>
           <?php 
                 $classpagamentos = new ClassPagamentos();
                 //$classpagamentos->gerarPagamentoALunoTrimestral();
                 $ClassConsulta->relatorioAcadmia();
           ?>
                
</div>
</div>

<script type="text/javascript">
function ExportToExcel() {
        var htmltable = document.getElementById('exportdata');
        var html = htmltable.outerHTML;
        window.open('data:application/vnd.ms-excel, ' + encodeURIComponent(html));
    }
</script>