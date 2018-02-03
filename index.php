<?
if(isset($_SESSION['id_user'])){
  session_destroy();
}
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
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="css/font-awesome.css">
   
    <!-- Theme style -->
    <link rel="stylesheet" href="css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="css/blue.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
       <b>ADMINISTRACIÓN INVERPARTS DEL TUY</b>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Ingrese sus datos de Acceso</p>
        <form id="login-form" action="#" method="post">
          <input hidden name="action" value="login">
          <div class="form-group has-feedback">
            <input class="form-control" type="email" name="email" placeholder="Email">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input class="form-control" type="password" name="password" placeholder="Password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="form-group">
            <div class="progress" style="display:none">
              <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">
              </div>
            </div>
          </div>
          <div class="alert alert-danger" role="alert" style="display:none">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>&nbsp;
            <span id="msj">Datos incorrectos</span>
          </div>
          <div class="row">
            <div class="col-xs-8">
            
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button id="enviar" type="submit" class="btn btn-primary btn-block btn-flat">Ingresar</button>
            </div><!-- /.col -->
          </div>
        </form>

        
        
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="js/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="js/icheck.min.js"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });

      $(document).ready(function(){
        $('#login-form').submit(function(e){
          e.preventDefault();  
          $('.progress').hide();
          $('.progress').show();
          $('#enviar').button('loading');

          $.ajax({
            type: 'POST',
            cache: false,
            url: 'funciones/funciones.php',
            data: $('#login-form').serialize(),
            dataType: 'json',
            success: function(r){
              console.log(r);
              if(r.r){
                $('.alert').removeClass('alert-danger').addClass('alert-success');
                window.location.replace('inicio.php');
              }else{
                $('.alert').removeClass('alert-success').addClass('alert-danger');
              }
              $('#msj').html(r.msj);
            },
            error: function(){
              $('.alert').removeClass('alert-success').addClass('alert-danger');
              $('#msj').html('Ha ocurrido un error inesperado')
            },
            complete: function(){
              $('.progress').hide();
              $('.alert').show().delay(7000).hide('slow');
              $('#enviar').button('reset');
            }
          })
        });
      })
    </script>
  </body>
</html>
