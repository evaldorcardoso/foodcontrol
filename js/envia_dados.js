//status= div para a mensagem final
//urlData= url com os parametros
//pagina= url da pagina a ser executada a operação
//msgErro= mensagem personalizada caso haja erro na solicitação
//atualiza_pagina= opção para atualizar a página ao finalizar a solicitação
function buscaDados(status,urlData,pagina,msgErro,atualiza_pagina){

    try{
        // Opera 8.0+, Firefox, Safari
        objetoAjax = new XMLHttpRequest();
    }
    catch (e){
        // Internet Explorer Browsers
        try{
            objetoAjax = new ActiveXObject("Msxml2.XMLHTTP");
        }
        catch (e) {
        try{
            objetoAjax = new ActiveXObject("Microsoft.XMLHTTP");
        }
        catch (e){
            // Something went wrong
            alert("Desculpe, mas seu navegador não é compatível, tente com outro navegador");
            $(status).fadeOut('fast');
            return false;
            }
        }
    }
    waitingDialog.show('Aguarde...', {dialogSize: 'm', progressType: 'success'});
    status = document.getElementById(status);
    objetoAjax.onreadystatechange = function(){
        // O valor 4 na propriedade readyState significa que o objeto já completou/finalizou o recebimento de dados
        
        if(objetoAjax.readyState == 4){
            // 200 = resposta do servidor OK
            if(objetoAjax.status == 200){
                waitingDialog.hide();
                var resposta=objetoAjax.responseText;
                
                switch(resposta.trim()){
                    case "OK":
                        status.innerHTML='<div class="col-md-12"><div class="msg msg-success msg-success-text"> <span class="glyphicon glyphicon glyphicon-ok"></span> Comando executado com sucesso!</div></div>';
                        if(atualiza_pagina)
                            location.reload();
                        break;
                    case "erro":
                        //status.innerHTML = '<div class="col-md-12"><div class="msg msg-danger"> <span class="glyphicon glyphicon glyphicon-remove"></span>'+msgErro+'</div></div>';
                        finalDialog.show(msgErro, {dialogSize: 'm'});
                        break;
                    case "-":
                        status.innerHTML='';
                        break;
                    default:
                        if (resposta.indexOf("OK")!=-1){
                            if(resposta.indexOf("out")!=-1)//logout
                            {
                                location.reload();
                                break;    
                            }
                            if(resposta.indexOf("backup")!=-1)
                            {
                                var currentDate = new Date();
                                var day = currentDate.getDate();
                                var month = currentDate.getMonth() + 1;
                                var year = currentDate.getFullYear();
                                download('backup-'+day+month+year+'.sql',resposta);
                                status.innerHTML="";
                                break;
                            }
                            if(resposta.indexOf("pedido")!=-1)
                            {
                                status.innerHTML='';
                                var index=resposta.indexOf('=');
                                index=resposta.substring(index+1);
                                location.href='pedido.php?id='+index; 
                                break;      
                            }
                            if(resposta.indexOf("cliente")!=-1)
                            {
                                status.innerHTML='';
                                var index=resposta.indexOf('=');
                                index=resposta.substring(index+1);
                                id_cliente=document.getElementById('id_cliente');
                                id_cliente.value=index;
                                document.getElementById("salvarButton").disabled=true;
                                document.getElementById("selecionaClienteButton").disabled=false;
                                break;      
                            }
                            if(resposta.indexOf("tele-salva")!=-1)
                            {
                                location.href="index.php"
                                break;  
                            }
                            if(resposta.indexOf("tele")!=-1)
                            {
                                var index=resposta.indexOf('=');
                                index=resposta.substring(index+1);
                                location.href='tele.php?id='+index; 
                                break;      
                            }
                            if(resposta.indexOf("divida")!=-1)
                            {
                                location.href='divida.php'; 
                                break;      
                            }
                            if(resposta.indexOf("pronto")!=-1)
                            {
                                status.innerHTML='';
                                var index=resposta.indexOf('=');
                                index=resposta.substring(index+1);
                                removeDaLista(index);
                                break;
                            }
                            if(resposta.indexOf("inicio")!=-1)
                            {
                                status.innerHTML='';
                                location.href="index.php";
                                break;
                            }
                            if(resposta.indexOf("entregue")!=-1)
                            {
                                status.innerHTML='';
                                var index=resposta.indexOf('=');
                                index=resposta.substring(index+1);
                                removeDaLista(index);
                                break;
                            }
                            if(resposta.indexOf("paga-item")!=-1)
                            {
                                //alert("ok");
                                status.innerHTML="";
                                //$('#fechar_pedido').modal('show');
                                //$('#finalizar_valorapagar').val($("#valorapagar").val());
                                novoFecharPedido();
                                break;
                            }
                            if(resposta.indexOf("reseta")!=-1)
                            {
                                status.innerHTML='';
                                $('#modalResetaSenha').modal('show');
                                var index=resposta.indexOf('=');
                                index=resposta.substring(index+1);
                                $('#id_reseta').val(index);
                                break;
                            }
                            else
                            {
                                finalDialog.show(resposta, {dialogSize: 'm'});
                                status.innerHTML = '<div class="col-md-12"><div class="msg msg-danger"> <span class="glyphicon glyphicon glyphicon-remove"></span>Erro inesperado</div></div>';
                                /*var r = confirm("Ver o erro?");
                                if (r == true) {
                                    alert(resposta);
                                } else {
                                    location.reload();    
                                }*/
                                break;
                            }
                        }
                        else
                        {
                            finalDialog.show(resposta, {dialogSize: 'm'});
                            //status.innerHTML = '<div class="col-md-12"><div class="msg msg-danger"> <span class="glyphicon glyphicon glyphicon-remove"></span>Erro inesperado</div></div>';
                            /*var r = confirm("Ver o erro?");
                                if (r == true) {
                                    alert(resposta);
                                } else {
                                    location.reload();    
                                }*/
                            break;
                        }
                }
            }
        }
    }
    //////////////////////////////////////////////////////
    objetoAjax.open("POST", pagina, true);
    objetoAjax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    objetoAjax.send(urlData);
}


function buscaDadosBanco(status,urlData,pagina,msgErro,tipo,elementoHTML,nivelFromImages){
    try{
        // Opera 8.0+, Firefox, Safari
        objetoAjax = new XMLHttpRequest();
    }
    catch (e){
        // Internet Explorer Browsers
        try{
            objetoAjax = new ActiveXObject("Msxml2.XMLHTTP");
        }
        catch (e) {
        try{
            objetoAjax = new ActiveXObject("Microsoft.XMLHTTP");
        }
        catch (e){
            // Something went wrong
            alert("Desculpe, mas seu navegador não é compatível, tente com outro navegador");
            $(status).fadeOut('fast');
            return false;
            }
        }
    }
    var temporaryStatus=status;
    status = document.getElementById(status);
    elementoHTML=document.getElementById(elementoHTML);
    objetoAjax.onreadystatechange = function(){
        // O valor 4 na propriedade readyState significa que o objeto já completou/finalizou o
        // recebimento de dados

        if(objetoAjax.readyState == 4){
            // 200 = resposta do servidor OK
            if(objetoAjax.status == 200){
                var resposta=objetoAjax.responseText;
                resposta.trim();
                switch(tipo){
                    case "getCaixa":
                        elementoHTML.innerHTML=resposta;
                        status.innerHTML="";
                        //carrega os scripts para gerenciar o + e - inputs buttons da quantidade
                        var js = document.createElement("script");
                        js.type = "text/javascript";
                        js.src = "minusandplus.js";
                        document.body.appendChild(js);  
                        pegaDetalhes();
                        
                    break;
                    case "getCaixaTotais":
                        elementoHTML.innerHTML=resposta;
                        status.innerHTML="";
                        document.getElementById("btnFinalizarPedido").disabled=false;
                    break;
                    case "getCaixaDetalhes":
                        elementoHTML.innerHTML=resposta;
                        status.innerHTML="";
                        pegaTotais();
                    break;
                    case "getListaCredor":
                        elementoHTML.innerHTML=resposta;
                        status.innerHTML="";
                        var js2 = document.createElement("script");
                        js2.type = "text/javascript";
                        js2.src = "seleciona.js";
                        document.body.appendChild(js2);
                    break;
                    case "getListaCliente":
                        elementoHTML.innerHTML=resposta;
                        status.innerHTML="";
                        var js3 = document.createElement("script");
                        js3.type = "text/javascript";
                        js3.src = "seleciona.js";
                        document.body.appendChild(js3);
                    break;
                    case "getRelatorioFinanceiro":
                        elementoHTML.innerHTML=resposta;
                        var index=resposta.indexOf('#');
                        var index_fim=resposta.indexOf('*');
                        //alert(index+'-'+index_fim);
                        var str=resposta.substring(index+1,index_fim);
                        str=parseFloat(str);
                        str=str.toFixed(2);
                        if(!isNaN(str))
                            document.getElementById("total").innerHTML="Total: R$ "+str;
                        else
                            document.getElementById("total").innerHTML="Total: R$ 0.00";
                        status.innerHTML="";
                    break;
                    case "getRelatorioDivida":
                        elementoHTML.innerHTML=resposta;
                        var index=resposta.indexOf('#');
                        var index_fim=resposta.indexOf('*');
                        //alert(index+'-'+index_fim);
                        var str=resposta.substring(index+1,index_fim);
                        str=parseFloat(str);
                        str=str.toFixed(2);
                        if(!isNaN(str))
                            document.getElementById("total").innerHTML="Total: R$ "+str;
                        else
                            document.getElementById("total").innerHTML="Total: R$ 0.00";
                        status.innerHTML="";
                    break;
                    case "tempo_ativo":
                        elementoHTML.innerHTML=resposta;
                        status.innerHTML="";
                        buscaTempo(2);
                    break;
                    case "tempo_inativo":
                        elementoHTML.innerHTML=resposta;
                        status.innerHTML="";
                        buscaFeed();
                    break;
                    case "feed":
                        elementoHTML.innerHTML=resposta;
                        status.innerHTML="";
                    break;
                    default:
                        alert(resposta);
                        status.innerHTML = '<font color="Red">Algo errado aconteceu, tente novamente!</font>';
                    break;

                    
                }
            }
        }
        else
        {
            if(status==null)
                alert('O div: '+temporaryStatus+' não existe!');
            status.innerHTML='Buscando dados...<p><img src="'+nivelFromImages+'images/large-facebook.gif"/>';
        }
    }
    //////////////////////////////////////////////////////
    objetoAjax.open("POST", pagina, true);
    objetoAjax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    objetoAjax.send(urlData);
}
