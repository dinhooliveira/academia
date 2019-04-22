<?php
/**
 * Description of ClassEmail
 *
 * @author oliveira
 */
class ClassEmail {

    function emailContrato($contrato) {

        $ClassContrato = new ClassContrato();
        $email = $ClassContrato->get_Aluno($contrato);

        $dominio = $_SERVER['SERVER_NAME'];

        $message = "<a href='" . $dominio . "/academia/?pagina=contrato-aluno&cod_contrato=" . $contrato . "' target_blank=''>Termo</a>";

        $to = $email['EMAIL'];
        $subject = "Termo de Responsabilidade";

        $msg = "Para visualizar seu contrato clique no link <br>";
        $msg .= $message;

        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // More headers
        $headers .= 'From: <oliveiracienciacomputacao@gmail.com>' . "\r\n";
        $headers .= 'Cc: backup@publisherdigital.com.br' . "\r\n";



        $f = "-f";
        $returnpath = "oliveira@publisherdigital.com.br";

        $result = mail($to, $subject, $msg, $headers);



        if (!$result) {

            echo "Falha ao enviar";
        } else {

            echo "<script>alert('Resultado Foi Enviado para seu " . $email['EMAIL'] . " com sucesso! ATENÇÃO CASO NÃO TENHA RECEBIDO, VERIFICAR LIXO ELETRONICO');</script>";
        }
    }

}
