<!--<script type="text/javascript" src="<?php echo base_url(); ?>jqtransformplugin/jquery.jqtransform.js" ></script>-->
<!--<link rel="stylesheet" href="<?php echo base_url(); ?>jqtransformplugin/jqtransform.css" type="text/css" media="all" />-->
<!--<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css" type="text/css" media="all" />-->
<script language="javascript">
    //    $(function(){
    //        $('#frmPacientess').jqTransform({imgPath:'jqtransformplugin/img/'});
    //    });
</script>

<style type="text/css">
    .ui-jqgrid tr.jqgrow td {white-space: normal; padding: 3px;} 
    .ui-widget input{background-color: #fff;}
</style>
<script type="text/javascript">
    $(document).ready(function(){
        //VALIDACION
        var validar_frmPacientes = $('form#frmPacientes').validate({
            rules:{
                pac_nombres:{
                    required:true,
                    minlength:1
                },
                pac_ape_paterno:{
                    required:true,
                    minlength:1
                } 
            },
            messages:{
                pac_nombres:{
                    required:'El numero  de Cuenta es Obligatorio',
                    minlength:jQuery.format('se requiere al menos {0} caracteres para el numero de cuenta.')
                },
                pac_ape_paterno:{
                    required:'El nombre  de Cuenta es Obligatorio',
                    minlength:jQuery.format('se requiere al menos {0} caracteres para el numero de cuenta.')
                } 
            },
            submitHandler:function(form){
               
                // gets the id stored in the anchor as attribute
                var datastring = $(form).serialize();
                var url = "<?php echo site_url("paciente/agregar_paciente"); ?>";
                // instantiate and executes the ajax
                $.ajax({
                    type: 'POST',
                    cache:'false',
                    url: url,
                    data: datastring,
                    dataType:'json',
                    async: true,
                    success: function(data){
                        // alerts the response, or whatever you need
                        console.log('Ok',data.code);
                        jqgrid_paciente.trigger('reloadGrid');
                        $('div#frmPacientesDiv').dialog('close');
                    }
                    ,error: function(data){
                        console.log('Error---> '+data.code);
                    }
                });
                
            }
                
        });
        //FIN VALIDACION
        
        var jqgrid_paciente = jQuery("#list2").jqGrid({
            url:'<?php echo site_url("paciente/listar"); ?>',
            datatype: "json",
            mtype:"POST",
            colNames:['Id','Nombres', 'Ape. paterno', 'Ape. materno','Edad','Telefono','Direccion','Ciudad','Acciones'],
            colModel:[
                {name:'pac_id',index:'pac_id', width:55,hidden:true},
                {name:'pac_nombres',index:'pac_nombres', width:90,align:'center'},
                {name:'pac_apellido_paterno',index:'pac_apellido_paterno', width:100,align:'center'},
                {name:'pac_apellido_materno',index:'pac_apellido_materno', width:100, align:"center"},
                {name:'pac_edad',index:'pac_edad', width:80, align:"center"},		
                {name:'pac_telefono',index:'pac_telefono', width:80,align:"center"},		
                {name:'pac_direccion',index:'pac_direccion', width:200, sortable:false,align:'center'},
                {name:'ciu_nombre',index:'ciu_nombre', width:150, sortable:false,align:'center'},		
                {name:'actions',index:'actions', width:100,align:'center', sortable:false}		
            ],
            rowNum:10,
            rowList:[10,20,30],
            pager: '#pager2',
            sortname: 'pac_id',
            viewrecords: true,
            sortorder: "desc",
            //            caption:"Pacientes",
            height:'auto'   
            ,gridComplete:function(){
                var ids = $('#list2').jqGrid('getDataIDs');
                for(var i=0 ; i<ids.length;i++){
                    edit = "<a class=\"edit\" style=\"cursor: pointer;\" rel=\""+ids[i]+"\" title=\"Editar\" >Editar</a>";
                    trash = "<a class=\"trash\" style=\"cursor: pointer;\" rel=\""+ids[i]+"\" title=\"Eliminar\" >Eliminar</a>";
                    $("#list2").jqGrid('setRowData',ids[i],{actions:edit+trash});
                }
                $('.edit').button({
                    icons:{
                        primary: 'ui-icon-pencil'
                    },
                    text: false
                });
                $('.trash').button({
                    icons:{
                        primary: 'ui-icon-trash'
                    },
                    text: false
                });                
                
            }
        });
        jQuery("#list2").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false});
        
        $('.edit').live('click',function(){
            // $('.frmSubtitle').text(subtitle_edit_commission);
            var idi=$(this).attr('rel');
          
            $.ajax({
                url:'<?php echo site_url("paciente/retornar_pacientexId"); ?>',
                type: 'POST',            
                dataType:'json',
                data:{idi:idi},
                success:function(response){
                    if(response.code == 441){
                        //$(".frmSubtitle").text(frm_edit_subtitle);
                        $("#pac_id").val(response.data.pac_id);
                        $("#pac_nombres").val(response.data.pac_nombres);
                        $("#pac_ape_paterno").val(response.data.pac_apellido_paterno);
                        $("#pac_ape_materno").val(response.data.pac_apellido_materno);
                        $("#pac_edad").val(response.data.pac_edad);
                        $("#pac_telefono").val(response.data.pac_telefono);
                        $("#pac_direccion").val(response.data.pac_direccion);
                        $("#list_ciudades").val(response.data.ciu_id);
                        
                        $('#frmPacientesDiv').dialog('open');
                    } else {
                        alert('Error al Retorar los Datos');
                    }
                }
            });

        });
        
        
        $('#btn_nuevo_paciente').button({
            icons:{
                primary: "ui-icon-plus"
            }
        }).click(function(){
            validar_frmPacientes.currentForm.reset();
            $('#frmPacientesDiv').dialog('open');
        });
        
        $('#frmPacientesDiv').dialog({
            title:'Administración de Pacientes',
            autoOpen:false,
            width:470,
            modal:true,
            resizable: false,
            show: "slide",
            hide: "fade",
            buttons: {
                "Aceptar": function() {
                    
                    $('form#frmPacientes').submit()
                },
                'Cancelar':function(){
                    $( this ).dialog( "close" );
                }
            }
        });
        
                
        var select =$('#list_ciudades');
        $.ajax({
            type: 'POST',
            url:'<?php echo site_url("paciente/listar_ciudades"); ?>',
            dataType:'json',
            success: function(resp){
                if(resp.code == 441){
                    var option = '<option value="[VALUE]">[LABEL]</option>';
                    $('option', select).remove();
                    $(select).append(option.replace('[VALUE]', 0,'g').replace('[LABEL]','<?php echo '-Seleccione un Origen-'; ?>', 'g'));
                    $.each(resp.data, function(index, array) {
                        $(select).append(option.replace('[VALUE]', array['ciu_id'],'g').replace('[LABEL]',array['ciu_nombre'], 'g'));
                    });
                }else{
                    msgBox(resp.msg,resp.code);
                }
            }
        });
        
        //FIN CLICK ELIMINAR		
        $('.trash').live('click',function(){    
            var idPac= $(this).attr("rel");
           
            $("#frmeliminar").dialog({
                title: 'Eliminar',
                modal: true,
                width: 400 , 
                buttons: [
                    {
                        id:"btndelno",
                        text: "No",
                        click: function() { $(this).dialog("close"); }
                    },
                    {
                        id:"btndelsi",				
                        text: "Si",
                        click: function() {
							
                            $.ajax({
                                type: "POST",
                                dataType: "json",
                                cache:false,
                                url: "<?php echo site_url("paciente/eliminar_paciente"); ?>",
                                data:{idi:idPac},
                                error:function(){
                                    $('#avisodel').fadeOut();
                                    alert("Ocurri� un error...");
                                    $("#btndelno").attr('disabled', false);
                                    $("#btndelsi").attr('disabled', false);

                                },
                                success: function(data) {
                                    if(data.code==441){
											
                                        $("#frmeliminar").dialog("close");	
                                        jqgrid_paciente.trigger("reloadGrid");				
                                    }
                                }
                            });
			
                        }
                    }
			
                ]});

          
	
            $("#btndelno").attr('style', 'color:#990000');
            $("#btndelsi").attr('style', 'color:#009900');	
            $("#btndelno").attr('disabled', false);
            $("#btndelsi").attr('disabled', false);
				
        });
    });
</script>

<!-- dialog eliminar-->
<div id="frmeliminar" title="" style="display: none;">

    <div id="avisodel" style="display:none; background:#FC6;border:1px solid #F90;width:350px;margin-bottom:10px;margin-top:10px;padding:10px;border-radius:3px;-webkit-border-radius:3px;-moz-border-radius:3px;behavior: url(<?php echo base_url(); ?>js/PIE.htc);">
        Procesando... espere un momento por favor...
    </div>

    <div id="anunciodel" style="display:none;color:#FFF; background:#F33;border:1px solid #C30;width:350px;margin-bottom:10px;margin-top:10px;padding:10px;    border-radius: 3px;-webkit-border-radius: 3px;-moz-border-radius: 3px;behavior: url(<?php echo base_url(); ?>js/PIE.htc);">
        Int&eacute;ntelo de nuevo por favor...
    </div>              

    &iquest; Est&aacute; seguro que quiere eliminar este registro ?

</div>
<!-- fin dialog eliminar-->

<div>
    <button id="btn_nuevo_paciente" id="btn_nuevo_paciente" type="button">Nuevo Paciente</button>
</div>
<div style="clear: both;"></div>
<table id="list2"></table>
<div id="pager2"></div>

<div id="frmPacientesDiv" style="display: none;">

    <form id="frmPacientes" action="" method="POST">
        <fieldset class="ui-widget ui-widget-content ui-corner-all">
            <legend class="frmSubtitle ui-widget ui-widget-content ui-corner-all ui-widget-header" style="margin-left: 10px; padding: 5px;">Nuevo Tipo de Requerimientos</legend>

            <div class="label_output">
                <div class="rowElem">
                    <label>Nombres:</label>
                    <input id="pac_nombres" name="pac_nombres" type="text" value=""/>
                </div>
                <div class="rowElem">
                    <label>Apellido Paterno:</label>
                    <input id="pac_ape_paterno" name="pac_ape_paterno" type="text" value=""/>
                </div>
                <div class="rowElem">
                    <label>Apellido Materno:</label>
                    <input id="pac_ape_materno" name="pac_ape_materno" type="text" vavaluel=""/>
                </div>
                <div class="rowElem">
                    <label>Edad:</label>
                    <input id="pac_edad" name="pac_edad" type="text" value=""/>
                </div>
                <div class="rowElem">
                    <label>Telefono:</label>
                    <input id="pac_telefono" name="pac_telefono" type="text" value=""/>
                </div>
                <div class="rowElem">
                    <label>Direcci&oacute;n:</label>
                    <input id="pac_direccion" name="pac_direccion" type="text" value=""/>
                </div>

                <div class="rowElem">
                    <label>Ciudad:</label>
                    <select id="list_ciudades" name="list_ciudades">
                        <option value="0">Seleccione una ciudad</option>

                    </select>
                </div>
            </div>

        </fieldset>
        <input id="pac_id" name="pac_id" type="hidden" value="0"/>
    </form>    
</div>
