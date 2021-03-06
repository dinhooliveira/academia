<?php
namespace Model;

class Login extends \Model\Configuracao {

    function login($login, $senha) {

        $funcao = new \Model\Funcoes();

        $login = addslashes($login);
        $SQL = "SELECT * FROM login WHERE cpf='" . $login . "' or email='" . $login . "'";
        $result = $this->conexao->query($SQL);

        if (!$result) {
            $funcao->msg('erro', 'Ocorreu um erro ao realizar a conexão com o banco de dados!');
        } else {

            $count = $result->num_rows;
            if ($count <= 0) {
                $funcao->msg('error', 'CPF ou E-mail não está cadastrado em nosso sistema!');
            } else {

                $dados = $result->fetch_assoc();

                if ($senha != $dados['SENHA']) {
                    $funcao->msg('error', 'Senha inválida!');
                } else {

                    $this->session($dados['NOME']);
                    $consulta = new \Model\Consulta();

                    echo"<script>location.href='?pagina=admin'</script>";
                }
            }
        }
    }

    function session($nome) {
        if (!isset($_SESSION))
            session_start();

        $_SESSION['nome'] = $nome;
        $_SESSION['seguranca'] = 'Admin12345**####**bc';
    }

    function seguranca() {
        if (!isset($_SESSION))
            session_start();

        if (!isset($_SESSION) || $_SESSION['seguranca'] != 'Admin12345**####**bc')
            echo"<script>location.href='?pagina=login'</script>";
    }

    function LogOut() {
        session_destroy();
        echo"<script>location.href='?pagina=login'</script>";
    }

}
