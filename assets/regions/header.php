<?php
header('Access-Control-Allow-Origin: *');
$dirasset = explode('/', $_SERVER['REQUEST_URI']); 
$dirasset = $dirasset[1];
$sitedir = "https://$_SERVER[HTTP_HOST]/$dirasset/assets";
// $directLink = "https://orspweb2.utep.edu/subktrace_dev/assets/Cascade";
?>
<meta charset="utf-8"/>
<meta content="IE=edge" http-equiv="X-UA-Compatible"/>
<meta content="width=device-width, initial-scale=1" name="viewport"/>
    
<title>NDA Display</title>

<link href="https://cdn.utep.edu/images/favicon.ico" rel="icon" type="image/x-icon"/>

<!-- CSS -->
<link href="<?php echo $sitedir;?>/css/bootstrap.css" rel="stylesheet"/>
    <link href="<?php echo $sitedir;?>/css/styles.css" rel="stylesheet"/>
<link href="<?php echo $sitedir;?>/css/jquery.sidr.bare.css" rel="stylesheet"/>
<link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet">

<!-- Typography -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,800,700,600" rel="stylesheet" type="text/css"/>
<link href="https://cloud.typography.com/6793094/7122152/css/fonts.css" rel="stylesheet" type="text/css"/>

<!-- JS -->
<script src="<?php echo $sitedir;?>/js/jquery-2.1.1.min.js" type="text/javascript"></script>
<script src="<?php echo $sitedir;?>/js/jquery-ui.min.js" type="text/javascript"></script>
<script>/*Insert Google Analytics*/</script>


<!-- Datatables  -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.13/datatables.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.2/css/fixedHeader.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css">

<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.13/datatables.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/fixedheader/3.1.3/js/dataTables.fixedHeader.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.15/sorting/datetime-moment.js"></script>


<!--
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="//cdn.datatables.net/buttons/1.1.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript" src="//cdn.datatables.net/buttons/1.1.2/js/buttons.print.min.js"></script>
-->


<link href="<?php echo $sitedir;?>/css/styles.css" rel="stylesheet"/>

<!-- <link rel="stylesheet" href="./assets/stylesheets/main_v2.css"> -->
<script>/*Insert Google Analytics*/</script>
