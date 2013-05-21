$(function(){
	
	var save_and_close = false;
	
	$('#save-and-go-back-button').click(function(){
		save_and_close = true;
		
		$('#crudForm').trigger('submit');
	});	
	
	$('#crudForm').submit(function(){		
		$(this).ajaxSubmit({
			url: validation_url,
			dataType: 'json',
			beforeSend: function(){
				$("#FormLoading").show();
			},
			cache: false,
			success: function(data){
				$("#FormLoading").hide();
				if(data.success)
				{					
					$('#crudForm').ajaxSubmit({
						dataType: 'text',
						cache: false,
						beforeSend: function(){
							$("#FormLoading").show();
						},							
						success: function(result){							
							$("#FormLoading").fadeOut("slow");
							data = $.parseJSON( result );
							if(data.success)
							{	
								if(save_and_close)
								{
									  var pathArray = window.location.pathname.split( '/' );
                                      newPathname = "";
                                      newPathname += pathArray[2];
                                      newPathname += pathArray[3];
                                      
                                      if(newPathname=="alumnoconsultar_alumnos")
                                      {
                                         var idJornada= $("#cmbJornada").find(":selected").val();
                                         var idCurso= $("#cmbCurso").find(":selected").val();
                                         //var cmbParal=document.getElementById("cmbParalelo");
                                         
                                         var idParal= $("#cmbParalelo").find(":selected").val();
                                         
                                         var idEspec= $("#cmbEspec").find(":selected").val();
                                         
                                         var cmbPeriodoLectivo=document.getElementById("cmbAnoLectivo");
                                         cmbPeriodoLectivo.disabled=false;
                                           
                                         var periodoLectivo= $("#cmbAnoLectivo").find(":selected").val();
                                         var strAnioLect=periodoLectivo.split("-");   
                                                            
                                        $.ajax({
                                               type:"post",
                                               url: data.success_list_url,
                                               data:"jornada="+idJornada+"&curso="+idCurso+"&paral="+idParal+"&strAnioLect="+strAnioLect[0]+"&indBachill=0"+"&indInicio=1",
                                               success:function(info){
                                                   //$("#consultaAlumnos").html(info);
                                                   //alert($('#consultaAlumnos').html(info).find('#consultaAlumnos').html());
                                                   //var html = $("<div/>").append(info).find('#groceryCrudTable').html();
                                                   $("#resultadosConsulta").innerHTML="";
                                                     $("#resultadosConsulta").html(info);
                                                     //alert(data.success_list_url);
                                                      //alert(newPathname);
                                               }
                                          });
                                      }
                                      
                                      else if(newPathname=="mantenimientousuarios")
                                      {
                                            var usuario= $("#cmbUsuario").find(":selected").val();
                                            var nombre= $("#txtNombre").val();
                                            
                                            $.ajax({
                                                type:"post",
                                                url: data.success_list_url,
                                                data:"usuario="+usuario+"&nombre="+nombre+"&indicador=1",
                                                success:function(info){
                                                    $("#resultadosConsulta").innerHTML="";
                                                    $("#resultadosConsulta").html(info);
                                                }
                                            });
                                      }
                                      
                                      else if(newPathname=="mantenimientocurso_paralelo")
                                      {
                                            var jornada = $("#cmbJornada").find(":selected").val();
                                            var especializacion = $("#cmbEspec").find(":selected").val();
                                            var curso = $("#cmbCurso").find(":selected").val();
                                            
                                            $.ajax({
                                                type:"post",
                                                url: data.success_list_url,
                                                data:"curso="+curso+"&jornada="+jornada+"&especializacion="+especializacion
                                                        +"&indicador=1",
                                                success:function(info){
                                                    $("#resultadosConsulta").innerHTML="";
                                                    $("#resultadosConsulta").html(info);
                                                }
                                            });
                                      }
                                      
                                      else if(newPathname=="personalconsultar")
                                      {
                                            var nom= $("#txtNom").val();
                                            var ape= $("#txtApe").val();
                                            
                                            $.ajax({
                                                type:"post",
                                                url: data.success_list_url,
                                                data:"nom="+nom+"&ape="+ape+"&ind=1",
                                                success:function(info){
                                                    $("#resultadosConsulta").innerHTML="";
                                                    $("#resultadosConsulta").html(info);
                                                }
                                            });
                                      }
                                        
                                      else if(newPathname=="mantenimientonom_mat")
                                      {
                                            var nom= $("#txtMat").val();
                                            
                                            $.ajax({
                                                type:"post",
                                                url: data.success_list_url,
                                                data:"nom="+nom+"&ind=1",
                                                success:function(info){
                                                    $("#resultadosConsulta").innerHTML="";
                                                    $("#resultadosConsulta").html(info);
                                                }
                                            });
                                      }
                                      
                                      else if(newPathname=="mantenimientomat_curso")
                                      {
                                            var nom= $("#txtMat").val();
                                            var cur = $("#cmbCurso").find(":selected").val();
                                            var esp = $("#cmbEspec").find(":selected").val();
                                            
                                            $("#resultadosConsulta").innerHTML="";
                                            $.ajax({
                                                type:"post",
                                                url: data.success_list_url,
                                                data:"nom="+nom+"&cur="+cur+"&esp="+esp+"&ind=1",
                                                success:function(info){
                                                    $("#resultadosConsulta").html(info);
                                                }
                                            });
                                      }
                                      
                                      else if(newPathname=="mantenimientonom_cursos")
                                      {
                                            var nom= $("#txtCurso").val();
                                            
                                            $.ajax({
                                                type:"post",
                                                url: data.success_list_url,
                                                data:"nom="+nom+"&ind=1",
                                                success:function(info){
                                                    $("#resultadosConsulta").innerHTML="";
                                                    $("#resultadosConsulta").html(info);
                                                }
                                            });
                                      }
                                    
                                   // window.location = data.success_list_url;
									return true;
								}								
								
								$('#report-error').hide().html('');									
								$('.field_error').each(function(){
									$(this).removeClass('field_error');
								});									
								
								$('#report-success').html(data.success_message);
								$('#report-success').slideDown('slow');
							}
							else
							{
								alert(message_update_error);
							}
						},
						error: function(){
								alert( message_update_error );
						}
					});
				}
				else
				{
					$('.field_error').each(function(){
						$(this).removeClass('field_error');
					});
					$('#report-error').slideUp('fast');
					$('#report-error').html(data.error_message);
					$.each(data.error_fields, function(index,value){
						$('input[name='+index+']').addClass('field_error');
					});
							
					$('#report-error').slideDown('normal');
					$('#report-success').slideUp('fast').html('');
					
				}
			}
		});
		return false;
	});
	
	$('.ui-input-button').button();
	$('.gotoListButton').button({
        icons: {
        	primary: "ui-icon-triangle-1-w"
    	}
	});
	
});	

/*
 function goToList()
 {
 	if( confirm( message_alert_edit_form ) )
 	{
 		window.location = list_url;
 	}

 	return false;	
 }
 */

function goToList(list_url,NumBoton)
{
    var pathArray = window.location.pathname.split( '/' );
    newPathname = "";
    newPathname += pathArray[2];
    newPathname += pathArray[3];
    
    if(newPathname=="alumnoconsultar_alumnos")
    {
        var idJornada= $("#cmbJornada").find(":selected").val();
        var idCurso= $("#cmbCurso").find(":selected").val();
        //var cmbParal=document.getElementById("cmbParalelo");
        
        var idParal= $("#cmbParalelo").find(":selected").val();
        
        var idEspec= $("#cmbEspec").find(":selected").val();
        
        var cmbPeriodoLectivo=document.getElementById("cmbAnoLectivo");
        cmbPeriodoLectivo.disabled=false;
        
        var periodoLectivo= $("#cmbAnoLectivo").find(":selected").val();
        var strAnioLect=periodoLectivo.split("-");  
        
        //NumBoton 
           // 1 si es el bot�n regresar a la lista que se encuentra en la parte superior  del formulario de editar
           // 2 si es el link q aparece una vez se ha dado click sobre el bot�n actualizar cambios    
            
        if(NumBoton==1)
        {
        	if( confirm( message_alert_edit_form ) )
           {
               	//window.location = list_url;
                $.ajax({
                   type:"post",
                   url: list_url,
                   data:"jornada="+idJornada+"&curso="+idCurso+"&paral="+idParal+"&strAnioLect="+strAnioLect[0]+"&indBachill=0"+"&indInicio=1",
                   success:function(info){
                         $("#resultadosConsulta").innerHTML="";
                         $("#resultadosConsulta").html(info);
                 
                   }
                });
            }
           
            return false;	
        }
        else
        {
            $.ajax({   
                   type:"post",
                   url: list_url,
                   data:"jornada="+idJornada+"&curso="+idCurso+"&paral="+idParal+"&strAnioLect="+strAnioLect[0]+"&indBachill=0"+"&indInicio=1",
                   success:function(info){
                       //$("#consultaAlumnos").html(info);
                       //alert($('#consultaAlumnos').html(info).find('#consultaAlumnos').html());
                       //var html = $("<div/>").append(info).find('#groceryCrudTable').html();
                       $("#resultadosConsulta").innerHTML="";
                       $("#resultadosConsulta").html(info);
                 
                   }
            });
        }
     }
    
    else if(newPathname=="mantenimientousuarios")   
    {
        var usuario= $("#cmbUsuario").find(":selected").val();
        var nombre = $("#txtNombre").val();
        
        if(NumBoton==1)
        {
        	if( confirm( message_alert_edit_form ) )
           {
               	//window.location = list_url;
                $.ajax({
                    type:"post",
                    url: list_url,
                    data:"usuario="+usuario+"&nombre="+nombre+"&indicador=1",
                    success:function(info){
                        $("#resultadosConsulta").innerHTML="";
                        $("#resultadosConsulta").html(info);
                    }
                });
            }
           
            return false;	
        }
        else
        {
            $.ajax({
                type:"post",
                url: list_url,
                data:"usuario="+usuario+"&nombre="+nombre+"&indicador=1",
                success:function(info){
                    $("#resultadosConsulta").innerHTML="";
                    $("#resultadosConsulta").html(info);
                }
            });
        }                                     
    }
    
    else if(newPathname=="mantenimientocurso_paralelo")   
    {
        var jornada = $("#cmbJornada").find(":selected").val();
        var especializacion = $("#cmbEspec").find(":selected").val();
        var curso = $("#cmbCurso").find(":selected").val();
        
        if(NumBoton==1)
        {
        	if( confirm( message_alert_edit_form ) )
           {
               	//window.location = list_url;
                $.ajax({
                    type:"post",
                    url: list_url,
                    data:"curso="+curso+"&jornada="+jornada+"&especializacion="+especializacion
                            +"&indicador=1",
                    success:function(info){
                        $("#resultadosConsulta").innerHTML="";
                        $("#resultadosConsulta").html(info);
                    }
                });
            }
           
            return false;	
        }
        else
        {
            $.ajax({
                type:"post",
                url: list_url,
                data:"curso="+curso+"&jornada="+jornada+"&especializacion="+especializacion
                        +"&indicador=1",
                success:function(info){
                    $("#resultadosConsulta").innerHTML="";
                    $("#resultadosConsulta").html(info);
                }
            });
        }                                
    }
    
    else if(newPathname=="personalconsultar")   
    {
        var nom= $("#txtNom").val();
        var ape= $("#txtApe").val();
        
        if(NumBoton==1)
        {
        	if( confirm( message_alert_edit_form ) )
           {
                $.ajax({
                    type:"post",
                    url: list_url,
                    data:"nom="+nom+"&ape="+ape+"&ind=1",
                    success:function(info){
                        $("#resultadosConsulta").innerHTML="";
                        $("#resultadosConsulta").html(info);
                    }
                });
            }
           
            return false;	
        }
        else
        {
            $.ajax({
                type:"post",
                url: list_url,
                data:"nom="+nom+"&ape="+ape+"&ind=1",
                success:function(info){
                    $("#resultadosConsulta").innerHTML="";
                    $("#resultadosConsulta").html(info);
                }
            });
        }                                
    }
    
    else if(newPathname=="mantenimientonom_cursos")   
    {
        var nom= $("#txtCurso").val();
        
        if(NumBoton==1)
        {
        	if( confirm( message_alert_edit_form ) )
           {
                $.ajax({
                    type:"post",
                    url: list_url,
                    data:"nom="+nom+"&ind=1",
                    success:function(info){
                        $("#resultadosConsulta").innerHTML="";
                        $("#resultadosConsulta").html(info);
                    }
                });
            }
           
            return false;	
        }
        else
        {
            $.ajax({
                type:"post",
                url: list_url,
                data:"nom="+nom+"&ind=1",
                success:function(info){
                    $("#resultadosConsulta").innerHTML="";
                    $("#resultadosConsulta").html(info);
                }
            });
        }                                
    }
    
    else if(newPathname=="mantenimientonom_mat")   
    {
        var nom= $("#txtMat").val();
        
        if(NumBoton==1)
        {
        	if( confirm( message_alert_edit_form ) )
           {
                $.ajax({
                    type:"post",
                    url: list_url,
                    data:"nom="+nom+"&ind=1",
                    success:function(info){
                        $("#resultadosConsulta").innerHTML="";
                        $("#resultadosConsulta").html(info);
                    }
                });
            }
           
            return false;	
        }
        else
        {
            $.ajax({
                type:"post",
                url: list_url,
                data:"nom="+nom+"&ind=1",
                success:function(info){
                    $("#resultadosConsulta").innerHTML="";
                    $("#resultadosConsulta").html(info);
                }
            });
        }                                
    }
    
    else if(newPathname=="mantenimientomat_curso")   
    {
        var nom= $("#txtMat").val();
        var cur = $("#cmbCurso").find(":selected").val();
        var esp = $("#cmbEspec").find(":selected").val();
        
        if(NumBoton==1)
        {
        	if( confirm( message_alert_edit_form ) )
           {
                $("#resultadosConsulta").innerHTML="";
                $.ajax({
                    type:"post",
                    url: list_url,
                    data:"nom="+nom+"&cur="+cur+"&esp="+esp+"&ind=1",
                    success:function(info){
                        $("#resultadosConsulta").html(info);
                    }
                });
            }
           
            return false;	
        }
        else
        {
            $("#resultadosConsulta").innerHTML="";
            $.ajax({
                type:"post",
                url: list_url,
                data:"nom="+nom+"&cur="+cur+"&esp="+esp+"&ind=1",
                success:function(info){
                    $("#resultadosConsulta").html(info);
                }
            });
        }                                
    }
}