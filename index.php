<link rel="icon" type="image/png" href="images/favicon.ico">
<?php    
    include_once('classes/Ini.class.php');
    $config = new IniParser('config.ini' );
    $tipo=$config->getValue('type');
    switch ($tipo) 
    {
        case 'normal':
            include_once ('_normal.php');
            break;
        case 'metro':
            include_once ('_metro.php');
            break;
        case 'normal_side':
            include_once ('_normal_side.php');
            break;
        case '':
            include_once ('_first_time.php');
            break;
        default:
            # code...
            break;
    }
    ?>