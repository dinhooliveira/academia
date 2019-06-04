<?php

class ClassAluno extends ClassConfiguracao
{

    function CadastrarAluno($nome, $nascimento, $cep, $logradouro, $numero, $complemento, $bairro, $cidade, $uf, $inscricao, $cpf, $rg, $email, $celular, $foto = null)
    {

        $funcao = new ClassFuncoes();
        $classUpload = new ClassUpload();
        if ($foto != null) $foto = $classUpload->construtor($foto, 1000, 800, "view/upload/");

        if ($nome == "") {
            $funcao->msg('error', 'Nome é Obrigatório');
        } else if (!$funcao->validCPF($cpf)) {
            $funcao->msg('error', 'CPF é Inválido');
        } else if ($email == "") {
            $funcao->msg('error', 'E-mail é Inválido');
        } else if (strlen($cep) != 8) {
            $funcao->msg('error', 'CEP Inválido verifique se foi digitado corretamente e tem  8 dígitos');
        } else if ($logradouro == "" || $bairro == "" || $cidade == "" || $uf == "") {
            $funcao->msg('error', 'Consulte o CEP para preenchimento dos dados de endereço');
        } else {

            $sql = "INSERT INTO aluno( nome,data_nasc,cep,logradouro,numero,complemento,bairro,cidade,uf,data_inscr,cpf,rg,email,celular,foto) VALUES ('" . addslashes($nome) . "','" . $nascimento . "','" . $cep . "','" . addslashes($logradouro) . "','" . $numero . "','" . $complemento . "','" . $bairro . "','" . $cidade . "','" . $uf . "','" . $inscricao . "','" . $cpf . "','" . $rg . "','" . $email . "','" . $celular . "','" . $foto . "')";
            $result = $this->conexao->query($sql);

            if (!$result) {
                if ($this->conexao->errno == 1062) {
                    $funcao->msg('info', 'CPF já possui cadastro');
                    if ($foto != FALSE) unlink("view/upload/" . $foto);
                } else {
                    $funcao->msg('info', $this->conexao->error);
                }
            } else {
                //$funcao->lead($nome, $email, $nascimento, $celular);
                $funcao->msg('ok', 'Cadastrado com sussesso');
            }
        }
    }

    function CadastrarDependente($nome, $nascimento, $inscricao, $responsavel, $foto = null)
    {

        $funcao = new ClassFuncoes();
        $classUpload = new ClassUpload();
        if ($foto != null) $foto = $classUpload->construtor($foto, 1000, 800, "view/upload/");

        if ($nome == "") {
            $funcao->msg('error', 'Nome é Obrigatório');
        } else {

            $sql = "INSERT INTO dependente(nome,nascimento,inscricao,id_aluno,foto) VALUES ('" . addslashes($nome) . "','" . $nascimento . "','" . $inscricao . "'," . $responsavel . ",'" . $foto . "')";
            $result = $this->conexao->query($sql);

            if (!$result) {
                if ($this->conexao->errno == 1062) {
                    $funcao->msg('info', 'CPF já possui cadastro');
                    if ($foto != FALSE) unlink("view/upload/" . $foto);
                } else {
                    $funcao->msg('info', $this->conexao->error);
                }
            } else {
                //$funcao->lead($nome, $email, $nascimento, $celular);
                $funcao->msg('ok', 'Cadastrado com sussesso');
            }
        }
    }

    function ListarAluno($pagina, $consulta,$urlParam)
    {
        $funcao = new ClassFuncoes();

        $porPagina = 5;
        $offset = (($pagina - 1) * $porPagina);
        $limit = $porPagina;

        $SQL = "SELECT SQL_CALC_FOUND_ROWS * FROM aluno WHERE (NOME LIKE '%" . $consulta . "%' or CPF LIKE '%" . $consulta . "%' OR LOGRADOURO LIKE '%" . $consulta . "%' OR CIDADE LIKE '%" . $consulta . "%' OR BAIRRO LIKE '%" . $consulta . "%' or UF LIKE '%" . $consulta . "%') LIMIT " . $limit . "  OFFSET " .$offset ;
        $result = $this->conexao->query($SQL);
        if (!$result) {
            $funcao->msg('error', $this->conexao->error);
        } else {

            $resultCountRow = $this->conexao->query("SELECT FOUND_ROWS() AS `found_rows`;");
            $total = $resultCountRow->fetch_assoc()["found_rows"];
            $totalPaginas = ceil($total / $porPagina);
            while ($row = $result->fetch_assoc()) {
                echo "<form method='post'>";

                echo "<ul class='list-group'>"
                    . "<li style='padding:5px;list-style-type:none;'>"
                    . "<img  style='border:4px #337ab7 solid;' width='150'  src='";
                if ($row['foto'] != "")
                    echo "{$this->URL}/public/upload/" . $row['foto'];
                else
                    echo "{$this->URL}/public/upload/semfoto.png";
                echo "' alt='...'>";
                echo "</li>";
                echo "<li href='#' class='list-group-item'><b>NOME:</b> " . $row['NOME'] . "</li>";
                echo "<li href='#' class='list-group-item'><b>CPF:</b> " . $row['CPF'] . "</li>";
                echo "<li href='#' class='list-group-item'><b>RG:</b> " . $row['RG'] . "</li>";
                $date = date_create($row['DATA_NASC']);
                echo "<li href='#' class='list-group-item'><b>NASCIMENTO : </b> " . date_format($date, 'd-m-Y');
                $date = date_create($row['DATA_INSCR']);
                echo " <b>DATA INSCRIÇÃO : </b>" . date_format($date, 'd-m-Y') . "</a>";
                echo "<li href='#' class='list-group-item'><b>CEP:</b> " . $row['CEP'];
                echo " <b>LOGRADOURO:</b> " . $row['LOGRADOURO'];
                echo " <b>NUMERO:</b> " . $row['NUMERO'];
                echo " <b>COMPLEMENTO:</b> " . $row['COMPLEMENTO'];
                echo " <b>BAIRRO:</b> " . $row['BAIRRO'];
                echo " <b>CIDADE:</b> " . $row['CIDADE'];
                echo " <b>UF:</b> " . $row['UF'] . "</a>";
                echo "<li class='list-group-item '>";
                echo "<a href='?pagina=atualizar-aluno&id=" . $row['ID_ALUNO'] . "' style='margin: 2px'  class='btn btn-primary margem_botao'>Editar</a>";
                echo "<a href='?pagina=cadastrar-contrato&id=" . $row['ID_ALUNO'] . "' style='margin: 2px'  class='btn btn-success'>Gerar contrato</a>";
                echo "<a href='?pagina=cadastrar-dependente&id={$row['ID_ALUNO']}' style='margin: 2px'  class='btn btn-success glyphicon glyphicon-plus'> Dependente</a>";
                echo "<a href='?pagina=ver-dependente&id={$row['ID_ALUNO']}' style='margin: 2px'  class='btn btn-success glyphicon glyphicon-eye-open'> Dependente</a>";
                echo "</li>";
                echo "</ul></form>";
            }

            $this->paginacao($pagina, $totalPaginas, $urlParam, $consulta);


        }
    }

    function dependentes($id = null)
    {
        $SQL = "SELECT * FROM dependente WHERE ID_ALUNO=" . $id . "";

        $result = $this->conexao->query($SQL);
        if ($result)
            return $result;
        else
            echo msg('error', $this->conexao->error);
        return false;
    }

    function ListarDependente($pagina, $consulta, $id)
    {
        $funcao = new ClassFuncoes();

        $SQL = "SELECT * FROM dependente where(NOME LIKE '%" . $consulta . "%') AND id_aluno={$id}";

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
            $SQL = "SELECT * FROM dependente where (NOME LIKE '%" . $consulta . "%') AND id_aluno={$id} limit " . $inicio . "," . $registros . "";
            $result = $this->conexao->query($SQL);
            if (!$result)
                $funcao->msg('error', $this->conexao->error);
            else
                $total = $result->num_rows;


            while ($row = $result->fetch_assoc()) { /* var_dump($row); */
                echo "<form method='post'>";

                echo "<div class='list-group'>"
                    . "<a href='#' class='list-group-item active'>"
                    . "<img style='width:10%; hight:10%; border-radius:50px;'  src='";
                if ($row['foto'] != "")
                    echo $this->URL."/public/upload/" . $row['foto'];
                else
                    echo $this->URL."/public/upload/semfoto.png";
                echo "' alt='...'>";
                echo "   <b style='font-size:200%'> " . $row['nome'] . "</b></a>";
                $date = date_create($row['nascimento']);
                echo "<a href='#' class='list-group-item'><b>NASCIMENTO : </b> " . date_format($date, 'd-m-Y');
                $date = date_create($row['inscricao']);
                echo " <b>DATA INSCRIÇÃO : </b>" . date_format($date, 'd-m-Y') . "</a>";
                echo "</div></form>";
            }


            echo "<nav aria-label='Page navigation'>";
            echo "<ul class='pagination'>";

            //exibe a paginação
            for ($i = 1; $i < $numPaginas + 1; $i++) {

                if ($i == $pagina)
                    echo "<li class='active'><a href='?pagina=ver-dependente&p={$i}&id={$id}'>" . $i . "</li></a> ";
                else
                    echo "<li><a href='?pagina=ver-dependente&p={$i}&id={$id}'>" . $i . "</li></a> ";
            }


            echo "</ul>";
            echo "</nav>";
        }
    }

    function GetAluno($id)
    {
        $SQL = "SELECT * FROM aluno WHERE ID_ALUNO=" . $id . "";

        $result = $this->conexao->query($SQL);
        if ($result)
            return $result->fetch_assoc();
        else
            echo msg('error', $this->conexao->error);
    }

    function AtualizarAluno($id, $nome, $nascimento, $cep, $logradouro, $numero, $complemento, $bairro, $cidade, $uf, $inscricao, $cpf, $rg, $email, $celular, $foto = null, $foto_antiga = null)
    {

        $funcao = new ClassFuncoes();
        $classUpload = new ClassUpload();
        if ($foto != null) $foto = $classUpload->construtor($foto, 1000, 800, "view/upload/");

        if ($nome == "") {
            $funcao->msg('error', 'Nome é Obrigatório');
        } else if (!$funcao->validCPF($cpf)) {
            $funcao->msg('error', 'CPF é Inválido');
        } else if ($email == "") {
            $funcao->msg('error', 'E-mail é Inválido');
        } else if (strlen($cep) != 8) {
            $funcao->msg('error', 'CEP Inválido verifique se foi digitado corretamente e tem  8 dígitos');
        } else if ($logradouro == "" || $bairro == "" || $cidade == "" || $uf == "") {
            $funcao->msg('error', 'Consulte o CEP para preenchimento dos dados de endereço');
        } else {

            if ($foto == null) {
                $sql = "UPDATE aluno "
                    . " Set nome='" . $nome
                    . "',data_nasc='" . $nascimento
                    . "',cep='" . $cep
                    . "',logradouro='" . $logradouro
                    . "',numero=" . $numero
                    . ",complemento='" . $complemento
                    . "',bairro='" . $bairro
                    . "',cidade='" . $cidade
                    . "',uf='" . $uf
                    . "',data_inscr='" . $inscricao
                    . "',cpf='" . $cpf
                    . "',rg='" . $rg
                    . "',email='" . $email
                    . "',celular='" . $celular
                    . "' WHERE ID_ALUNO=" . $id . "";


            } else {
                $sql = "UPDATE aluno "
                    . "SET nome='" . $nome
                    . "',data_nasc='" . $nascimento
                    . "',cep='" . $cep
                    . "',logradouro='" . $logradouro
                    . "',numero=" . $numero
                    . ",complemento='" . $complemento
                    . "',bairro='" . $bairro
                    . "',cidade='" . $cidade
                    . "',uf='" . $uf
                    . "',data_inscr='" . $inscricao
                    . "',cpf='" . $cpf
                    . "',rg='" . $rg
                    . "',email='" . $email
                    . "',celular='" . $celular
                    . "',foto='" . $foto
                    . "' WHERE ID_ALUNO=" . $id . "";
            }
            $result = $this->conexao->query($sql);

            if (!$result) {
                if ($foto != FALSE) unlink("view/upload/" . $foto);
                $funcao->msg('error', 'Não foi possivel atualizar os dados!');
            } else {
                if ($foto_antiga != null) unlink("view/upload/" . $foto_antiga);
                $funcao->msg('ok', 'Atualizado com sussesso!');
            }
        }
    }


}
