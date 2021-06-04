<?php
		if(isset($_GET['action']))
		{
			switch ($_GET['action']) 
			{
				case 'tempo':
					include_once('../classes/Ini.class.php');
                	$config = new IniParser('../config.ini' );
					$jsonurl = "http://api.openweathermap.org/data/2.5/weather?q=".$config->getValue('local')."&lang=pt";
                  	
                  	$json = file_get_contents($jsonurl);
                  	$weather = json_decode($json);
                  	$kelvin = $weather->main->temp;
                  	$celcius = $kelvin - 273;
                  	$city=$weather->name;
                  	$image=$weather->weather[0]->icon;
                  	$descricao=$weather->weather[0]->description;
					echo '<center><div id="statusTempo"></div></center>
					<img src="http://openweathermap.org/img/w/'.$image.'.png" />
						<h3 class="tilecaptiontime">'.$city.'</h3>
              			<br><h1 class="tilecaptiontime">';
              		if($celcius<>'') { echo round($celcius).'º';}
              		echo '</h1>
              		<h4 class="tilecaptiontime">'.$descricao.'</h4>';
					break;
				case 'tempo_inativo':
					echo 
               				'<center><div id="statusTempoInativo"></div></center>
               				<h2 class="tilecaption">'.date("d/m/Y").'</h2>
              				<h3 class="tilecaption">'.date("H:i:s").'</h3>';
               		break;
               	case 'feed':
               		try
               		{
               			include_once ('../classes/simple_html_dom.php');
		            	$rss = simplexml_load_file('http://g1.globo.com/dynamo/tecnologia/rss2.xml');
		          		echo '<center><div id="statusFeed"></div></center>
		          		<div class="item active">
               					<center><img src="http://g1.globo.com/Portal/globonoticias/img/tit_header_rss.jpg" class="img-responsive"/></center>
            				</div>';
            				if($rss)
            				{
			            foreach ($rss->channel->item as $item) 
			            { 
			                echo '<div class="item">';
			                echo '<center><h4>'.$item->title.'</h4>';
			                $html = str_get_html($item->description);
			                foreach($html->find('img') as $element) {// Find all images 
			                  echo '<a href="'.$item->link.'" target="_blank"><img src="'.$element->src .'"/></a><br></center>';
			                } 
			                echo '</div>';
			            }
			        }
			        else
			        	echo '<div class="item active">
               					<center>Não foi possível obter os dados!</center>
            				</div>';
			        }
			        catch(exception $ex)
			        {
			        	echo '<div class="item active">
               					<center>Não foi possível obter os dados!</center>
            				</div>';
			        }
               		break;
				default:
					# code...
					break;
			}
		}
		else
		{
			?>
			
				<script>
					setTimeout(function () { // wait 3 seconds and reload
		        	location.href="../index.php";
		        	}, 2000);
		        
				</script><!-- SCRIPT PARA REDIRECIONAR AUTOMATICAMENTE PARA OUTRA PÁGINA  -->
			<?php
		}
?>
