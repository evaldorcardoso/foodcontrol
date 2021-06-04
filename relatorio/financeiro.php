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
	<title>FoodControl - Relatório financeiro</title>
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
        pg=document.getElementById("chkPorcentagemGarcom").checked;
        dinheiro=document.getElementById("chkDinheiro").checked;
        credito=document.getElementById("chkCredito").checked;
        debito=document.getElementById("chkDebito").checked;
        cliente=document.getElementById("chkCliente").checked;
        obs=document.getElementById("chkObs").checked;
        var queryString="data_inicio="+data_inicio+"&data_final="+data_final;
        queryString+="&pg="+pg+"&dinheiro="+dinheiro+"&credito="+credito;
        queryString+="&debito="+debito+"&cliente="+cliente+"&obs="+obs;
        buscaDadosBanco("statusTabela",queryString,"../get/getRelatorioFinanceiro.php?action=carregaItens","Erro","getRelatorioFinanceiro","tabela","../");
      }

      function imprime()
      {
        data_inicio = document.getElementById("data_inicio").value;
        data_final = document.getElementById("data_final").value;
        pg=document.getElementById("chkPorcentagemGarcom").checked;
        dinheiro=document.getElementById("chkDinheiro").checked;
        credito=document.getElementById("chkCredito").checked;
        debito=document.getElementById("chkDebito").checked;
        cliente=document.getElementById("chkCliente").checked;
        obs=document.getElementById("chkObs").checked;
        
        window.open("financeiro_print.php?data_inicio="+data_inicio+"&data_final="+data_final+"&pg="+pg+"&dinheiro="+dinheiro+"&credito="+credito+"&debito="+debito+"&cliente="+cliente+"&obs="+obs,"_blank");
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
            <a href="#" class="btn btn-default active"><div>Relatório Financeiro</div></a>
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
        <input id="chkPorcentagemGarcom" type="checkbox" data-toggle="toggle" data-on="% Garçom" data-off="% Garçom" onchange="filtraItens()" checked/>
      </label>
      <label class="checkbox-inline">
        <input id="chkDinheiro" type="checkbox" data-toggle="toggle" data-on="Dinheiro" data-off="Dinheiro" onchange="filtraItens()" checked/>
      </label>
      <label class="checkbox-inline">
        <input id="chkCredito" type="checkbox" data-toggle="toggle" data-on="Crédito" data-off="Crédito" onchange="filtraItens()" checked/>
      </label>
      <label class="checkbox-inline">
        <input id="chkDebito" type="checkbox" data-toggle="toggle" data-on="Débito" data-off="Débito" onchange="filtraItens()" checked/>
      </label>
      <label class="checkbox-inline">
        <input id="chkCliente" type="checkbox" data-toggle="toggle" data-on="Cliente" data-off="Cliente" onchange="filtraItens()" checked/>
      </label>
      <label class="checkbox-inline">
        <input id="chkObs" type="checkbox" data-toggle="toggle" data-on="Obs." data-off="Obs." onchange="filtraItens()" checked/>
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