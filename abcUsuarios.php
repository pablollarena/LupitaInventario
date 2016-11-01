<?php
/**
 * Created by PhpStorm.
 * User: PLLARENA
 * Date: 31/10/2016
 * Time: 03:02 PM
 */
include_once ("Class/Usuarios.php");
session_start();
$sErr = "";
$oUser = new Usuarios();
$oUsuario = new Usuarios();
$sNom = "";
$sErr2 = "";
$sRuta = "abcUsuarios.php";
$bLlave = false;
$bCampo = false;
$sOp = "";
$sMensaje = "";
    if(isset($_SESSION['sUser']) && !empty($_SESSION['sUser'])){
        $oUser = $_SESSION['sUser'];
        $oUser->buscarDatosUsuario();
        $sNom = $oUser->getUsuario();
        $sOp = $_POST['txtOp'];

        if($sOp != 'a'){
            $oUsuario->setIdUsuario($_POST['txtUser']);
            try{
                $oUsuario->buscarDatosUsuario();
            }catch (Exception $e){
                error_log($e->getFile() . " " . $e->getLine() . " " . $e->getMessage(),0);
                //$sErr2 = "Error en base de datos, comunicarse con el administrador";
            }
        }

        if($sOp == 'a'){
            $bCampo = true;
            $bLlave = true;
            $sMensaje = "Agregar";
        }else if($sOp == 'm'){
            $bCampo = true;
            $sMensaje = "Modificar";
        }else{
            $sMensaje = "Eliminar";
        }

    }else{
        $sErr = "Error, faltan datos de sesión";
    }

    if($sErr != ""){
        header("Location: error.php?sError=".$sErr);
    }else if($sErr2 != ""){
        header("Location: errorProceso.php?sError=".$sErr."&sRuta?=".$sRuta);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INVENTARIO </title>

    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="css/local.css" />

    <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>

    <!-- you need to include the shieldui css and js assets in order for the charts to work -->
    <link rel="stylesheet" type="text/css" href="http://www.shieldui.com/shared/components/latest/css/light-bootstrap/all.min.css" />
    <link id="gridcss" rel="stylesheet" type="text/css" href="http://www.shieldui.com/shared/components/latest/css/dark-bootstrap/all.min.css" />

    <script type="text/javascript" src="http://www.shieldui.com/shared/components/latest/js/shieldui-all.min.js"></script>
    <script type="text/javascript" src="http://www.prepbootstrap.com/Content/js/gridData.js"></script>

    <link href="vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

</head>
<body>
<div id="wrapper">
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="panelAdmin.php">Bienvenido - <?php echo $sNom;?></a>
        </div>
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul id="active" class="nav navbar-nav side-nav">
                <li class="selected"><a href="panelAdmin.php"><i class="fa fa-bullseye"></i> Principal</a></li>
                <li><a href="controlUsuarios.php"><i class="fa fa-child"></i> Usuarios</a></li>
                <li><a href="blog.html"><i class="fa fa-desktop"></i> Equipos</a></li>
                <li><a href="index.html"><i class="fa fa-archive"></i> Departamentos</a></li>
                <li><a href="register.html"><i class="fa fa-file-pdf-o"></i> Reportes</a></li>
                <li><a href="timeline.html"><i class="fa fa-terminal"></i> Software</a></li>
                <li><a href="forms.html"><i class="fa fa-book"></i> Empleados</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right navbar-user">
                <li class="dropdown user-dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $sNom;?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="logout.php"><i class="fa fa-power-off"></i> Log Out</a></li>

                    </ul>
                </li>
                <li class="divider-vertical"></li>
            </ul>
        </div>
    </nav>

    <div id="page-wrapper">
        <form class="form-horizontal form-label-left" id="frmusuarios" action="Controladores/accionUsuarios.php" method="post">
            <input type="hidden" name="txtUser" value="<?php echo($sOp == 'a' ? '' : $oUsuario->getIdUsuario());?>">
            <input type="hidden" name="txtOp" value="<?php echo $sOp;?>">
            <h2><span class="section">CONTROL DE USUARIOS</span></h2>
            <?php
                if($sOp != 'a'){
                    ?>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="iduser">ID USUARIO
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="iduser" class="form-control col-md-7 col-xs-12" name="iduser" type="text" disabled value="<?php echo $oUser->getIdUsuario();?>">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="txtNombre">NOMBRE DE USUARIO
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="txtNombre" name="txtNombre"  class="form-control col-md-7 col-xs-12"
                            value="<?php echo($bLlave == true ? '' : $oUsuario->getUsuario());?>" <?php echo($sOp == 'm' ? 'required' : '');?> <?php echo($sOp == 'm' ? '' : 'disabled');?> >
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="txtPass1">PASSWORD (OPCIONAL)
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="password" id="txtPass1" name="txtPass1"  class="form-control col-md-7 col-xs-12" <?php echo ($sOp == 'e' ? 'disabled' : '');?>>
                        </div>
                    </div>
            <?php
                }else{
                    ?>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="txtNombre">NOMBRE DE USUARIO <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="txtNombre" name="txtNombre" required class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="txtPass">PASSWORD <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="password" id="txtPass" name="txtPass" required class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
            <?php
                }
            ?>

            <input type="submit" value="<?php echo $sMensaje;?>" class="btn btn-primary">
        </form>


    </div>
</div>
<!-- /#wrapper -->

<script type="text/javascript">
    jQuery(function ($) {
        var performance = [12, 43, 34, 22, 12, 33, 4, 17, 22, 34, 54, 67],
            visits = [123, 323, 443, 32],
            traffic = [
                {
                    Source: "Direct", Amount: 323, Change: 53, Percent: 23, Target: 600
                },
                {
                    Source: "Refer", Amount: 345, Change: 34, Percent: 45, Target: 567
                },
                {
                    Source: "Social", Amount: 567, Change: 67, Percent: 23, Target: 456
                },
                {
                    Source: "Search", Amount: 234, Change: 23, Percent: 56, Target: 890
                },
                {
                    Source: "Internal", Amount: 111, Change: 78, Percent: 12, Target: 345
                }];


        $("#shieldui-chart1").shieldChart({
            theme: "dark",

            primaryHeader: {
                text: "Visitors"
            },
            exportOptions: {
                image: false,
                print: false
            },
            dataSeries: [{
                seriesType: "area",
                collectionAlias: "Q Data",
                data: performance
            }]
        });

        $("#shieldui-chart2").shieldChart({
            theme: "dark",
            primaryHeader: {
                text: "Traffic Per week"
            },
            exportOptions: {
                image: false,
                print: false
            },
            dataSeries: [{
                seriesType: "pie",
                collectionAlias: "traffic",
                data: visits
            }]
        });

        $("#shieldui-grid1").shieldGrid({
            dataSource: {
                data: traffic
            },
            sorting: {
                multiple: true
            },
            rowHover: false,
            paging: false,
            columns: [
                { field: "Source", width: "170px", title: "Source" },
                { field: "Amount", title: "Amount" },
                { field: "Percent", title: "Percent", format: "{0} %" },
                { field: "Target", title: "Target" },
            ]
        });
    });
</script>

<!-- Datatables -->
<script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
<script src="vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
<script src="vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
<script src="vendors/datatables.net-scroller/js/datatables.scroller.min.js"></script>
<script src="vendors/jszip/dist/jszip.min.js"></script>
<script src="vendors/pdfmake/build/pdfmake.min.js"></script>
<script src="vendors/pdfmake/build/vfs_fonts.js"></script>

<!-- Datatables -->
<script>
    $(document).ready(function() {
        var handleDataTableButtons = function() {
            if ($("#datatable-buttons").length) {
                $("#datatable-buttons").DataTable({
                    dom: "Bfrtip",
                    buttons: [
                        {
                            extend: "copy",
                            className: "btn-sm"
                        },
                        {
                            extend: "csv",
                            className: "btn-sm"
                        },
                        {
                            extend: "excel",
                            className: "btn-sm"
                        },
                        {
                            extend: "pdfHtml5",
                            className: "btn-sm"
                        },
                        {
                            extend: "print",
                            className: "btn-sm"
                        },
                    ],
                    responsive: true
                });
            }
        };

        TableManageButtons = function() {
            "use strict";
            return {
                init: function() {
                    handleDataTableButtons();
                }
            };
        }();

        $('#datatable').dataTable();

        $('#datatable-keytable').DataTable({
            keys: true
        });

        $('#datatable-responsive').DataTable();

        $('#datatable-scroller').DataTable({
            ajax: "js/datatables/json/scroller-demo.json",
            deferRender: true,
            scrollY: 380,
            scrollCollapse: true,
            scroller: true
        });

        $('#datatable-fixed-header').DataTable({
            fixedHeader: true
        });

        var $datatable = $('#datatable-checkbox');

        $datatable.dataTable({
            'order': [[ 1, 'asc' ]],
            'columnDefs': [
                { orderable: false, targets: [0] }
            ]
        });
        $datatable.on('draw.dt', function() {
            $('input').iCheck({
                checkboxClass: 'icheckbox_flat-green'
            });
        });

        TableManageButtons.init();
    });
</script>
<!-- /Datatables -->
</body>
</html>

