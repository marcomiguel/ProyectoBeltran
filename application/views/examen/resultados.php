<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css" type="text/css" media="all" /><!--
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.ee4.4/jquery.min.js"></script>

--><script src="<?php echo base_url(); ?>js/jquery.tools.min.js"></script>

<style type="text/css">
    .ui-jqgrid tr.jqgrow td {white-space: normal; padding: 3px;} 
    .ui-jqgrid .ui-jqgrid-htable th div {
        height: auto;
        overflow: hidden;
        position: relative;
        white-space: normal;
    }
    .padding5 {
        padding: 5px;
    }
    .input-append input{
        background-color:#fff;
        width: 300px;
    }   
    .isEspecial{   
        margin: 0px;
        padding: 0px;
    }
    .mys_input_result_antibiograma_sensible{
        width: 50px;
    }
    .mys_input_result_value{
        width: 150px;
    }
</style>

<style>
    /* main vertical scroll */
    #main_scroll {
        position:relative;
        overflow:hidden;
        height: 450px;
    }

    /* root element for pages */
    #pages {
        position:absolute;
        height:20000em;
    }

    /* single page */
    .page {
        padding:10px 10px 10px 10px;
        height: 450px;
        background:#49A006;
        width:550px;
    }

    /* root element for horizontal scrollables */
    .scrollable {
        position:relative;
        overflow:hidden;
        width: 510px;
        height: 450px;
    }

    /* root element for scrollable items */
    .scrollable .items {
        width:20000em;
        position:absolute;
        clear:both;
    }

    /* single scrollable item */
    .item {
        float:left;
        cursor:pointer;
        width:525px;
        height:450px;
        padding:10px 10px 10px 10px;
    }

    /* main navigator */
    #main_navi {
        float:left;
        padding:0px !important;
        margin:0px !important;
    }

    #main_navi li {
        background-color:#459E00;
        border-top:1px solid #666;
        clear:both;
        color:#FFFFFF;
        font-size:12px;
        height:45px;
        list-style-type:none;
        padding:10px;
        width:150px;
        cursor:pointer;
    }

    #main_navi li:hover {
        background-color:#6FBF4D;
    }

    #main_navi li.active {
        background-color:#FAFAF4;
        color:#459E00;
    }

    #main_navi img {
        float:left;
        margin-right:10px;
    }

    #main_navi strong {
        display:block;
    }

    #main div.navi {
        margin-left:250px;
        cursor:pointer;
    }
    .hidden_antobiograma{
        display: none;
    }
    .show_antobiograma{
        display: block;
    }
</style>

<script type="text/javascript">
    var flags = {};
    flags.idPaciente=0;
    var div_ind_especial='';
    
    $(document).ready(function(){
        $('.isEspecial').button().live('click', function(){
            $('#frmHematograma input#input_idInd').val($(this).attr('data-id'));
            $('#frmHematograma input#input_idDetalleInd').val($(this).attr('data-idDet'));
            $('#frmHematograma').dialog('open');
        });
        
        $('#frmHematograma').dialog({
            title:'<?php echo "Indicador Especial"; ?>',
            autoOpen:false,        
            autoSize:true,
            modal:true,
            resizable:false,
            closeOnEscape:false,
            width:'auto',
            height:'auto',
            buttons:{
                'Guardar':function(){
                    var o_datos_form = $('#frmHematograma').serialize();
                    $.ajax({
                        url:'<?php echo site_url("examen/guardar_resultado_indicador_especial"); ?>',
                        type: 'POST',            
                        dataType:'json',
                        //async:true,
                        data:o_datos_form,
                        success:function(response){
                            if(response.code == 441){
                                //console.log(response.data);
                                msgBox("Hemograna Guardado Correctamente","Aviso");
                                $('#frmHematograma').dialog('close');
                            } else {
                                alert('Error al Retorar los Datos');
                            }
                        }
                    });              
                },
                'Cerrar':function(){
                    $('#frmHematograma').dialog('close');
                    //window.location.reload();
                }
            },
            close: function(event, ui) {
                //window.location.reload();
            }
            
        });
        //Buscar Pacientes
        $( "#input_search" ).autocomplete({
            minLength: 1,
            autoFocus: true,
            source:function(req,response){
                
                $.ajax({ 
                    url:'<?php echo site_url("examen/listar_pacintes"); ?>',
                    dataType:"json",  
                    data:{
                        term:function(){
                            return req.term;
                        }                      
                    },
                    type:'post',
                    success:function(r){ 
                       
                        if(r.code==441){ 
                            response($.map(r.data,function(i){ 
                                var text= '<span class="spanSearchLeft">' + i.pac_fullname + '</span>';     
                                
                                text+= '<div class="clear"></div>';      
                                return{
                                    label:text.replace(
                                    new RegExp("(?![^&;]+;)(?!<[^<>]*)(" +
                                        $.ui.autocomplete.escapeRegex(req.term) +
                                        ")(?![^<>]*>)(?![^&;]+;)", "gi")
                                    ,"<strong>$1</strong>" ),
                                    value: i.pac_fullname,
                                    idPerson:i.pac_id
                                } 
                              
                            }));                        
                            
                        }
                        else{
                            console.log('error',r);
                        }                        
                    }  
                });
            },
            select: function( event, ui ) {                
                var id = ui.item.idPerson;   
                
                $('#input_search').attr('rel',id);                
                flags.idPaciente = id;
                             
                tableExamenes_jqgrid.trigger('reloadGrid');
              
            },
            change: function( event, ui ) {
                if ( !ui.item ) {                                       
                    return false;
                }                
                
                return true;
            }
        }).data( "autocomplete" )._renderItem = function( ul, item ) {               
            return $( "<li></li>" )
            .data( "item.autocomplete", item )
            .append( "<a>" + item.label + "</a>" )
            .appendTo( ul );
        };  
        // Fin Buscar Pacientes
        
        /* Lista de Examenes */
        tableExamenes_jqgrid = jQuery("#listExamenes").jqGrid({
            url:'<?php echo site_url("examen/listar_examenes"); ?>',
            datatype: "json",
            mtype:"POST",
            postData:{
                i_idexamen:function(){
                    return flags.idPaciente; 
                }
            },
            colNames:['ID','Cod. Examen','Estado','Fecha de Registro','Nombre Paciente', 'Nombre Médico','Estado Pago','Monto a Cobrar (S/.)','Adelanto (S/.)','Restante (S/.)','Acciones'],
            colModel:[
                {name:'id',index:'id', width:55,align:'center',hidden:true},
                {name:'exa_cod',index:'exa_cod', width:80,align:'center'},
                {name:'exa_estado',index:'exa_estado', width:100,align:'center'},
                {name:'exa_fregistro',index:'exa_fregistro', width:130,align:'center'},
                {name:'pac_fullname',index:'pac_fullname', width:150,align:'center'},
                {name:'med_fullname',index:'med_fullname', width:150,align:'center'},
                {name:'exa_estado_pago',index:'exa_estado_pago', width:100,align:'center'},                
                {name:'exa_monto',index:'exa_monto', width:70,align:'center'},                
                {name:'exa_monto_prepago',index:'exa_monto_prepago', width:70,align:'center'},                
                {name:'exa_monto_restante',index:'exa_monto_restante', width:70,align:'center'},                
               
                {name:'acciones',index:'acciones', width:100,align:'center'},
                		
            ],
            rowNum:10,
            height:'auto',
            rowList:[10,20,30],
            pager: '#listExamenes_paper',
            sortname: 'exa_id',           
            viewrecords: true,
            rownumbers:true,
            sortorder: "desc",           
            caption: "Lista de Análisis Realizados por Paciente"
            ,gridComplete:function(){
                var ids = $('#listExamenes').jqGrid('getDataIDs');
                for(var i=0 ; i<ids.length;i++){
                    renDatos = jQuery("#listExamenes").getRowData(ids[i]);   
                    if(renDatos.exa_estado != 'cancelado'){
                        register = "<a class=\"register\" style=\"cursor: pointer;\" rel=\""+ids[i]+"\" title=\"Registrar\" >Registrar</a>";
                        exportToWord = "<a class=\"export\" style=\"cursor: pointer;\" rel=\""+ids[i]+"\" title=\"Exportar\" >Exportar</a>";
                        cancel = "<a class=\"cancel\" style=\"cursor: pointer;\" rel=\""+ids[i]+"\" title=\"Cancel\" >Cancel</a>";
                        $("#listExamenes").jqGrid('setRowData',ids[i],{acciones:register+exportToWord+cancel});
                    }
                }
                $('.register').button({
                    icons:{
                        primary: 'ui-icon-folder-collapsed'
                    },
                    text: false
                });
                $('.export').button({
                    icons:{
                        primary: 'ui-icon-print'
                    },
                    text: false
                });
                $('.cancel').button({
                    icons:{
                        primary: 'ui-icon-circle-close'
                    },
                    text: false
                });
                               
                
            }
          
        });
        
        $('.register').live('click', function(){
          
            var mi_lu = $("#main_navi");
            var miclass_active = "";
            var miclass_hide_antibiograma = "hidden_antobiograma";
            var miclass_show_antobiograma = "show_antobiograma";
            var page = '<div class="page" id="[NAMEPAGE]" rel="[IDEXAMEN]"><div class="navi"></div><div class="scrollable"><div class="items"><div class="item"><div><form style="background-color: #FFFFFF;"><h4 style="text-align: center; color: #41729B;">[NAME]</h4>[TABLE]</form></div></div></div></div></div>';
            var table_ini = '<table id="[IDTABLE]" class="table table-striped table-bordered table-condensed">';
            
            var thead= '<thead><tr>'+       
                '<th>#</th>'+
                '<th class="yellow">Indicador</th>'+
                '<th class="blue">Resultado</th>'+
                '<th class="green">Medida</th>'+
                '<th class="orange">Rango</th>'+
                '</tr></thead><tbody id="[IDTBODY]">';
            
            var thead2 = '<thead><tr>'+       
                '<th>#</th>'+
                '<th class="yellow">Indicador</th>'+
                '<th class="blue">Valoración</th>'+
                '<th class="green">Resultado</th>'+
                '</tr></thead><tbody id="[IDTBODY]">';
            
            
            var table_fin='</tbody></table>';
            
            $.ajax({
                url:'<?php echo site_url("examen/listar_tipoexamen"); ?>',
                type: 'POST',            
                dataType:'json',
                data:{idExamen:$(this).attr('rel')},
                success:function(response){
                    if(response.code == 441){
                        //console.log(response.data);
                        var li = '<li class="[CLASE] [CLASE2]"  data-isAntibiograma="[VALUE2]"><img src="<?php echo base_url() ?>/images/lab.png"/><strong data-id="[VALUE]">[LABEL]</strong></li>';
                        $('li', mi_lu).remove();
                        $.each(response.data, function(index, array) {
                            if(index==0)
                                miclass_active = "active"
                            else
                                miclass_active = ""
                            //$(mi_lu).append(li.replace('[VALUE]', array['exad_id'],'g').replace('[LABEL]',array['exad_nombre'], 'g').replace('[CLASE]',miclass_active, 'g').replace('[CLASE2]',miclass_show_antobiograma, 'g'));  
                            
                            
                            if(array['tex_antibiograma']==1){
                                mi_header = thead2;
                                $(mi_lu).append(li.replace('[VALUE]', array['exad_id'],'g').replace('[LABEL]',array['exad_nombre'], 'g').replace('[CLASE]',miclass_active, 'g').replace('[VALUE2]',1, 'g').replace('[CLASE2]',miclass_show_antobiograma, 'g'));
                            }else{
                                mi_header = thead;
                                $(mi_lu).append(li.replace('[VALUE]', array['exad_id'],'g').replace('[LABEL]',array['exad_nombre'], 'g').replace('[CLASE]',miclass_active, 'g').replace('[VALUE2]',0, 'g'));  
                            }
                     
                            /*  Las Pages */
                            array['indd_valor_resultante']==null?'':array['indd_valor_resultante']
                            
                            
                            $('div#pages').append((page).replace('[NAMEPAGE]','pg_'+array['exad_nombre']).replace('[IDEXAMEN]',array['exad_id']).replace('[NAME]',array['exad_nombre']).replace('[TABLE]',table_ini+mi_header+table_fin).replace('[IDTABLE]',array['exad_id']).replace('[IDTBODY]','tb_'+array['exad_id']));
                            
                            //console.log('ID',array['exad_id']);
                            //console.log('juju',fnDetalleINdicadores(array['exad_id']));
                        });                        
                        $('.show_antobiograma').hide();
                       
                        
                        //$(".frmSubtitle").text(frm_edit_subtitle);
                        //                        $("#pac_id").val(response.data.pac_id);
                        //                        $("#pac_nombres").val(response.data.pac_nombres);
                        //                        $("#pac_ape_paterno").val(response.data.pac_apellido_paterno);
                        //                        $("#pac_ape_materno").val(response.data.pac_apellido_materno);
                        //                        $("#pac_edad").val(response.data.pac_edad);
                        //                        $("#pac_telefono").val(response.data.pac_telefono);
                        //                        $("#pac_direccion").val(response.data.pac_direccion);
                        //                        $("#list_ciudades").val(response.data.ciu_id);
                        
                        fnMiScroll();
                        $('#listaIndicadoresDiv').dialog('open');
                        $( "ul#main_navi" ).find('li.active').trigger('click');
                      
                    } else {
                        alert('Error al Retorar los Datos');
                    }
                }
            });
           
        });
        
        $('.export').live('click', function(){        
            idExamen=$(this).attr('rel')
            $('input#print_idExamen').val(idExamen);
            $('div#typePrintExamenDiv').dialog('open')
         
           
        });
        
        /* fin Lista de Examenes */     
        
        /* Dialog Detalle de Examen */
        $('#listaIndicadoresDiv').dialog({
            title:'<?php echo "Lista de Exámenes Realizados por Paciente"; ?>',
            autoOpen:false,        
            autoSize:true,
            modal:true,
            resizable:false,
            closeOnEscape:false,
            width:770,
            height:600,
            buttons:{
                //                'Agregar':function(){
                //                    
                //                },
                'Cerrar':function(){
                    $('#listaIndicadoresDiv').dialog('close');
                    window.location.reload();
                }
            },
            close: function(event, ui) {
                window.location.reload();
            }
        });
        /*  fin de Dialog */
        $( "ul#main_navi" ).on('click','li',function(){
        
            //ar a_tr='<tr>[LISTTD]</tr>';
            mi_this_general = $(this).data('isantibiograma');
            console.log(mi_this_general);
            //data-isantibiograma
                    
            var a_tr='<tr></tr>';
            div_ind_especial='<div data-id="0" data-idDet="0" class="isEspecial"></div>';
            div_ind_hematograma='<div data-id="0" data-idDet="0" class="isHematograma"></div>';
            var mi_id = $(this).find('strong').data('id');
            
            $('.isEspecial').remove();
            $.ajax({
                url:'<?php echo site_url("examen/listar_indicadoresByExamen"); ?>',
                type: 'POST',            
                dataType:'json',
                async:true,
                data:{idTipoExamen:$(this).find('strong').data('id')},
                success:function(response){
                    // if(response.code == 441){
                    //var table_b = '<table class="table table-striped table-bordered table-condensed">';
                    //var thead = '<thead><tr><th>#</th><th class="yellow">Indicador</th><th class="blue">Resultado</th><th class="green">Medida</th><th class="orange">Rango</th></tr></thead>';
                    //var tr = '<tbody><tr><td>jjjj</td></tr></tbody>';
                    //var table_e = '</table>';
                    //a_tr = ''; 
                    $('.item #tb_'+mi_id+' tr').remove();
                        
                    $.each(response.data, function(index, array) {
                        // tr.replace('[TD]','<td>'+array['indd_nombre']+'</td>');
                        //a_tr.replace('[LISTTD]','dsfsd','g')
                        //if(eval(array['idIndicador'])!=26)
                            
                        if(eval(array['idIndicador'])==26){  
                            is_espaecial = 1;
                            a_tr = '<tr>'+
                                '<td>'+eval(index+1)+'</td>'+'<td>'+array['ind_descripcion']+'</td>'+'<td><input class="input-mini" data-id_Ind="'+array['indd_id']+'" id="input_ind_'+array['indd_id']+'" name="input_ind_'+array['indd_id']+'" type="text" value="'+(array['indd_valor_resultante']==null?'':array['indd_valor_resultante'])+'"/></td><td>'+array['ind_unidad_medida']+'</td>'+'<td>'+array['ind_rango_referencial']+'</td>'
                                +'</tr>';
                        
                            div_ind_especial = $(div_ind_especial).attr('data-id',array['idIndicador']).attr('data-idDet',array['indd_id']).append(array['ind_descripcion']);
                            $('.item #tb_'+mi_id).append(div_ind_especial);
                            /******** Llenar Hemograma *******/
                            console.log(array['indd_id']);
                            idDetExamen = array['indd_id'];
                            $.ajax({
                                url:'<?php echo site_url("examen/listar_hematograma"); ?>',
                                type: 'POST',            
                                dataType:'json',
                                async:true,
                                data:{idDetExamen:idDetExamen},
                                success:function(response){
                                    console.log(response.data);
                                    console.log(response.count);
                                    if(eval($.trim(response.count))!=0){
                                        $(response.data).each(function(){                                        
                                            $('input#input_idInd').val(this.inde_id);
                                            $('input#input_idDetalleInd').val(this.indd_id);
                                            $('input#input_leucocitos').val(this.die_leucocitos);
                                            $('input#input_mielo').val(this.die_mielo);
                                            $('input#input_juv').val(this.die_juv);
                                            $('input#input_abs').val(this.die_abs);
                                            $('input#input_seg').val(this.die_seg);
                                            $('input#input_oe').val(this.die_eo);
                                            $('input#input_bas').val(this.die_bas);
                                            $('input#input_mon').val(this.die_mon);
                                            $('input#input_linf').val(this.die_linf);
                                            $('textarea#input_observacion').val(this.die_observaciones);
                                            $('input#input_Neutrofilos').val(this.die_neutrofilos);
                                            $('input#input_indd_id').val(this.indd_id);
                                        });
                                    }
                                }
                                
                            });
                        }else if(eval(array['es_antibiograma'])==1){
                            console.log('Antibiograma');
                            div_ind_hematograma = $(div_ind_hematograma).attr('data-id',array['idIndicador']).attr('data-idDet',array['indd_id']).append(array['ind_descripcion']);
                            $('.item #tb_'+mi_id).append(div_ind_hematograma);
                        }else{
                            if(mi_this_general==1)
                            {
                                a_tr = '<tr>'+
                                    '<td>'+eval(index+1)+'</td>'+'<td>'+array['ind_descripcion']+'</td><td><textarea class="input-large" data-id_Ind="'+array['indd_id']+'" id="input_ind_'+array['indd_id']+'" name="input_ind_'+array['indd_id']+'" type="text">'+(array['indd_valor_resultante']==null?'':array['indd_valor_resultante'])+'</textarea></td><td><button type="button" class="my_button_antibiograma" data-id_Ind="'+array['indd_id']+'" >Guardar Resultado</button></td><td>'+array['ind_rango_referencial']+'</td>'
                                    +'</tr>';
                             
                                //$('.item #tb_'+mi_id).append(a_tr); 
                            }else{
                              
                                a_tr = '<tr>'+
                                    '<td>'+eval(index+1)+'</td>'+'<td>'+array['ind_descripcion']+'</td>'+'<td><input class="mys_input_result_ind" data-id_Ind="'+array['indd_id']+'" id="input_ind_'+array['indd_id']+'" name="input_ind_'+array['indd_id']+'" type="text" value="'+(array['indd_valor_resultante']==null?'':array['indd_valor_resultante'])+'"/></td><td>'+array['ind_unidad_medida']+'</td>'+'<td>'+array['ind_rango_referencial']+'</td>'
                                    +'</tr>';
                        
                            }
                            
                            $('.item #tb_'+mi_id).append(a_tr); 
                           
                        }
                           
                     
                        //console.log('div_ind_especial',div_ind_especial); 
                        //$(div_ind_especial).append(array['idIndicador']==26?array['ind_descripcion']:'NO')
                        
                        //console.log('tr',$('.item #tb_'+mi_id).append(a_tr));
                        //LLENAR CUADRO DETALLE
                       
                        
                    });
                    //                    if(is_espaecial==1){
                    //                        
                    //                    }else{
                    //                      $('.item #tb_'+mi_id).append(a_tr);   
                    //                    }
                    
                    //$.each(response.data, function(i, value){
                    //$("div#tbl_2").append(table_b+thead+table_e);   
                    //console.log('table',(table_b+thead+tr+table_e),'ind',i,value.indd_nombre,value.ind_unidad_medida,value.ind_rango_referencial);
                    //alert(value.indd_nombrey+'table'+table);
                    //console.log(table_b+thead+table_e);
                    //});
                        
                    //                    } else {
                    //                        alert('Error al Retorar los Datos');
                    //      
                    //                                  }
                    
                    //console.log('tr',a_tr);
                    
                    //                    if((($('#pages').find('.page').eq($(this).find('strong').data('id')-1)).find('table tbody').text())==""){
                    //                        console.log((($('#pages').find('.page').eq($(this).find('strong').data('id')-1)).find('table')).append('<tr>dfdf</tr>'));
                    //                    }
                    $('.isEspecial').button();   
                }
                
                
            });
            
            // console.log('huhuhu',$(this).find('li :selected').text());
            //            var mi_tbl2 = $('#tbl_2');
            //            console.log('huhuhu',$(this).find('strong').data('id'));
            //            console.log((($('#pages').find('.page').eq($(this).find('strong').data('id')-1)).find('table tbody').text()));
            //            
            //            if((($('#pages').find('.page').eq($(this).find('strong').data('id')-1)).find('table tbody').text())==""){
            //                console.log((($('#pages').find('.page').eq($(this).find('strong').data('id')-1)).find('table')).append(a_tr));
            //            }
        });
  
        
        fnMiScroll = function(){

            // main vertical scroll
            $("#main_scroll").scrollable({

                // basic settings
                vertical: true,

                // up/down keys will always control this scrollable
                keyboard: 'static',
                
                onSeek: function(){
                   
                }

                // assign left/right keys to the actively viewed scrollable
                //                onSeek: function(event, i) {
                //                    console.log('midsd',$(this).find('strong').attr('data-id'));
                //                    console.log($( "#main_navi li" ).find('strong').text());
                //                    console.log(event);
                //                    horizontal.eq(i).data("scrollable").focus();
                //                }

                // main navigator (thumbnail images)
            }).navigator("#main_navi");
            
            // horizontal scrollables. each one is circular and has its own navigator instance
            var horizontal = $(".scrollable").scrollable({ circular: true }).navigator(".navi");


            // when page loads setup keyboard focus on the first horzontal scrollable
            horizontal.eq(0).data("scrollable").focus();
        }
        
        fnDetalleINdicadores = function(idTipoExamen){
        
            $.ajax({
                url:'<?php echo site_url("examen/listar_indicadoresByExamen"); ?>',
                type: 'POST',            
                dataType:'json',
                //async:true,
                data:{idTipoExamen:idTipoExamen},
                success:function(response){
                    if(response.code == 441){
                        console.log(response.data);
                    } else {
                        alert('Error al Retorar los Datos');
                    }
                }
            });
            return response.data;
        }
        
        fnSaveIndicadores = function(idIndicador,dato_resultado){
        
            $.ajax({
                url:'<?php echo site_url("examen/guardar_resultado_indicador"); ?>',
                type: 'POST',            
                dataType:'json',
                //async:true,
                data:{idIndicador:idIndicador, dato_resultado:dato_resultado},
                success:function(response){
                    if(response.code == 441){
                        console.log(response.data);
                        //$('#input_ind_'+idIndicador).css('color', '#6AAB33');
                    } else {
                        alert('Error al Retorar los Datos');
                    }
                }
            });
            //return response.data;
        }
        fnActivarKeydown();  
        
        
        //
        $('input[name=reg_pago_credito]').change(function(){
            if($(this).is(':checked')){
                $('#sec_pago_credito').show();
            }else{
                $('#sec_pago_credito').hide();
                $('input#reg_pago_adelanto').val(0);
            }
        });
        
        //INICIO CANCELAR
        msgDiv = $("span.titleDiv").html();
        titleContent = $("span.msgContent").html();
        $(".cancel").live("click",function(){
    
            var i_idExamen = $(this).attr("rel");
            confirmBox(titleContent,msgDiv,function(response){
                if(response == true)
                {
                    $.ajax(
                    {
                        type: "POST",
                        url: '<?php echo site_url("examen/cancelar_examen"); ?>',                        
                        dataType:'json',
                        data: {idExamen : i_idExamen},
                        success: function(r){
                            if(r.code==441){   
                                tableExamenes_jqgrid.trigger('reloadGrid');
                            } else {
                                msgBox(r.msg,r.code);
                            }
                        }
                    });
                }
            });
            return false;
        });
        //FIN CANCELAR
        
        
        confirmBox = function(message, title,fn)
        {
            $("div.confirmBox").remove();
            $("body").append("<div class=\"confirmBox\" >"+message+"</div>");
            $("div.confirmBox").dialog({
                autoOpen: false,
                modal:true,
                title:title,
                buttons:[
                    {
                        text: 'Ok',
                        click: function() {
                            $(this).remove();
                            fn(true);
                        }
                    },{
                        text: 'Cerrar',
                        click: function() {
                            $(this).remove();
                            fn(false);
                        }
                    }
                ],
                close: function(event, ui)
                {
                    fn(false);
                    $(this).remove();
                },

                open: function(event, ui)
                {
                    $(this).focus();
                }
            });

            $("div.confirmBox").dialog('open');
        }
        
        /* Mensaje Box*/
        msgBox = function(text, title, after)
        {
            $("div.msgbox").each(function() {
                $(this).remove();
            });
            $("body").append("<div class='msgbox' >"+text+"</div>");
            var dlg = $("div.msgbox");
            $("div.msgbox").dialog({
                autoOpen: true,
                modal:true,
                title:title,
                position:'center',
                minWidth:350,
           
                close: function(event, ui)
                {
                    $(dlg).remove();
                    if ( typeof(after) == 'function' ) after();
                },
                open: function(event, ui)
                {
                    $(dlg).find("button").focus();
                },
                buttons:[{
                        text: "Aceptar",
                        click: function() {
                            $(dlg).remove();
                            if( typeof(after) == 'function' ){
                                after();
                            }
                        }
                    }]
            });       
        }
        /* Fin de Mesaje Box*/
        
        /*********Buttons Antibiograma********/
        $('.my_button_antibiograma').button({
            icons: {
                primary: "ui-icon-circle-check"
            },
            text: false
        }).live('click',function(e){
            e.preventDefault();
            
            var i_id_ind = $(this).attr('data-id_Ind'); 
            console.log('act8888',i_id_ind );
            var d_valor = $('textarea#input_ind_'+i_id_ind+'').val();
            console.log(d_valor);
                           
            fnSaveIndicadores(i_id_ind,d_valor)
            
        });
       
        $('a#btnconfirmationPrintVoucherOne').click(function(){
           
            idExamen = $('#print_idExamen').val();
            var url='<?php echo site_url("examen/printDataToExport"); ?>'+'/'+idExamen;
            document.location.href=url;
            //window.open('http://galenox/forms/f_authorizationform_pdf.php?s_authorizationForm_id='+authorizationForm_id, 'Authorization Form Printing');            
            $('div#typePrintExamenDiv').dialog('close');
        });
            
        $('a#btnconfirmationPrintVoucherTwo').click(function(){
            idExamen = $('#print_idExamen').val();
            var url='<?php echo site_url("examen/printDataToExport_mitad"); ?>'+'/'+idExamen;
            document.location.href=url;    
            $('div#typePrintExamenDiv').dialog('close');
        });
        // Ventana de Impresion
        $('div#typePrintExamenDiv').dialog({
            title:"Impresion de Examen Clinico",
            autoOpen:false,        
            autoSize:true,
            modal:true,
            resizable:false,
            closeOnEscape:true,
            width:'auto',
            open: function(event, ui) {
                $(document).bind('keydown.ac1','1',function(){ 
                    $('a#btnconfirmationPrintVoucherOne').trigger('click');
                });            
                $(document).bind('keydown.ac2','2',function(){
                    $('a#btnconfirmationPrintVoucherTwo').trigger('click');        
                   
                });
             
            },
            close: function(event, ui) {
                $(document).unbind('keydown.ac1');
                $(document).unbind('keydown.ac2');                   
            }
        });
        
        //Activar Antibiograma
        $("input[name=view_antibiograma]").live('click', function(){
            if($(this).prop('checked'))
                $('.show_antobiograma').show();
            else
                $('.show_antobiograma').hide();
        });
        
    });
    
    //FUNCIONES
         
    function fnActivarKeydown(){       
       
        $("tr input").live('keydown',function(event){ 
           
            //console.log('act',this);
            var i_id_ind = $(this).attr('data-id_Ind'); 
            var d_valor = $(this).val();
            if(event.keyCode=="13"){
                event.preventDefault();                
                fnSaveIndicadores(i_id_ind,d_valor)
            }
      
        });
    }
</script>


<div style="width: 41%; margin: 0 auto;" class="ui-corner-all ui-widget-header ui-state-focus search_header">
    <div id="gbusqueda" class="padding5">
        <div class="control-group">
            <div class="controls">
                <div class="input-append" style="width: 90%; margin: 0 auto;">
                    <input id="input_search" name="input_search" rel="0" class="span2" type="text" size="16">
                    <span class="add-on">
                        <i class="icon-envelope"></i>
                    </span>
                </div>
<!--                <p class="help-block">z</p>-->
                <div style="clear: both;"></div>
            </div>
        </div>
    </div>
</div>

<div style="width: 100%; margin: 20px auto;">       
    <div style="clear: both;"></div>
    <table id="listExamenes"></table>
    <div id="listExamenes_paper"></div>
</div>

<!-- main navigator -->
<div id="listaIndicadoresDiv">
    <ul id="main_navi">


    </ul>

    <!-- root element for the main scrollable -->
    <div id="main_scroll">

        <!-- root element for pages -->
        <div id="pages">

        </div>
        <!--        <div id="pages">
        
                     page #1 
                    <div class="page">
        
                         sub navigator #1 
                        <div class="navi"></div>
        
                         inner scrollable #1 
                        <div class="scrollable">
        
                             root element for scrollable items 
                            <div class="items">
        
                                 items  
                                <div class="item">
                                    <div>
                                        <form style="background-color: #FFFFFF;">
                                            <h4 style="text-align: center; color: #41729B;">Examen: Orina Completa - Urocultiva</h4>
                                            <table class="table table-striped table-bordered table-condensed">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th class="yellow">Indicador</th>
                                                        <th class="blue">Resultado</th>
                                                        <th class="green">Medida</th>
                                                        <th class="orange">Rango</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>Mark</td>
                                                        <td style="text-align: center;"><input type="text" class="input-medium" placeholder="Ingresar Valor..."></td>
                                                        <td>CSS</td>
                                                        <td>CSS</td>
                                                    </tr>
                                                    <tr>
                                                        <td>2</td>
                                                        <td>Jacob</td>
                                                        <td style="text-align: center;"><input type="text" class="input-medium" placeholder="Ingresar Valor..."></td>
                                                        <td>Javascript</td>
                                                        <td>Javascript</td>
                                                    </tr>
                                                    <tr>
                                                        <td>3</td>
                                                        <td>Stu</td>
                                                        <td style="text-align: center;"><input type="text" class="input-medium" placeholder="Ingresar Valor..."></td>
                                                        <td>HTML</td>
                                                        <td>HTML</td>
                                                    </tr>
                                                    <tr>
                                                        <td>4</td>
                                                        <td>Brosef</td>
                                                        <td style="text-align: center;"><input type="text" class="input-medium" placeholder="Ingresar Valor..."></td>
                                                        <td>HTML</td>
                                                        <td>HTML</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </form>
                                    </div>
                                </div>
        
                            </div>
        
                        </div>
        
                    </div>
        
                     page #2 
                    <div class="page">
        
                        <div class="navi"></div>
        
                         inner scrollable #2 
                        <div class="scrollable">
        
                             root element for scrollable items 
                            <div class="items">
        
                                 items on the second page 
                                <div class="item">
                                    <div id="tbl_2">
                                        <form style="background-color: #FFFFFF;">
                                            <h4 style="text-align: center; color: #41729B;">Examen: Orina Completa - Urocultiva</h4>
                                            <table class="table table-striped table-bordered table-condensed">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th class="yellow">Indicador</th>
                                                        <th class="blue">Resultado</th>
                                                        <th class="green">Medida</th>
                                                        <th class="orange">Rango</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>Mark</td>
                                                        <td style="text-align: center;"><input type="text" class="input-medium" placeholder="Ingresar Valor..."></td>
                                                        <td>CSS</td>
                                                        <td>CSS</td>
                                                    </tr>
                                                    <tr>
                                                        <td>2</td>
                                                        <td>Jacob</td>
                                                        <td style="text-align: center;"><input type="text" class="input-medium" placeholder="Ingresar Valor..."></td>
                                                        <td>Javascript</td>
                                                        <td>Javascript</td>
                                                    </tr>
                                                    <tr>
                                                        <td>3</td>
                                                        <td>Stu</td>
                                                        <td style="text-align: center;"><input type="text" class="input-medium" placeholder="Ingresar Valor..."></td>
                                                        <td>HTML</td>
                                                        <td>HTML</td>
                                                    </tr>
                                                    <tr>
                                                        <td>4</td>
                                                        <td>Brosef</td>
                                                        <td style="text-align: center;"><input type="text" class="input-medium" placeholder="Ingresar Valor..."></td>
                                                        <td>HTML</td>
                                                        <td>HTML</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </form>
                                    </div>
        
                                </div>
        
                            </div>
        
                        </div>
        
        
                    </div>
        
        
                     page #3 
                    <div class="page">
        
                        <div class="navi"></div>
        
                         inner scrollable #3 
                        <div class="scrollable">
        
                             root element for scrollable items 
                            <div class="items">
        
                                 items on the first page 
                                <div class="item">
                                    sdfsd
                                    <img src="http://farm4.static.flickr.com/3155/2636513939_cd75b704ec.jpg" />
                                </div>
        
                            </div>
        
                        </div>
        
                    </div>
        
                </div>-->

    </div>
    <div class="clearfix"></div>
    <div>
        <input type="checkbox" id="view_antibiograma" name="view_antibiograma" /><label for="view_antibiograma">Llenar Antobiograma</label>
    </div>
</div>

<script>
    // What is $(document).ready ? See: http://flowplayer.org/tools/documentation/basics.html#document_ready
    $(document).ready(function() {


    
        
    });
</script>


<span style="display: none;" class="titleDiv"><?php echo "Cancelar Examen"; ?></span>
<span style="display: none;" class="msgContent"><?php echo "¿Está seguro que desea Cancelar Examen?"; ?></span>

<form id="frmHematograma" class="form-horizontal">
    <fieldset>
        <legend>Hemograma</legend>
        <div class="controls">
            <label class="control-label" for="input_idInd">ID:</label>
            <input type="text" class="input-small" id="input_idInd" name="input_idInd">
        </div>
        <div class="controls">
            <label class="control-label" for="input_idDetalleInd">ID Det:</label>
            <input type="text" class="input-small" id="input_idDetalleInd" name="input_idDetalleInd">
        </div>
        <div class="control-group">
            <label class="control-label" for="input_leucocitos">Leucocitos: </label>
            <div class="controls">
                <input type="text" class="input-medium" id="input_leucocitos" name="input_leucocitos" placeholder="Leucocitos">
            </div>
            <div class="well form-horizontal" style="padding: 10px; margin: 10px; width:550px;">
                <h4>Fórmula diferencial</h4>
                <div style=" width: 250px; float: left;">                    
                    <label class="control-label" for="input_mielo">Mielo:</label>
                    <div class="controls">
                        <input type="text" class="input-small" id="input_mielo" name="input_mielo">
                    </div>
                    <label class="control-label" for="input_juv">Juv.:</label>
                    <div class="controls">
                        <input type="text" class="input-small" id="input_juv" name="input_juv">
                    </div>
                    <label class="control-label" for="input_abs">Abs.:</label>
                    <div class="controls">
                        <input type="text" class="input-small" id="input_abs" name="input_abs">
                    </div>
                    <label class="control-label" for="input_seg">Seg.:</label>
                    <div class="controls">
                        <input type="text" class="input-small" id="input_seg" name="input_seg">
                    </div>
                </div>
                <div style=" width: 250px; float: left;">
                    <label class="control-label" for="input_oe">Oe:</label>
                    <div class="controls">
                        <input type="text" class="input-small" id="input_oe" name="input_oe">
                    </div>
                    <label class="control-label" for="input_bas">Bas.:</label>
                    <div class="controls">
                        <input type="text" class="input-small" id="input_bas" name="input_bas">
                    </div>
                    <label class="control-label" for="input_mon">Mon.:</label>
                    <div class="controls">
                        <input type="text" class="input-small" id="input_mon" name="input_mon">
                    </div>
                    <label class="control-label" for="input_linf">Linf.:</label>
                    <div class="controls">
                        <input type="text" class="input-small" id="input_linf" name="input_linf">
                    </div>
                </div>
                <br/>
                <div class="control-group">
                    <label class="control-label" for="input_observacion">Observación</label>
                    <div class="controls">
                        <textarea class="input-xlarge" id="input_observacion" name="input_observacion"></textarea>
                    </div>
                </div>
                <div style="clear: both;"></div>
            </div>
            <label class="control-label" for="input_Neutrofilos">Neutrofilos: </label>
            <div class="controls">
                <input type="text" class="input-medium" id="input_Neutrofilos" name="input_Neutrofilos" placeholder="Neutrófilos">
            </div>
            <div class="controls">
                <input type="text" class="input-medium" id="input_indd_id" name="input_indd_id" value="0">
            </div>
        </div>
    </fieldset>
</form>
<!-- ELEGIR TIPO DE EIMPRESIÓN-->
<div id="typePrintExamenDiv">
    <p>Elegir el Tamaño de Hoja de Impresión</p>
    <ul>
        <li><a style="cursor: pointer;" id="btnconfirmationPrintVoucherOne">(1)Tamaño A4 [Hoja Grande]</a></li>
        <li><a style="cursor: pointer;" id="btnconfirmationPrintVoucherTwo">(2)Tamaño A5 [Hoja Mitad]</a></li>
    </ul>
    <div><input id="print_idExamen" name="print_idExamen" type="hidden" value="0"/></div>
</div>
<!-- FIN DE IMPRESION>
