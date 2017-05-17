<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClassPagamentos
 *
 * @author oliveira
 */
class ClassPagamentos extends ClassConexao {

    //put your code here
    //lança as datas de pagamentos mensais na tabela
    //lanca o primeiro pagamento com a data do contrato
    function gerarPagamento($contrato, $data, $data_vencimento, $tipo, $servico, $status) {
        $funcao = new ClassFuncoes();
        $classServico = new ClassServico();
        //inserem o codigo e data de pagamento na tabela pagamento e como padrao atribui 0 como não pago
        if ($tipo == "MENSAL") {
            $data_vencimento = $this->Data($data_vencimento);
        }
        if ($tipo == "TRIMESTRAL") {
            $data_vencimento = $this->DataTrimestral($data_vencimento);
        }

        $valor = $classServico->getValor($servico);

        $SQL = "INSERT INTO pagamentos (COD_CONTRATO,DATA_PAG,STATUS,DATA_VENC,ID_SERVICO,VALOR) VALUES ('" . $contrato . "','" . $data . "'," . $status . ",'" . $data_vencimento . "'," . $servico . "," . $valor . ")";

        $result = $this->conexao->query($SQL);

        if (!$result)
            $funcao->msg('error', $this->conexao->error);
        else
            return false;
    }

    function gerarPagamentoAtual($contrato, $dia_venc, $data_vencimento, $tipo, $servico, $status) {
        $funcao = new ClassFuncoes();
        $classServico = new ClassServico();
        //inserem o codigo e data de pagamento na tabela pagamento e como padrao atribui 0 como não pago
        if ($tipo == "MENSAL") {
            $data_vencimento = $this->DataPrazo($dia_venc, $data_vencimento);
        }
        if ($tipo == "TRIMESTRAL") {
            $data_vencimento = $this->DataTrimestralPrazo($dia_venc, $data_vencimento);
        }

        $valor = $classServico->getValor($servico);

        $SQL = "INSERT INTO pagamentos (COD_CONTRATO,DATA_PAG,STATUS,DATA_VENC,ID_SERVICO,VALOR) VALUES ('" . $contrato . "','" . Date('Y-m-d') . "'," . $status . ",'" . $data_vencimento . "'," . $servico . "," . $valor . ")";

        $result = $this->conexao->query($SQL);

        if (!$result)
            $funcao->msg('error', $this->conexao->error);
        else
            return false;
    }

    function pagar($contrato, $academia, $servico, $dia_venc) {
        $funcao = new ClassFuncoes();
        $classContrato = new ClassContrato();

        $classServico = new ClassServico();
        $tipo = $classServico->getTipoServico($servico);

        $data_vencimento = $this->getMensalUltimoPagamento($contrato);


        //VERFICA SE O VENCIMENTO DO ULTIMO LANÇAENTO E MENOR QUE A DATA ATUAL OU SEJA SE O PAGAMENTO ESTÁ EM ATRASO
        if ($data_vencimento < Date('Y-m-d')) {
            //FAZ ALTERAÇÃO NA TABELA CONTRATO
            $classContrato->UpdateContrato($contrato, $academia, $servico, $dia_venc);
            //FAZ INCLUSÃO NA TABELA PAGAMENTOS
            $this->gerarPagamentoAtual($contrato, $dia_venc, Date('Y-m-d'), $tipo, $servico, 1);
        } else {
            $classContrato->UpdateContrato($contrato, $academia, $servico, $dia_venc);
            $this->gerarPagamentoAtual($contrato, $dia_venc, $data_vencimento, $tipo, $servico, 1);
        }

        $funcao->refresh(3);
    }

    //verifica se o ultimo pagamento foi pago se sim retorna true
    function verificaUltimoPagamento($cod) {
        $funcao = new ClassFuncoes();

        $SQL = "SELECT pagamentos.DATA_VENC  FROM pagamentos LEFT JOIN contrato ON pagamentos.COD_CONTRATO = contrato.COD_CONTRATO LEFT JOIN aluno ON contrato.ID_ALUNO = aluno.ID_ALUNO LEFT JOIN servico ON servico.ID_SERVICO=contrato.ID_SERVICO WHERE pagamentos.COD_CONTRATO = '" . $cod . "'  ORDER BY pagamentos.DATA_PAG DESC ";

        $result = $this->conexao->query($SQL);

        if (!$result)
            $funcao->msg('error', $this->conexao->error);
        else
            $row = $result->fetch_assoc();

        //var_dump($row);

        if ($row['DATA_VENC'] >= Date('Y-m-d')) {
            //var_dump($row);

            return true;
        } else {
            return false;
        }
    }

    function getMensalUltimoPagamento($cod) {
        $funcao = new ClassFuncoes();

        $SQL = "SELECT pagamentos.DATA_VENC  FROM pagamentos LEFT JOIN contrato ON pagamentos.COD_CONTRATO = contrato.COD_CONTRATO LEFT JOIN aluno ON contrato.ID_ALUNO = aluno.ID_ALUNO LEFT JOIN servico ON servico.ID_SERVICO=contrato.ID_SERVICO WHERE pagamentos.COD_CONTRATO = '" . $cod . "'  ORDER BY pagamentos.DATA_VENC DESC ";

        $result = $this->conexao->query($SQL);

        if (!$result)
            $funcao->msg('error', $this->conexao->error);
        else
            $row = $result->fetch_assoc();

        //var_dump($row);

        return $row['DATA_VENC'];
    }

    function deletarPagamento($id) {
        $classFuncoes = new ClassFuncoes();
        $SQL = "DELETE FROM pagamentos WHERE ID_PAGAMENTO=" . $id . "";

        if ($this->conexao->query($SQL)) {
            $classFuncoes->msg('OK', 'Exluido com sucesso!');
        } else {
            $classFuncoes->msg('error', 'Não foi possivel efetuar a exclusão' . $this->conexao->error);
        }
    }

    //lança as datas de pagamentos trimestrais na tabela
    function gerarPagamentoALunoTrimestral() {
        $funcao = new ClassFuncoes();
        /* seleciona os dados dos alunos trimestrais ativos */
        $SQL = "SELECT * FROM servico,contrato,aluno,academia WHERE (contrato.ID_ALUNO=aluno.ID_ALUNO AND contrato.ID_SERVICO=servico.ID_SERVICO AND contrato.ID_ACADEMIA=academia.ID_ACADEMIA) AND servico.TIPO='TRIMESTRAL' AND contrato.status=1";

        $result = $this->conexao->query($SQL);

        if (!$result) {
            /* passa mensagem para metodo msg para informar o erro */
            $funcao->msg('error', $this->conexao->error);
        } else {


            while ($row = $result->fetch_assoc()) {

                /* var_dump($row); */



                $DATA = $row['DATA_VENC'];
                /* Formata a data retornando com o dia da data de vencimento 
                 * e mes o ano atual
                 */
                $DATA = $this->DataTrimestral($DATA);

                /* seleciona na tabela pagamentos os ultimos pagamentos lançados dos contratos  */
                $SQL = "SELECT * FROM pagamentos WHERE COD_CONTRATO='" . $row['COD_CONTRATO'] . "' ORDER BY DATA_PAG  DESC";

                $result2 = $this->conexao->query($SQL);
                if (!$result2) {
                    $funcao->msg('error', $this->conexao->error);
                } else {
                    $dados = $result2->fetch_assoc();
                    //var_dump($dados);
                    //verifica se o ultimo lançamento tem o mesmo mês que o atual 
                    if ($this->verificarMesIgualMesAutal($dados["DATA_PAG"])) {
                        //se for o mesmo mês lança o proximo pagamento o novo vencimento
                        $this->gerarPagamento($row['COD_CONTRATO'], $DATA, $row['TIPO'], $row['ID_SERVICO'], 0);
                    }
                }
            }
        }
    }

    function verificarMesIgualMesAutal($data) {
        var_dump($data);
        $data1 = (string) $data;
        $data1 = explode('-', $data1);

        $mes_atual = explode('-', date('Y-m-d'));
        if ($data1[1] == $mes_atual[1]) {
            return true;
        } else {
            return FALSE;
        }
    }

    function gerarPagamentoALunoMensal() {
        $funcao = new ClassFuncoes();
        /* seleciona os dados dos alunos mensais ativos */
        $SQL = "SELECT * FROM pagamentos LEFT JOIN contrato ON pagamentos.COD_CONTRATO = contrato.COD_CONTRATO LEFT JOIN aluno ON contrato.ID_ALUNO = aluno.ID_ALUNO LEFT JOIN servico ON contrato.ID_SERVICO = servico.ID_SERVICO WHERE contrato.COD_CONTRATO = '" . $cod . "' AND pagamentos.STATUS=0 AND pagamentos.TIPO='MENSAL'";

        $result = $this->conexao->query($SQL);

        if (!$result) {
            /* passa mensagem para metodo msg para informar o erro */
            $funcao->msg('error', $this->conexao->error);
        } else {


            while ($row = $result->fetch_assoc()) {

                /* var_dump($row); */



                $DATA = $row['DATA_VENC'];
                /* Formata a data retornando com o dia da data de vencimento 
                 * e mes o ano atual
                 */
                $DATA = $this->DataTrimestral($DATA);
                $mes_atual = date("m");
                /* seleciona na tabela pagamentos os contratos com os meses e pagamentos atuais */
                $SQL = "SELECT * FROM pagamentos WHERE COD_CONTRATO='" . $row['COD_CONTRATO'] . "' AND  MONTH(DATA_PAG)='" . $mes_atual . "'";

                $result2 = $this->conexao->query($SQL);
                if (!$result2) {
                    $funcao->msg('error', $this->conexao->error);
                } else {
                    $dados = $result2->fetch_assoc();
                    //var_dump($dados);

                    /* passa a quantidade linhas de registro para variavel QTD */
                    $QTD = $result2->num_rows;

                    /* se nao existir registro de pagamento para o mes 
                     * passa mensagem com os valores de numero de contrato e a data formatada e 0 como não pago para o metodo geraPagamentoMes
                     */
                    if ($QTD == 0) {
                        $this->gerarPagamento($row['COD_CONTRATO'], $DATA, $row['TIPO'], $row['ID_SERVICO'], 0);
                    }
                }
            }
        }
    }

    function gerarPagamentoTodosALunoMensal() {
        $funcao = new ClassFuncoes();
        /* seleciona os dados dos alunos mensais ativos */
        $SQL = "SELECT * FROM servico,contrato,aluno,academia WHERE (contrato.ID_ALUNO=aluno.ID_ALUNO AND contrato.ID_SERVICO=servico.ID_SERVICO AND contrato.ID_ACADEMIA=academia.ID_ACADEMIA) AND servico.TIPO='MENSAL' AND contrato.status=1";

        $result = $this->conexao->query($SQL);

        if (!$result) {
            /* passa mensagem para metodo msg para informar o erro */
            $funcao->msg('error', $this->conexao->error);
        } else {


            while ($row = $result->fetch_assoc()) {

                /* var_dump($row); */



                $DATA = $row['DATA_VENC'];
                /* Formata a data retornando com o dia da data de vencimento 
                 * e mes o ano atual
                 */
                $DATA = $this->DataTrimestral($DATA);
                $mes_atual = date("m");
                /* seleciona na tabela pagamentos os contratos com os meses e pagamentos atuais */
                $SQL = "SELECT * FROM pagamentos WHERE COD_CONTRATO='" . $row['COD_CONTRATO'] . "' AND  MONTH(DATA_PAG)='" . $mes_atual . "'";

                $result2 = $this->conexao->query($SQL);
                if (!$result2) {
                    $funcao->msg('error', $this->conexao->error);
                } else {
                    $dados = $result2->fetch_assoc();
                    //var_dump($dados);

                    /* passa a quantidade linhas de registro para variavel QTD */
                    $QTD = $result2->num_rows;

                    /* se nao existir registro de pagamento para o mes 
                     * passa mensagem com os valores de numero de contrato e a data formatada e 0 como não pago para o metodo geraPagamentoMes
                     */
                    if ($QTD == 0) {
                        $this->gerarPagamento($row['COD_CONTRATO'], $DATA, $row['TIPO'], $row['ID_SERVICO'], 0);
                    }
                }
            }
        }
    }

    function Data($dia_venc) {


        $mes_atual = explode('-', date('Y-m-d'));

        if (($mes_atual[1] + 1) <= 12)
        //retorna o ano atual mais 1 meses e a data de vencimento escolhida no contrato
            return $mes_atual[0] . "-" . ($mes_atual[1] + 1) . "-" . $dia_venc;
        else
        //retorna o ano atual somado a um  e total dos meses menos 12 e a data de vencimento escolhida no contrato
            return ($mes_atual[0] + 1) . "-" . ($mes_atual[1] + 1 - 12) . "-" . $dia_venc;
    }

    function DataTrimestral($dia_venc) {


        $mes_atual = explode('-', date('Y-m-d'));

        if (($mes_atual[1] + 3) <= 12)
        //retorna o ano atual mais 2 meses e a data de vencimento escolhida no contrato
            return $mes_atual[0] . "-" . ($mes_atual[1] + 3) . "-" . $dia_venc;
        else
        //retorna o ano atual somado a um  e total dos meses menos 12 e a data de vencimento escolhida no contrato
            return ($mes_atual[0] + 1) . "-" . ($mes_atual[1] + 3 - 12) . "-" . $dia_venc;
    }

    function DataTrimestralPrazo($dia_venc, $ultimaData) {


        $mes_atual = explode('-', $ultimaData);

        if (($mes_atual[1] + 3) <= 12)
        //retorna o ano atual mais 2 meses e a data de vencimento escolhida no contrato
            return $mes_atual[0] . "-" . ($mes_atual[1] + 3) . "-" . $dia_venc;
        else
        //retorna o ano atual somado a um  e total dos meses menos 12 e a data de vencimento escolhida no contrato
            return ($mes_atual[0] + 1) . "-" . ($mes_atual[1] + 3 - 12) . "-" . $dia_venc;
    }

    function DataPrazo($dia_venc, $ultimaData) {


        $mes_atual = explode('-', $ultimaData);

        if (($mes_atual[1] + 1) <= 12)
        //retorna o ano atual mais 2 meses e a data de vencimento escolhida no contrato
            return $mes_atual[0] . "-" . ($mes_atual[1] + 1) . "-" . $dia_venc;
        else
        //retorna o ano atual somado a um  e total dos meses menos 12 e a data de vencimento escolhida no contrato
            return ($mes_atual[0] + 1) . "-" . ($mes_atual[1] + 1 - 12) . "-" . $dia_venc;
    }

    function alterar_vencimento_e_pagamento($id_pagamento, $pagamento, $vencimento) {

        $ClassFuncao = new ClassFuncoes();
        if ($pagamento == "" || $pagamento == "0000-00-00") {
            $ClassFuncao->msg('error', 'Verifique o preenchimento do pagamento');
        } else
        if ($vencimento == "" || $vencimento == "0000-00-00") {
            $ClassFuncao->msg('error', 'Verifique o preenchimento do vencimento');
        } else if ($id_pagamento == "") {
            $ClassFuncao->msg('error', 'Erro ao encontrar contrato');
        } else {
            $SQL = "UPDATE  pagamentos set DATA_PAG='" . $pagamento . "', DATA_VENC='" . $vencimento . "' WHERE ID_PAGAMENTO=" . $id_pagamento . "";
            if ($this->conexao->query($SQL)) {
                $ClassFuncao->msg('OK', 'Atualizado com sucesso');
            } else {
                $ClassFuncao->msg('error', 'Ocorreu um error na atualização das datas');
                $ClassFuncao->msg('error', $this->conexao->error);
            }
        }
    }

}
