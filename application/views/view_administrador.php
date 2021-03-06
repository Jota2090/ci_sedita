<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Sedita Administrador</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="" />
    <meta name="Sedita" content="" />
    <base href="<?=site_url()?>" />
    
    <!-- Le styles -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="shortcut icon" href="assets/ico/favicon.ico"/>
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png" />
    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png" />
    
    <script src="assets/js/jquery-bootstrap.js"></script>
    <script src="assets/js/bootstrap-alert.js"></script>
    <script src="assets/js/bootstrap-modal.js"></script>
    <script src="assets/js/bootstrap-dropdown.js"></script>
        
    <style type="text/css">
        body {
            width: 1320px;
            padding-top: 10px;
            padding-bottom: 40px;
            margin: 0 auto;
            font-family: Arial;
            font-size: 14px;
        }
        .sidebar-nav {
            padding: 9px 0;
        }
    </style>
  </head>

  <body data-spy="scroll" data-target=".bs-docs-sidebar">
    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span12">
            <div class="hero-unit">
                <div class="cuadro_titulo2">
                    <h1>Unidad Educativa<br />"La Luz de Dios"!</h1>
                </div>
                <dl class="dl-horizontal" style="float: left;">
                    <dt>Usuario:</dt>
                    <dd><?php echo $usuario ?></dd>
                    <dt>Fecha:</dt>
                    <dd><?php echo $fecha ?></dd>
                </dl>
            </div>
        </div><!--/span-->
        <div class="span6">
            <img style="margin-left: 100px;" width="250px" alt="Imagen Login" src="assets/img/logo-escuela.png" />
        </div>
        <div class="span4">
            <p style="margin-top: 20px;"><a class="btn btn-large btn-block btn-primary" type="button" href="<?=site_url("alumno/matricular")?>" >Matriculaci&oacute;n de Estudiantes</a></p>
            <p style="margin-top: 10px;"><a class="btn btn-large btn-block btn-primary" type="button" href="<?=site_url("personal/registro")?>" >Registro del Personal</a></p>
            <p style="margin-top: 10px;"><a class="btn btn-large btn-block btn-primary" type="button" href="<?=site_url("personal/asignacion_cursos")?>" >Asignaci&oacute;n de Cursos y Dirigentes</a></p>
            <p style="margin-top: 10px;">
                <a class="span6 btn btn-large btn-primary" type="button" href="<?=site_url("listados/nominas")?>">Listados</a>
                <a class="span6 btn btn-large btn-primary" type="button" href="<?=site_url("alumno/consultar")?>">Actualizaci&oacute;n de Datos</a>
            </p>
            <p style="margin-top: 60px;">
                <a class="span6 btn btn-large btn-primary" type="button" href="<?=site_url("acta_calificaciones/acta_nueva")?>">Actas de Caificaciones</a>
                <a class="span6 btn btn-large btn-primary" type="button" href="<?=site_url("libreta")?>">Libretas</a>
            </p>
            <p style="margin-top: 120px;">
                <a class="span12 btn btn-large btn-primary" type="button" href="<?=site_url("facturacion/cobros")?>">Facturaci&oacute;n</a>
            </p>
            <!--<p style="margin-top: 170px;">
                <a class="span12 btn btn-large btn-primary" type="button" href="<?=site_url("banda_guerra")?>">Control de Activos</a>
            </p>-->
        </div>
        <div class="span2"></div>
      </div><!--/row-->
    </div><!--/.fluid-container-->
    
  </body>
</html>