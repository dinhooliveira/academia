<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link href="view/contrato/contrato_style.css" rel="stylesheet">
        <link href="<?= $config->URL ?>/public/admin/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        
           <img src="./view/img/logo.png"/>
         
        <?php
          if(isset($_GET['cod_contrato']))
          {   date_default_timezone_set('America/Sao_Paulo');
              $classContrato = new \Model\Contrato();
              $aluno = $classContrato->get_Aluno($_GET['cod_contrato']);
              $academia= $classContrato->Get_Academia($_GET['cod_contrato']);
              //var_dump($aluno);
              //var_dump($academia);
          
        ?>
        <div class="contrato">
        <p>Eu <b><?=$aluno['NOME']?></b>, nascido em <b><?=date('d/m/Y', strtotime($aluno['DATA_NASC']))?></b> brasileiro, residente <b><?=$aluno['LOGRADOURO']." N° ".$aluno['NUMERO']." ".$aluno['COMPLEMENTO']."  ".$aluno['BAIRRO']." ".$aluno['CIDADE']." - ".$aluno['UF']?></b> 
        celular <b><?=$aluno['CELULAR']?></b> E-mail <b><?=$aluno['EMAIL']?></b>, portador do CPF <b><?=$aluno['CPF']?></b> Matriculado com o nº de registro <b><?=$aluno['COD_CONTRATO']?></b>
        assumo o termo de compromisso, firmado com a BOX FUNCIONAL LTDA <b><?=$academia['NOME']?></b>. Estabelecida na <b><?=$academia['LOGRADOURO']." N° ".$academia['NUMERO']." ".$academia['COMPLEMENTO']."  ".$academia['BAIRRO']." ".$academia['CIDADE']." - ".$academia['UF']?></b> pela a pratica de <b><?=$aluno['DESCRICAO'];?></b>, mediante as seguintes cláusulas e condições abaixo:
        
        <?php } ?>
        <br><br><b>Cláusula 1º</b> – Não nos responsabilizamos por objetos e/ou pertences pessoais extraviados ou esquecidos nas dependências da academia

<br><br><b>Cláusula 2º</b> – É imprescindível o uso de calçado e roupas adequados à prática de atividade física, sendo terminantemente proibido treinar com roupa de banho ( sunga e biquínis) bem como roupas jeans, vestidos ou sem camisa.

<br><br><b>Cláusula 3º</b> – O aluno é responsável pelos instrumentos, equipamentos, Materiais e instalações que lhes forem confiados ou que fizer uso, assim como, por guardar todo material utilizado, como anilhas, halteres, tornozeleiras, barras, colchonetes etc.

<br><br><b>Cláusula 4º</b> – O aluno que estiver inadimplente com a mensalidade ficará suspenso das atividades, até que regularize a pendência. O valor pago pelo aluno é pessoal e intransferível e corresponde a um período consecutivo de trinta (30) dias, não tendo nenhuma relação com a freqüência ou assiduidade. Faltas não serão compensadas no mês posterior. 

<br><br><b>Cláusula 5º</b> – A apresentação de atestado médico é indispensável. 

<br><br><b>Cláusula 6º</b> – Em caso de desistência de qualquer atividade pretendida, não devolvemos quaisquer importância/valores recebidos.

<br><br><b>Cláusula 7º</b> – É terminantemente proibido o uso de esteroides anabolizantes no interior do Centro de Treinamento,podendo o cliente/aluno ou instrutor ser expulso do estabelecimento.

<br><br><b>Cláusula 8º</b> -  O aluno deverá seguir as instruções dos professores na utilização dos aparelhos, zelando pela preservação dos mesmos. Bem como já estabelecido no item 3.

<br><br><b>Cláusula 9º</b> - Ao se matricular na Box Funcional LTDA, fica autorizada, por parte do aluno/matriculado, o uso das imagens em que estiver presente, que forem feitas dentro das dependências da academia, ou em atividades externas para fins de publicidade da mesma. Não podendo haver quaisquer tipo de reclamação futura.

<br><br><b>Cláusula 10º</b> - Academia não se responsabiliza pelo aluno menor de idade, devendo os pais ou responsáveis, acompanhá-los durante todo o período de treinamento.

<br><br><b>Cláusula 11º</b> - Em caso de suspeita/confirmação de doenças transmissíveis pelo ar ou por contato físico, o aluno deve suspender os exercícios, até que se restabeleça sua saúde. Fica a academia no direito de exigir atestado médico a qualquer tempo. 

<br><br><b>Cláusula 12º</b> - O ambiente da Box Funcional,  é destinado a pessoas que buscam melhoria do condicionamento físico, da saúde, eliminação das tensões e estresses, conquista de novas amizades, lazer, etc. Por essa razão, não condutas(s) que fere(m) a ordem, a falta de educação ou constrangimento por conduta que fere os padrões éticos e morais fundamentados nos bons costumes. 
 

<br><br>Após ter lido o presente Regulamento da Box Funcional e tendo compreendido e concordado com todos os seus termos, declaro que me submeterei às disposições nele contidas, razão pela qual solicito minha inscrição para utilização na BOX FUNCIONAL LTDA.
            
    </p>
    <?PHP if(isset($aluno["ACEITO"]) && $aluno["ACEITO"]==0 && isset($_GET['cod_contrato'])){ ?>
    <form method="POST">
    <input type="checkbox" name="aceito" value="1"><b>Marque aqui para concordar.</b>
    <br><br>
    <input type="submit" class="btn btn-success" name="aceitar" value="concordo"/>
    </form><br><br>
    
    <?PHP 
    if(isset($_POST['aceitar']))
    {   $ClassFuncoes = new \Model\Funcoes();
       if(isset($_POST['aceito']))
        $classContrato->aceitarContrato($_GET['cod_contrato']);
       else
       $ClassFuncoes->msg('ok','Marque o checkbox para concordar');
    }
    
    ?>
    
    <?php
     
     
    }
    else if(isset($_GET['cod_contrato'])) {
        $date= date_create($aluno["DATA_ACEITE"]);
        ?>
    <b>Contrato aceito em <?=date_format($date,'d-m-Y G:ia');?> utilizando IP <?=$aluno["IP"];?></b>
    <?php
    }
    //echo date('d-m-Y G:ia');
    ?>
    
  
        </div>
       
    </body>
</html>
