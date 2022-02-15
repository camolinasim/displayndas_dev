<?php
header('Access-Control-Allow-Origin: *');
$dirasset = explode('/', $_SERVER['REQUEST_URI']); 
$dirasset = $dirasset[1];
$sitedir = "https://$_SERVER[HTTP_HOST]/$dirasset/assets_r";
// $directLink = "https://orspweb2.utep.edu/subktrace_dev/assets/Cascade";
?>

<footer>
<div class="container">
    <div class="col-md-3 footerLogo"><img alt="UTEP" class="img-responsive" src="<?php echo $sitedir;?>/images/UTEP-Footer.png" title="UTEP"/></div>
    <!-- /col-md-3 -->
    <div class="col-md-9 requiredLinks">
        <h2>THE UNIVERSITY OF TEXAS AT EL PASO</h2>
        <ul>
            <li><a href="http://admin.utep.edu/Default.aspx?tabid=59577" target="_blank">Web Accessibility</a></li>
            <li><a href="https://adminapps.utep.edu/emergencynotification/generic/" target="_blank">Campus Alerts</a></li>
            <li><a href="https://www.utep.edu/clery/" target="_blank">Clery Crime Statistics</a></li>
        </ul>
        <ul>
            <li><a href="http://admin.utep.edu/Default.aspx?tabid=73912" target="_blank">Employment</a></li>
            <li><a href="http://sao.fraud.state.tx.us/" target="_blank">Report Fraud</a></li>
            <li><a href="http://admin.utep.edu/Default.aspx?tabid=54275" target="_blank">Required Links</a></li>
        </ul>
        <ul>
            <li><a href="http://admin.utep.edu/Default.aspx?tabid=49976" target="_blank">State Reports</a></li>
            <li><a href="http://www.utsystem.edu/" target="_blank">UT System</a></li>
            <li><a href="http://utep.edu/feedback" target="_blank">Site Feedback</a></li>
        </ul>
        <div class="clearfix"></div>
        <p>500 West University Avenue | El Paso, TX 79968 | 915-747-5000</p>
    </div>
    <!-- /col-md-9 -->
</div>
<!-- /container -->
</footer>
</div>
<div class="full-screen modal fade" id="myModal" role="dialog">
<div class="modal-dialog">
    <div class="transparent modal-content text-center">
        <div class="modal-header">
            <button class="close" data-dismiss="modal" type="button">X</button>
        </div>
        <div class="modal-body">
            <iframe frameborder="0" height="400" width="645"></iframe>
        </div>
    </div>
</div>
</div>

<script src="<?php echo $sitedir;?>/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo $sitedir;?>/js/modernizr-2.8.3.min.js" type="text/javascript"></script>
<script src="<?php echo $sitedir;?>/js/jquery.sidr.js" type="text/javascript"></script>
<script src="<?php echo $sitedir;?>/js/iphone-inline-video.browser.js" type="text/javascript"></script>
<script src="<?php echo $sitedir;?>/js/carrousel-autoplay.js" type="text/javascript"></script>
<script src="<?php echo $sitedir;?>/js/main.js" type="text/javascript"></script>
<script src="<?php echo $sitedir;?>/js/carousel.js" type="text/javascript"></script>

<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js">
</script>
<script type="text/javascript" language="javascript" src="//cdn.datatables.net/buttons/1.3.1/js/buttons.flash.min.js">
</script>
<script type="text/javascript" language="javascript" src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js">
</script>
<script type="text/javascript" language="javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js">
</script>
<script type="text/javascript" language="javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js">
</script>
<script type="text/javascript" language="javascript" src="//cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js">
</script>
<script type="text/javascript" language="javascript" src="//cdn.datatables.net/buttons/1.3.1/js/buttons.print.min.js">
</script>
<!-- MARKS TO HIGHLIGHT DATATABLE SEARCH -->
<script type="text/javascript" language="javascript" src="https://cdn.jsdelivr.net/datatables.mark.js/2.0.0/datatables.mark.min.js">
</script>
<script type="text/javascript" language="javascript" src="https://cdn.jsdelivr.net/mark.js/8.6.0/jquery.mark.min.js">
</script>