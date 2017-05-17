<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClassUpload
 *
 * @author oliveira
 */
class ClassUpload {

    //put your code here

    private $arquivo;
    private $altura;
    private $largura;
    private $pasta;

    function construtor($arquivo, $altura, $largura, $pasta) {
        $this->arquivo = $arquivo;
        $this->altura = $altura;
        $this->largura = $largura;
        $this->pasta = $pasta;
        return $this->salvar();
    }

    private function getExtensao() {
        //retorna a extensao da imagem	
        return $extensao = strtolower(end(explode('.', $this->arquivo['name'])));
    }

    private function ehImagem($extensao) {
        $extensoes = array('gif', 'jpeg', 'jpg', 'png');  // extensoes permitidas
        if (in_array($extensao, $extensoes))
            return true;
    }

    //largura, altura, tipo, localizacao da imagem original
    private function redimensionar($imgLarg, $imgAlt, $tipo, $img_localizacao) {
        //descobrir novo tamanho sem perder a proporcao
        if ($imgLarg > $imgAlt) {
            $novaLarg = $this->largura;
            $novaAlt = round(($novaLarg / $imgLarg) * $imgAlt);
        } elseif ($imgAlt > $imgLarg) {
            $novaAlt = $this->altura;
            $novaLarg = round(($novaAlt / $imgAlt) * $imgLarg);
        } else // altura == largura
            $novaAltura = $novaLargura = max($this->largura, $this->altura);

        //redimencionar a imagem
        //cria uma nova imagem com o novo tamanho	
        $novaimagem = imagecreatetruecolor($novaLarg, $novaAlt);

        switch ($tipo) {
            case 1: // gif
                $origem = imagecreatefromgif($img_localizacao);
                imagecopyresampled($novaimagem, $origem, 0, 0, 0, 0, $novaLarg, $novaAlt, $imgLarg, $imgAlt);
                imagegif($novaimagem, $img_localizacao);
                break;
            case 2: // jpg
                $origem = imagecreatefromjpeg($img_localizacao);
                imagecopyresampled($novaimagem, $origem, 0, 0, 0, 0, $novaLarg, $novaAlt, $imgLarg, $imgAlt);
                imagejpeg($novaimagem, $img_localizacao);
                break;
            case 3: // png
                $origem = imagecreatefrompng($img_localizacao);
                imagecopyresampled($novaimagem, $origem, 0, 0, 0, 0, $novaLarg, $novaAlt, $imgLarg, $imgAlt);
                imagepng($novaimagem, $img_localizacao);
                break;
        }
        
         
        //destroi as imagens criadas
        imagedestroy($novaimagem);
        imagedestroy($origem);
    }

    private function salvar() {
        $extensao = $this->getExtensao();

        //gera um nome unico para a imagem em funcao do tempo
        $novo_nome = time() . '.' . $extensao;
        //localizacao do arquivo 
        $destino = $this->pasta . $novo_nome;

        //move o arquivo
        if (!move_uploaded_file($this->arquivo['tmp_name'], $destino)) {
            if ($this->arquivo['error'] == 1)
                //return "Tamanho excede o permitido";
                return false;
            else
                //return "Erro " . $this->arquivo['error'];
                return false;
        }

        if ($this->ehImagem($extensao)) {
            //pega a largura, altura, tipo e atributo da imagem
            list($largura, $altura, $tipo, $atributo) = getimagesize($destino);
            // testa se é preciso redimensionar a imagem
            if (($largura > $this->largura) || ($altura > $this->altura))
                $this->redimensionar($largura, $altura, $tipo, $destino);
        }

            return $novo_nome;
       
    }

}
