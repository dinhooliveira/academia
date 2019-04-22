<?php


class ClassConexao
{

    public $host = "localhost";
    public $usuario = "root";
    public $senha = "";
    public $banco = "academia";
    public $conexao;

    function ClassConexao()
    {
        $this->conexao = mysqli_connect($this->host, $this->usuario, $this->senha, $this->banco) or die(mysqli_error());
        $this->conexao->set_charset("utf8");
    }


}
