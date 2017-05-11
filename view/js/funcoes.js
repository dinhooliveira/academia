/* Máscaras ER */
function mascara(o,f){
    v_obj=o
    v_fun=f
    setTimeout("execmascara()",1)
}
function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}
function mcep(v){
    v=v.replace(/\D/g,"")                    //Remove tudo o que não é dígito
    v=v.replace(/^(\d{5})(\d)/,"$1-$2")         //Esse é tão fácil que não merece explicações
    return v;
}
function mtel(v){
    v=v.replace(/\D/g,"");             //Remove tudo o que não é dígito
    v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
    v=v.replace(/(\d)(\d{4})$/,"$1-$2");    //Coloca hífen entre o quarto e o quinto dígitos
    return v;
}

function mCel(v){
    v=v.replace(/\D/g,"");             //Remove tudo o que não é dígito
    v=v.replace(/^(\d{3})(\d)/g,"($1) $2"); //Coloca parênteses em volta dos três primeiros dígitos
   // v=v.replace(/(\d)(\d{4})$/,"$1-$2");    //Coloca hífen entre o quarto e o quinto dígitos
    return v;
}
function mcnpj(v){
    v=v.replace(/\D/g,"")                           //Remove tudo o que não é dígito
    v=v.replace(/^(\d{2})(\d)/,"$1.$2")             //Coloca ponto entre o segundo e o terceiro dígitos
    v=v.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3") //Coloca ponto entre o quinto e o sexto dígitos
    v=v.replace(/\.(\d{3})(\d)/,".$1/$2")           //Coloca uma barra entre o oitavo e o nono dígitos
    v=v.replace(/(\d{4})(\d)/,"$1-$2")              //Coloca um hífen depois do bloco de quatro dígitos
    return v
}
function mcpf(v){
    v=v.replace(/\D/g,"")                    //Remove tudo o que não é dígito
    v=v.replace(/(\d{3})(\d)/,"$1.$2")       //Coloca um ponto entre o terceiro e o quarto dígitos
    v=v.replace(/(\d{3})(\d)/,"$1.$2")       //Coloca um ponto entre o terceiro e o quarto dígitos
                                             //de novo (para o segundo bloco de números)
    v=v.replace(/(\d{3})(\d{1,2})$/,"$1-$2") //Coloca um hífen entre o terceiro e o quarto dígitos
    return v
}
function mdata(v){
    v=v.replace(/\D/g,"");                    //Remove tudo o que não é dígito
    v=v.replace(/(\d{2})(\d)/,"$1/$2");
    v=v.replace(/(\d{2})(\d)/,"$1/$2");

    v=v.replace(/(\d{2})(\d{2})$/,"$1$2");
    return v;
}
function mtempo(v){
    v=v.replace(/\D/g,"");                    //Remove tudo o que não é dígito
    v=v.replace(/(\d{1})(\d{2})(\d{2})/,"$1:$2.$3");
    return v;
}
function mhora(v){
    v=v.replace(/\D/g,"");                    //Remove tudo o que não é dígito
    v=v.replace(/(\d{2})(\d)/,"$1h$2");
    return v;
}
function mrg(v){
    v=v.replace(/\D/g,"");                                      //Remove tudo o que não é dígito
        v=v.replace(/(\d)(\d{7})$/,"$1.$2");    //Coloca o . antes dos últimos 3 dígitos, e antes do verificador
        v=v.replace(/(\d)(\d{4})$/,"$1.$2");    //Coloca o . antes dos últimos 3 dígitos, e antes do verificador
        v=v.replace(/(\d)(\d)$/,"$1-$2");               //Coloca o - antes do último dígito
    return v;
}
function mnum(v){
    v=v.replace(/\D/g,"");                                      //Remove tudo o que não é dígito
    return v;
}
function mfloat(v){
    v=v.replace(/\D/g,"");//Remove tudo o que não é dígito
    v=v.replace(/(\d)(\d{2})$/,"$1.$2");//coloca a ponto antes dos 2 últimos dígitos
    return v;
    }	
	function mascaraMoeda(v){
v = v.toString().replace(/\D/g,""); // permite digitar apenas numero
v = v.toString().replace(/(\d)(\d{14})$/,"$1.$2"); // coloca ponto antes dos ultimos digitos
v = v.toString().replace(/(\d)(\d{11})$/,"$1.$2"); // coloca ponto antes dos ultimos 11 digitos
v = v.toString().replace(/(\d)(\d{8})$/,"$1.$2"); // coloca ponto antes dos ultimos 8 digitos
v = v.toString().replace(/(\d)(\d{5})$/,"$1.$2"); // coloca ponto antes dos ultimos 5 digitos
v = v.toString().replace(/(\d)(\d{2})$/,"$1,$2"); // coloca virgula antes dos ultimos 2 digitos
 return v
}

    /*    function mascaraValor(valor) {
    valor = valor.toString().replace(/\D/g,"");
    valor = valor.toString().replace(/(\d)(\d{8})$/,"$1.$2");
    valor = valor.toString().replace(/(\d)(\d{5})$/,"$1.$2");
    valor = valor.toString().replace(/(\d)(\d{2})$/,"$1,$2");
    return valor                    
}*/

/*---------------------FIM_MASCARAS_ER-------------------------- */

/*BUSCAR CEP*/
  function limpa_formulário_cep() {
            //Limpa valores do formulário de cep.
            document.getElementById('logradouro').value=("");
            document.getElementById('bairro').value=("");
            document.getElementById('cidade').value=("");
            document.getElementById('uf').value=("");
           
    }

    function meu_callback(conteudo) {
        if (!("erro" in conteudo)) {
            //Atualiza os campos com os valores.
            document.getElementById('logradouro').value=(conteudo.logradouro);
            document.getElementById('bairro').value=(conteudo.bairro);
            document.getElementById('cidade').value=(conteudo.localidade);
            document.getElementById('uf').value=(conteudo.uf);
        
        } //end if.
        else {
            //CEP não Encontrado.
            limpa_formulário_cep();
            alert("CEP não encontrado.");
        }
    }
        
    function pesquisacep(valor) {

        //Nova variável "cep" somente com dígitos.
        var cep = valor.replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                document.getElementById('logradouro').value="...";
                document.getElementById('bairro').value="...";
                document.getElementById('cidade').value="...";
                document.getElementById('uf').value="...";
              

                //Cria um elemento javascript.
                var script = document.createElement('script');

                //Sincroniza com o callback.
                script.src = '//viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';
               console.log(script);
                //Insere script no documento e carrega o conteúdo.
                document.body.appendChild(script);

            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    };
/*---------------------FIM_BUSCAR_CEP-----------------------------------*/



/*----------------PRECIFICADOR---PARTE---1---*/

function calculo(){
 
 
 
  var qtdprod =  parseFloat(document.getElementById("qtd_produto").value);
  var valorprod = parseFloat(document.getElementById("produto").value);
  
  var qtdfunc = parseFloat(document.getElementById("qtd_funcionario").value);
  var valorfunc= parseFloat(document.getElementById("funcionario").value);
  
  var base= parseFloat(document.getElementById("base").value);
  var mlucro= parseFloat(document.getElementById("mlucro").value);
   
   var variacao= parseFloat(document.getElementById("taxa_variacao").value);
   var monetario= parseFloat(document.getElementById("taxa_monetario").value);
 
  if( isNaN(qtdprod))qtdprod=0;
  if( isNaN(qtdfunc) )qtdfunc=0;
  if( isNaN(monetario) )monetario=0;
  var resultprod = (qtdprod*valorprod);
  var resultfunc = (qtdfunc*valorfunc);
  
  var resultado = resultprod + resultfunc + base;
  var honorario = (resultado*(mlucro/100))+ resultado;
  var thonorario =   (honorario*(variacao/100))+ honorario + monetario;
  
  document.getElementById("custo_total").value=resultado.toFixed(2);
  document.getElementById("precohonorario").value=honorario.toFixed(2);
  document.getElementById("precothonorario").value=thonorario.toFixed(2); 
  
  thonorario = Math.round(thonorario);
  honorario= Math.round(honorario);
  var textvalor = resultado.toFixed(2);
  var texthonorario = honorario.toFixed(2);
  var textThonorario = thonorario.toFixed(2);
  
 
  
 
  
  
  textvalor= mascaraMoeda(textvalor);
  texthonorario= mascaraMoeda(texthonorario);
   textThonorario= mascaraMoeda(textThonorario);
  /*alert(test);*/
   
  var resultext="<p id='prec_honario'> Valor Honorário  <b>R$: "+texthonorario+"</b></p>";
  resultext+="<p id='prec_honario_variacao'> Valor Honorário com variação <b>R$:"+textThonorario+"</b></p>";
    
   document.getElementById("resultado").innerHTML= resultext;
  
  /*alert("funcionou"+resultado);*/
}

function carregar(){
    /*alert('carregou');*/
    var produto = document.getElementById("qtd_produto").value;
    if(produto=="")document.getElementById("qtd_produto").value=0;

     var func = document.getElementById("qtd_funcionario").value;
     if(func=="")document.getElementById("qtd_funcionario").value=0;
     
    var percentual = document.getElementById("percentual");
   
    testevariacao();
    calculo();
}


function testevariacao(){
    
    var monetario = document.getElementById("monetario");
    var percentual = document.getElementById("percentual");
    
    if(monetario.checked==true){
        /*alert('monetario');*/
        document.getElementById("taxa_variacao").disabled=true;
        document.getElementById("taxa_monetario").disabled=false;
        document.getElementById("taxa_variacao").style.backgroundColor='#ccc';
        document.getElementById("taxa_monetario").style.backgroundColor='#90EE90';
        document.getElementById("taxa_variacao").value=0;
    }
    
    if(percentual.checked==true){
        /*alert('perncentaul');*/
        document.getElementById("taxa_variacao").disabled=false;
        document.getElementById("taxa_monetario").disabled=true;
        document.getElementById("taxa_variacao").style.backgroundColor='#90EE90';
        document.getElementById("taxa_monetario").style.backgroundColor='#ccc';
        document.getElementById("taxa_monetario").value=0;

        
    }
    
     calculo();
}


/*-----------------------------------FIM_PRECIFICAÇÃO----------------------------*/



/*----------------------------BUSCA-------------------------------*/
function consulta_dados(){
    
    //alert('chamou');
    document.getElementById("formulario").submit();
}

/*------------------SE O USUARIO CLICAR NA CHECKBOX A DATA SE TORNA OBRIGATORIA-------------------------------*/



function consulta_hb_data(){
   var x = document.getElementById("hbdata");
    if(x.checked==true){
        //alert('verdadeiro');
        document.getElementById("datainicio").required=true;
        document.getElementById("datafim").required=true;
        document.getElementById("datainicio").disabled=false;
        document.getElementById("datafim").disabled=false;
        document.getElementById("hb").value="checked";
    }else{
        //alert('falso');
        document.getElementById("datainicio").required=false;
        document.getElementById("datafim").required=false;
        document.getElementById("datainicio").disabled=true;
        document.getElementById("datafim").disabled=true;
        document.getElementById("datainicio").value="00/00/0000";
        document.getElementById("datafim").value="00/00/0000";
        document.getElementById("hb").value="";
    }
}