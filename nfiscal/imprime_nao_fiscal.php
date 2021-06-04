<?php
        
    /*
	 * Gerar um arquivo para imprimir na impressora Bematech
	 */

        global $n_colunas; // 40 colunas por linha
        
        /**
         * Adiciona a quantidade necessaria de espaços no inicio 
         * da string informada para deixa-la centralizada na tela
         * 
         * @global int $n_colunas Numero maximo de caracteres aceitos
         * @param string $info String a ser centralizada
         * @return string
         */
        function centraliza($info)
        {
            //global $n_colunas;
            $n_colunas=40;
            $aux = strlen($info);
            
            if ($aux < $n_colunas) {
                // calcula quantos espaços devem ser adicionados
                // antes da string para deixa-la centralizada
                $espacos = floor(($n_colunas - $aux) / 2);
                
                $espaco = '';
                for ($i = 0; $i < $espacos; $i++){
                    $espaco .= ' ';
                }
                
                // retorna a string com os espaços necessários para centraliza-la
                return $espaco.$info;
                
            } else {
                // se for maior ou igual ao número de colunas
                // retorna a string cortada com o número máximo de colunas.
                return substr($info, 0, $n_colunas);
            }
            
        }
        
        /**
         * Adiciona a quantidade de espaços informados na String
         * passada na possição informada.
         * 
         * Se a string informada for maior que a quantidade de posições
         * informada, então corta a string para ela ter a quantidade
         * de caracteres exata das posições.
         * 
         * @param string $string String a ter os espaços adicionados.
         * @param int $posicoes Qtde de posições da coluna
         * @param string $onde Onde será adicionar os espaços. I (inicio) ou F (final).
         * @return string
         */
        function addEspacos($string, $posicoes, $onde)
        {
            
            $aux = strlen($string);
            
            if ($aux >= $posicoes)
                return substr ($string, 0, $posicoes);
            
            $dif = $posicoes - $aux;
            
            $espacos = '';
            
            for($i = 0; $i < $dif; $i++) {
                $espacos .= ' ';
            }
            
            if ($onde === 'I')
                return $espacos.$string;
            else
                return $string.$espacos;
            
        }
        

        function imprime_pedido($id_pedido)
        {
            $n_colunas=40;
            $txt_cabecalho = array();
            $txt_cabecalho2 = array();
            $txt_cabecalho3 = array();
            $txt_itens = array();
            $txt_valor_total = '';
            $txt_rodape = array();
            $tot_itens = 0;
            $responsavel="";
            $data="";
            $garcom="";
            $obs="";
            $mesa="";

            include_once('../classes/Ini.class.php');
            $config = new IniParser( '../config.ini' );
            include_once '../classes/crudClass.php';
            $cClass = new crudClass();

            
            $txt_itens[] = array('PRODUTO', 'QTD', 'V. UN', 'TOTAL');
            
            $cClass->listarItensPedidoCaixaNovo($id_pedido);
            if(0<>mysqli_num_rows($cClass->getconsulta()))
            {
                while($array_ = mysqli_fetch_array($cClass->getconsulta()))
                {
                    $total_item=$array_['quantidade']*$array_['valor'];
                    $total_item=number_format($total_item,2, '.', '');
                    $txt_itens[] = array(utf8_decode($array_['descricao']),$array_['quantidade'],$array_['valor'],$total_item);
                    $tot_itens+=$total_item;
                    if($responsavel=='')
                        $responsavel=utf8_decode(html_entity_decode($array_['nome']));
                    if($data=='')
                        $data=$array_['data'];
                    if($garcom=='')
                        $garcom=$array_['garcom'];
                    if($obs=='')
                        $obs=utf8_decode(html_entity_decode($array_['obs']));
                    if($mesa=='')
                        $mesa=$array_['mesa'];
                }
            }
            $timestamp=strtotime($data);
            $data=date("d/m/Y",$timestamp);
            
            $tot_itens=number_format($tot_itens, 2, '.', '');
            $aux_valor_total = 'Sub-total: R$ '.$tot_itens;
            
            // calcula o total de espaços que deve ser adicionado antes do "Sub-total" para alinhado a esquerda
            $total_espacos = $n_colunas - strlen($aux_valor_total);
            
            $espacos = '';
            
            for($i = 0; $i < $total_espacos; $i++){
                $espacos .= ' ';
            }
            
            $txt_cabecalho[] = utf8_decode($config->getValue('razao_social')); 
            //$txt_cabecalho[] = $config->getValue('CNPJ');
            $txt_cabecalho2[]="CNPJ: ".$config->getValue('CNPJ');
            //$txt_cabecalho[] = ' '; // força pular uma linha
            $txt_cabecalho2[] = '---------------------------------------';
            $txt_cabecalho2[]="COD. DO PEDIDO: ".$id_pedido;
            $txt_cabecalho2[]="CLIENTE: ".$responsavel;
            $txt_cabecalho2[]="DATA: ".$data;
            $txt_cabecalho2[]=utf8_decode("GARÇOM: ").$garcom;
            $txt_cabecalho2[]="MESA: ".$mesa;
            
            $txt_cabecalho2[] = ' '; // força pular uma linha
            $txt_cabecalho3[] = utf8_decode('CUPOM NÃO FISCAL');
            $txt_cabecalho3[] = ' '; // força pular uma linha entre o cabeçalho e os itens

            $txt_valor_total = $espacos.$aux_valor_total;
            $txt_rodape[] = ' '; // força pular uma linha
            if($config->getValue('imprimir_cupom_obs'))
                $txt_rodape[] = '*Obs.:'.utf8_decode(html_entity_decode($obs));
            $txt_rodape[] = utf8_decode('       * Não é documento fiscal *       ');
            $txt_rodape[] = '________________________________________';
            $txt_rodape[] = '         Sistema - FoodControl          ';
            $txt_rodape[] = '________________________________________';
            
            // centraliza todas as posições do array $txt_cabecalho
            $cabecalho = array_map("centraliza", $txt_cabecalho);
            $cabecalho3 = array_map("centraliza", $txt_cabecalho3);
            /* para cada linha de item (array) existente no array $txt_itens,
             * adiciona cada posição da linha em um novo array $itens
             * fazendo a formatação dos espaçamentos entre cada coluna
             * da linha através da função "addEspacos"
             */
            foreach ($txt_itens as $item) 
            {
                    /*
                 * Cod. => máximo de 5 colunas
                 * Produto => máximo de 11 colunas
                 * Env. => máximo de 6 colunas
                 * Qtd => máximo de 4 colunas
                 * V. UN => máximo de 7 colunas
                 * Total => máximo de 7 colunas
                 *
                 * $itens[] = 'Cod. Produto      Env. Qtd  V. UN  Total'
                 */
                $itens[] = addEspacos($item[0], 22, 'F')
                        . addEspacos($item[1], 4, 'F')
                        . addEspacos($item[2], 7, 'I')
                        . addEspacos($item[3], 7, 'I')
                ;
            }
            
            /* concatena o cabelhaço, os itens, o sub-total e rodapé
             * adicionando uma quebra de linha "\r\n" ao final de cada
             * item dos arrays $cabecalho, $itens, $txt_rodape
             */
            $txt = implode("\r\n", $cabecalho)
                . "\r\n"
                . implode("\r\n", $txt_cabecalho2)
                . "\r\n"
                . implode("\r\n", $cabecalho3)
                . "\r\n"
                . implode("\r\n", $itens)
                . "\r\n\n"
                . $txt_valor_total // Sub-total
                . "\r\n\r\n"
                . implode("\r\n", $txt_rodape);
            
            if ( $handle = printer_open($config->getValue('printer')) ){ // impressora configurada no windows
                printer_set_option($handle, PRINTER_MODE, "RAW");
                printer_set_option($handle, PRINTER_COPIES,$config->getValue('copias_cupom_final'));
                printer_set_option($handle, PRINTER_PAPER_FORMAT,"PRINTER_FORMAT_CUSTOM");
                //printer_set_option($handle, PRINTER_PAPER_LENGTH, 300);
                printer_set_option($handle, PRINTER_PAPER_WIDTH, 80);
 
                $txt=utf8_encode($txt);
                $tr = strtr($txt,
                    array (                     
                          'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A',
                          'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E',
                          'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ð' => 'D', 'Ñ' => 'N',
                          'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O',
                          'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Ŕ' => 'R',
                          'Þ' => 's', 'ß' => 'B', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a',
                          'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e',
                          'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
                          'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o',
                          'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y',
                          'þ' => 'b', 'ÿ' => 'y', 'ŕ' => 'r'
                        )
                    );

                if(printer_write($handle,$tr))
                {
                  printer_close($handle);
                  echo 'OK';  
                }
                else
                {
                  printer_close($handle);
                  echo 'Não foi possível imprimir';
                }
            } 
            else echo 'Não foi possível encontrar a impressora: '. $config->getValue('printer');
        }

        //faz a impressão do cupom para ser entregue na copa ou na cozinha
        function imprime_pedido_categoria($id_pedido,$categoria)
        {
            $n_colunas=40;
            $txt_cabecalho = array();
            $txt_cabecalho2 = array();
            $txt_cabecalho3 = array();
            $txt_itens = array();
            $txt_rodape = array();
            $tot_itens = 0;
            $responsavel="";
            $data="";
            $garcom="";
            $mesa="";
            //$items=array();

            include_once('../classes/Ini.class.php');
            $config = new IniParser( '../config.ini' );
            include_once '../classes/crudClass.php';
            $cClass = new crudClass();

            
            $txt_itens[] = array('QTD','PRODUTO');
            
            $cClass->listarItensPedidoCupomEntregar($id_pedido,$categoria);
            if(0<>mysqli_num_rows($cClass->getconsulta()))
            {
                while($array_ = mysqli_fetch_array($cClass->getconsulta()))
                {
                    $txt_itens[] = array($array_['quantidade'].'x',$array_['descricao']);
                    if($responsavel=='')
                        $responsavel=utf8_decode(html_entity_decode($array_['cliente']));
                    if($responsavel=='')
                        $responsavel=utf8_decode(html_entity_decode($array_['nome']));
                    if($data=='')
                        $data=$array_['data'];
                    if($garcom=='')
                        $garcom=$array_['garcom'];
                    if($mesa=='')
                        $mesa=$array_['mesa'];
                    $items[]=$array_['pic'];
                }
            }
            else
            {
              echo 'As comandas para este tipo de item já foram impressas';
              return;
            }
            if(count($txt_itens)==0)
            {
              echo 'As comandas para este tipo de item já foram impressas';
              return;
            }
            $timestamp=strtotime($data);
            $data=date("d/m/Y",$timestamp);
            
            $espacos = '';
            
            $txt_cabecalho[] = utf8_decode($config->getValue('razao_social')); 
            //$txt_cabecalho[] = $config->getValue('CNPJ');
            //$txt_cabecalho2[]="CNPJ: ".$config->getValue('CNPJ');
            //$txt_cabecalho[] = ' '; // força pular uma linha
            $txt_cabecalho2[] = '---------------------------------------';
            $txt_cabecalho2[]="COD. DO PEDIDO: ".$id_pedido;
            $txt_cabecalho2[]="CLIENTE: ".$responsavel;
            $txt_cabecalho2[]="DATA: ".$data." - ".date("H:i",time());
            $txt_cabecalho2[]=utf8_decode("GARÇOM: ").$garcom;
            $txt_cabecalho2[]="MESA: ".$mesa;
            
            $txt_cabecalho2[] = ' '; // força pular uma linha
            if($categoria=='1')
              $txt_cabecalho3[] = utf8_decode('COMANDA DE COMIDA');
            if($categoria=='2')
              $txt_cabecalho3[] = utf8_decode('COMANDA DE BEBIDAS');
            $txt_cabecalho3[] = ' '; // força pular uma linha entre o cabeçalho e os itens

            
            $txt_rodape[] = ' '; // força pular uma linha
            //$txt_rodape[] = utf8_decode('       * Não é documento fiscal *       ');
            $txt_rodape[] = '________________________________________';
            $txt_rodape[] = '         Sistema - FoodControl          ';
            $txt_rodape[] = '________________________________________';
            
            // centraliza todas as posições do array $txt_cabecalho
            $cabecalho = array_map("centraliza", $txt_cabecalho);
            $cabecalho3 = array_map("centraliza", $txt_cabecalho3);
            /* para cada linha de item (array) existente no array $txt_itens,
             * adiciona cada posição da linha em um novo array $itens
             * fazendo a formatação dos espaçamentos entre cada coluna
             * da linha através da função "addEspacos"
             */
            foreach ($txt_itens as $item) 
            {
                    /*
                 * Cod. => máximo de 5 colunas
                 * Produto => máximo de 11 colunas
                 * Env. => máximo de 6 colunas
                 * Qtd => máximo de 4 colunas
                 * V. UN => máximo de 7 colunas
                 * Total => máximo de 7 colunas
                 *
                 * $itens[] = 'Cod. Produto      Env. Qtd  V. UN  Total'
                 */
                $itens[] = addEspacos($item[0], 4, 'F')
                        . addEspacos($item[1], 30, 'F')
                ;
            }
            
            /* concatena o cabelhaço, os itens, o sub-total e rodapé
             * adicionando uma quebra de linha "\r\n" ao final de cada
             * item dos arrays $cabecalho, $itens, $txt_rodape
             */
            $txt = implode("\r\n", $cabecalho)
                . "\r\n"
                . implode("\r\n", $txt_cabecalho2)
                . "\r\n"
                . implode("\r\n", $cabecalho3)
                . "\r\n"
                . implode("\r\n", $itens)
                . "\r\n\n"
                . "\r\n\r\n"
                . implode("\r\n", $txt_rodape);
            
            if($categoria=='1')
              $printer=$config->getValue('printer_cozinha');
            else
            {
              if($categoria=='2')
                $printer=$config->getValue('printer_copa');
            }

            if ($handle = printer_open($printer)){ // impressora configurada no windows
                printer_set_option($handle, PRINTER_MODE, "RAW");
                //printer_set_option($handle, PRINTER_COPIES,$config->getValue('copias_cupom_final'));
                printer_set_option($handle, PRINTER_PAPER_FORMAT,"PRINTER_FORMAT_CUSTOM");
                printer_set_option($handle, PRINTER_PAPER_WIDTH, 80);
                //echo html_entity_decode($txt);
                //$txt=utf8_decode($txt);
                //$txt=html_entity_decode($txt);
                $txt=utf8_encode($txt);
                $tr = strtr($txt,
                    array (                     
                          'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A',
                          'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E',
                          'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ð' => 'D', 'Ñ' => 'N',
                          'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O',
                          'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Ŕ' => 'R',
                          'Þ' => 's', 'ß' => 'B', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a',
                          'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e',
                          'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
                          'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o',
                          'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y',
                          'þ' => 'b', 'ÿ' => 'y', 'ŕ' => 'r'
                        )
                    );
                //echo $tr;
                if(printer_write($handle,$tr))
                {
                  printer_close($handle);
                  //echo 'OK';
                  
                  $quantidade='';//quantidade a ser reduzida no estoque
                  if($cClass -> entregaItensPorCategoria($id_pedido,$categoria))
                  {
                    //echo 'vou atualizar'.count($items).' no estoque.';
                    for ($i=0; $i < count($items); $i++)
                    {
                      $detalhes=$cClass->pesquisarQuantidadeItem($items[$i]);
                      //echo $detalhes['quantidadeVenda'].'-'.$quantEntregue;
                      if($detalhes['formaQuantidade']==$detalhes['formaVenda'])
                        $quantidade=$detalhes['quantidade']*$detalhes['quantidadeVenda'];
                      elseif(($detalhes['formaQuantidade']=="l")&&($detalhes['formaVenda']=="ml")) 
                        $quantidade=(($detalhes['quantidade']*$detalhes['quantidadeVenda'])/10)/100;
                      elseif(($detalhes['formaQuantidade']=="ml")&&($detalhes['formaVenda']=="l"))
                        $quantidade=(($detalhes['quantidade']*$detalhes['quantidadeVenda'])*10)*100;
                      else
                        echo 'Não foi possível atualizar a quantidade no estoque, verifique as formas de quantidade e venda!';

                      //echo $quantidade;
                      if($quantidade<>'')
                      {
                        //echo 'quantidade='.$quantidade;
                        $quantidade=$detalhes['quantEstoque'] - $quantidade;
                        $campos = array('id' => $detalhes['id'],'quantidade' => $quantidade);
                        if($cClass->acaoCrud($campos,'produto_estoque','update','id',$detalhes['id']))
                        {
                          
                        }
                        else
                          echo 'Não foi possível atualizar a quantidade no estoque';
                      }
                    }
                    echo 'OK';    
                  }
                  else
                    echo 'erro';
                    
                }
                else
                {
                  printer_close($handle);
                  echo 'Não foi possível imprimir';
                }
            } 
            else echo 'Não foi possível encontrar a impressora: '. $config->getValue('printer');
        }  

        //faz a impressão do cupom para ser entregue na copa ou na cozinha
        function imprime_numero_pedido($id_pedido)
        {
            $n_colunas=40;
            $txt_cabecalho = array();
            $txt_cabecalho2 = array();
            $txt_cabecalho3 = array();
            $itens=array();
            $txt_rodape = array();
            $data="";
            $garcom="";

            include_once('../classes/Ini.class.php');
            $config = new IniParser( '../config.ini' );
            include_once '../classes/crudClass.php';
            $cClass = new crudClass();

            $timestamp=strtotime($data);
            $data=date("d/m/Y",$timestamp);
            
            $espacos = '';
            $txt_itens[]=$id_pedido;
            $txt_cabecalho[] = utf8_decode($config->getValue('razao_social')); 
            //$txt_cabecalho[] = $config->getValue('CNPJ');
            //$txt_cabecalho2[]="CNPJ: ".$config->getValue('CNPJ');
            //$txt_cabecalho[] = ' '; // força pular uma linha
            $txt_cabecalho2[] = '---------------------------------------';
            $txt_cabecalho2[]="COD. DO PEDIDO: ".$id_pedido;
            $txt_cabecalho2[]="DATA: ".$data." - ".date("H:i",time());
            $txt_cabecalho2[]=utf8_decode("GARÇOM: ").$garcom;
            
            $txt_cabecalho2[] = ' '; // força pular uma linha
            $txt_cabecalho3[] = ' '; // força pular uma linha entre o cabeçalho e os itens

            
            $txt_rodape[] = ' '; // força pular uma linha
            //$txt_rodape[] = utf8_decode('       * Não é documento fiscal *       ');
            $txt_rodape[] = '________________________________________';
            $txt_rodape[] = '         Sistema - FoodControl          ';
            $txt_rodape[] = '________________________________________';
            
            // centraliza todas as posições do array $txt_cabecalho
            $cabecalho = array_map("centraliza", $txt_cabecalho);
            $cabecalho3 = array_map("centraliza", $txt_cabecalho3);
            /* para cada linha de item (array) existente no array $txt_itens,
             * adiciona cada posição da linha em um novo array $itens
             * fazendo a formatação dos espaçamentos entre cada coluna
             * da linha através da função "addEspacos"
             */
            
            /* concatena o cabelhaço, os itens, o sub-total e rodapé
             * adicionando uma quebra de linha "\r\n" ao final de cada
             * item dos arrays $cabecalho, $itens, $txt_rodape
             */
            $txt = implode("\r\n", $cabecalho)
                . "\r\n"
                . implode("\r\n", $txt_cabecalho2)
                . "\r\n"
                . implode("\r\n", $cabecalho3)
                . "\r\n"
                . implode("\r\n", $itens)
                . "\r\n\n"
                . "\r\n\r\n"
                . implode("\r\n", $txt_rodape);
            
              $printer=$config->getValue('printer');

            if ($handle = printer_open($printer)){ // impressora configurada no windows
                //printer_set_option($handle, PRINTER_MODE, "RAW");
                //printer_set_option($handle, PRINTER_PAPER_FORMAT,"PRINTER_FORMAT_CUSTOM");
                //printer_set_option($handle, PRINTER_PAPER_WIDTH, 80);
                $font=printer_create_font('Arial', 88,48, 200, false, false, false, 1);
                printer_select_font($handle, $font);
                $txt=utf8_encode($txt);
                $tr = strtr($txt,
                    array (                     
                          'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A',
                          'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E',
                          'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ð' => 'D', 'Ñ' => 'N',
                          'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O',
                          'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Ŕ' => 'R',
                          'Þ' => 's', 'ß' => 'B', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a',
                          'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e',
                          'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
                          'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o',
                          'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y',
                          'þ' => 'b', 'ÿ' => 'y', 'ŕ' => 'r'
                        )
                    );
                //echo $tr;
                printer_start_doc($handle, "My Document");
                printer_start_page($handle);
                printer_draw_text($handle, implode($txt_cabecalho), 200, 10);
                printer_draw_text($handle, 'Cartao de Pedido', 200, 200);

                $font2=printer_create_font('Arial', 500,300, 300, false, false, false, 1);
                printer_select_font($handle, $font2);
                printer_draw_text($handle, implode($txt_itens), 500, 500);
                //if(printer_write($handle,$tr))
                //{
                  printer_end_page($handle);
                  printer_end_doc($handle);
                  printer_close($handle);
                  print_r(var_dump(printer_list(PRINTER_ENUM_LOCAL)));
                  echo 'OK';
                //}
                //else
                  //echo 'erro';
                    
                }
                else
                {
                  printer_close($handle);
                  echo 'Não foi possível imprimir';
                }
        }       
?>