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
            padding-top: 60px;
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
     <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="navbar-inner">
          <div class="container-fluid">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </a>
            <a class="brand" href="<?=site_url("main")?>">Sistema Sedita</a>
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
                              <a tabindex="-1" href="<?=site_url("alumno")?>">Alumnos</a>
                              <ul class="dropdown-menu">
                                  <li><a tabindex="-1" href="<?=site_url("alumno")?>">Matriculaci&oacute;n</a></li>
                                  <li><a tabindex="-1" href="<?=site_url("alumno/consultar")?>">Consultar o Actualizar</a></li>
                              </ul>
                          </li>
                          <li class="dropdown-submenu">
                              <a tabindex="-1" href="<?=site_url("personal")?>">Personal</a>
                              <ul class="dropdown-menu">
                                  <li><a tabindex="-1" href="<?=site_url("personal")?>">Registro</a></li>
                                  <li><a tabindex="-1" href="<?=site_url("personal/consultar")?>">Consultar o Actualizar</a></li>
                                  <li><a tabindex="-1" href="<?=site_url("personal/asignacion_cursos")?>">Asignar Curso o Dirigente</a></li>
                              </ul>
                          </li>
                          <li class="dropdown-submenu">
                              <a tabindex="-1" href="<?=site_url("listados/nomina_alumnos")?>">Listados</a>
                              <ul class="dropdown-menu">
                                  <li><a tabindex="-1" href="<?=site_url("listados/nomina_alumnos")?>">N&oacute;mina o Actas de Alumnos</a></li>
                                  <li><a tabindex="-1" href="<?=site_url("listados/hoja_matricula")?>">Hoja de Matr&iacute;cula</a></li>
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
                          <li><a tabindex="-1" href="<?=site_url("acta_calificaciones")?>">Actas de Calificaciones</a></li>
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
                      <a class="dropdown-toggle" data-toggle="dropdown" href="<?=site_url("mantenimiento/usuarios") ?>">
                          Mantenimiento
                          <b class="caret"></b>
                      </a>
                      <ul class="dropdown-menu">
                          <li><a tabindex="-1" href="<?=site_url("mantenimiento/usuarios") ?>">Usuarios</a></li>
                          <li><a tabindex="-1" href="<?=site_url("mantenimiento/cursos") ?>">Cursos</a></li>
                          <li class="dropdown-submenu">
                              <a tabindex="-1" href="#">Materias</a>
                              <ul class="dropdown-menu">
                                  <li><a tabindex="-1" href="<?=site_url("mantenimiento/nom_mat")?>">Nombres</a></li>
                                  <li><a tabindex="-1" href="<?=site_url("mantenimiento/mat_curso")?>">Materias por Curso</a></li>
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
  </body>
</html>