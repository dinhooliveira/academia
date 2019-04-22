<?php

class ClassRota
{

    public function Paginacao()
    {

        $login = new ClassLogin();

        if (isset($_GET["pagina"])) {
            $pagina = $_GET["pagina"]; //se existir um url pagina o valor sera recebido
        } else {
            $pagina = "0"; //se não existir receberá 0 como padrao
        }

        switch ($pagina) {

            case "login":
                include("view/login/login.php");
                break;

            case"admin":
                $login->seguranca();
                include("view/admin/header.php");
                include("view/admin/menu.php");
                include("view/admin/dashboard/consultar_valores.php");
                include("view/admin/footer.php");
                break;

            case"alunos-em-dia":
                $login->seguranca();
                include("view/admin/header.php");
                include("view/admin/menu.php");
                include("view/admin/dashboard/consultar_em_dia.php");
                include("view/admin/footer.php");
                break;

            case"alunos-a-vencer":
                $login->seguranca();
                include("view/admin/header.php");
                include("view/admin/menu.php");
                include("view/admin/dashboard/consultar_em_vencer.php");
                include("view/admin/footer.php");
                break;

            case"alunos-em-atraso":
                $login->seguranca();
                include("view/admin/header.php");
                include("view/admin/menu.php");
                include("view/admin/dashboard/consultar_em_atraso.php");
                include("view/admin/footer.php");
                break;

            case"cadastrar-aluno":
                $login->seguranca();
                include("view/admin/header.php");
                include("view/admin/menu.php");
                include("view/admin/aluno/cadastrar_aluno.php");
                include("view/admin/footer.php");

                break;

            case"cadastrar-dependente":
                $login->seguranca();
                include("view/admin/header.php");
                include("view/admin/menu.php");
                include("view/admin/cadastrar_dependente.php");
                include("view/admin/footer.php");

                break;

            case"ver-dependente":
                $login->seguranca();
                include("view/admin/header.php");
                include("view/admin/menu.php");
                include("view/admin/consultar_depedente.php");
                include("view/admin/footer.php");
                break;

            case"consultar-aluno":
                $login->seguranca();
                include("view/admin/header.php");
                include("view/admin/menu.php");
                include("view/admin/aluno/consultar_aluno.php");
                include("view/admin/footer.php");
                break;

            case"atualizar-aluno":
                $login->seguranca();
                include("view/admin/header.php");
                include("view/admin/menu.php");
                include("view/admin/aluno/atualizar_aluno.php");
                include("view/admin/footer.php");
                break;
            case"consultar-servico":
                $login->seguranca();
                include("view/admin/header.php");
                include("view/admin/menu.php");
                include("view/admin/servico/consultar_servico.php");
                include("view/admin/footer.php");
                break;

            case"atualizar-servico":
                $login->seguranca();
                include("view/admin/header.php");
                include("view/admin/menu.php");
                include("view/admin/servico/atualizar_servico.php");
                include("view/admin/footer.php");
                break;

            case"consultar-academia":
                $login->seguranca();
                include("view/admin/header.php");
                include("view/admin/menu.php");
                include("view/admin/academia/consultar_academia.php");
                include("view/admin/footer.php");
                break;

            case"cadastrar-academia":
                $login->seguranca();
                include("view/admin/header.php");
                include("view/admin/menu.php");
                include("view/admin/academia/cadastrar_academia.php");
                include("view/admin/footer.php");

                break;

            case"atualizar-academia":
                $login->seguranca();
                include("view/admin/header.php");
                include("view/admin/menu.php");
                include("view/admin/academia/atualizar_academia.php");
                include("view/admin/footer.php");
                break;


            case"consultar-contrato":
                $login->seguranca();
                include("view/admin/header.php");
                include("view/admin/menu.php");
                include("view/admin/consultar_contrato.php");
                include("view/admin/footer.php");
                break;

            case"cadastrar-contrato":
                $login->seguranca();
                include("view/admin/header.php");
                include("view/admin/menu.php");
                include("view/admin/aluno/contrato/cadastrar_contrato.php");
                include("view/admin/footer.php");
                break;

            case"atualizar-contrato":
                $login->seguranca();
                include("view/admin/header.php");
                include("view/admin/menu.php");
                include("view/admin/atualizar_contrato.php");
                include("view/admin/footer.php");
                break;

            case"consultar-valores":
                $login->seguranca();
                include("view/admin/header.php");
                include("view/admin/menu.php");
                include("view/admin/consultar_valores.php");
                include("view/admin/footer.php");
                break;

            case"historico-pagamento":
                $login->seguranca();
                include("view/admin/header.php");
                include("view/admin/menu.php");
                include("view/admin/historico_pagamento.php");
                include("view/admin/footer.php");
                break;

            case"atualizar-data-aula":
                $login->seguranca();
                include("view/admin/header.php");
                include("view/admin/menu.php");
                include("view/admin/atualizar_data_aula.php");
                include("view/admin/footer.php");
                break;

            case"relatorio-academia":
                $login->seguranca();
                include("view/admin/header.php");
                include("view/admin/menu.php");
                include("view/admin/relatorio_academia.php");
                include("view/admin/footer.php");
                break;

            case"consultar-alunos":
                $login->seguranca();
                include("view/admin/header.php");
                include("view/admin/menu.php");
                include("view/admin/consultar_alunos.php");
                include("view/admin/footer.php");
                break;

            case"contrato-aluno":
                include("view/contrato/contrato_aluno.php");
                break;
            default:
                include("view/login/login.php");
                break;
        }
    }

}
