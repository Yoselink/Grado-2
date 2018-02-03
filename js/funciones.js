
$(document).ready(function(){


  $('#logout').click(function(){
    $.ajax({
      type: 'post',
      cache: false,
      url: 'funciones/funciones.php',
      data: {action:'logout'},
      dataType: 'json',
      success: function(e){
        window.location.replace('index.php');
      },
      error: function(){
        window.location.replace('index.php');
      }
    })
  });

  $('.b-submit').click(function(e){
    e.preventDefault();
    var bid = this.id;
    $('#'+bid).button('loading');
    var form = $(this).closest('form');
    var action = form.attr('action');
    var fid = form.attr('id');
    $('#'+fid+' .progress').show();
    $('#'+fid+' .alert').hide('fast');
    //Validacion
    var fields = $('#'+fid+' input,#'+fid+' select').filter('[required]').length;
    $('#'+fid+' input,#'+fid+' select').filter('[required]').each(function(){
      var regex = $(this).attr('pattern');
      var val   = $(this).val();
      if(val == ""){
        $(this).closest('.form-group').addClass('has-error');
        $(this).closest('.form-group').find('.help-block').show();
      }
      else{
        if(val.match(regex)){
          $(this).closest('.form-group').removeClass('has-error');
          $(this).closest('.form-group').find('.help-block').hide('fast');
          fields = fields-1;
        }else{
          $(this).closest('.form-group').addClass('has-error');
          $(this).closest('.form-group').find('.help-block').show();
        }
      }
    });

    if(fields!=0){
      $('#'+fid+' .alert').removeClass('alert-success').addClass('alert-danger');
      $('#'+fid+' .alert #msj').html('Debe completar todos los campos requeridos');
      $('#'+fid+' .progress').hide();
      $('#'+bid).button('reset');
      $('#'+fid+' .alert').show().delay(7000).hide('slow');
    }else{
      $.ajax({
        type: 'POST',
        cache: false,
        url: action,
        data: form.serialize(),
        dataType: 'json',
        success: function(r){
          if(r.r){
            $('#'+fid+' .alert').removeClass('alert-danger').addClass('alert-success');
            form[0].reset();
          }else if(r.r=="mod"){
            $('#'+fid+' .alert').removeClass('alert-danger').addClass('alert-success');
          }else{
            $('#'+fid+' .alert').removeClass('alert-info alert-success').addClass('alert-danger');
          }
          $('#'+fid+' .alert #msj').text(r.msj);
          if(r.reload){
            location.replace(r.redirect);
          }
        },
        error: function(){
          $('#'+fid+' .alert').removeClass('alert-info alert-success').addClass('alert-danger');
          $('#'+fid+' .alert #msj').text('Ah ocurrido un error inesperado!');
        },
        complete: function(r){
          $('#'+fid+' .progress').hide();
          $('#'+bid).button('reset');
          $('#'+fid+' .alert').show().delay(7000).hide('slow');
        }
      })
    }
  });


});