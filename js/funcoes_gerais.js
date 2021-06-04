
/*FUNÇÃO PARA VALIDAR CAMPOS INFORMADOS E MOSTRAR UMA MENSAGEM CASO ALGUM CAMPO ESTEJA VAZIO*/
function validaCampos(campos)
{
    var retorno=true;
    for (var i = 0; i <= campos.length -1; i++) 
    {
        
        var elemento = document.getElementById(campos[i]).value;
        //alert(elemento);
        if(elemento=='')
        {
            alert("Algum campo nao foi preenchido corretamente!");
            document.getElementById(campos[i]).focus();
            retorno=false;
            break;
        }
    }
    return retorno;
}

/* FUNÇÃO PARA LIMPAR OS CAMPOS */
function limpaCampos(campos)
{
    for(var i = 0; i <= campos.length -1; i++)
    {
        $('#'+campos[i]).val('');
    }
}

/*FUNÇÃO PARA CARREGAR UM CAMPO COM P VALOR INFORMADO*/
function carregaCampo(campo,valor)
{
    $('#'+campo).val(valor);
    //
}

/*FUNÇÃO PARA DEIXAR UM ELEMENTO COM FOCO OU ATIVO*/
function focusElement(id)
{
    setTimeout(function () { // wait 3 seconds and reload
        document.getElementById(id).focus();
    }, 1000);
}

function createNoty(message, type) 
{
    var html = '<div class="alert alert-' + type + ' alert-dismissable page-alert">';    
    html += '<button type="button" class="close"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>';
    html += '<center>'+message+'</center>';
    html += '</div>';    
    $(html).hide().prependTo('#noty-holder').slideDown();
}

/*FUNÇÃO PARA CHAMAR UMA NOTIFICAÇÃO*/
function notificacao(mensagem)
{
    createNoty(mensagem, 'danger');
    $('.page-alert .close').click(function(e) {
        e.preventDefault();
        $(this).closest('.page-alert').slideUp();
    });
}