<?php

class ClassAcademia extends ClassConexao {

    function CadastrarAcademia($nome, $cep, $logradouro, $numero, $complemento, $bairro, $cidade, $uf) {

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
            }
            else {
                $funcao->msg('ok', 'Cadastrado com sussesso');
            }
        }
    }

    function ListarAcademia($pagina, $consulta) {
        $funcao = new ClassFuncoes();

        $SQL = "SELECT * FROM academia where(NOME LIKE '%" . $consulta . "%' or LOGRADOURO LIKE '%" . $consulta . "%' or CIDADE LIKE '%" . $consulta . "%' or BAIRRO LIKE '%" . $consulta . "%' or UF LIKE '%" . $consulta . "%')";

        $result = $this->conexao->query($SQL);
        if (!$result) {
            $this->conexao->error;
        } else {
            //conta o total de itens
            $total = $result->num_rows;

            //seta a quantidade de itens por página, neste caso, 2 itens
            $registros = 5;

            //calcula o número de páginas arredondando o resultado para cima
            $numPaginas = ceil($total / $registros);

            //variavel para calcular o início da visualização com base na página atual
            $inicio = ($registros * $pagina) - $registros;

            //seleciona os itens por página
            $SQL = "SELECT * FROM academia where (NOME LIKE '%" . $consulta . "%' or LOGRADOURO LIKE '%" . $consulta . "%' or CIDADE LIKE '%" . $consulta . "%' or BAIRRO LIKE '%" . $consulta . "%' or UF LIKE '%" . $consulta . "%') limit " . $inicio . "," . $registros . "";
            $result = $this->conexao->query($SQL);
            if (!$result)
                $funcao->msg('error', $this->conexao->error);
            else
                $total = $result->num_rows;





            while ($row = $result->fetch_assoc()) { /* var_dump($row); */
                echo"<form method='post'>";
                echo"<div class='list-group'><a href='#' class='list-group-item active'><b>Nome:</b> " . $row['NOME'] . "</a>";
                echo"<a href='#' class='list-group-item'><b>CEP:</b> " . $row['CEP'];
                echo" <b>LOGRADOURO:</b> " . $row['LOGRADOURO'];
                echo" <b>NUMERO:</b> " . $row['NUMERO'];
                echo" <b>COMPLEMENTO:</b> " . $row['COMPLEMENTO'];
                echo" <b>BAIRRO:</b> " . $row['BAIRRO'];
                echo" <b>CIDADE:</b> " . $row['CIDADE'];
                echo" <b>UF:</b> " . $row['UF'] . "</a>";


                echo "<a href='?pagina=atualizar-academia&id=" . $row['ID_ACADEMIA'] . "' class='btn btn-primary'>Editar</a>";
                echo "<input type='hidden' name='id' value=" . $row['ID_ACADEMIA'] . " />";
                echo "<input type='hidden' name='status' value=" . $row['STATUS'] . " />";

                if ($row['STATUS'] == '1')
                    echo "<input type='submit' name='bt_status' value='Ativo' class='btn btn-success' />";
                else
                    echo "<input type='submit' name='bt_status' value='Desativado' class='btn btn-danger' />";

                echo"</div></form>";
            }



            echo"<nav aria-label='Page navigation'>";
            echo"<ul class='pagination'>";

            //exibe a paginação
            for ($i = 1; $i < $numPaginas + 1; $i++) {

                if ($i == $pagina)
                    echo "<li class='active'><a href='?pagina=consultar-academia&p=$i'>" . $i . "</li></a> ";
                else
                    echo "<li><a href='?pagina=consultar-academia&p=$i'>" . $i . "</li></a> ";
            }




            echo"</ul>";
            echo"</nav>";
        }
    }

    function GetAcademia($id) {
        $funcao = new ClassFuncoes();
        $SQL = "SELECT * FROM academia WHERE ID_ACADEMIA=" . $id . "";

        $result = $this->conexao->query($SQL);
        if ($result)
            return $result->fetch_assoc();
        else
            $funcao->msg('error', $this->conexao->error);
    }

    function retun_Academia() {
        $funcao = new ClassFuncoes();
        $SQL = "SELECT * FROM academia ";

        $result = $this->conexao->query($SQL);
        if ($result)
            return $result;
        else
            $funcao->msg('error', $this->conexao->error);
    }

    function AtualizarAcademia($id, $nome, $cep, $logradouro, $numero, $complemento, $bairro, $cidade, $uf) {

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

    function AtivarAcademia($id, $status) {
        $funcao = new ClassFuncoes();
        if ($status == 0)
            $status = 1;
        else
            $status = 0;

        $SQL = "UPDATE academia Set status=" . $status . " WHERE id_academia=" . $id . "";
        $result = $this->conexao->query($SQL);
        if ($result) {
            $funcao->msg('ok', ' Status atualizado com sucesso!');
            echo"<meta http-equiv='refresh' content='1'>";
        } else {
            $funcao->msg('error', 'Não foi possivel mudar status!' . $this->conexao->error);
            echo"<meta http-equiv='refresh' content='2'>";
            //echo $SQL;
        }
    }

}
