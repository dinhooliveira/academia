<?php


class ClassConfiguracao
{

    public $host = "localhost";
    public $usuario = "root";
    public $senha = "";
    public $banco = "academia";
    public $conexao;
    public $URL;


    public function ClassConfiguracao()
    {
        $this->URL = ($_SERVER['HTTPS'] ? "https" : "http") . "://" . ($_SERVER['HTTP_HOST'] . "/academia");
        $this->conexao = mysqli_connect($this->host, $this->usuario, $this->senha, $this->banco) or die(mysqli_error());
        $this->conexao->set_charset("utf8");

    }


    function paginacao($pagina, $totalPaginas, $paramsPag, $paramSearch)
    {
        if ($totalPaginas > 0) {


            $maxLinks = 3;
            echo "<nav aria-label='Page navigation'>";
            echo "<ul class='pagination'>";

            echo "<li><a href='$this->URL?pagina=$paramsPag&p=1&search=$paramSearch' aria-label='Previous'><span aria-hidden='true'>Primeiro</span></a></li>";
            //exibe botão de anterior
            $anteriorPagina = ($pagina - 1);
            if ($pagina > 1)
                echo "<li><a href='$this->URL?pagina=$paramsPag&p=$anteriorPagina&search=$paramSearch' ><span aria-hidden='true'><<</span></a></li>";
            else
                echo "<li disabled='true'><a><span aria-hidden='true'><<</span></a></li>";


            //apresenta 3 items de pagina a esquerda
            for ($i = $pagina - $maxLinks; $i <= $pagina - 1; $i++) {

                if ($i > 0) {
                    echo "<li><a href='$this->URL?pagina=$paramsPag&p=$i&search=$paramSearch'>" . $i . "</li></a> ";
                }
            }

            echo "<li class='active'><a href='$this->URL?pagina=$paramsPag&p=$i&search=$paramSearch'>" . $i . "</li></a> ";

            //apresenta 3 items de pagina a direita
            for ($i = $pagina + 1; $i <= $pagina + $maxLinks; $i++) {
                if ($i > $pagina && $i < $totalPaginas + 1) {
                    echo "<li><a href='$this->URL?pagina=$paramsPag&p=$i&search=$paramSearch'>" . $i . "</li></a> ";
                }
            }

            //exibe botão de anterior
            $proximaPagina = ($pagina + 1);
            if ($proximaPagina <= $totalPaginas)
                echo "<li><a href='$this->URL?pagina=$paramsPag&p=$proximaPagina&search=$paramSearch' ><span aria-hidden='true'> >> </span></a></li>";
            else
                echo "<li disabled='true'><a ><span aria-hidden='true'> >> </span></a></li>";

            echo "<li><a href='$this->URL?pagina=$paramsPag&p=$totalPaginas&search=$paramSearch' aria-label='Next'><span aria-hidden='true'> Ultima</span></a></li>";


            echo "</ul>";
            echo "</nav>";

        }


    }


}
