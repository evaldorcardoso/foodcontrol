<?php 
$texto = 'TEXTO PARA IMPRIMIR'; // texto que será impresso

if ( $handle = printer_open( "CutePDF Writer" ) ){ // impressora configurada no windows
 //printer_set_option($handle, PRINTER_MODE, "RAW");
 printer_write($handle, $texto );
 printer_close($handle);
} else echo 'Não foi possível abrir a impressora';
?>