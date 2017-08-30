<?php

class ClassAluno extends ClassConexao {

    function CadastrarAluno($nome, $nascimento, $cep, $logradouro, $numero, $complemento, $bairro, $cidade, $uf, $inscricao, $cpf, $rg, $email, $celular,$foto=null) {

        $funcao = new ClassFuncoes();
        $classUpload = new ClassUpload();
        if($foto!=null) $foto = $classUpload->construtor($foto, 1000,800, "view/upload/");
      
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
            
            $sql = "INSERT INTO aluno( nome,data_nasc,cep,logradouro,numero,complemento,bairro,cidade,uf,data_inscr,cpf,rg,email,celular,foto) VALUES ('" . addslashes($nome) . "','" . $nascimento . "','" . $cep . "','" . addslashes($logradouro) . "','" . $numero . "','" . $complemento . "','" . $bairro . "','" . $cidade . "','" . $uf . "','" . $inscricao . "','" . $cpf . "','" . $rg . "','" . $email . "','" . $celular . "','".$foto."')";
            $result = $this->conexao->query($sql);

            if (!$result) {
                if ($this->conexao->errno == 1062)
                {
                    $funcao->msg('info', 'CPF já possui cadastro');
                   if($foto!=FALSE) unlink("view/upload/".$foto);
                }else{
                     $funcao->msg('info', $this->conexao->error);
                }
            }
            else {
                //$funcao->lead($nome, $email, $nascimento, $celular);
                $funcao->msg('ok', 'Cadastrado com sussesso');
            }
        }
    }
    
    function ListarAluno($pagina, $consulta) {
        $funcao = new ClassFuncoes();
        
        $SQL = "SELECT * FROM aluno where(NOME LIKE '%" . $consulta . "%' or CPF LIKE '%" . $consulta . "%' or LOGRADOURO LIKE '%" . $consulta . "%' or CIDADE LIKE '%" . $consulta . "%' or BAIRRO LIKE '%" . $consulta . "%' or UF LIKE '%" . $consulta . "%')";

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
            $SQL = "SELECT * FROM aluno where (NOME LIKE '%" . $consulta . "%' or CPF LIKE '%" . $consulta . "%' or LOGRADOURO LIKE '%" . $consulta . "%' or CIDADE LIKE '%" . $consulta . "%' or BAIRRO LIKE '%" . $consulta . "%' or UF LIKE '%" . $consulta . "%') limit " . $inicio . "," . $registros . "";
            $result = $this->conexao->query($SQL);
            if (!$result)
                $funcao->msg('error', $this->conexao->error);
            else
                $total = $result->num_rows;





            while ($row = $result->fetch_assoc()) { /* var_dump($row); */
                echo"<form method='post'>";
                
                echo"<div class='list-group'>"
                . "<a href='#' class='list-group-item active'>"
                ."<img style='width:10%; hight:10%; border-radius:50px;'  src='";
                if($row['foto']!="") 
                    echo"view/upload/".$row['foto']; 
                else 
                    echo"view/upload/semfoto.png" ;
                echo"' alt='...'>";
                echo"   <b style='font-size:200%'> " . $row['NOME'] . "</b></a>";
                echo"<a href='#' class='list-group-item'><b>CPF:</b> " . $row['CPF'] . "</a>";
                echo"<a href='#' class='list-group-item'><b>RG:</b> " . $row['RG'] . "</a>";
                $date = date_create($row['DATA_NASC']);
                echo"<a href='#' class='list-group-item'><b>NASCIMENTO : </b> " . date_format($date, 'd-m-Y');
                $date = date_create($row['DATA_INSCR']);
                echo" <b>DATA INSCRIÇÃO : </b>" . date_format($date, 'd-m-Y') . "</a>";
                echo"<a href='#' class='list-group-item'><b>CEP:</b> " . $row['CEP'];
                echo" <b>LOGRADOURO:</b> " . $row['LOGRADOURO'];
                echo" <b>NUMERO:</b> " . $row['NUMERO'];
                echo" <b>COMPLEMENTO:</b> " . $row['COMPLEMENTO'];
                echo" <b>BAIRRO:</b> " . $row['BAIRRO'];
                echo" <b>CIDADE:</b> " . $row['CIDADE'];
                echo" <b>UF:</b> " . $row['UF'] . "</a>";


                echo "<a href='?pagina=atualizar-aluno&id=" . $row['ID_ALUNO'] . "' class='btn btn-primary'>Editar</a>";
                echo "<a href='?pagina=cadastrar-contrato&id=" . $row['ID_ALUNO'] . "' class='btn btn-success'>Gerar contrato"
                . "</a>";

                echo"</div></form>";
            }



            echo"<nav aria-label='Page navigation'>";
            echo"<ul class='pagination'>";

            //exibe a paginação
            for ($i = 1; $i < $numPaginas + 1; $i++) {

                if ($i == $pagina)
                    echo "<li class='active'><a href='?pagina=consultar-aluno&p=$i'>" . $i . "</li></a> ";
                else
                    echo "<li><a href='?pagina=consultar-aluno&p=$i'>" . $i . "</li></a> ";
            }




            echo"</ul>";
            echo"</nav>";
        }
    }

    function GetAluno($id) {
        $SQL = "SELECT * FROM aluno WHERE ID_ALUNO=" . $id . "";

        $result = $this->conexao->query($SQL);
        if ($result)
            return $result->fetch_assoc();
        else
            echo msg('error', $this->conexao->error);
    }

    function AtualizarAluno($id, $nome, $nascimento, $cep, $logradouro, $numero, $complemento, $bairro, $cidade, $uf, $inscricao, $cpf, $rg, $email, $celular,$foto=null,$foto_antiga=null) {

        $funcao = new ClassFuncoes();
        $classUpload = new ClassUpload();
        if($foto!=null) $foto = $classUpload->construtor($foto, 1000,800, "view/upload/");
        
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
         
           if($foto==null){
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
            
            
           }else{
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
                if($foto!=FALSE) unlink("view/upload/".$foto);
                $funcao->msg('error', 'Não foi possivel atualizar os dados!');
            } else {
                if($foto_antiga!=null) unlink("view/upload/".$foto_antiga);
                $funcao->msg('ok', 'Atualizado com sussesso!');
            }
        }
    }

}
