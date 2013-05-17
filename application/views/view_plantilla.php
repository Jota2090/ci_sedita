<!DOCTYPE html>
<html lang="es">
    <head>
    	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>Sedita</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="" />
        <meta name="Sedita" content="" />
        <base href="<?=site_url()?>" />

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
        <script src="js/jquery.validate.js"></script> 
        <script src="js/jquery.validate.bootstrap.js"></script>
        <script src="js/misfunciones.js"></script> 
    </head>

    <body data-spy="scroll" data-target=".bs-docs-sidebar">
        <div style="margin-bottom: 40px">
            <div class="navbar navbar-inverse navbar-fixed-top">
              <div class="navbar-inner">
                <div class="container-fluid">
                  <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </a>
                  <a class="brand" href="<?=site_url("main/menu")?>">Sistema Sedita</a>
                  <div class="nav-collapse collapse">
                    <p class="navbar-text pull-right">
                        <a href="<?=site_url("login/cerrar")?>" class="navbar-link">Cerrar Sesion</a>
                    </p>
                    <ul class="nav nav-pills">
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="">
                                Ingresos
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="dropdown-submenu">
                                    <a tabindex="-1" href="<?=site_url("alumno/nuevo/matricular")?>">Alumnos</a>
                                    <ul class="dropdown-menu">
                                        <li><a tabindex="-1" href="<?=site_url("alumno/nuevo/matricular")?>">Matriculaci&oacute;n</a></li>
                                        <li><a tabindex="-1" href="<?=site_url("alumno/nuevo/consultar")?>">Consultar o Actualizar</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown-submenu">
                                    <a tabindex="-1" href="<?=site_url("personal/nuevo/registro")?>">Personal</a>
                                    <ul class="dropdown-menu">
                                        <li><a tabindex="-1" href="<?=site_url("personal/nuevo/registro")?>">Registro</a></li>
                                        <li><a tabindex="-1" href="<?=site_url("personal/nuevo/consultar")?>">Consultar o Actualizar</a></li>
                                        <li><a tabindex="-1" href="<?=site_url("personal/nuevo/asignacion_cursos")?>">Asignar Curso o Dirigente</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown-submenu">
                                    <a tabindex="-1" href="<?=site_url("listados/nuevo/nominas")?>">Listados</a>
                                    <ul class="dropdown-menu">
                                        <li><a tabindex="-1" href="<?=site_url("listados/nuevo/nominas")?>">N&oacute;mina o Actas de Alumnos</a></li>
                                        <li><a tabindex="-1" href="<?=site_url("listados/nuevo/hoja_matricula")?>">Hoja de Matr&iacute;cula</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="">
                                Calificaciones
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <!--<li><a tabindex="-1" href="=site_url("acta_calificaciones")?>">Actas de Calificaciones</a></li>-->
                                <li class="dropdown-submenu">
                                    <a tabindex="-1" href="<?=site_url("libreta")?>">Libretas</a>
                                    <ul class="dropdown-menu">
                                        <li><a tabindex="-1" href="<?=site_url("libreta")?>">Consultar o Imprimir</a></li>
                                        <li><a tabindex="-1" href="<?=site_url("listados/cuadro_honor")?>">Cuadro de Honor</a></li>
                                        <li><a tabindex="-1" href="<?=site_url("listados/cuadro_promocion")?>">Cuadro de Promoci&oacute;n</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="<?=site_url("mantenimiento/nuevo/usuarios") ?>">
                                Mantenimiento
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a tabindex="-1" href="<?=site_url("mantenimiento/nuevo/usuarios") ?>">Usuarios</a></li>
                                <li><a tabindex="-1" href="<?=site_url("mantenimiento/nuevo/cursos") ?>">Cursos</a></li>
                                <li class="dropdown-submenu">
                                    <a tabindex="-1" href="<?=site_url("mantenimiento/nuevo/nom_mat")?>">Materias</a>
                                    <ul class="dropdown-menu">
                                        <li><a tabindex="-1" href="<?=site_url("mantenimiento/nuevo/nom_mat")?>">Nombres</a></li>
                                        <li><a tabindex="-1" href="<?=site_url("mantenimiento/nuevo/mat_curso")?>">Materias por Curso</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li><a href="#contact">Ayuda</a></li>
                    </ul>
                  </div><!--/.nav-collapse -->
                </div>
              </div>
            </div>
        </div>
        <div class="container-fluid" >
            <iframe width="100%" height="700px" src="<?echo $link;?>"></iframe>
        </div>
    </body>
</html>
