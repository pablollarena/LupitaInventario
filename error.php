<?php
/**
 * Created by PhpStorm.
 * User: PLLARENA
 * Date: 28/10/2016
 * Time: 10:46 AM
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - Dark Admin</title>

    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="css/local.css" />

    <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
<div align="center">
    <div>
        <div class="col-lg-12 text-center v-center">
            <h1>ERROR</h1>
            <h1>Error</h1>
            <h4><?php echo $_REQUEST["sError"]; ?></h4>
            <a href="index.html">Regresar al inicio de sesión</a>

        </div>
    </div>
    <!-- /.row -->
    <!-- /#page-wrapper -->
</div>
</body>
</html>

