<?php
namespace Model;
use \Model\Funcoes;

class Aulas extends \Model\Configuracao {

    function insert_Aulas($cod, $seg, $ter, $qua, $qui, $sex, $sab, $horario) {
        $ClassFuncao = new Funcoes();
        
        $SQL = "INSERT INTO aula(cod_contrato, seg, ter, qua, qui, sex, sab, horario) values ('" . $cod . "'," . $seg . "," . $ter . "," . $qua . "," . $qui . "," . $sex . "," . $sab . ",'" . $horario . "')";
        if ($this->conexao->query($SQL))
            $ClassFuncao->msg('ok', 'Aula Salva');
        else {
            $ClassFuncao->msg('error', $this->conexao->error);
        }
    }

    function update_Aulas($cod, $seg, $ter, $qua, $qui, $sex, $sab, $horario) {
        $ClassFuncao = new Funcoes();
        $total = $this->return_Aulas($cod);
        if ($total == NULL) {
            $this->insert_Aulas($cod, $seg, $ter, $qua, $qui, $sex, $sab, $horario);
        } else {


            $SQL = "UPDATE  aula set  seg='" . $seg . "', ter='" . $ter . "', qua='" . $qua . "', qui='" . $qui . "', sex='" . $sex . "', sab='" . $sab . "', horario='" . $horario . "' where cod_contrato='" . $cod . "' ";
            if ($this->conexao->query($SQL))
                $ClassFuncao->msg('ok', 'Aula Atualizada');
            else {
                $ClassFuncao->msg('error', $this->conexao->error);
            }
        }
    }

    function return_Aulas($cod) {
        $ClassFuncao = new Funcoes();
        $SQL = "SELECT * FROM aula WHERE cod_contrato='" . $cod . "'";
        if ($result = $this->conexao->query($SQL)) {
            return $result->fetch_assoc();
        } else
            $ClassFuncao->msg('error', $this->conexao->error);
    }

}
