<?php
/**
 * Created by PhpStorm.
 * User: PLLARENA
 * Date: 02/11/2016
 * Time: 12:25 PM
 */
require_once ("Class/Empleadas.php");
include_once ("Class/Usuarios.php");
session_start();
$oEmpleados = new Empleadas();
$oUser = new Usuarios();
$sErr = "";
$sNom = "";
$arrEmp = null;
$sErr2 = "";
$sRuta = "controlEmpleados.php";

    if(isset($_SESSION['sUser']) && !empty($_SESSION['sUser'])){
        $oUser = $_SESSION['sUser'];
        if($oUser->buscarDatosUsuario()){
            $sNom = $oUser->getUsuario();
            $arrEmp = $oEmpleados->buscarTodos();
        }else{
            $sErr2 = "Usuario no registrado";
        }

    }else{
        $sErr = "Faltan datos de sesión";
    }

    if($sErr != ""){
        header("Location: error.php?sError=".$sErr);
    }else if($sErr2 != ""){
        header("Location: errorProceso.php?sError=".$sErr2."&sRuta=".$sRuta);
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
                <li><a href="controlDepto.php"><i class="fa fa-archive"></i> Departamentos</a></li>
                <li><a href="register.html"><i class="fa fa-file-pdf-o"></i> Reportes</a></li>
                <li><a href="controlSoftware.php"><i class="fa fa-terminal"></i> Software</a></li>
                <li><a href="controlEmpleados.php"><i class="fa fa-book"></i> Empleados</a></li>
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
        <form id="frmEmpleados" action="abcEmpleados.php" method="post">
            <input type="hidden" name="txtClave">
            <input type="hidden" name="txtOp">
            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>ID EMPLEADO</th>
                    <th>NOMBRE</th>
                    <th>DEPARTAMENTO</th>
                    <th>ACCIÓN</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if($arrEmp){
                    foreach ($arrEmp as $vRow){
                        ?>
                        <tr>
                            <td><?php echo $vRow->getIdEmpleada();?></td>
                            <td><?php echo $vRow->getNombre();?></td>
                            <td><?php echo $vRow->getDepto()->getDepto();?></td>
                            <td>
                                <input type="submit" value="Modificar" class="btn btn-warning" onClick="txtClave.value=<?php echo $vRow->getIdEmpleada();?>; txtOp.value='m';">
                                <input type="submit" value="Eliminar" class="btn btn-danger" onClick="txtClave.value=<?php echo $vRow->getIdEmpleada();?>; txtOp.value='e';">
                            </td>
                        </tr>
                        <?php
                    }
                }else{
                    ?>
                    <td>No se encontraron registros</td>
                    <?php
                }
                ?>
                </tbody>
            </table>
            <input type="submit" value="Agregar Departamento" class="btn btn-primary" onClick="txtClave.value='-1';txtOp.value='a'">
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



