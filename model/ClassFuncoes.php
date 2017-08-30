<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClassFuncoes
 *
 * @author oliveira
 */
class ClassFuncoes {

    function validCPF($cpf) {
        // determina um valor inicial para o digito $d1 e $d2
        // pra manter o respeito ;)
        $d1 = 0;
        $d2 = 0;
        // remove tudo que não seja número
        $cpf = preg_replace("/[^0-9]/", "", $cpf);
        // lista de cpf inválidos que serão ignorados
        $ignore_list = array(
            '00000000000',
            '01234567890',
            '11111111111',
            '22222222222',
            '33333333333',
            '44444444444',
            '55555555555',
            '66666666666',
            '77777777777',
            '88888888888',
            '99999999999'
        );
        // se o tamanho da string for dirente de 11 ou estiver
        // na lista de cpf ignorados já retorna false
        if (strlen($cpf) != 11 || in_array($cpf, $ignore_list)) {
            return false;
        } else {
            // inicia o processo para achar o primeiro
            // número verificador usando os primeiros 9 dígitos
            for ($i = 0; $i < 9; $i++) {
                // inicialmente $d1 vale zero e é somando.
                // O loop passa por todos os 9 dígitos iniciais
                $d1 += $cpf[$i] * (10 - $i);
            }
            // acha o resto da divisão da soma acima por 11
            $r1 = $d1 % 11;
            // se $r1 maior que 1 retorna 11 menos $r1 se não
            // retona o valor zero para $d1
            $d1 = ($r1 > 1) ? (11 - $r1) : 0;
            // inicia o processo para achar o segundo
            // número verificador usando os primeiros 9 dígitos
            for ($i = 0; $i < 9; $i++) {
                // inicialmente $d2 vale zero e é somando.
                // O loop passa por todos os 9 dígitos iniciais
                $d2 += $cpf[$i] * (11 - $i);
            }
            // $r2 será o resto da soma do cpf mais $d1 vezes 2
            // dividido por 11
            $r2 = ($d2 + ($d1 * 2)) % 11;
            // se $r2 mair que 1 retorna 11 menos $r2 se não
            // retorna o valor zeroa para $d2
            $d2 = ($r2 > 1) ? (11 - $r2) : 0;
            // retona true se os dois últimos dígitos do cpf
            // forem igual a concatenação de $d1 e $d2 e se não
            // deve retornar false.
            return (substr($cpf, -2) == $d1 . $d2) ? true : false;
        }
    }

    function buscacnpj($cnpj) {
        $url = "http://receitaws.com.br/v1/cnpj/$cnpj";
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    function TratarData($data) {
        if ($data == "" || is_null($data))
            return false;
        else
            $resultado = explode("-", $data);
        //$resultado =  explode("/",$data);
        if (strlen($resultado[2]) == 4) {
            $data = $resultado[2] . "-" . $resultado[1] . "-" . $resultado[0];
        } else {
            $data = $resultado[0] . "-" . $resultado[1] . "-" . $resultado[2];
        }

        return $data;
    }

    function validar_cnpj($cnpj) {
        $cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);
        // Valida tamanho
        if (strlen($cnpj) != 14)
            return false;
        // Valida primeiro dígito verificador
        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
            $soma += $cnpj{$i} * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
        $resto = $soma % 11;
        if ($cnpj{12} != ($resto < 2 ? 0 : 11 - $resto))
            return false;
        // Valida segundo dígito verificador
        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
            $soma += $cnpj{$i} * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
        $resto = $soma % 11;
        return $cnpj{13} == ($resto < 2 ? 0 : 11 - $resto);
    }

    function extenso($valor = 0, $maiusculas = false) {
        if (!$maiusculas) {
            $singular = ["centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão"];
            $plural = ["centavos", "reais", "mil", "milhões", "bilhões", "trilhões", "quatrilhões"];
            $u = ["", "um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove"];
        } else {
            $singular = ["CENTAVO", "REAL", "MIL", "MILHÃO", "BILHÃO", "TRILHÃO", "QUADRILHÃO"];
            $plural = ["CENTAVOS", "REAIS", "MIL", "MILHÕES", "BILHÕES", "TRILHÕES", "QUADRILHÕES"];
            $u = ["", "um", "dois", "TRÊS", "quatro", "cinco", "seis", "sete", "oito", "nove"];
        }

        $c = ["", "cem", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos"];
        $d = ["", "dez", "vinte", "trinta", "quarenta", "cinquenta", "sessenta", "setenta", "oitenta", "noventa"];
        $d10 = ["dez", "onze", "doze", "treze", "quatorze", "quinze", "dezesseis", "dezesete", "dezoito", "dezenove"];

        $z = 0;
        $rt = "";

        $valor = number_format($valor, 2, ".", ".");
        $inteiro = explode(".", $valor);
        for ($i = 0; $i < count($inteiro); $i++)
            for ($ii = strlen($inteiro[$i]); $ii < 3; $ii++)
                $inteiro[$i] = "0" . $inteiro[$i];

        $fim = count($inteiro) - ($inteiro[count($inteiro) - 1] > 0 ? 1 : 2);
        for ($i = 0; $i < count($inteiro); $i++) {
            $valor = $inteiro[$i];
            $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
            $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
            $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

            $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd &&
                    $ru) ? " e " : "") . $ru;
            $t = count($inteiro) - 1 - $i;
            $r .= $r ? " " . ($valor > 1 ? $plural[$t] : $singular[$t]) : "";
            if ($valor == "000")
                $z++;
            elseif ($z > 0)
                $z--;
            if (($t == 1) && ($z > 0) && ($inteiro[0] > 0))
                $r .= (($z > 1) ? " de " : "") . $plural[$t];
            if ($r)
                $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
        }

        if (!$maiusculas) {
            $return = $rt ? $rt : "zero";
        } else {
            if ($rt)
                $rt = preg_replace("/E/", " e ", ucwords($rt));
            $return = ($rt) ? ($rt) : "Zero";
        }

        if (!$maiusculas) {
            return preg_replace("/E/ ", " e ", ucwords($return));
        } else {
            return strtoupper($return);
        }
    }

    function GerarCodigo($id, $cpf, $data) {

        $pontuacao = array('.', ',', '/', '-');
        $data = (string) $data;

        $data = str_replace($pontuacao, '', $data);
        $cpf = str_replace($pontuacao, '', $cpf);


        $codigo = $id . $cpf . $data;
        return $codigo;
    }

    function msg($tipo, $msg) {
        echo "<div class='col-md-12'>";

        if ($tipo == "ok")
            echo "<div class='alert alert-success' role='alert'>" . $msg
            . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button></div>";

        if ($tipo == "error")
            echo "<div class='alert alert-danger' role='alert'>" . $msg
            . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button></div>";

        if ($tipo == "info")
            echo "<div class='alert alert-info' role='alert'>" . $msg
            . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button></div>";

        echo "</div>";
    }

    function refresh($tempo = 0) {
        echo "<meta http-equiv='refresh' content='{$tempo}'>";
    }

    function lead($nome, $email,$nascimento,$celular) {

        $ch = curl_init();
         $post = "id=122394&pid=3551590&list_id=122394&provider=leadlovers&email="
        .$email
        ."&name=".$nome 
        ."&birthdate=".$nascimento
        ."&phone=".$celular;
         
         echo $post;
        curl_setopt($ch, CURLOPT_URL, "https://leadlovers.com/Pages/Index/12239");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
// in real life you should use something like:
//curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('postvar1' => 'value1')));
// receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);

        curl_close($ch);

// further processing ....
    //var_dump($server_output);
        if ($server_output == "OK") {
            return true;
        } else {
             return false;
        }

        return $server_output . $post;
    }

}
