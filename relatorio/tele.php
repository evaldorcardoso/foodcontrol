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
	<title>FoodControl - Relatório Tele-Entrega</title>
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
        ac=document.getElementById("cbxTaxaEntrega").checked;
        cliente=document.getElementById("chkCliente").checked;
        usuario=document.getElementById("chkUsuario").checked;
        var queryString="data_inicio="+data_inicio+"&data_final="+data_final;
        queryString+="&ac="+ac+"&cliente="+cliente+"&usuario="+usuario;
        buscaDadosBanco("statusTabela",queryString,"../get/getRelatorioTele.php?action=carregaItens","Erro","getRelatorioFinanceiro","tabela","../");
      }

      function imprime()
      {
        data_inicio = document.getElementById("data_inicio").value;
        data_final = document.getElementById("data_final").value;
        ac=document.getElementById("cbxTaxaEntrega").checked;
        cliente=document.getElementById("chkCliente").checked;
        usuario=document.getElementById("chkUsuario").checked;
        window.open("tele_print.php?data_inicio="+data_inicio+"&data_final="+data_final+"&ac="+ac+"&cliente="+cliente+"&usuario="+usuario,"_blank");
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
            <a href="#" class="btn btn-default active"><div>Relatório de Tele-Entregas</div></a>
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
          <div class="input-group-addon">De:</div>
          <input id="data_inicio" type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" onchange="filtraItens()">
        </div>
        <div class="input-group">
          <div class="input-group-addon">à:</div>
          <input id="data_final" type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" onchange="filtraItens()"/>
        </div>
      <label class="checkbox-inline">
        <input id="cbxTaxaEntrega" type="checkbox" data-toggle="toggle" data-on="Taxa de Entrega" data-off="Taxa de Entrega" onchange="filtraItens()" checked/>
      </label>
      <label class="checkbox-inline">
        <input id="chkCliente" type="checkbox" data-toggle="toggle" data-on="Cliente" data-off="Cliente" onchange="filtraItens()" checked/>
      </label>
      <label class="checkbox-inline">
        <input id="chkUsuario" type="checkbox" data-toggle="toggle" data-on="Usuário" data-off="Usuário" onchange="filtraItens()" checked/>
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