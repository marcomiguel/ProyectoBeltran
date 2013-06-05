<!--<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css" type="text/css" media="all" />-->
<style type="text/css">
    .ui-jqgrid tr.jqgrow td {white-space: normal; padding: 3px;} 
    .ui-widget input{background-color: #fff;};
</style>
<script type="text/javascript">
    $(document).ready(function(){
		
        //VALIDACION
        var validar_frmMedicos = $('form#frmMedicos').validate({
            rules:{
                med_nombres:{
                    required:true,
                    minlength:1
                },
                med_ape_paterno:{
                    required:true,
                    minlength:1
                } 
            },
            messages:{
                med_nombres:{
                    required:'Nombre Obligatorio',
                    minlength:jQuery.format('se requiere al menos {0} caracteres para el nombre.')
                },
                med_ape_paterno:{
                    required:'Apellido Obligatorio',
                    minlength:jQuery.format('se requiere al menos {0} caracteres para el apellidos.')
                } 
            },
            submitHandler:function(form){
               
                // gets the id stored in the anchor as attribute
                var datastring = $(form).serialize();
                var url = "<?php echo site_url("medico/agregar_medico"); ?>";
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
                        jqgrid_medico.trigger('reloadGrid');
                        $('div#frmMedicosDiv').dialog('close');
                    }
                    ,error: function(data){
                        console.log('Error---> '+data.code);
                    }
                });           
            }   
        });
        //FIN VALIDACION
	
        var jqgrid_medico= jQuery("#list2").jqGrid({
            url:'<?php echo site_url("medico/listar"); ?>',
            datatype: "json",
            mtype:"POST",
            colNames:['Id','Nombres', 'Apellido paterno', 'Apellido materno','Especialidad','Telefono','Dirección','Centro Laboral','Acciones'],
            colModel:[
                {name:'med_id',index:'pac_id', width:55,hidden:true},
                {name:'med_nombres',index:'med_nombres', width:90,align:'center', search:true},
                {name:'med_apellido_paterno',index:'med_apellido_paterno', width:120,align:'center', search:true},
                {name:'med_apellido_materno',index:'med_apellido_materno', width:120, align:"center", search:true},
                {name:'esp_nombre',index:'esp_nombre', width:120, align:"center", search:true},
                {name:'med_telefono',index:'med_telefono', width:120, align:"center", search:true},	
                {name:'med_direccion',index:'med_direccion', width:120, align:"center", search:true},	
                {name:'cenl_nombre',index:'cenl_nombre', width:120, align:"center", search:true},	
                {name:'actions',index:'actions', width:80, align:"center", search:false}	
            ],
            rowNum:10,
            rowList:[10,20,30],
            pager: '#pager2',
            sortname: 'med_id',
            viewrecords: true,
            sortorder: "desc",
            rownumbers:true,
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
        // jQuery("#list2").jqGrid('navGrid','#pager2',{edit:false,add:false,del:false});
        jQuery("#list2").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false}); 
        
        $('#btn_nuevo_medico').button({
            icons:{
                primary: "ui-icon-plus"
            }
        }).click(function(){
            //validar_frmPacientes.currentForm.reset();
            $('#frmMedicosDiv').dialog('open');
        });
		
        $('#frmMedicosDiv').dialog({
            title:'Administración de Médicos',
            autoOpen:false,
            width:470,
            modal:true,
            resizable: false,
            show: "slide",
            hide: "fade",
            buttons: {
                "Aceptar": function() {
                    
                    $('form#frmMedicos').submit()
                },
                'Cancelar':function(){
                    $( this ).dialog( "close" );
                }
            }
        });
		
        var select =$('#list_especialidades');
        $.ajax({
            type: 'POST',
            url:'<?php echo site_url("medico/listar_especialidades"); ?>',
            dataType:'json',
            success: function(resp){
                if(resp.code == 441){
                    var option = '<option value="[VALUE]">[LABEL]</option>';
                    $('option', select).remove();
                    $(select).append(option.replace('[VALUE]', 0,'g').replace('[LABEL]','<?php echo '-Seleccione una especialidad-'; ?>', 'g'));
                    $.each(resp.data, function(index, array) {
                        $(select).append(option.replace('[VALUE]', array['esp_id'],'g').replace('[LABEL]',array['esp_nombre'], 'g'));
                    });
                }else{
                    msgBox(resp.msg,resp.code);
                }
            }
        });
		
        var select_cl =$('#med_centro_lab');
        $.ajax({
            type: 'POST',
            url:'<?php echo site_url("medico/listar_centro_laboral"); ?>',
            dataType:'json',
            success: function(resp){
                if(resp.code == 441){
                    var option = '<option value="[VALUE]">[LABEL]</option>';
                    $('option', select_cl).remove();
                    $(select_cl).append(option.replace('[VALUE]', 0,'g').replace('[LABEL]','<?php echo '-Seleccione Centro Lab.-'; ?>', 'g'));
                    $.each(resp.data, function(index, array) {
                        $(select_cl).append(option.replace('[VALUE]', array['cenl_id'],'g').replace('[LABEL]',array['cenl_nombre'], 'g'));
                    });
                }else{
                    msgBox(resp.msg,resp.code);
                }
            }
        });
		
    });
</script>

<!--<div>
    <button id="btn_nuevo_paciente" id="btn_nuevo_paciente" type="button">Nuevo Médico</button>
</div>-->
<div style="clear: both;"></div>

<div style="margin: 0 auto; width: 100%;">
    <button id="btn_nuevo_medico" id="btn_nuevo_medico" type="button">Nuevo Médico</button>
    <br/>
    <table id="list2"></table>
    <div id="pager2"></div>
</div>

<div id="frmMedicosDiv" style="display: none;">

    <form id="frmMedicos" action="post.php" method="POST">
        <fieldset class="ui-widget ui-widget-content ui-corner-all">
            <legend class="frmSubtitle ui-widget ui-widget-content ui-corner-all ui-widget-header" style="margin-left: 10px; padding: 5px;">Nuevo Tipo de Requerimientos</legend>
            <div class="label_output">
                <div class="rowElem">
                    <label>Nombres:</label>
                    <input id="med_nombres" name="med_nombres" type="text" value=""/>
                </div>
                <div class="rowElem">
                    <label>Apellido Paterno:</label>
                    <input id="med_ape_paterno" name="med_ape_paterno" type="text" value=""/>
                </div>
                <div class="rowElem">
                    <label>Apellido Materno:</label>
                    <input id="med_ape_materno" name="med_ape_materno" type="text" valuel=""/>
                </div>
                <div class="rowElem">
                    <label>Especialidad:</label>

                    <select id="list_especialidades" name="list_especialidades">
                        <option value="0">Seleccione una especialidad</option>

                    </select>
                </div>
                <div class="rowElem">
                    <label>Telefono:</label>
                    <input id="med_telefono" name="med_telefono" type="text" value=""/>
                </div>
                <div class="rowElem">
                    <label>Celular:</label>
                    <input id="med_celular" name="med_celular" type="text" value=""/>
                </div>
                <div class="rowElem">
                    <label>Direcci&oacute;n:</label>
                    <input id="med_direccion" name="med_direccion" type="text" value=""/>
                </div>

                <div class="rowElem">
                    <label>Centro de Laboral:</label>

                    <select id="med_centro_lab" name="med_centro_lab">
                        <option value="0">Seleccione Centro Lab.</option>

                    </select>
                </div>
            </div>

        </fieldset>
        <input id="med_id" name="med_id" type="hidden" value="0"/>
    </form>    
</div>

