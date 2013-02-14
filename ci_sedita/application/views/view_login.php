<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Sistema Sedita</title>
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
        
        a{
            color: blue;
            text-decoration: none;
            font-size: 14px;
        }
        
        a:hover{
            text-decoration: underline;
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
          <a class="brand" href="#">Sistema Sedita</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active"><a href="#">Misi&oacute;n</a></li>
              <li><a href="#about">Visi&oacute;n</a></li>
              <li><a href="#contact">Ayuda</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span9">
            <div class="hero-unit">
                <div class="cuadro_titulo">
                    <h1>Sistema Sedita!</h1>
                    <p>Impulsando a los Sistemas de Informaci&oacute;n.</p>
                </div>
                
                <div class="cuadro_imagen">
                    <img alt="Imagen Login" src="assets/img/logo-escuela.png" />
                </div>
            </div>
            
            <?=$error?>
            <div class="cuadro_login">
                <form id="forma" name="forma" class="panel-login form-horizontal" action="<?=site_url("login/validar")?>" method="post" >
                  <div class="control-group">
                    <label class="control-label"> Usuario</label>
                    <div class="controls">
                      <input type="text" id="txtUser"  name="txtUser" placeholder="Usuario" />
        			</div>
                  </div>
                  <div class="control-group">
                    <label class="control-label">Contrase&ntilde;a</label>
                    <div class="controls">
                      <input type="password" id="txtClave" name="txtClave" placeholder="Contrase&ntilde;a" />
                    </div>
                  </div>
                  <div class="control-group">
                    <div class="controls">
                      <input style="margin-left: 135px;" type="submit" class="btn btn-primary" value="Ingresar" />
                    </div>
                  </div>
                </form>
            </div>
        </div><!--/span-->
      </div><!--/row-->

      <hr>

      <footer>
        <h6>Realizado por Sedita &nbsp;&nbsp; - &nbsp;&nbsp; &copy; Company 2012</h6>
      </footer>

    </div><!--/.fluid-container-->

  </body>
</html>