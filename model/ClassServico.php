+<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClassSevico
 *
 * @author oliveira
 */
class ClassServico extends ClassConexao {
  
 
    function GetServico($id)
    {
        
         $funcao = new ClassFuncoes();
        $SQL = "SELECT * FROM servico WHERE ID_SERVICO=".$id."";
        
        $result = $this->conexao->query($SQL);
        
        if($result)
            return $result->fetch_assoc();
        else       
        $funcao->msg('error',$this->conexao->error);
            
    }
    
     function returnServico()
    {
        
         $funcao = new ClassFuncoes();
        $SQL = "SELECT * FROM servico";
        
        if($result = $this->conexao->query($SQL))
            return $result;
        else       
        $funcao->msg('error',$this->conexao->error);
            
    }
    
    function ListarServico($pagina,$consulta)
            {
              $funcao = new ClassFuncoes();
              
              $SQL ="SELECT * FROM servico where(TIPO LIKE '%".$consulta."%' or DESCRICAO LIKE '%".$consulta."%')";
              
              $result = $this->conexao->query($SQL);
              if(!$result)
              {
                 $this->conexao->error; 
              }
              else
              {    
                //conta o total de itens
                $total = $result->num_rows;
              
                //seta a quantidade de itens por página, neste caso, 2 itens
                $registros = 5;
                
                //calcula o número de páginas arredondando o resultado para cima
                $numPaginas = ceil($total/$registros);
                
                //variavel para calcular o início da visualização com base na página atual
                $inicio = ($registros*$pagina)-$registros;
                
                 //seleciona os itens por página
                $SQL ="SELECT * FROM servico where (TIPO LIKE '%".$consulta."%' or DESCRICAO LIKE '%".$consulta."%') limit ".$inicio.",".$registros."";
                $result = $this->conexao->query($SQL);
                if(!$result)
                   $funcao->msg('error',$this->conexao->error);
                 else
                $total = $result->num_rows;
              
              
                    
                     
                    
                     while($row = $result->fetch_assoc())
                     {     /*var_dump($row);*/
                         echo"<form method='post'>";
                         echo"<div class='list-group'><li href='#' class='list-group-item '><b>TIPO:</b> ".$row['TIPO']
                         ."<b>DESCRIÇÃO:</b> ".utf8_encode($row['DESCRICAO'])
                         ."<b>VALOR:</b> ".$row['VALOR']
                         ."   <a href='?pagina=atualizar-servico&id=".$row['ID_SERVICO']."' class='btn btn-primary'>Editar </a>  "."</li>"
                         ."</div>";
                         echo "<input type='hidden' name='id' value=".$row['ID_SERVICO']." />";
                         echo "<input type='hidden' name='status' value=".$row['STATUS']." />";
                         
                        /* if($row['STATUS']=='1')
                          echo "<input type='submit' name='bt_status' value='Ativo' class='btn btn-success' />";
                         else
                          echo "<input type='submit' name='bt_status' value='Desativado' class='btn btn-danger' />";  
                         echo"</div></form>";*/
                            
                     }
                    
                    
                     
            echo"<nav aria-label='Page navigation'>";
            echo"<ul class='pagination'>";
            
                      //exibe a paginação
                      for($i = 1; $i < $numPaginas + 1; $i++) 
                      {
                          
                           if($i==$pagina)
                               echo "<li class='active'><a href='?pagina=consultar-servico&p=$i'>".$i."</li></a> ";
                           else 
                               echo "<li><a href='?pagina=consultar-servico&p=$i'>".$i."</li></a> ";  
           
                       
                        }
           
            echo"</ul>";
            echo"</nav>";
                }               
        }
        
    function AtivarServicos($id,$status)
    {    $funcao = new ClassFuncoes();
        if($status==0)
             $status=1;
        else
           $status=0; 
        
        $SQL="UPDATE servico Set status=".$status." WHERE id_servico=".$id."";
        $result = $this->conexao->query($SQL);
        if($result)
        {   $funcao->msg ('ok',' Status atualizado com sucesso!');
            echo"<meta http-equiv='refresh' content='1'>";
        
        }
        else
        {
            $funcao->msg ('error','Não foi possivel mudar status!'.$this->conexao->error); 
            echo"<meta http-equiv='refresh' content='2'>";
            //echo $SQL;
        } 
    }
    
    function getTipoServico($id)
    {
        $funcao = new ClassFuncoes();
        $SQL = "SELECT * FROM servico WHERE ID_SERVICO=".$id."";
        
        $result = $this->conexao->query($SQL);
        
        if($result)
        {
         $dados = $result->fetch_assoc();
            return $dados["TIPO"];
        }
        else 
        {
           return false;
        }
    }
    
     function getValor($id)
    {
        $funcao = new ClassFuncoes();
        $SQL = "SELECT * FROM servico WHERE ID_SERVICO=".$id."";
        
        $result = $this->conexao->query($SQL);
        
        if($result)
        {
         $dados = $result->fetch_assoc();
            return $dados["VALOR"];
        }
        else 
        {
           return false;
        }
    }
    
    function updateValor($id,$valor)
    {
        $funcao = new ClassFuncoes();
        $SQL = "UPDATE servico set VALOR=".$valor." WHERE ID_SERVICO=".$id."";
        
         if($this->conexao->query($SQL))
         {
           $funcao->msg ('ok', 'Atualizado com sucesso');
           echo"<meta http-equiv='refresh' content='1'>";
         }
        else 
        {
          $funcao->msg ('error', 'Não foi possivel efetuar a atualização');
          $funcao->msg ('error', $this->conexao->error);
        }
        
    }
}
