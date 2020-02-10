<?php

namespace Model;
use  Model\Funcoes;

class Consulta extends \Model\Configuracao
{
    /* retorna o valor total a receber com aluno mensal */

    function getValorAlunoMensal()
    {
        $funcao = new Funcoes();
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

    function getValorAlunoTrimestral()
    {
        $funcao = new Funcoes();
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

    function ConsultarVencimentos()
    {
        //seleciona todos os contratos
        $SQL = "SELECT 
                * FROM
                (
                    SELECT 
                         DATEDIFF(MAX(pg.DATA_VENC),NOW()) AS vencimento,
                         pg.*, al.*,ac.NOME AS academia,sv.TIPO,co.STATUS AS SITUACAO
                        FROM aluno AS al
                        LEFT JOIN contrato AS co ON co.ID_ALUNO = al.ID_ALUNO
                        LEFT JOIN pagamentos AS pg ON pg.COD_CONTRATO = co.COD_CONTRATO
                        LEFT JOIN academia AS ac ON ac.ID_ACADEMIA = co.ID_ACADEMIA
                        LEFT JOIN servico AS sv ON sv.ID_SERVICO = pg.ID_SERVICO
                     GROUP BY co.COD_CONTRATO
                    )AS con
                WHERE con.COD_CONTRATO IS NOT NULL AND con.SITUACAO=1 ";

        $result = $this->conexao->query($SQL);

        if (!$result)
            $funcao->msg('error', $this->conexao->error);
        else
            return $result;
    }

    function getValorMensalTotalReceber($cod)
    {
        $funcao = new Funcoes();

        $SQL = "SELECT sum(servico.VALOR) FROM pagamentos LEFT JOIN contrato ON pagamentos.COD_CONTRATO = contrato.COD_CONTRATO LEFT JOIN aluno ON contrato.ID_ALUNO = aluno.ID_ALUNO LEFT JOIN servico ON contrato.ID_SERVICO = servico.ID_SERVICO WHERE contrato.COD_CONTRATO = '" . $cod . "' AND pagamentos.STATUS=0  ";

        $result = $this->conexao->query($SQL);

        if (!$result)
            $funcao->msg('error', $this->conexao->error);
        else
            $row = $result->fetch_assoc();
        return "R$ " . number_format($row["sum(servico.VALOR)"], '2', ',', '');
    }

    function getQtdMensalAtraso($cod)
    {
        $funcao = new Funcoes();

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

    function adimplencia($data_vencimento)
    {
        $data = Date("Y-m-d");

        // Usa a função strtotime() e pega o timestamp das duas datas:
        $time_inicial = strtotime($data);
        $time_final = strtotime($data_vencimento);
// Calcula a diferença de segundos entre as duas datas:
        $diferenca = $time_final - $time_inicial; // 19522800 segundos
// Calcula a diferença de dias
        $dias = (int)floor($diferenca / (60 * 60 * 24)); // 225 dias
        if ($data_vencimento < $data) {

            $data = date_diff(date_create($data_vencimento), date_create($data)); //days
            return $dias;
        } else
            return $dias;
    }

    function relatorioPagamento($cod)
    {
        $funcao = new Funcoes();
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
                echo "
                                            <tr>
                                                
                                                <td>" . $row['TIPO'] . " " . $row['DESCRICAO'] . "</td>
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

    function get_Qtd_Em_Dia()
    {
        $result = $this->get_Em_Dia();
        return $result->num_rows;

    }

    function get_Qtd_Em_Vencer()
    {
        $result = $this->get_Em_Vencer();
        return $result->num_rows;
    }

    function get_Qtd_Em_Atraso()
    {
        $result = $this->get_Em_Atraso();
        return $result->num_rows;
    }

    function get_Em_Dia()
    {
        $SQL = " 
            SELECT 
                * FROM
                (
                    SELECT 
                         DATEDIFF(MAX(pg.DATA_VENC),NOW()) AS vencimento,
                         pg.*,date_format(pg.DATA_VENC,'%d-%m-%Y') as DT_VENCIMENTO, 
                         al.*,date_format(al.DATA_NASC,'%d-%m-%Y') as NASCIMENTO,
                         ac.NOME AS academia,sv.TIPO,sv.DESCRICAO,co.STATUS AS SITUACAO
                        FROM aluno AS al
                        LEFT JOIN contrato AS co ON co.ID_ALUNO = al.ID_ALUNO
                        LEFT JOIN pagamentos AS pg ON pg.COD_CONTRATO = co.COD_CONTRATO
                        LEFT JOIN academia AS ac ON ac.ID_ACADEMIA = co.ID_ACADEMIA
                        LEFT JOIN servico AS sv ON sv.ID_SERVICO = pg.ID_SERVICO
                     GROUP BY co.COD_CONTRATO
                    )AS con
                WHERE con.COD_CONTRATO IS NOT NULL AND con.SITUACAO = 1 AND con.vencimento >10";

        $result = $this->conexao->query($SQL);


        if (!$result) {
            $funcao = new ClassFuncoes();
            $funcao->msg('error', $this->conexao->error);
        } else
            return $result;
    }

    function get_Em_Vencer()
    {
        $SQL = " SELECT 
            * FROM
            (
                SELECT 
                     DATEDIFF(MAX(pg.DATA_VENC),NOW()) AS vencimento,
                     pg.*,date_format(pg.DATA_VENC,'%d-%m-%Y') as DT_VENCIMENTO, 
                     al.*,date_format(al.DATA_NASC,'%d-%m-%Y') as NASCIMENTO,
                     ac.NOME AS academia,sv.TIPO,sv.DESCRICAO,co.STATUS AS SITUACAO
                    FROM aluno AS al
                    LEFT JOIN contrato AS co ON co.ID_ALUNO = al.ID_ALUNO
                    LEFT JOIN pagamentos AS pg ON pg.COD_CONTRATO = co.COD_CONTRATO
                    LEFT JOIN academia AS ac ON ac.ID_ACADEMIA = co.ID_ACADEMIA
                    LEFT JOIN servico AS sv ON sv.ID_SERVICO = pg.ID_SERVICO
                 GROUP BY co.COD_CONTRATO
                )AS con
            WHERE con.COD_CONTRATO IS NOT NULL AND  con.SITUACAO = 1 AND con.vencimento BETWEEN 1 AND 10";

        $result = $this->conexao->query($SQL);

        if (!$result)
            $funcao->msg('error', $this->conexao->error);
        else
            return $result;
    }

    function get_Em_Atraso()
    {
        $SQL = " SELECT 
            * FROM
            (
                SELECT 
                     DATEDIFF(MAX(pg.DATA_VENC),NOW()) AS vencimento,
                     pg.*,date_format(pg.DATA_VENC,'%d-%m-%Y') as DT_VENCIMENTO, 
                     al.*,date_format(al.DATA_NASC,'%d-%m-%Y') as NASCIMENTO,
                     ac.NOME AS academia,sv.TIPO,sv.DESCRICAO,co.STATUS AS SITUACAO
                    FROM aluno AS al
                    LEFT JOIN contrato AS co ON co.ID_ALUNO = al.ID_ALUNO
                    LEFT JOIN pagamentos AS pg ON pg.COD_CONTRATO = co.COD_CONTRATO
                    LEFT JOIN academia AS ac ON ac.ID_ACADEMIA = co.ID_ACADEMIA
                    LEFT JOIN servico AS sv ON sv.ID_SERVICO = pg.ID_SERVICO
                 GROUP BY co.COD_CONTRATO
                )AS con
            WHERE con.COD_CONTRATO IS NOT NULL   AND con.SITUACAO = 1 AND con.vencimento<=0";

        $result = $this->conexao->query($SQL);

        if (!$result)
            $funcao->msg('error', $this->conexao->error);
        else
            return $result;
    }

    function relatorioAcadmia($dataI = '0000-00-00', $dataF = '0000-00-00', $academia = '')
    {
        $funcao = new Funcoes();
        if ($dataF == '0000-00-00')
            $dataF = Date('Y-m-d');
        $SQL = "SELECT 
                   * ,
                   DATE_FORMAT(pagamentos.DATA_PAG,'%d-%m-%Y') AS DATA_PAG
                FROM  contrato 
                LEFT JOIN pagamentos ON contrato.COD_CONTRATO=pagamentos.COD_CONTRATO 
                LEFT JOIN servico ON servico.ID_SERVICO=pagamentos.ID_SERVICO 
                LEFT JOIN academia ON contrato.ID_ACADEMIA=academia.ID_ACADEMIA 
                WHERE 
                    academia.NOME LIKE  '%" . $academia . "%' 
                AND pagamentos.DATA_PAG  BETWEEN '" . $dataI . "' AND '" . $dataF . "' 
                ORDER BY pagamentos.ID_PAGAMENTO DESC";
        if ($result = $this->conexao->query($SQL))
            return $result;
        else {
            $funcao->msg('error', $this->conexao->error);
        }
    }

    function get_relatorio_Acadmia_soma_mensal($dataI = '0000-00-00', $dataF = '0000-00-00', $academia = '')
    {
        $funcao = new Funcoes();
        if ($dataF == '0000-00-00')
            $dataF = Date('Y-m-d');
        $SQL = "SELECT sum(pagamentos.valor) FROM  contrato LEFT JOIN pagamentos ON contrato.COD_CONTRATO=pagamentos.COD_CONTRATO LEFT JOIN servico ON servico.ID_SERVICO=pagamentos.ID_SERVICO LEFT JOIN academia ON contrato.ID_ACADEMIA=academia.ID_ACADEMIA WHERE academia.NOME LIKE  '%" . $academia . "%' AND pagamentos.DATA_PAG  BETWEEN '" . $dataI . "' AND '" . $dataF . "' AND servico.TIPO='MENSAL' ORDER BY pagamentos.ID_PAGAMENTO DESC";
        if ($result = $this->conexao->query($SQL)) {
            $dados = $result->fetch_assoc();
            //var_dump($dados);
            return "R$ <br>" . number_format($dados["sum(pagamentos.valor)"], '2', ',', '.');
        } else {
            $funcao->msg('error', $this->conexao->error);
        }
    }

    function get_relatorio_Acadmia_soma_trimestral($dataI = '0000-00-00', $dataF = '0000-00-00', $academia = '')
    {
        $funcao = new Funcoes();
        if ($dataF == '0000-00-00')
            $dataF = Date('Y-m-d');
        $SQL = "SELECT sum(pagamentos.valor) FROM  contrato LEFT JOIN pagamentos ON contrato.COD_CONTRATO=pagamentos.COD_CONTRATO LEFT JOIN servico ON servico.ID_SERVICO=pagamentos.ID_SERVICO LEFT JOIN academia ON contrato.ID_ACADEMIA=academia.ID_ACADEMIA WHERE academia.NOME LIKE  '%" . $academia . "%' AND pagamentos.DATA_PAG  BETWEEN '" . $dataI . "' AND '" . $dataF . "' AND servico.TIPO='TRIMESTRAL' ORDER BY pagamentos.ID_PAGAMENTO DESC";
        if ($result = $this->conexao->query($SQL)) {
            $dados = $result->fetch_assoc();
            //var_dump($dados);
            return "R$ <br>" . number_format($dados["sum(pagamentos.valor)"], '2', ',', '.');
        } else {
            $funcao->msg('error', $this->conexao->error);
        }
    }

    function get_relatorio_Acadmia_soma_total($dataI = '0000-00-00', $dataF = '0000-00-00', $academia = '')
    {
        $funcao = new Funcoes();
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

    function consultaAlunos($horario = "", $semana = "", $academia = "", $servico = "")
    {
        $funcao = new Funcoes();

        $queryAux = !empty($semana) ? " AND  aula." . $semana . "=1" : "";


        $SQL = " SELECT 
                       academia.NOME as ACADEMIA,
                       IF(contrato.ID_DEPENDENTE > 0,'DEPENDENTE','ALUNO') as TIPO,
                       IF(contrato.ID_DEPENDENTE > 0, dependente.nome, aluno.NOME) AS NOME,
                       servico.DESCRICAO,
                       aula.horario,
                       CONCAT(
                         IF(aula.seg=1,'SEG,',''),
                         IF(aula.ter=1,'TER,',''),
                         IF(aula.qua=1,'QUA,',''),
                         IF(aula.qui=1,'QUI,',''),
                         IF(aula.sex=1,'SEX,',''),
                         IF(aula.sab=1,'SAB,','')
                       ) as semana
                FROM contrato 
                LEFT JOIN aluno ON aluno.ID_ALUNO = contrato.ID_ALUNO 
                LEFT JOIN academia ON academia.ID_ACADEMIA=contrato.ID_ACADEMIA 
                LEFT JOIN aula ON contrato.COD_CONTRATO = aula.cod_contrato
                LEFT JOIN servico ON servico.ID_SERVICO=contrato.ID_SERVICO 
                LEFT JOIN dependente ON dependente.id = contrato.ID_DEPENDENTE
                WHERE
                     academia.NOME LIKE '%" . $academia . "%'
                AND    aula.horario LIKE '%" . $horario . "%' 
                AND servico.DESCRICAO LIKE '%" . $servico . "%'
                {$queryAux}
                ";

        if ($result = $this->conexao->query($SQL)) {
            //var_dump($result);
            return $result;
        } else
            $funcao->msg('error', $this->conexao->error);
    }

}



        
