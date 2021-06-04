<script type='text/javascript' src='../js/jquery-2.1.1.min.js'></script>
<script src="../js/bootstrap.js" type="text/javascript"></script>
<script src="../js/waitingfor.js" type="text/javascript"></script>
<script src="../js/envia_dados.js" type="text/javascript"></script>
<script src="../js/bootstrap-toggle.min.js"></script>
<link rel="stylesheet" href="../css/bootstrap.css">
<link href="../css/bootstrap-toggle.min.css" rel="stylesheet"><!-- REFERENCIA AO CHECKBOX TOGGLE-->
<link rel="icon" type="image/png" href="../images/favicon.ico">
<?php include_once "../verificador/verificador.php"; ?>
<head>
	<title>FoodControl - Relatório de Dívidas</title>
    <style type="text/css">
    	body{
        background-color: #690202;
      }

      p.credit {
        margin-top: -3%;
      }
    </style>

    <script type="text/javascript">
      function filtraItens()
      {
        data_inicio = document.getElementById("data_inicio").value;
        data_final = document.getElementById("data_final").value;
        situacao=document.getElementById("chkSituacao").checked;
        data_pagamento=document.getElementById("chkDataPagamento").checked;
        credor=document.getElementById("chkCredor").checked;
        var queryString="data_inicio="+data_inicio+"&data_final="+data_final;
        queryString+="&situacao="+situacao+"&data_pagamento="+data_pagamento+"&credor="+credor;
        buscaDadosBanco("statusTabela",queryString,"../get/getRelatorioDivida.php?action=carregaItens","Erro","getRelatorioDivida","tabela","../");
      }

      function imprime()
      {
        data_inicio = document.getElementById("data_inicio").value;
        data_final = document.getElementById("data_final").value;
        situacao=document.getElementById("chkSituacao").checked;
        data_pagamento=document.getElementById("chkDataPagamento").checked;
        credor=document.getElementById("chkCredor").checked;
        
        window.open("divida_print.php?data_inicio="+data_inicio+"&data_final="+data_final+"&situacao="+situacao+"&data_pagamento="+data_pagamento+"&credor="+credor,"_blank");
      }
    </script>

 
</head>
<body>
<div class="container">
     <center><img class="img img-responsive" style="max-width:300px;margin-top:10px" src="../images/logo-foodcontrol.png"><hr></center>
  <div class="row">
        <div id="bc1" class="btn-group btn-breadcrumb">
            <a href="../index.php" class="btn btn-warning"><div>Início</div></a>
            <a href="index.php" class="btn btn-default"><div>Visão Geral</div></a>
            <a href="#" class="btn btn-default active"><div>Relatório de Dívidas</div></a>
        </div>
        <button type="button" class="btn btn-success pull-right" onclick="location.reload()"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Atualizar</button>
        <button type="button" class="btn btn-default pull-right" style="margin-right:10px" onclick="imprime()"><span class="glyphicon glyphicon-print"></span> Imprimir</button>
   </div><br>
   <div class="panel panel-default">
   
    <div class="panel-body">
      <div class="well well-lg">
      <div class="row">
        <form class="form-inline">
          <div class="form-group">
        <div class="input-group">
          <div class="input-group-addon">Vencimento de:</div>
          <input id="data_inicio" type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" onchange="filtraItens()">
        </div>
        <div class="input-group">
          <div class="input-group-addon">à:</div>
          <input id="data_final" type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" onchange="filtraItens()"/>
        </div>
      <label class="checkbox-inline">
        <input id="chkSituacao" type="checkbox" data-toggle="toggle" data-on="Paga" data-off="Aberta" onchange="filtraItens()" checked/>
      </label>
      <label class="checkbox-inline">
        <input id="chkDataPagamento" type="checkbox" data-toggle="toggle" data-on="Data de Pagamento" data-off="Data de Pagamento" onchange="filtraItens()" checked/>
      </label>
      <label class="checkbox-inline">
        <input id="chkCredor" type="checkbox" data-toggle="toggle" data-on="Credor" data-off="Credor" onchange="filtraItens()" checked/>
      </label>
    </div>
   </form> 
   </div>
 </div>
   <br>
   <center><div id="statusTabela"></div></center>
   <br>
  <table id="tabela" class="col-md-12 table-bordered table-condensed table-stripped">
     <h4 id="total"></h4>
  </table> 
  </div>
</div>
</div>


<script>filtraItens();</script>
</body>