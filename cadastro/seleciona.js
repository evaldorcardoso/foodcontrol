$(document).ready(function() 
	    {
        
//vai ler apenas os cliques com atributo data-toggle=modal
        $('[data-toggle=seleciona]').click(function ()
        {
          
          //************************************************
          var data_id = '';
          if (typeof $(this).data('id') !== 'undefined') 
          {
            data_id = $(this).data('id');
          }
          $('#id_credor').val(data_id);
          //************************************************
          var data_credor_nome = '';
          if (typeof $(this).data('nome') !== 'undefined') 
          {
            data_credor_nome = $(this).data('nome');
          }
          $('#nome_credor').val(data_credor_nome);
          
          $('#lista_credores').modal('hide');
        });

    });