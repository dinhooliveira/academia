<?php

/**
 * Description of ClassSevico
 *
 * @author oliveira
 */
class ClassServico extends ClassConfiguracao
{

    function GetServico($id)
    {

        $funcao = new ClassFuncoes();
        $SQL = "SELECT * FROM servico WHERE ID_SERVICO=" . $id;

        $result = $this->conexao->query($SQL);

        if ($result)
            return $result->fetch_assoc();
        else
            $funcao->msg('error', $this->conexao->error);
    }

    function returnServico()
    {

        $funcao = new ClassFuncoes();
        $SQL = "SELECT * FROM servico";

        if ($result = $this->conexao->query($SQL))
            return $result;
        else
            $funcao->msg('error', $this->conexao->error);
    }

    function ListarServico($pagina = 1, $consulta = "", $paramPag)
    {
        $funcao = new ClassFuncoes();
        $porPagina = 5;
        $offset = (($pagina - 1) * $porPagina);
        $limit = $porPagina;

        $SQL = "SELECT SQL_CALC_FOUND_ROWS * FROM servico where (TIPO LIKE '%" . $consulta . "%' or DESCRICAO LIKE '%" . $consulta . "%') LIMIT " . $limit . " OFFSET " . $offset;
        $result = $this->conexao->query($SQL);
        if (!$result) {
            $funcao->msg('error', $this->conexao->error);
        } else {

            $resultCountRow = $this->conexao->query("SELECT FOUND_ROWS() AS `found_rows`;");
            $total = $resultCountRow->fetch_assoc()["found_rows"];

            $totalPaginas = ceil($total / $porPagina);

            //$inicio = ($offset * $pagina) - $offset;

            while ($row = $result->fetch_assoc()) {
                echo "<form method='post'>";
                echo "<div class='list-group'>"
                    . " <a href=\"#\" class=\"list-group-item active\">#{$row['ID_SERVICO']} - {$row['TIPO']}</a>"
                    . "<li href='#' class='list-group-item '>"
                    . $row['DESCRICAO']
                    . "<b>   R$ :</b> " . number_format($row['VALOR'], 2, ',', '.')
                    . "</li>"
                    . "<li class='list-group-item '>"
                    . "   <a href='?pagina=atualizar-servico&id=" . $row['ID_SERVICO'] . "' class='btn btn-primary'>Editar </a>  ";
                if ($row['STATUS'] == '1')
                    echo "<input type='submit' name='bt_status' value='Ativo' class='btn btn-success' />";
                else
                    echo "<input type='submit' name='bt_status' value='Desativado' class='btn btn-danger' />";

                echo "</li>";
                echo "</div>";
                echo "</form>";
                echo "<input type='hidden' name='id' value=" . $row['ID_SERVICO'] . " />";
                echo "<input type='hidden' name='status' value=" . $row['STATUS'] . " />";


            }

            $this->paginacao($pagina, $totalPaginas, $paramPag, $consulta);


        }


    }

    function AtivarServicos($id, $status)
    {
        $funcao = new ClassFuncoes();
        if ($status == 0)
            $status = 1;
        else
            $status = 0;

        $SQL = "UPDATE servico Set status=" . $status . " WHERE id_servico=" . $id . "";
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

    function getTipoServico($id)
    {
        $funcao = new ClassFuncoes();
        $SQL = "SELECT * FROM servico WHERE ID_SERVICO=" . $id . "";

        $result = $this->conexao->query($SQL);

        if ($result) {
            $dados = $result->fetch_assoc();
            return $dados["TIPO"];
        } else {
            return false;
        }
    }

    function getValor($id)
    {
        $funcao = new ClassFuncoes();
        $SQL = "SELECT * FROM servico WHERE ID_SERVICO=" . $id . "";

        $result = $this->conexao->query($SQL);

        if ($result) {
            $dados = $result->fetch_assoc();
            return $dados["VALOR"];
        } else {
            return false;
        }
    }

    function updateValor($id, $valor)
    {
        $funcao = new ClassFuncoes();
        $SQL = "UPDATE servico set VALOR=" . $valor . " WHERE ID_SERVICO=" . $id . "";

        if ($this->conexao->query($SQL)) {
            $funcao->msg('ok', 'Atualizado com sucesso');
            echo "<meta http-equiv='refresh' content='1'>";
        } else {
            $funcao->msg('error', 'Não foi possivel efetuar a atualização');
            $funcao->msg('error', $this->conexao->error);
        }
    }


}
