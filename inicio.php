<?
require_once 'funciones/conex.php';
if(isset($_GET['ver'])){ $ver = $_GET['ver']; }else{ $ver = ""; }
if(isset($_GET['opc'])){ $opc = $_GET['opc']; }else{ $opc = ""; }
if(isset($_GET['id'])){ $id = $_GET['id']; }else{ $id = 0; }

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>INVERPARTS DEL TUY</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="includes/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="includes/css/select2.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="includes/css/font-awesome.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="includes/css/AdminLTE.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="includes/css/_all-skins.min.css">
    <link rel="apple-touch-icon" href="img/apple-touch-icon.png">
     <!-- jQuery 2.1.4 -->
    <script src="includes/js/jQuery-2.1.4.min.js"></script>
    <script type="text/javascript" src="includes/js/select2.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="includes/js/bootstrap.min.js"></script>
    <!-- AdminLTE App -->
    <script src="includes/js/app.min.js"></script>
    <script src="includes/js/funciones.js"></script>
  </head>

  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
      <header class="main-header">
        <!-- Logo -->
        <a href="inicio.php" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>P</b>NL</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>PANEL</b></span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Navegación</span>
          </a>
          <!-- Menu derecho de la barra de navegación -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Cuenta de usuario -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <span class="hidden-xs"><?=$_SESSION['email']?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- Menu Footer-->
                  <li>
                    <div class="pull-right">
                      <button id="logout" class="btn btn-flat btn-danger">Salir</button>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- Columna del lado izquierdo. Contiene el logotipo y la barra lateral -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">       
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header"></li>

            <!--Para permisos de este menu, en este caso solo se va a mostrar a nivel 1-->
            <?php if($_SESSION['nivel'] == "1"): ?>
            <!--Agregar y modificar usuarios-->
            <li class="treeview">
              <a href="#">
                <i class="fa fa-users"></i>
                <span>Usuarios</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="?ver=usuarios"><i class="fa fa-circle-o"></i>Ver Usuarios</a></li>
                <li><a href="?ver=usuarios&opc=add"><i class="fa fa-circle-o"></i>Agregar Usuario</a></li>
              </ul>
            </li>
           	<!-- Fin dar permisos -->
          
          	<!--Agregar y modificar niveles-->
           	<li class="treeview">
              <a href="#">
                <i class="fa fa-users"></i>
                <span>Niveles</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="?ver=niveles"><i class="fa fa-circle-o"></i>Ver niveles</a></li>
                <li><a href="?ver=niveles&opc=add"><i class="fa fa-circle-o"></i>Agregar niveles</a></li>
              </ul>
          	</li>
           	<!--Agregar y modificar materiales-->
           	<li class="treeview">
              <a href="#">
                <i class="fa fa-cubes"></i>
                <span>Productos</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="?ver=productos"><i class="fa fa-circle-o"></i>Ver productos</a></li>
                <li><a href="?ver=productos&opc=add"><i class="fa fa-circle-o"></i>Agregar productos</a></li>
              </ul>
          	</li>

           	<li class="treeview">
              <a href="#">
                <i class="fa fa-list"></i>
                <span>Salidas</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="?ver=salidas"><i class="fa fa-circle-o"></i>Ver salidas</a></li>
                <li><a href="?ver=salidas&opc=add"><i class="fa fa-circle-o"></i>Agregar salida</a></li>
              </ul>
          	</li>
          <?php endif; ?>
            <!--Areas-->
        		<!--Quitar etiqueta de abrir y cerrar comentarios-->
        
      <!--  <li class="treeview">
              <a href="#">
                <i class="fa  fa-files-o"></i>
                <span>Solicitudes</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">-->
                <!-- Permisos para dos tipos de usuarios -->
                <?php if( ($_SESSION['nivel'] == "1") || ($_SESSION['nivel'] == "2") ): ?>
              	<!-- 
                <li><a href="ventas/venta"><i class="fa fa-check"></i> Mantenimiento</a></li>
              	-->
                <?php endif; ?>
                <!-- fin permisos para dos usuarios -->
                <?php if( ($_SESSION['nivel'] == "1") || ($_SESSION['nivel'] == "3") ): ?>
                <!-- 
                <li><a href="ventas/venta"><i class="fa fa-check"></i> Servicios</a></li>
              	-->
                <?php endif;?>
                <?php if( ($_SESSION['nivel'] == "1") || ($_SESSION['nivel'] == "4") ): ?>
                <!--
                <li><a href="ventas/venta"><i class="fa fa-check"></i> Planta fisica</a></li>
              	-->
              	<?php endif; ?>
              	<?php if( ($_SESSION['nivel'] == "1") || ($_SESSION['nivel'] == "5") ): ?>
              	<!--
                <li><a href="ventas/venta"><i class="fa fa-check"></i> Electricidad</a></li>
              	-->
              <?php endif;?>
                <!--
              </ul>
            </li> 
           --> 
            <li>
              <a href="#">
                <i class="fa fa-info-circle"></i> <span>Acerca de Inverparts <br> del Tuy</span>
                <!--<small class="label pull-right bg-yellow">IT</small>-->
              </a>
            </li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

      <!--Contenido TODO LO DE EL MEDIO -->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">      
        <!-- Main content -->
      <?
      //Switch llamar a las vistas
        switch($ver){
          case 'usuarios':
            require_once 'views/usuarios.php';
          break;
           case 'niveles':
            require_once 'views/niveles.php';
          break;
          case 'productos':
            require_once 'views/productos.php';
          break;
          case 'salidas':
            require_once 'views/salidas.php';
          break;
          default;
      ?>
          <section class="content">
            <div class="row">
              <div class="col-md-12">
                <div class="box">
                  <div class="box-header with-border">
                    <h3 class="box-title">Sistema </h3>
                    <div class="box-tools pull-right">
                      <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>  
                      <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                    <div class="row">
                      <div class="col-md-12">
                        <!--Contenido-->
                        <h3>Formularios</h3>
                      </div>
                    </div><!-- /.row -->
                  </div><!-- /.box-body -->
                </div><!-- /.box -->
              </div><!-- /.col -->
            </div><!-- /.row -->
          </section><!-- /.content -->
        <?
          break;
        }//Switch
        ?>
      </div><!-- /.content-wrapper -->
      <!--Fin-Contenido-->
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 2.3.0 
        </div>
        <!--Footer-->
        <strong>Copyright &copy;  <a href="">INVERPARTS DEL TUY</a></strong> All rights reserved.
    	</footer>
    </div>
  </body>
</html>
