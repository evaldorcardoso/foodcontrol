<script type='text/javascript' src='js/jquery-2.1.1.min.js'></script>
<link rel="stylesheet" href="css/bootstrap.css"><!--REFERENCIA Á PÁGINA CONTENDO O ESTILO CSS -->
<script src="js/bootstrap.js" type="text/javascript"></script>
<script src="js/waitingfor.js" type="text/javascript"></script>
<script src="js/envia_dados.js" type="text/javascript"></script>
<script src="js/funcoes_gerais.js" type="text/javascript"></script>
<?php include_once "verificador.php"; ?>
<head>
    <title>FoodControl</title>
    <link rel="stylesheet" href="css/metro.css">
    <script src="js/metro.js" type="text/javascript"></script>
</head>
<style type="text/css">
      body{
        background-color: #690202;
      }

      p.credit {
        margin-top: -3%;
      }

      .user_box{
        background: #f32d27;
      }

</style>

<script type="text/javascript">

  setInterval(function(){ buscaTempo(2); }, 60000);
  
  function logout()
  {
      buscaDados("statusLogout","","get/getUsuario.php?action=logout","","true");
  }

  function buscaTempo(tipo)
  {
        var queryString="";
        if(tipo==1)
          buscaDadosBanco('statusTempo',queryString,'get/getMenu.php?action=tempo','Sem conexão','tempo_ativo','tempo_ativo','');
        if(tipo==2)
          buscaDadosBanco('statusTempoInativo',queryString,'get/getMenu.php?action=tempo_inativo','Sem conexão','tempo_inativo','tempo_inativo','');
  }

  function buscaFeed()
  {
    buscaDadosBanco('statusFeed',"",'get/getMenu.php?action=feed','Sem conexão','feed','feed','');
  }

  

</script>

<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
<body>
<div id="noty-holder"></div><!-- HERE IS WHERE THE NOTY WILL APPEAR-->
<?php
$dias=$cClass->verificaValidadeLicencaDias();
if($dias<=10)
{ 
  if($dias==0)
  {
    ?>
      <script>notificacao('Sua licença vai expirar hoje!'); </script>
    <?php }
  else
  {?>
      <script>notificacao('Sua licença vai expirar em <?php echo $dias;?> dias!'); </script>
  <?php } 
}?>
<center>
  <img class="img img-responsive" style="max-width:500px;margin-top:10px" src="images/logo-foodcontrol.png"></img>
  <span class="label label-danger pull-right" style="margin-right:440px"><?php echo 'v. '.$GLOBALS['versao'];?></span>
</center><br>
<div class="row">
  <a href="#" id="a_perfil">
    <div class="col-md-2 col-xs-2 col-md-offset-9 user_box" align="right">
      <h4 style="color:#fff">Olá <?php echo $_SESSION['login'];?>! <i class="fa fa-fw fa-sort-desc"></i></h4>
    </div>
  </a>
</div>
<div id="sair" class="row">
    <div class="col-md-2 col-xs-2 col-md-offset-9" align="right" style="margin-top:1px">
      <a href="#" onclick="logout()"><h4 style="color:#fff">Sair</h4></a>
      <div id="statusLogout"></div>
    </div>
</div>
<br><br>
<div class="container dynamicTile">
<div class="row">
    <div class="col-sm-2 col-xs-4">
    	<div id="tile1" class="tile"><!-- MODOS -->
         <div class="carousel slide" data-ride="carousel">
          <!-- Wrapper for slides -->
          <a id="tile-modos" href="#" class="metros">
          <div class="carousel-inner">
            <div class="item active">
               <img src="images/modos.png" class="img-responsive"/>
            </div>
          </div>
        </a>
        </div>
    	</div><!--MODOS -->
	  </div>

	  <div class="col-sm-2 col-xs-4">
		  <div id="tile2" class="tile">
         <div class="carousel slide" data-ride="carousel">
          <!-- Wrapper for slides -->
          <a id="tile-cadastros" class="metros" href="#">
          <div class="carousel-inner">
            <div class="item active">
              <img src="images/cadastros.png" class="img-responsive"/>
            </div>
          </div>
        </a>
        </div>
		  </div><!-- CADASTROS -->
	  </div>

    <div class="col-sm-2 col-xs-4">
      <div id="tile8" class="tile">
       
         <div class="carousel slide" data-ride="carousel">
          <!-- Wrapper for slides -->
          <div class="carousel-inner">
            <div class="item active">
               <img src="images/backup.png" class="img-responsive"/>
            </div>
            <div class="item">
               <h3 class="tilecaption">Backup</h3>
            </div>
            </div>
         </div>
         
      </div>
    </div>
	
    <div class="col-sm-2 col-xs-4">
		  <div id="tile3" class="tile">	 
        <div class="carousel slide" data-ride="carousel">
          <!-- Wrapper for slides -->
          <div class="carousel-inner">
            <div id="tempo_ativo" class="item active">
              <center><div id="statusTempo"></div></center>
              <?php
                include_once('classes/Ini.class.php');
                $config = new IniParser('config.ini' );
                if($config->getValue('previsao_tempo_feed'))
                { 
                  ?>
                  <script>buscaTempo(1);</script> 
                  <?php 
                }
                else
                {
                  $celcius = '';
                  $city=$config->getValue('local');
                  $image='01d';
                  $descricao='Desativado'; 
                  ?>
                  <h2 class="tilecaption"><?php echo $city;?></h2>
                  <h1 class="tilecaption"><?php if($celcius<>'') { echo round($celcius).'º';}?></h1>
                  <?php
                }
              ?>
              <!--<h2 class="tilecaption"><?php echo $city;?></h2>
              <h1 class="tilecaption"><?php if($celcius<>'') { echo round($celcius).'º';}?></h1>-->
            </div>
            <div id="tempo_inativo" class="item">
                <center><div id="statusTempoInativo"></div></center>
               <!--<img src="http://openweathermap.org/img/w/<?php echo $image;?>.png" class="img-responsive"/>
               <h4 class="tilecaption"><?php echo $descricao;?></h4>-->
            </div>
            </div>
         </div>
		  </div><!-- PREVISAO TEMPO -->
	  </div>

	  <div class="col-sm-2 col-xs-4">
		  <div id="tile4" class="tile">
        <div class="carousel slide" data-ride="carousel">
          <!-- Wrapper for slides -->
          <a href="relatorio/">
          <div class="carousel-inner">
            <div class="item active">
              <img src="images/relatorios.png" class="img-responsive"/>
            </div>
            <div class="item">
              <h1 class="tilecaption">Relatórios</h1>
            </div>
          </div>
          </a>
        </div>

		  </div><!-- RELATÓRIOS-->
	  </div>

    <div class="col-sm-2 col-xs-4">
  	  <div id="tile5" class="tile">  	 
        <div class="carousel slide" data-ride="carousel">
          <!-- Wrapper for slides -->
          <div class="carousel-inner"><a href="ajustes/">
            <div class="item active">
              <img src="images/ajustes.png" class="img-responsive"/>
            </div></a>
          </div>
        </div> 
  		</div><!-- AJUSTES -->
	  </div>

</div> <!-- /ROW-->

<div class="row">
    <div id="modos">
      <div class="col-sm-2 col-xs-4">
        <div class="tile">
         <div class="carousel slide" data-ride="carousel">
          <!-- Wrapper for slides -->
          <div class="carousel-inner"><a href="auxiliar/">
            <div class="item active">
              <img src="images/auxiliar.png" class="img-responsive"/>
            </div></a>
          </div>
          </div>
        </div><!-- AUXILIAR -->
      </div>

      <div class="col-sm-2 col-xs-4"><!--  CAIXA-->
        <div class="tile">
         <div class="carousel slide" data-ride="carousel">
          <!-- Wrapper for slides -->
          <div class="carousel-inner"><a href="caixa/">
            <div class="item active">
              <img src="images/caixa.png" class="img-responsive"/>
            </div></a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-2 col-xs-4">
        <div class="tile">
         <div class="carousel slide" data-ride="carousel">
          <!-- Wrapper for slides -->
          <div class="carousel-inner"><a href="cozinha/">
            <div class="item active">
              <img src="images/cozinha.png" class="img-responsive"/>
            </div></a>
            </div>
          </div>
        </div><!-- COZINHA -->
      </div>

      <div class="col-sm-2 col-xs-4">
        <div class="tile">
         <div class="carousel slide" data-ride="carousel">
          <!-- Wrapper for slides -->
          <div class="carousel-inner"><a href="garcom/">
            <div class="item active">
              <img src="images/garcom.png" class="img-responsive"/>
            </div></a>
            </div>
          </div>
        </div><!--  GARÇOM-->
      </div>

      <div class="col-sm-2 col-xs-4">
        <div class="tile">
         <div class="carousel slide" data-ride="carousel">
          <!-- Wrapper for slides -->
          <div class="carousel-inner"><a href="tele/">
            <div class="item active">
              <img src="images/tele-entrega.png" class="img-responsive"/>
            </div></a>
            </div>
          </div>
        </div><!--  TELE-ENTREGA-->
      </div>
    </div>

    <div id= "cadastros">
      <div class="col-sm-2 col-xs-4"><!-- CARDÁPIO -->
        <div class="tile">
         <div class="carousel slide" data-ride="carousel">
          <!-- Wrapper for slides -->
          <div class="carousel-inner"><a href="cadastro/cardapio.php">
            <div class="item active">
              <img src="images/cardapio.png" class="img-responsive"/>
            </div></a>
          </div>
          </div>
        </div>
      </div>

      <div class="col-sm-2 col-xs-4"><!-- CLIENTES -->
        <div class="tile">
         <div class="carousel slide" data-ride="carousel">
          <!-- Wrapper for slides -->
          <div class="carousel-inner"><a href="cadastro/cliente.php">
            <div class="item active">
              <img src="images/clientes.png" class="img-responsive"/>
            </div></a>
          </div>
          </div>
        </div>
      </div>

      <div class="col-sm-2 col-xs-4"><!-- CREDORES -->
        <div class="tile">
         <div class="carousel slide" data-ride="carousel">
          <!-- Wrapper for slides -->
          <div class="carousel-inner"><a href="cadastro/credor.php">
            <div class="item active">
              <img src="images/credores.png" class="img-responsive"/>
            </div></a>
          </div>
          </div>
        </div>
      </div>

      <div class="col-sm-2 col-xs-4"><!-- DIVIDAS -->
        <div class="tile">
         <div class="carousel slide" data-ride="carousel">
          <!-- Wrapper for slides -->
          <div class="carousel-inner"><a href="cadastro/divida.php">
            <div class="item active">
              <img src="images/dividas.png" class="img-responsive"/>
            </div></a>
          </div>
          </div>
        </div>
      </div>

      <div class="col-sm-2 col-xs-4"><!-- ESTOQUE -->
        <div class="tile">
         <div class="carousel slide" data-ride="carousel">
          <!-- Wrapper for slides -->
          <div class="carousel-inner"><a href="cadastro/estoque.php">
            <div class="item active">
              <img src="images/estoque.png" class="img-responsive"/>
            </div></a>
          </div>
          </div>
        </div>
      </div>

      <div class="col-sm-2 col-xs-4"><!-- MESAS -->
        <div class="tile">
         <div class="carousel slide" data-ride="carousel">
          <!-- Wrapper for slides -->
          <div class="carousel-inner"><a href="cadastro/mesa.php">
            <div class="item active">
              <img src="images/mesas.png" class="img-responsive"/>
            </div></a>
          </div>
          </div>
        </div>
      </div>

      <div class="col-sm-2 col-xs-4"><!-- USUARIOS -->
        <div class="tile">
         <div class="carousel slide" data-ride="carousel">
          <!-- Wrapper for slides -->
          <div class="carousel-inner"><a href="cadastro/usuario.php">
            <div class="item active">
              <img src="images/usuarios.png" class="img-responsive"/>
            </div></a>
          </div>
          </div>
        </div>
      </div>
    </div>
</div><!-- /ROW-->

<div class="row">
	<div class="col-sm-4 col-xs-8">
		<div id="tile7" class="tile">    	 
        <div class="carousel slide" data-ride="carousel">
          <!-- Wrapper for slides -->
          <div id="feed" class="carousel-inner">
            <center><div id="statusFeed"></div></center>
            <?php
            if(!$config->getValue('previsao_tempo_feed'))
            { 
              echo '<div class="item"><center><h3>Feed de notícias desativado</h3></center></div>';
            }
            ?>
          </div>
        </div>
		</div>
	</div>

	<div class="col-sm-2 col-xs-4"><!-- EVALDORC -->
      <div id="tile6" class="tile">
         <div class="carousel slide" data-ride="carousel">
          <!-- Wrapper for slides -->
          
          <div class="carousel-inner">
            <div class="item active">
              <img src="images/banner-200x200.png" class="img-responsive"/>
            </div>
            <div class="item">
              <img src="images/perfil.png" style="cursor:pointer" class="img-responsive" onclick="location.href='https://www.facebook.com/wpappsbyevaldorc'"/>
            </div>
            <div class="item" style="cursor:pointer" onclick="location.href='http://www.evaldorc.com.br'">
              <h3 class="tilecaption">evaldorc.com.br</h3>
            </div>
          </div>
        
        </div>
      </div>
  </div>

	<div class="col-sm-2 col-xs-4">
		<div id="tile9" class="tile">
    	 
          <div class="carousel slide" data-ride="carousel">
          <!-- Wrapper for slides -->
          <div class="carousel-inner"><a href="licenca.php">
            <div class="item active">
               <img src="images/licenca.png" class="img-responsive"/>
            </div></a>
            <div class="item">
               <h3 class="tilecaption">Licença</h3>
            </div>
          </div>
        </div>
         
		</div>
	</div>

	<div class="col-sm-4 col-xs-8">
		<div id="tile10" class="tile">
        <div class="carousel slide" data-ride="carousel">
          <!-- Wrapper for slides -->
          <div class="carousel-inner">
            <div class="item active">
              <h3 class="tilecaption"><a style="color:#fff" href="http://evaldorc.com.br/logs/foodcontrol.php?versao=<?php echo $GLOBALS['versao'];?>" target="_blank">Novidades desta versão<br><i class="fa fa-info fa-4x"></i></a><p><?php echo $GLOBALS['versao'];?></h3>
            </div>
          </div>
        </div>   
		</div>
	</div>

</div><!-- /ROW-->

<center><br><br>
  <p class="credit" style="color:#fff">Copyright © 2015 - Todos os direitos reservados</p>
  
</center>
</body>