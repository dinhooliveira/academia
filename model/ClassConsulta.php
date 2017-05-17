<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClassConsulta
 *
 * @author oliveira
 */
class ClassConsulta extends ClassConexao {
    /* retorna o valor total a receber com aluno mensal */

    function getValorAlunoMensal() {
        $funcao = new ClassFuncoes();
        $SQL = "SELECT sum(servico.VALOR),aluno.ID_ALUNO,aluno.NOME FROM servico,contrato,aluno,academia WHERE (contrato.ID_ALUNO=aluno.ID_ALUNO AND contrato.ID_SERVICO=servico.ID_SERVICO AND contrato.ID_ACADEMIA=academia.ID_ACADEMIA) AND servico.TIPO='MENSAL' AND contrato.status=1 ";
        $result = $this->conexao->query($SQL);

        if (!$result) {
            $funcao->msg('error', $this->conexao->error);
        } else {

            $dados = $result->fetch_assoc();
            //var_dump($dados);
            return "R$ <br>" . number_format($dados["sum(servico.VALOR)"], 2, ',', ' ');
        }
    }

    /* retorna o valor total a receber com aluno trimestral */

    function getValorAlunoTrimestral() {
        $funcao = new ClassFuncoes();
        $SQL = "SELECT sum(servico.VALOR),aluno.ID_ALUNO,aluno.NOME FROM servico,contrato,aluno,academia WHERE (contrato.ID_ALUNO=aluno.ID_ALUNO AND contrato.ID_SERVICO=servico.ID_SERVICO AND contrato.ID_ACADEMIA=academia.ID_ACADEMIA) AND servico.TIPO='TRIMESTRAL' AND contrato.status=1 ";
        $result = $this->conexao->query($SQL);

        if (!$result) {
            $funcao->msg('error', $this->conexao->error);
        } else {

            $dados = $result->fetch_assoc();
            //var_dump($dados);
            return "R$ <br>" . number_format($dados["sum(servico.VALOR)"], 2, ',', ' ');
        }
    }

    function ConsultarMensal() {
        $funcao = new ClassFuncoes();
        $ClassServico = new ClassServico();
        $classPagamento = new ClassPagamentos();
        //seleciona todos os alunos
        $SQL = "SELECT servico.ID_SERVICO,aluno.ID_ALUNO,aluno.NOME,contrato.COD_CONTRATO,academia.NOME as ACADEMIA FROM  contrato LEFT JOIN aluno ON contrato.ID_ALUNO = aluno.ID_ALUNO LEFT JOIN academia ON contrato.ID_ACADEMIA=academia.ID_ACADEMIA LEFT JOIN servico ON contrato.ID_SERVICO=servico.ID_SERVICO";

        $result = $this->conexao->query($SQL);

        if (!$result)
            $funcao->msg('error', $this->conexao->error);
        else
            echo"<div class='panel panel-default'>
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
                                        <tbody>";


        while ($row = $result->fetch_assoc()) {             //recebe o ultimo pagamento do aluno     
            $ultimo_venc = $classPagamento->getMensalUltimoPagamento($row['COD_CONTRATO']);

            //Encontra a diferença da data atual para o ultimo vencimento
            //se a diferença for  maior que 10 está em dia 
            if ($this->adimplencia($ultimo_venc) > 10) {
                $situacao = "Em Dia";
                echo "<tr class='bg-success'>";
            }

            //se a diferença for  menor ou igual  10 está à vencer
            if ($this->adimplencia($ultimo_venc) <= 10 && $this->adimplencia($ultimo_venc) > 0) {
                $situacao = "À vencer";
                echo "<tr class='bg-warning'>";
            }
            //se a diferença for  menor   10 está atrasado
            if ($this->adimplencia($ultimo_venc) <= 0) {
                $situacao = "Em Atraso";
                echo "<tr class='bg-danger'>";
            }

            echo" 
                                                <td>{$row["NOME"]}</td>
                                                <td>{$row["ACADEMIA"]}</td>
                                                <td>{$ClassServico->getTipoServico($row["ID_SERVICO"])}</td>
                                                <td><b>{$situacao}</b></td>
                                                <td>{$this->adimplencia($ultimo_venc)}</td>
                                                <td><a href='?pagina=historico-pagamento&id=" . $row['COD_CONTRATO'] . "'>Detalhes</a></td>
                                            </tr>";
        }

        echo"</tbody>
                                    </table>
                                </div>
                                <div class='text-right'>
                                    <a href='#'>View All Transactions <i class='fa fa-arrow-circle-right'></i></a>
                                </div>
                            </div>
                        </div>";
    }

    function getValorMensalTotalReceber($cod) {
        $funcao = new ClassFuncoes();

        $SQL = "SELECT sum(servico.VALOR) FROM pagamentos LEFT JOIN contrato ON pagamentos.COD_CONTRATO = contrato.COD_CONTRATO LEFT JOIN aluno ON contrato.ID_ALUNO = aluno.ID_ALUNO LEFT JOIN servico ON contrato.ID_SERVICO = servico.ID_SERVICO WHERE contrato.COD_CONTRATO = '" . $cod . "' AND pagamentos.STATUS=0  ";

        $result = $this->conexao->query($SQL);

        if (!$result)
            $funcao->msg('error', $this->conexao->error);
        else
            $row = $result->fetch_assoc();
        return "R$ " . number_format($row["sum(servico.VALOR)"], '2', ',', '');
    }

    function getQtdMensalAtraso($cod) {
        $funcao = new ClassFuncoes();

        $SQL = "SELECT * FROM pagamentos LEFT JOIN contrato ON pagamentos.COD_CONTRATO = contrato.COD_CONTRATO LEFT JOIN aluno ON contrato.ID_ALUNO = aluno.ID_ALUNO LEFT JOIN servico ON servico.ID_SERVICO=contrato.ID_SERVICO WHERE pagamentos.COD_CONTRATO = '" . $cod . "' AND pagamentos.STATUS=0 ";

        $result = $this->conexao->query($SQL);

        if (!$result)
            $funcao->msg('error', $this->conexao->error);
        else
            $row = $result->fetch_assoc();
        $qtd = $result->num_rows;
        //var_dump($row);
        return $qtd;
    }

    function adimplencia($data_vencimento) {
        $data = Date("Y-m-d");

        // Usa a função strtotime() e pega o timestamp das duas datas:
        $time_inicial = strtotime($data);
        $time_final = strtotime($data_vencimento);
// Calcula a diferença de segundos entre as duas datas:
        $diferenca = $time_final - $time_inicial; // 19522800 segundos
// Calcula a diferença de dias
        $dias = (int) floor($diferenca / (60 * 60 * 24)); // 225 dias
        if ($data_vencimento < $data) {

            $data = date_diff(date_create($data_vencimento), date_create($data)); //days
            return $dias;
        } else
            return $dias;
    }

    function relatorioPagamento($cod) {
        $funcao = new ClassFuncoes();
        $SQL = "SELECT * FROM  contrato LEFT JOIN pagamentos ON contrato.COD_CONTRATO=pagamentos.COD_CONTRATO LEFT JOIN servico ON servico.ID_SERVICO=pagamentos.ID_SERVICO WHERE contrato.COD_CONTRATO= '" . $cod . "' ORDER BY pagamentos.ID_PAGAMENTO DESC";
        $result = $this->conexao->query($SQL);

        if (!$result) {
            $funcao->msg('error', $this->conexao->error);
        } else {

            echo "<div class='col-md-12'>
                        <div class='panel panel-default'>
                            <div class='panel-heading'>
                                <h3 class='panel-title'><i class='fa fa-money fa-fw'></i>Relatórios de pagamentos</h3>
                            </div>
                            <div class='panel-body'>
                                <div class='table-responsive'>
                                    <table class='table table-bordered table-hover table-striped'>
                                        <thead>
                                            <tr>
                                                <th>Serviço</th>
                                                <th>Valor</th>
                                                <th>Data pagamento</th>
                                                <th>Data vencimento</th>
                                            </tr>
                                        </thead>
                                        <tbody>";
            while ($row = $result->fetch_assoc()) {


                //var_dump($row);
                echo"
                                            <tr>
                                                
                                                <td>" . utf8_encode($row['TIPO'] . " " . $row['DESCRICAO']) . "</td>
                                                <td>" . "R$ " . number_format($row['VALOR'], 2, ',', '.') . "</td>";

                echo "<form method='POST'>"
                . "<td><input type='date' class='form-control' name='data_pag' value='" . $funcao->TratarData($row['DATA_PAG']) . "'></td>
                                                <input type='hidden'name='id_pag' value='" . $row['ID_PAGAMENTO'] . "' >
                                                <td><input type='date' class='form-control' name='data_venc' value='{$row['DATA_VENC']}'></td>
                                                <td><button type='submit'name='editar' class='btn btn-primary' > 
                                                 <span class='glyphicon glyphicon glyphicon-pencil' aria-hidden='true'></span>
                                                 </button></td>
                                               </form>
                                               
                                                  <td>
                                                <form method='POST'>
                                                 <input type='hidden'name='id_pag' value='" . $row['ID_PAGAMENTO'] . "' >
                                                 <button type='submit'name='deletar' class='btn btn-danger' > 
                                                 <span class='glyphicon glyphicon glyphicon-remove' aria-hidden='true'></span>
                                                 </button>
                                                  </form>
                                                  </td>
                                                  
                                                
          
                                            </tr>";
            }
            echo "</tbody>
                                    </table>
                                </div>
                                <div class='text-right'>
                                    <a href='#'>View All Transactions <i class='fa fa-arrow-circle-right'></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                
                <!-- /.row -->";
        }
    }

    function get_Qtd_Em_Dia() {
        $funcao = new ClassFuncoes();
        $ClassServico = new ClassServico();
        $classPagamento = new ClassPagamentos();
        //seleciona todos os alunos
        $SQL = "SELECT servico.ID_SERVICO,aluno.ID_ALUNO,aluno.NOME,contrato.COD_CONTRATO,academia.NOME as ACADEMIA FROM  contrato LEFT JOIN aluno ON contrato.ID_ALUNO = aluno.ID_ALUNO LEFT JOIN academia ON contrato.ID_ACADEMIA=academia.ID_ACADEMIA LEFT JOIN servico ON contrato.ID_SERVICO=servico.ID_SERVICO";

        $result = $this->conexao->query($SQL);

        if (!$result)
            $funcao->msg('error', $this->conexao->error);
        else
            $cont = 0;
        while ($row = $result->fetch_assoc()) {             //recebe o ultimo pagamento do aluno     
            $ultimo_venc = $classPagamento->getMensalUltimoPagamento($row['COD_CONTRATO']);


            //Encontra a diferença da data atual para o ultimo vencimento
            //se a diferença for  maior que 10 está em dia 
            if ($this->adimplencia($ultimo_venc) > 10) {
                $cont++;
            }
        }

        return $cont;
    }

    function get_Qtd_Em_Vencer() {

        $funcao = new ClassFuncoes();
        $ClassServico = new ClassServico();
        $classPagamento = new ClassPagamentos();
        //seleciona todos os alunos
        $SQL = "SELECT servico.ID_SERVICO,aluno.ID_ALUNO,aluno.NOME,contrato.COD_CONTRATO,academia.NOME as ACADEMIA FROM  contrato LEFT JOIN aluno ON contrato.ID_ALUNO = aluno.ID_ALUNO LEFT JOIN academia ON contrato.ID_ACADEMIA=academia.ID_ACADEMIA LEFT JOIN servico ON contrato.ID_SERVICO=servico.ID_SERVICO";

        $result = $this->conexao->query($SQL);

        if (!$result)
            $funcao->msg('error', $this->conexao->error);
        else
            $cont = 0;
        while ($row = $result->fetch_assoc()) {             //recebe o ultimo pagamento do aluno     
            $ultimo_venc = $classPagamento->getMensalUltimoPagamento($row['COD_CONTRATO']);


            //Encontra a diferença da data atual para o ultimo vencimento
            //se a diferença for  menor ou igual  10 está à vencer
            if ($this->adimplencia($ultimo_venc) <= 10 && $this->adimplencia($ultimo_venc) > 0) {
                $cont++;
            }
            //se a diferença for  menor   10 está atrasado
            if ($this->adimplencia($ultimo_venc) <= 0) {
                $situacao = "Atrasado";
                echo "<tr class='bg-danger'>";
            }
        }

        return $cont;
    }

    function get_Qtd_Em_Atraso() {

        $funcao = new ClassFuncoes();
        $ClassServico = new ClassServico();
        $classPagamento = new ClassPagamentos();
        //seleciona todos os alunos
        $SQL = "SELECT servico.ID_SERVICO,aluno.ID_ALUNO,aluno.NOME,contrato.COD_CONTRATO,academia.NOME as ACADEMIA FROM  contrato LEFT JOIN aluno ON contrato.ID_ALUNO = aluno.ID_ALUNO LEFT JOIN academia ON contrato.ID_ACADEMIA=academia.ID_ACADEMIA LEFT JOIN servico ON contrato.ID_SERVICO=servico.ID_SERVICO";

        $result = $this->conexao->query($SQL);

        if (!$result)
            $funcao->msg('error', $this->conexao->error);
        else
            $cont = 0;


        while ($row = $result->fetch_assoc()) {             //recebe o ultimo pagamento do aluno     
            $ultimo_venc = $classPagamento->getMensalUltimoPagamento($row['COD_CONTRATO']);


            //Encontra a diferença da data atual para o ultimo vencimento
            //se a diferença for  menor   10 está atrasado
            if ($this->adimplencia($ultimo_venc) <= 0) {
                $cont++;
            }
        }

        return $cont;
    }

    function relatorioAcadmia($dataI = '0000-00-00', $dataF = '0000-00-00', $academia = '') {
        $funcao = new ClassFuncoes();
        if ($dataF == '0000-00-00')
            $dataF = Date('Y-m-d');
        $SQL = "SELECT * FROM  contrato LEFT JOIN pagamentos ON contrato.COD_CONTRATO=pagamentos.COD_CONTRATO LEFT JOIN servico ON servico.ID_SERVICO=pagamentos.ID_SERVICO LEFT JOIN academia ON contrato.ID_ACADEMIA=academia.ID_ACADEMIA WHERE academia.NOME LIKE  '%" . $academia . "%' AND pagamentos.DATA_PAG  BETWEEN '" . $dataI . "' AND '" . $dataF . "' ORDER BY pagamentos.ID_PAGAMENTO DESC";
        if ($result = $this->conexao->query($SQL))
            return $result;
        else {
            $funcao->msg('error', $this->conexao->error);
        }
    }

    function get_relatorio_Acadmia_soma_mensal($dataI = '0000-00-00', $dataF = '0000-00-00', $academia = '') {
        $funcao = new ClassFuncoes();
        if ($dataF == '0000-00-00')
            $dataF = Date('Y-m-d');
        $SQL = "SELECT sum(pagamentos.valor) FROM  contrato LEFT JOIN pagamentos ON contrato.COD_CONTRATO=pagamentos.COD_CONTRATO LEFT JOIN servico ON servico.ID_SERVICO=pagamentos.ID_SERVICO LEFT JOIN academia ON contrato.ID_ACADEMIA=academia.ID_ACADEMIA WHERE academia.NOME LIKE  '%" . $academia . "%' AND pagamentos.DATA_PAG  BETWEEN '" . $dataI . "' AND '" . $dataF . "' AND servico.TIPO='MENSAL' ORDER BY pagamentos.ID_PAGAMENTO DESC";
        if ($result = $this->conexao->query($SQL)) {
            $dados = $result->fetch_assoc();
            //var_dump($dados);
            return "R$ " . number_format($dados["sum(pagamentos.valor)"], '2', ',', '.');
        } else {
            $funcao->msg('error', $this->conexao->error);
        }
    }

    function get_relatorio_Acadmia_soma_trimestral($dataI = '0000-00-00', $dataF = '0000-00-00', $academia = '') {
        $funcao = new ClassFuncoes();
        if ($dataF == '0000-00-00')
            $dataF = Date('Y-m-d');
        $SQL = "SELECT sum(pagamentos.valor) FROM  contrato LEFT JOIN pagamentos ON contrato.COD_CONTRATO=pagamentos.COD_CONTRATO LEFT JOIN servico ON servico.ID_SERVICO=pagamentos.ID_SERVICO LEFT JOIN academia ON contrato.ID_ACADEMIA=academia.ID_ACADEMIA WHERE academia.NOME LIKE  '%" . $academia . "%' AND pagamentos.DATA_PAG  BETWEEN '" . $dataI . "' AND '" . $dataF . "' AND servico.TIPO='TRIMESTRAL' ORDER BY pagamentos.ID_PAGAMENTO DESC";
        if ($result = $this->conexao->query($SQL)) {
            $dados = $result->fetch_assoc();
            //var_dump($dados);
            return "R$ " . number_format($dados["sum(pagamentos.valor)"], '2', ',', '.');
        } else {
            $funcao->msg('error', $this->conexao->error);
        }
    }

    function get_relatorio_Acadmia_soma_total($dataI = '0000-00-00', $dataF = '0000-00-00', $academia = '') {
        $funcao = new ClassFuncoes();
        if ($dataF == '0000-00-00')
            $dataF = Date('Y-m-d');
        $SQL = "SELECT sum(pagamentos.valor) FROM  contrato LEFT JOIN pagamentos ON contrato.COD_CONTRATO=pagamentos.COD_CONTRATO LEFT JOIN servico ON servico.ID_SERVICO=pagamentos.ID_SERVICO LEFT JOIN academia ON contrato.ID_ACADEMIA=academia.ID_ACADEMIA WHERE academia.NOME LIKE  '%" . $academia . "%' AND pagamentos.DATA_PAG  BETWEEN '" . $dataI . "' AND '" . $dataF . "' ORDER BY pagamentos.ID_PAGAMENTO DESC";
        if ($result = $this->conexao->query($SQL)) {
            $dados = $result->fetch_assoc();
            //var_dump($dados);
            return "R$ " . number_format($dados["sum(pagamentos.valor)"], '2', ',', '.');
        } else {
            $funcao->msg('error', $this->conexao->error);
        }
    }

    function consultaAlunos($horario = "8:00", $semana = "", $academia = "", $servico = "") {
        $funcao = new ClassFuncoes();

        if ($semana == "") {
            $data = date("d-m-Y");
            if (date('w', strtotime($data)) == 0)
                $semana = "seg";
            if (date('w', strtotime($data)) == 1)
                $semana = "seg";
            if (date('w', strtotime($data)) == 2)
                $semana = "ter";
            if (date('w', strtotime($data)) == 3)
                $semana = "qua";
            if (date('w', strtotime($data)) == 4)
                $semana = "qui";
            if (date('w', strtotime($data)) == 5)
                $semana = "sex";
            if (date('w', strtotime($data)) == 6)
                $semana = "sab";
        }

        $SQL = "SELECT academia.NOME as ACADEMIA,aluno.NOME,servico.DESCRICAO,aula.horario FROM contrato LEFT JOIN aluno ON aluno.ID_ALUNO = contrato.ID_ALUNO LEFT JOIN academia ON academia.ID_ACADEMIA=contrato.ID_ACADEMIA LEFT JOIN aula ON contrato.COD_CONTRATO = aula.cod_contrato LEFT JOIN servico ON servico.ID_SERVICO=contrato.ID_SERVICO WHERE aula.horario LIKE '%" . $horario . "%' AND aula." . $semana . "=1 AND   academia.NOME LIKE '%" . $academia . "%' AND servico.DESCRICAO LIKE '%" . $servico . "%'";

        if ($result = $this->conexao->query($SQL)) {
            //var_dump($result);
            return $result;
        } else
            $funcao->msg('error', $this->conexao->error);
    }

}
