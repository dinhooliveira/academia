<?php

class ClassAcademia extends ClassConfiguracao
{

    function CadastrarAcademia($nome, $cep, $logradouro, $numero, $complemento, $bairro, $cidade, $uf)
    {

        $funcao = new ClassFuncoes();
        if ($nome == "") {
            $funcao->msg('error', 'Nome é Obrigatório');
        } else if (strlen($cep) != 8) {
            $funcao->msg('error', 'CEP Inválido verifique se foi digitado corretamente e tem  8 dígitos');
        } else if ($logradouro == "" || $bairro == "" || $cidade == "" || $uf == "") {
            $funcao->msg('error', 'Consulte o CEP para preenchimento dos dados de endereço');
        } else {

            $sql = "INSERT INTO academia( nome,cep,logradouro,numero,complemento,bairro,cidade,uf,status) VALUES ('" . $nome . "','" . $cep . "','" . $logradouro . "','" . $numero . "','" . $complemento . "','" . $bairro . "','" . $cidade . "','" . $uf . "',1)";

            $result = $this->conexao->query($sql);

            if (!$result) {
                if ($this->conexao->errno == 1062)
                    $funcao->msg('info', 'Nome da academia já possui cadastro');
                if ($this->conexao->errno != 1062)
                    $funcao->msg('info', $this->conexao->error);
            } else {
                $funcao->msg('ok', 'Cadastrado com sussesso');
            }
        }
    }

    function ListarAcademia($pagina, $consulta,$urlParam)
    {
        $funcao = new ClassFuncoes();

        $porPagina = 5;
        $offset = (($pagina - 1) * $porPagina);
        $limit = $porPagina;

        $SQL = "SELECT * FROM academia where (NOME LIKE '%" . $consulta . "%' or LOGRADOURO LIKE '%" . $consulta . "%' or CIDADE LIKE '%" . $consulta . "%' or BAIRRO LIKE '%" . $consulta . "%' or UF LIKE '%" . $consulta . "%') LIMIT " . $limit . " OFFSET " . $offset;
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
                echo "<li href='#' class='list-group-item active'><b>Nome:</b> " . $row['NOME'] . "</li>";
                echo "<li href='#' class='list-group-item'><b>CEP:</b> " . $row['CEP'];
                echo " <b>LOGRADOURO:</b> " . $row['LOGRADOURO'];
                echo " <b>NUMERO:</b> " . $row['NUMERO'];
                echo " <b>COMPLEMENTO:</b> " . $row['COMPLEMENTO'];
                echo " <b>BAIRRO:</b> " . $row['BAIRRO'];
                echo " <b>CIDADE:</b> " . $row['CIDADE'];
                echo " <b>UF:</b> " . $row['UF'] . "</li>";

                echo "<li href='#' class='list-group-item'>";
                echo "<a href='?pagina=atualizar-academia&id=" . $row['ID_ACADEMIA'] . "' style='margin: 2px' class='btn btn-primary'>Editar</a>";
                echo "<input type='hidden' name='id' value=" . $row['ID_ACADEMIA'] . " />";
                echo "<input type='hidden' name='status' value=" . $row['STATUS'] . " />";

                if ($row['STATUS'] == '1')
                    echo "<input type='submit' name='bt_status' value='Ativo' style='margin: 2px' class='btn btn-success' />";
                else
                    echo "<input type='submit' name='bt_status' value='Desativado' style='margin: 2px' class='btn btn-danger' />";

                echo "</li>";
                echo "</ul></form>";
            }

            $this->paginacao($pagina, $totalPaginas, $urlParam, $consulta);
        }
    }

    function GetAcademia($id)
    {
        $funcao = new ClassFuncoes();
        $SQL = "SELECT * FROM academia WHERE ID_ACADEMIA=" . $id . "";

        $result = $this->conexao->query($SQL);
        if ($result)
            return $result->fetch_assoc();
        else
            $funcao->msg('error', $this->conexao->error);
    }

    function retun_Academia()
    {
        $funcao = new ClassFuncoes();
        $SQL = "SELECT * FROM academia ";

        $result = $this->conexao->query($SQL);
        if ($result)
            return $result;
        else
            $funcao->msg('error', $this->conexao->error);
    }

    function AtualizarAcademia($id, $nome, $cep, $logradouro, $numero, $complemento, $bairro, $cidade, $uf)
    {

        $funcao = new ClassFuncoes();
        if ($nome == "") {
            $funcao->msg('error', 'Nome é Obrigatório');
        } else if (strlen($cep) != 8) {
            $funcao->msg('error', 'CEP Inválido verifique se foi digitado corretamente e tem  8 dígitos');
        } else if ($logradouro == "" || $bairro == "" || $cidade == "" || $uf == "") {
            $funcao->msg('error', 'Consulte o CEP para preenchimento dos dados de endereço');
        } else {

            $sql = "UPDATE academia Set nome='" . $nome . "',logradouro='" . $logradouro . "',numero=" . $numero . ",complemento='" . $complemento . "',bairro='" . $bairro . "',cidade='" . $cidade . "',uf='" . $uf . "' WHERE ID_ACADEMIA=" . $id . "";

            $result = $this->conexao->query($sql);

            if (!$result) {

                $funcao->msg('error', 'Não foi possivel atualizar os dados!');
            } else {
                $funcao->msg('ok', 'Atualizado com sussesso!');
            }
        }
    }

    function AtivarAcademia($id, $status)
    {
        $funcao = new ClassFuncoes();
        if ($status == 0)
            $status = 1;
        else
            $status = 0;

        $SQL = "UPDATE academia Set status=" . $status . " WHERE id_academia=" . $id . "";
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

}
