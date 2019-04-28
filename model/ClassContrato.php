<?php

class ClassContrato extends ClassConfiguracao
{

    function CadastrarContrato($alunoID, $servicoID, $dataVencimento, $cpf, $academiaID, $seg, $ter, $qua, $qui, $sex, $sab, $hor, $ob, $dep)
    {

        $funcao = new ClassFuncoes();
        $pagamento = new ClassPagamentos();
        $classServico = new ClassServico();
        $classAula = new ClassAulas();
        $classEmail = new ClassEmail();

        $this->conexao->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);

        if ($alunoID == "") {
            $funcao->msg('error', 'Ocorreu um erro no sistema ao verficar ao aluno refaça o contrato');
        } else if ($servicoID == "") {
            $funcao->msg('error', 'Ocorreu um erro no sistema ao verficar ao serviço refaça o contrato');
        } else if ($academiaID == "") {
            $funcao->msg('error', 'Ocorreu um erro no sistema ao verficar ao academia refaça o contrato');
        } else {


            try {

                echo $dep;
                $codigo = $funcao->GerarCodigo($alunoID, $cpf, $academiaID,$dep);

                $agora = date("Y-m-d H:i:s");
                $sql = "INSERT INTO contrato(COD_CONTRATO,ID_ALUNO,ID_ACADEMIA,ID_SERVICO,STATUS,DATA_VENC,ATUALIZACAO,OBSERVACAO,ID_DEPENDENTE,ACEITO) VALUES ('" . $codigo . "','" . $alunoID . "', '" . $academiaID . "','" . $servicoID . "',1,'" . $dataVencimento . "','" . $agora . "','" . $ob . "','" . $dep . "','0')";

                $result = $this->conexao->query($sql);

                if (!$result) {
                    if ($this->conexao->errno == 1062) {
                        throw new Exception('Contrato já possui cadastro');
                    } else {
                        throw new Exception($this->conexao->error);
                    }
                } else {
                    $data = date("Y-m-d");
                    $tipo = $classServico->getTipoServico($servicoID);

                    $pagamento->gerarPagamento($codigo, $data, $dataVencimento, $tipo, $servicoID, 1);
                    $classAula->insert_Aulas($codigo, $seg, $ter, $qua, $qui, $sex, $sab, $hor);

                    $classEmail->emailContrato($codigo);
                    $funcao->msg('ok', 'Cadastrado com sussesso');
                    $this->conexao->commit();
                }

            } catch (Exception $e) {
                $funcao->msg('error', $e->getMessage());
                $this->conexao->rollback();
            }
        }
    }

    function ListarContrato($pagina, $consulta,$urlParam)
    {
        $funcao = new ClassFuncoes();

        $porPagina = 5;
        $offset = (($pagina - 1) * $porPagina);
        $limit = $porPagina;


        $SQL = "SELECT  
                    contrato.COD_CONTRATO ,
                    contrato.STATUS ,
                    contrato.ACEITO ,
                    academia.NOME AS ACADEMIA,
                    academia.BAIRRO,
                    IF( contrato.ID_DEPENDENTE > 0 , dependente.NOME , aluno.NOME ) AS ALUNO,
                    aluno.CPF,
                    servico.TIPO,
                    servico.DESCRICAO,
                    servico.VALOR
                    FROM 
                    contrato
                    LEFT JOIN academia ON academia.ID_ACADEMIA = contrato.ID_ACADEMIA
                    LEFT JOIN aluno ON aluno.ID_ALUNO = contrato.ID_ALUNO
                    LEFT JOIN dependente ON dependente.id = contrato.ID_DEPENDENTE
                    LEFT JOIN servico ON servico.ID_SERVICO = contrato.ID_SERVICO
                    HAVING
                    ALUNO LIKE '%" . $consulta . "%' 
                    OR CPF LIKE '%" . $consulta . "%'
                    OR DESCRICAO LIKE '%" . $consulta . "%'
                    OR TIPO LIKE '%" . $consulta . "%' 
                    OR BAIRRO LIKE '%" . $consulta . "%' 
                    OR ACADEMIA LIKE '%" . $consulta . "%' LIMIT " . $limit . " OFFSET " . $offset;

        $result = $this->conexao->query($SQL);
        if (!$result) {
            $funcao->msg('error', $this->conexao->error);
        } else {

            $resultCountRow = $this->conexao->query("SELECT FOUND_ROWS() AS `found_rows`;");
            $total = $resultCountRow->fetch_assoc()["found_rows"];
            $totalPaginas = ceil($total / $porPagina);

            while ($row = $result->fetch_assoc()) { /* var_dump($row); */

                echo "<form method='post'>";
                echo "<ul class='list-group'>";
                echo "<li  class='list-group-item active'><b>Código : </b> {$row['COD_CONTRATO']}</li>";
                echo "<li href='#' class='list-group-item '><b>ALUNO:</b> " . $row['ALUNO'];
                echo "<b> CPF:</b> " . $row['CPF'];
                echo "<b> ACADEMIA:</b> " . $row['ACADEMIA'];
                echo "<b> BAIRRO:</b> " . $row['BAIRRO'];
                echo "<b> TIPO:</b> " . $row['TIPO'];
                echo "<b> SERVIÇO:</b> " . utf8_encode($row['DESCRICAO']);
                echo "<b> VALOR:</b> " . $row['VALOR'];
                echo "</li>";
                echo "<li class='list-group-item '>";
                echo "<a href='?pagina=historico-pagamento&id=" . $row['COD_CONTRATO'] . "' class='btn btn-warning'>Histórico/Pagamento</a> ";
                echo "<a href='?pagina=atualizar-data-aula&id=" . $row['COD_CONTRATO'] . "' class='btn btn-primary'>Aulas</a> ";
                if ($row['ACEITO'] == 0) {
                    echo "<button type='submit' name='reeviar_contrato' value=" . $row['COD_CONTRATO'] . " class='btn btn-danger'>Contrato pendente</button> ";
                } else
                    echo "<a href='/academia/?pagina=contrato-aluno&cod_contrato=" . $row['COD_CONTRATO'] . "' target='_blank' class='btn btn-success'>Contrato aceito</a> ";
                //não haverá necessida de redirecionar para pagina de atualização de contrato
                echo "<a href='?pagina=atualizar-contrato&id=".$row['COD_CONTRATO']."' class='btn btn-primary'>Editar</a>";
                echo "<input type='hidden' name='id' value=" . $row['COD_CONTRATO'] . " />";
                echo "<input type='hidden' name='status' value=" . $row['STATUS'] . " />";


                //função não será mais necessaria mas ta comentado caso necessite para outra ocasião
                if ($row['STATUS'] == '1')
                    echo " <input type='submit' name='bt_status' value='Ativo' class='btn btn-success' />";
                else
                    echo " <input type='submit' name='bt_status' value='Desativado' class='btn btn-danger' />";
                echo "</form>" . " </li></ul>";
            }

           echo $this->paginacao($pagina, $totalPaginas, $urlParam, $consulta);

        }
    }

    function get_Aluno($cod_contrato = "")
    {

        $funcao = new ClassFuncoes();
        $SQL = "SELECT * FROM  aluno LEFT JOIN contrato ON contrato.ID_ALUNO=aluno.ID_ALUNO LEFT JOIN servico ON servico.ID_SERVICO=contrato.ID_SERVICO  WHERE contrato.COD_CONTRATO='" . $cod_contrato . "'";

        $result = $this->conexao->query($SQL);
        if ($result)
            return $result->fetch_assoc();
        else
            $funcao->msg('error', $this->conexao->error);
    }

    //retorna um objeto com os dados do banco
    function get_Academia($cod_contrato)
    {
        $funcao = new ClassFuncoes();
        $SQL = "SELECT * FROM  academia LEFT JOIN contrato ON contrato.ID_ACADEMIA=academia.ID_ACADEMIA WHERE contrato.COD_CONTRATO='" . $cod_contrato . "'";

        $result = $this->conexao->query($SQL);
        if ($result)
            return $result->fetch_assoc();
        else
            $funcao->msg('error', $this->conexao->error);
    }

    //retorna um objeto com os dados do banco
    function get_Servico($cod_contrato)
    {
        $funcao = new ClassFuncoes();
        $SQL = "SELECT * FROM  servico LEFT JOIN contrato ON contrato.ID_SERVICO=servico.ID_SERVICO WHERE contrato.COD_CONTRATO='" . $cod_contrato . "'";

        $result = $this->conexao->query($SQL);
        if ($result)
            return $result->fetch_assoc();
        else
            $funcao->msg('error', $this->conexao->error);
    }

    function GetDadosContrato($id)
    {
        $funcao = new ClassFuncoes();
        $SQL = "SELECT academia.NOME AS ACADEMIA ,academia.ID_ACADEMIA, aluno.NOME,servico.ID_SERVICO,servico.TIPO,servico.DESCRICAO,servico.VALOR,contrato.DATA_VENC,contrato.OBSERVACAO FROM contrato,aluno,servico,academia WHERE (contrato.ID_ALUNO=aluno.ID_ALUNO AND contrato.ID_ACADEMIA=academia.ID_ACADEMIA AND contrato.ID_SERVICO=servico.ID_SERVICO) AND contrato.COD_CONTRATO='" . $id . "'";

        $result = $this->conexao->query($SQL);
        if ($result)
            return $result->fetch_assoc();
        else
            $funcao->msg('error', $this->conexao->error);
    }

    function GetAcademia()
    {
        $funcao = new ClassFuncoes();
        $SQL = "SELECT * FROM academia ORDER BY NOME ASC";

        $result = $this->conexao->query($SQL);
        if ($result)
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row["ID_ACADEMIA"] . "'>";
                echo $row["NOME"];
                echo "</option>";
            } else
            $funcao->msg('error', $this->conexao->error);
    }

    function GetAluno()
    {
        $funcao = new ClassFuncoes();
        $SQL = "SELECT * FROM aluno ORDER BY NOME ASC";

        $result = $this->conexao->query($SQL);
        if ($result)
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row["ID_ALUNO"] . "'>";
                echo $row["NOME"] . " - CPF :" . $row["CPF"];
                echo "</option>";
            } else
            $funcao->msg('error', $this->conexao->error);
    }

    function GetServico()
    {
        $funcao = new ClassFuncoes();
        $SQL = "SELECT * FROM servico ORDER BY TIPO ASC";

        $result = $this->conexao->query($SQL);
        if ($result)
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row["ID_SERVICO"] . "'>";
                echo $row["TIPO"] . " " . utf8_encode($row["DESCRICAO"]) . " -  R$ " . $row["VALOR"];
                echo "</option>";
            } else
            $funcao->msg('error', $this->conexao->error);
    }

    function AtualizarContrato($id, $academia, $servico, $vencimento)
    {

        $funcao = new ClassFuncoes();
        $pagamentos = new ClassPagamentos();
        $ClassServico = new ClassServico();

        if ($id == "" || $academia == "" || $servico == "" || $vencimento == "") {
            $funcao->msg('error', 'Selecione todos os dados');
        } else {
            $dadosContrato = $this->GetDadosContrato($id);
            $servicoTipo = $ClassServico->getTipoServico($servico);
            echo $servicoTipo;
            echo $dadosContrato['TIPO'];

            if ($servicoTipo == $dadosContrato['TIPO']) {

            }
        }
    }

    function UpdateContrato($id, $academia, $servico, $vencimento)
    {
        $funcao = new ClassFuncoes();
        $data = date("Y-m-d H:i:s");
        $sql = "UPDATE contrato Set ID_ACADEMIA=" . $academia . ",ID_SERVICO=" . $servico . ",DATA_VENC='" . $vencimento . "', ATUALIZACAO='" . $data . "' WHERE COD_CONTRATO=" . $id . "";

        $result = $this->conexao->query($sql);

        if (!$result) {
            if ($this->conexao->errno == 1062)
                $funcao->msg('info', 'Não foi possivel atualizar os dados! pois já possui cadastro nesta academia');

            if ($this->conexao->errno != 1062)
                $funcao->msg('info', $this->conexao->error);
        } else {
            $funcao->msg('ok', 'Atualizado com sussesso!');
        }
    }

    function AtivarContrato($id, $status)
    {
        $funcao = new ClassFuncoes();

        if ($status == 0)
            $status = 1;
        else
            $status = 0;

        $SQL = "UPDATE contrato Set status=" . $status . " WHERE cod_contrato=" . $id . "";
        $result = $this->conexao->query($SQL);
        if ($result) {
            $funcao->msg('ok', ' Status atualizado com sucesso!');
            echo "<meta http-equiv='refresh' content='1'>";
        } else {
            $funcao->msg('error', 'Não foi possivel mudar status!' . $this->conexao->error);
            echo "<meta http-equiv='refresh' content='2'>";
            //echo $SQL;
        }
    }

    function update_observacao($cod, $observacao)
    {
        $funcao = new ClassFuncoes();
        $SQL = "UPDATE contrato Set OBSERVACAO='" . $observacao . "' WHERE cod_contrato='" . $cod . "'";

        if ($this->conexao->query($SQL)) {
            $funcao->msg('ok', ' Observação!');
            //echo"<meta http-equiv='refresh' content='1'>";
        } else {
            $funcao->msg('error', $this->conexao->error);
            //echo"<meta http-equiv='refresh' content='2'>";
            //echo $SQL;
        }
    }

    function aceitarContrato($contrato)
    {
        $funcao = new ClassFuncoes();

        $SQL = "UPDATE contrato SET DATA_ACEITE='" . date('Y-m-d H:i:s') . "',IP='" . $_SERVER['REMOTE_ADDR'] . "',ACEITO=1 WHERE COD_CONTRATO='" . $contrato . "'";

        if ($this->conexao->query($SQL)) {
            $funcao->msg('ok', 'Aceite gerao com suscesso!');
            //echo"<meta http-equiv='refresh' content='1'>";
        } else {
            $funcao->msg('error', $this->conexao->error);
            //echo"<meta http-equiv='refresh' content='2'>";
            //echo $SQL;
        }
    }

}
