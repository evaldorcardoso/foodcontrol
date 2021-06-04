<!-- 
 // Inspiration taken from Mike | Creative Mints
 // - Dribbble.com page -> http://drbl.in/ghSU
 
 Tried to keep it clean and documented. It's not absolutely perfect and I haven't tested it in many of the older browsers, 
 but I will try and tweak it when I see an issue or someone mentions it. Always love the work the designers over at Dribbble.com
 put together. I wanted to attempt to mimic their photoshop work and provide some fun widgets for you Bootstrappers.
 
 ** Brian Moeller
-->
<script type='text/javascript' src='../js/jquery-2.1.1.min.js'></script>
<script src="../js/bootstrap.js" type="text/javascript"></script>
<script src="../js/kit.js" type="text/javascript"></script>
<script src="../js/simpleWeather.min.js"></script><!-- Docs at http://simpleweatherjs.com -->
<script src="../js/Chart.min.js"></script><!-- Docs at http://www.chartjs.org -->
<link rel="stylesheet" href="../css/bootstrap.css">
<link rel="stylesheet" href="../css/kit.css">
<link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet">
<link rel="icon" type="image/png" href="../images/favicon.ico">
<?php include_once "../verificador/verificador.php"; ?>
<head>
   <title>FoodControl - Relatórios</title>
   <style type="text/css">
      .btn-outlined {
    border-radius: 0;
    -webkit-transition: all 0.3s;
       -moz-transition: all 0.3s;
            transition: all 0.3s;
}

.btn-outlined.btn-theme {
    background: #55BC75;
    color: #fff;
  border-color: #fff;
  width:200px;
}

.btn-outlined.btn-theme:hover,
.btn-outlined.btn-theme:active {
    color: #55BC75;
    background: #fff;
    border-color: #6f5499;
}

.btn-outlined.btn-black {
    background: none;
    color: #000000;
  border-color: #000000;
}

.btn-outlined.btn-black:hover,
.btn-outlined.btn-black:active {
    color: #FFF;
    background: #000000;
    border-color: #000000;
}

.btn-outlined.btn-white {
    background: none;
    color: #FFFFFF;
  border-color: #FFFFFF;
}

.btn-outlined.btn-white:hover,
.btn-outlined.btn-white:active {
    color: #6f5499;
    background: #FFFFFF;
    border-color: #FFFFFF;
}
   </style>
</head>


<div class="container">
<center><img class="img img-responsive" style="max-width:300px;margin-top:10px" src="../images/logo-foodcontrol.png"><hr></center>
  <div class="row">
        <div id="bc1" class="btn-group btn-breadcrumb">
            <a href="../index.php" class="btn btn-warning"><div>Início</div></a>
            <a href="#" class="btn btn-default active"><div>Visão Geral</div></a>
        </div>
        <button type="button" class="btn btn-success pull-right" onclick="location.reload()"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Atualizar</button>
   </div><br>     

   <?php
   $d = array();
   for($i = 0; $i < 14; $i++) 
   {
      $d[] = date("Y-m-d", strtotime('-'. $i .' days'));
   }

      echo '<script>
         var line_data = {
    labels: ["'.$d[0].'", "'.$d[1].'", "'.$d[2].'", "'.$d[3].'", "'.$d[4].'", "'.$d[5].'", "'.$d[6].'", "'.$d[7].'", "'.$d[8].'", "'.$d[9].'", "'.$d[10].'", "'.$d[11].'", "'.$d[12].'", "'.$d[13].'"],
    datasets: [
        {
            label: "My Second dataset",
            fillColor: "rgba(77, 175, 124,1)",
            strokeColor: "rgba(255,255,255,1)",
            pointColor: "rgba(255,255,255,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(151,187,205,1)",
            data: ['.$cClass->totalPedidosPorDia($d[0]).','.$cClass->totalPedidosPorDia($d[1]).','.$cClass->totalPedidosPorDia($d[2]).','.$cClass->totalPedidosPorDia($d[3]).','.$cClass->totalPedidosPorDia($d[4]).','.$cClass->totalPedidosPorDia($d[5]).','.$cClass->totalPedidosPorDia($d[6]).','.$cClass->totalPedidosPorDia($d[7]).','.$cClass->totalPedidosPorDia($d[8]).','.$cClass->totalPedidosPorDia($d[9]).','.$cClass->totalPedidosPorDia($d[10]).','.$cClass->totalPedidosPorDia($d[11]).','.$cClass->totalPedidosPorDia($d[12]).','.$cClass->totalPedidosPorDia($d[13]).']
        }
    ]
    };
      </script>';
   ?>

   <div class="row">
      <!-- COLUMN ONE -->
      <div class="col-sm-6 col-md-6">
         <!--
            ****** LINE CHART WIDGET *******
            -->    
         <div id="line-chart-widget" class="panel">
            <div class="panel-heading">
               <h4 class="text-uppercase"><strong>Vendas Diárias</strong>
                  <!--<span class="label pull-right">107.26 <i class="fa fa-plus"></i>0.23(0.10%)</span>-->
                  <br><small>Últimos 14 dias:</small>
               </h4>
            </div>
            <div class="panel-body">
               <canvas id="myLineChart"></canvas>
            </div>
            <div class="panel-footer">
               <div class="list-block">
                  <ul class="text-center legend">
                     <li>
                        <h3><?php echo $cClass->totalPedidosPorPeriodo($d[13],$d[0]);?></h3>
                        <?php $date = new DateTime($d[13]);
                              echo 'Pedidos desde<br>'.$date->format('d/m/Y');;?>
                     </li>
                     <!--<li>
                        <h3>28.44 B</h3>
                        Market Cap
                     </li>-->
                  </ul>
               </div>
               <!--<div class="chart-block clearfix">
                  <div class="pull-left">
                     Monthly Volume
                     <canvas id="myBarChart"></canvas>
                  </div>
                  <div class="pull-right">
                     Yearly Change<br>
                     <div class="change text-center"><i class="fa fa-plus"></i> 86.01</div>
                  </div>
               </div>-->
            </div>
         </div>
      </div>
      
      
      <!-- COLUMN TWO -->   
      <div class="col-sm-6 col-md-4">
         <!--
            ****** CHART WIDGET *******
            -->    
         <div id="pie-chart-widget" class="panel">
            <div class="panel-heading text-center">
               <h5 class="text-uppercase"><strong>Itens mais vendidos</strong></h5>
            </div>
            <div class="panel-body">
               <canvas id="myPieChart"></canvas>
            </div>
            <div class="panel-footer">
               <div class="list-block">
                  <ul class="text-center legend">
                     <?php
                     $result=$cClass->quantidadeVendidaPorCategoria();
                     $row1=mysqli_fetch_array($result);
                     $row2=mysqli_fetch_array($result);
                     $comida=(100*$row1['count'])/(($row1['count']+$row2['count']) == 0 ? 1 : ($row1['count']+$row2['count']));
                     $bebida=(100*$row2['count'])/(($row1['count']+$row2['count']) == 0 ? 1 : ($row1['count']+$row2['count']));
                     ?>
                     <li class="photo">
                        Comida
                        <h2><?php echo round($comida).'%';?></h2>
                     </li>
                     <li class="audio" style="margin-left: 1px;">
                        Bebida
                        <h2><?php echo round($bebida).'%';?></h2>
                     </li>
                  </ul>
                  <?php
                  echo '<script>
                  var pie_data = [
                  {
                     value: '.round($bebida).',
                     color: "#EAC85D",
                     highlight: "#f9d463",
                     label: "Bebida"
                 },
                 {
                     value: '.round($comida).',
                     color: "#E25331",
                     highlight: "#f45e3d",
                     label: "Comida"
                 }
                  ]
                  </script>'
                  ?>
               </div>
            </div>
         </div>
      </div>

      <!-- COLUMN THREE -->
      <div class="col-sm-6 col-md-2">
        <a href="financeiro.php" class="btn btn-outlined btn-theme" data-wow-delay="0.7s">Relatório de Pedidos</a><br><br>
        <a href="tele.php" class="btn btn-outlined btn-theme" data-wow-delay="0.7s">Relatório de Tele-Entregas</a><br><br>
        <a href="divida.php" class="btn btn-outlined btn-theme" data-wow-delay="0.7s">Relatório de Dívidas</a><br><br>
      </div>
   </div>
</div>
</div>