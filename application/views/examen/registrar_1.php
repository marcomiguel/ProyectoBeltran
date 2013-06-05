<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css" type="text/css" media="all" />
<link rel="stylesheet" href="<?php echo base_url(); ?>css/tipTip.css" type="text/css" media="all" />

<script src="<?php echo base_url(); ?>js/jquery.tipTip.js"></script>
<style type="text/css">
    .ui-jqgrid tr.jqgrow td {white-space: normal; padding: 3px;} 
    .ui-widget input{background-color: #fff;}

    .input_form{width: 150px;}
    #div_register_client{position: absolute;top:0;left: 0;z-index: 50;
                         box-shadow: rgba(0, 0, 0, 1) 0 0 5px;
                         -webkit-box-shadow: rgba(0, 0, 0, 1) 0px 0px 5px;}
    #div_register_client .divLine,.divLine.autoPayment{width: auto;}
    .divLine{width:310px;}
    #div_register_client .arrow_left{
        left: -25px;
        top: 22px;
    }

    .divContentPadding{
        width: 950px;
        margin: 0 auto;
    }

    .divContentPadding ul li{
        /*        width: 450px;*/
        float:left;
        list-style-type: none;
    }
    #li_tablaDetalle{
        width: 550px;
        float:left;
        list-style-type: none;
    }
    #li_panelPago{
        width: 235px;
        float:right;
        list-style-type: none;
    }
    .input-pago{
        text-align: right;
    }

    .ui-widget-content input[type="text"].ui-autocomplete-loading ,
    .ui-widget-content textarea.ui-widget-content.ui-autocomplete-loading { background-image: url('/images/ui-anim_loading_16x16.gif');background-position: right center;background-repeat: no-repeat; }
    .ui-widget-content textarea.ui-widget-content.ui-autocomplete-loading { background-position: right top;}

</style>
<style type="text/css">
    body{background-color: white;}
    div#subcontent{margin-top: 0px;}
    .div-border{
        border: red solid thin;
        background-color: white;
    }
    .g-margin{margin: 5px;}
    #cmp-container{
        border-bottom: 1px solid #EEEEEE;
    }
    .component{
        border-radius: 4px;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        float: left;
        margin: 5px;
        font-size: 1.5em;
    }
    .active-link{
        background-color: #5BB25B;
        text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
        border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
        background-image: -moz-linear-gradient(center top , #62C462, #57A957);
        background-image: linear-gradient(center top , #62C462, #57A957);
        background-image: -webkit-linear-gradient(top, #62C462, #57A957);
        background-image: -o-linear-gradient(top, #62C462, #57A957);
        background-image: linear-gradient(top, #62C462, #57A957);
        background-repeat: repeat-x;
        /*        color: white;*/
    }

    .component > div{ margin: 5px;}
    .component:hover,.active-link:hover,.deactive-link:hover,.open-link:hover{
        background-position: 0 -15px;
        cursor: pointer;
    }
    .opt-item:hover,.open-link:hover,.active-link:hover,.deactive-link:hover{
        cursor: default;
    }
    div#opt-items{margin-left: 15px;}
    div#opt-container{margin: 0 auto; width: 90%;}
    div#opt-title{
        margin-top:15px;
        margin-bottom:15px;
        width: 40%;
        text-align: center;
        font-size: 1.7em;
        line-height: 2em;
        position: relative;
    }
    .opt-item{
        width: 250px;
        height: 25px; 
        margin: 1px 1px 1px 80px;
        font-size: 1.2em;
        line-height: 1.7em;
        border: 1px solid #EEEEEE;
        float: left;
        position: relative;
        text-align: center;
        clear: both;
    }
    .opt-item-sub{
        width: 210px;
        height: auto;
        margin: 1px 1px 1px 100px;
        font-size: 1.1em;
        line-height: 1.5em;
        border: 1px solid #EEEEEE;
        float: left;
        left: 50px;
        /*position: absolute;*/
        text-align: center;
        clear: both;
        white-space: normal;

    }

    /*    .opt-item > div > div:first-child{
            text-align: center;
        }*/

    .opt-item-value{
        width: 100px;
        float: left;
        margin-left: 20px;

    }
    .opt-item-sDesc{
        width: 300px;
        float: left;
        margin-left: 20px;
    }
    .opt-item-sDesc > div:hover{
        text-decoration: underline;
        cursor: pointer;
    }
    .opt-item-sDesc div, .opt-item-lDesc{
        padding: 4px;
        line-height: 1em;
        color:gray;
        text-align: justify;
    }
    .opt-item-lDesc{
        margin-left: 20px;
        margin-right: 20px;
        overflow: auto;
    }
    .opt-item-ico{
        width: 16px;
        height: 16px;
        background-repeat: no-repeat;
        position: absolute;
        cursor: pointer;

    }

    .opt-item-number{
        width: 32px;
        height: 32px;
        background-repeat: no-repeat;
        position: absolute;
        background-image: url('/media/ico/ico_circle_black.png');
        top: -12px; left: -12px;
        text-align: center;
        line-height: 32px;
        color: white;
        font-weight: bold;
    }
    .opt-item-edit-cancel{
        background-image: url('/media/ico/ico_cancel.png');
        top: 5px;right: 5px;
    }
    .opt-item-edit-save{
        background-image: url('/media/ico/ico_save_16x16.png');
        top: 24px;right: 5px;
    }

    .search-msg{
        position: absolute; 
        right: 5px; 
        min-width: 100px;
        max-width: 250px;
        line-height: 1.5em;
        font-size: 1.2em;
        display: none;
    }

</style>
<script type="text/javascript">
    var sumTotal = 0;
    var iCountItem = 0;
    var iCountItemInd = 0;
    var ind_arrayDetails = new Object(); 
    var arrayDetails = new Object(); 
    var idExamen = 0;
    var tableIndicadres_jqgrid;
    var flags = {};
    var nIndicadores = 0;
    /**/
    var ind_miArray = new Array()
    var name_miArray = new Array()
    
    $(document).ready(function(){
        //Buscar Pacientes
        $( "#reg_paciente" ).autocomplete({
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
                
                $('#reg_paciente').attr('rel',id);
              
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
        
        //Buscar Médicos
        $( "#reg_medicos" ).autocomplete({
            minLength: 1,
            autoFocus: true,
            source:function(req,response){
                
                $.ajax({ 
                    url:'<?php echo site_url("examen/listar_medicos"); ?>',
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
                                var text= '<span class="spanSearchLeft">' + i.med_fullname + '</span>';     
                                
                                text+= '<div class="clear"></div>';      
                                return{
                                    label:text.replace(
                                    new RegExp("(?![^&;]+;)(?!<[^<>]*)(" +
                                        $.ui.autocomplete.escapeRegex(req.term) +
                                        ")(?![^<>]*>)(?![^&;]+;)", "gi")
                                    ,"<strong>$1</strong>" ),
                                    value: i.med_fullname,
                                    idPerson:i.med_id
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
                
                $('#reg_medicos').attr('rel',id);
              
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
        // Fin Buscar Médicos
        
        $( "#group_examen" ).buttonset();
        $( "#group_examen_2" ).buttonset();
        
        iCountItemInd=0;
        //        $( "#group_examen li" ).click(function(event){
        //            
        //            id = $(this).find('input').attr('id'); 
        //            status = $(this).find('label').attr('aria-pressed');
        //            name = $(this).find('label').text();
        //            //            if(status=='false'){
        //            //             
        //            //                fnMostrarDialog(id,name);
        //            //                console.log('sddf1',  iCountItemInd++);
        //            //            }else{
        //            //                console.log("El Examen Ya ha sido regsitrado...Quitar del Detalle y volver a Ingrear.");
        //            //                msgBox("El Examen Ya ha sido regsitrado...Quitar del Detalle y volver a Ingrear.","Alerta");
        //            //                event.preventDefault();
        //            //            }
        //
        //            console.log('sddf222',  iCount2ItemInd++);
        //            fnMostrarDialog(id,name);
        //           
        //              
        //        });
        
        $( ".opt-item" ).live('click',function(event){
            
            id = $(this).attr('rel'); 
            name = $(this).text();
            esOrina = $(this).attr('data-esOrina');
            console.log(esOrina);
          
            //if($(this).data('is_parent')==0 || $(this).attr('rel')==1)
            //if($(this).data('is_parent')==0 || $(this).attr('rel')==1)
                fnMostrarDialog(id,name,esOrina);
        });
        
        $( ".opt-item-sub" ).live('click',function(event){
            
            id = $(this).attr('rel'); 
            name = $(this).text();
      
            fnMostrarDialog(id,name);
        });
        
        $('#detalleIndicadoresDiv').dialog({
            title:'<?php echo "Lista de Indicadores"; ?>',
            autoOpen:false,        
            autoSize:true,
            modal:true,
            resizable:false,
            closeOnEscape:true,
            width:'auto',
            buttons:{
                'Agregar':function(){   
                    var itemDetail = new Object();
                    ind_miArray = []
                    name_miArray = []
                                      
                    var cadIndicadores = "";
                    var indIndicadores ="";
                    var temp_ind = 0;
                    //Set<String> s = new LinkedHashSet<String>(ind_arrayDetails);
                    console.log('size1',Objectsize(ind_arrayDetails));
                    
                    console.log('key',$('#get_idIndicador').attr('data-isorina'));
                    
                    $.each(ind_arrayDetails, function(index, value) { 
                        ind_miArray.push([value.IDindicadores]);
                        name_miArray.push([value.indicadores]);
                      
                    }); 
                    
                    console.log('size2',ind_miArray);
                    console.log('size2',name_miArray);
                    
                    //console.log('dede',miArray.distinct().join(','));
                    //                    console.log('dede',ind_miArray);
                    //                    console.log('dedeww',name_miArray);
                    $.each(unique(ind_miArray) , function(index, value) { 
                        indIndicadores+= value+',';
                      
                    }); 
                    $.each(unique(name_miArray) , function(index, value) {                       
                        cadIndicadores+= value;
                        cadIndicadores+=', ';
                    }); 
                    
                    
                    /********************/
                    itemDetail.idExamen= $('#get_idIndicador').attr('data-cod'); 
                    itemDetail.nameExamen= $('#get_idIndicador').text(); 
                    itemDetail.idIndicadores= indIndicadores; 
                    itemDetail.getTotal= $('#sumTotal').text(); 
                    
                    arrayDetails[iCountItem] = itemDetail;
    
                     
                    
                    tblPackageDetail.addRowData(iCountItem, {
                        id:iCountItem+1,
                        examenOut:$('#get_idIndicador').text(),
                        idIndicadorOut:$('#get_idIndicador').attr('data-cod'),
                        precioOut:$('#sumTotal').text(),
                        idIndicadorOut:unique(ind_miArray),
                        inidicadoresOut:unique(name_miArray)
                                  
                    }); 
                    /******************/
                    
                    iCountItem++;
                    $('#detalleIndicadoresDiv').dialog('close');
                    iCountItemInd=0;
                    reinitiarObject(ind_arrayDetails);
                      
                },
                'Cancelar':function(){
                    $('#detalleIndicadoresDiv').dialog('close');
                }
            }
          
        });
        
        //Grid Indicadores
        $('#jqgh_listIndicadores_cb').hide();
        //CountItemInd=0;
        tableIndicadres_jqgrid = jQuery("#listIndicadores").jqGrid({
            url:'<?php echo site_url("examen/listar_indicadores"); ?>',
            datatype: "json",
            mtype:"POST",
            postData:{
                i_idexamen:function(){
                    return idExamen; 
                }
            },
            colNames:['ID','Nombre Indicador', 'Precio (S/.)'],
            colModel:[
                {name:'id',index:'id', width:55,align:'center',hidden:true},
                {name:'nameind',index:'nameind', width:400},
                {name:'precioind',index:'precioind', width:150,align:'center'},
                		
            ],
            rowNum:10,
            rowList:[10,20,30],
            pager: '#listIndicadores_paper',
            sortname: 'ind_id',
            multiboxonly: false,
            viewrecords: true,
            sortorder: "asc",
            multiselect: true,
            caption: "Lista de Indicadores con Precios"
            ,onSelectRow: function(rowid, status) {    
                
                var ind_itemDetail = new Object();                    
                //               
                rendatos = tableIndicadres_jqgrid.getRowData(rowid);                 
                //                    
                ind_itemDetail.IDindicadores = rendatos.id;
                ind_itemDetail.indicadores = rendatos.nameind;
              
                if(status){                    
                    sumTotal=parseFloat(sumTotal)+parseFloat(rendatos.precioind);
                   
                    ind_arrayDetails[iCountItemInd] = ind_itemDetail; 
                    iCountItemInd++;
                    console.log(ind_arrayDetails);
                    //delete arrayDetails[$(this).data('idout')];                      
                    //setTimeout(function(){tblPackageDetail.delRowData(id_delete);},200);
                    //console.log('iCountItemInd',iCountItemInd);
                }else{
                    sumTotal=parseFloat(sumTotal)-parseFloat(rendatos.precioind);
                    $.each(ind_arrayDetails, function(index, value) { 
                
                        if(value.IDindicadores == rowid){
                            delete ind_arrayDetails[index]; 
                            //setTimeout(function(){tblPackageDetail.delRowData(id_delete);},200);
                        }
                      
                    });
                                        
                    //setTimeout(function(){tblPackageDetail.delRowData(id_delete);},200);
                    //console.log('ind_arrayDetails',ind_arrayDetails);
                }
                $('#sumTotal').text(sumTotal);
                //  
            }
      
        });
        
        //DETALLE DE PAGO
        $('.delItem').live('click', function(){  
            var id_delete =$(this).data('idout');
            
            delete arrayDetails[$(this).data('idout')];                      
            setTimeout(function(){tblPackageDetail.delRowData(id_delete);},200);
        });
        
        var tblPackageDetail = $('#luggageDetail_jqGrid').jqGrid({            
            height: 200,                        
            width:'auto',
            datatype: 'local',
            sortable: false,
            rownumbers:true,
            colNames:[      
                "ID",
                "Examen",
                "Hidden Debe",
                "Precio (S/.)",
                "Indicadores",                         
                "Opcion"
            ],
            colModel:[     
                {name:'id',index:'id', width:55,hidden:true},
                {name:'examenOut',index:'examenOut',width:120,align: 'center'},
                {name:'idIndicadorOut',index:'idIndicadorOut',width:120,align: 'center',hidden:true},
                {name:'precioOut',index:'precioOut',width:120,align: 'center'},
                {name:'inidicadoresOut',index:'inidicadoresOut',width:290,align: 'center'},
                {name:'optionsOut',index:'optionsOut', width:90, align: 'center'}
            ],
            viewrecords: true,
            sortname: 'idOut',            
            gridview : true,
            rownumbers: true,      
            rownumWidth: 40,            
            footerrow:true,            
         
            gridComplete:function(){
                try{
                    var aIDs = tblPackageDetail.getDataIDs();
                    $.each(aIDs,function(){                   
                        deleteOption = "<button class='delItem' type='button' data-idout='"+this+"'>Delete</button>"
                        editOption = "<button class='editItem' type='button' data-idout='"+this+"'>Editar</button>"
                        tblPackageDetail.setRowData(this,{                        
                            optionsOut: deleteOption
                        });
                       
                    });
                
                    $('.delItem').button({
                        icons: {
                            primary: 'ui-icon-trash'
                        }
                        ,text: false
                    });
                    $('.editItem').button({
                        icons: {
                            primary: 'ui-icon-pencil'
                        }
                        ,text: false
                    });
                    //                 
                    var aGridData = tblPackageDetail.getRowData(),
                    fTotalAmountSum = 0;
                
                    $.each(aGridData,function(i, oRowData){                    
                        fTotalAmountSum += parseFloat(oRowData.precioOut);  
                                           
                    });
                    
                    tblPackageDetail.footerData('set',{examenOut:'TOTALES',precioOut:fTotalAmountSum.toFixed(2)});
                    
                    $('#pago_generado').val(fTotalAmountSum.toFixed(2));
                    $('#pago_efectivo').val(eval(fTotalAmountSum.toFixed(2)));
                
                }catch(e){
                    //GG
                }
            }
        });
        
        formHeaderPackage = $('#formHeaderExamen').validate();
        if(formHeaderPackage.form()){    
            //                                                                          
            //                            $overlay.css('display', 'block');
            //                            $divPaymentShadow.css('display', 'block');
            //                            $divPaymentContent.css('display', 'block');
                                                                                    
        }
        //REGISTRAR PAGO
        $('#btn_registerPago').button({
            icons: {
                primary: 'ui-icon-disk'
            }            
        }).click(function(){
            var oData = new Object();
            
            oData.paciente = $('#reg_paciente').attr('rel');
            oData.medico = $('#reg_medicos').attr('rel');
            oData.pago_efectivo = $('input#pago_efectivo').val();
            oData.pago_adelanto = $('input#reg_pago_adelanto').val();
            
            oData.detail = arrayDetails;
            
            /*sdsd*/
            var url = "<?php echo site_url("examen/agregar_examen"); ?>";
            // instantiate and executes the ajax
            $.ajax({
                type: 'POST',
                cache:'false',
                url: url,
                data: oData,
                dataType:'json',
                async: true,
                success: function(response){
                 
                    alert("Examen Registrado Correctamente.");
                    //                        jqgrid_paciente.trigger('reloadGrid');
                    //                        $('div#frmPacientesDiv').dialog('close');
                }
                ,error: function(response){
                    alert("ERROR: El Examen No Registrado Correctamente.");
                }
            });
        });
      
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
        
        
        $('#reg_pago_credito').change(function(){
            if($('#reg_pago_credito').is(':checked')){
                $('#sec_pago_credito').show();
            }else{
                $('#sec_pago_credito').hide();
                $('#reg_pago_adelanto').val(0);
            }
        });
        
        loadOptions();
        
        $('.opt-item-sDesc').button();
    });       
        
        
    //FUNCIONES
    //MOSTRAR INDICADORES
    function fnMostrarDialog(id,name,esOrina){
        //$('#'+id).click(function(event){
        $('#get_idIndicador').text(name);
        $('#get_idIndicador').attr('data-cod',id);
        $('#get_idIndicador').attr('data-isOrina',esOrina);
                
        //REINICIA DIALOG
        sumTotal = 0;
        countIgual = 0;
        $('#sumTotal').text(sumTotal);
        
        //Sirve para enviar valores en el POST Listr_indicadores
        idExamen=id;
                    
        tableIndicadres_jqgrid.trigger('reloadGrid');
            
        $.each(arrayDetails, function(key, value) { 
            if(value.idExamen == id)
                countIgual++;
        });
            
        if(countIgual!=0){
            msgBox("El Examen Ya ha sido regsitrado...Quitar del Detalle y volver a Ingrear.","Alerta");
                
        }else{
            $('#detalleIndicadoresDiv').dialog('open');
            $('#jqgh_listIndicadores_cb').hide();
        }
        //  });
    }
    
    //Retornar 
    var url = "<?php echo site_url("examen/getTipoExamen"); ?>";
    function loadOptions(){
        var params = new Object();
        //        if(typeof cmp !=null) params.cmp = cmp;
        params.key = null;
        $.ajax({
            url:url,
            type: 'POST',            
            dataType:'json',
            data:params,    
            success:function(response){
                
                $.each(response.data,function(idx,obj){
                    var option = $(document.createElement('div')).attr('rel',obj['tex_id']).attr('data-is_parent',obj['subExamenes']).attr('data-esOrina',obj['tex_esOrina']).attr('data-orinaOrder',obj['tex_orina_order']).addClass('opt-item ui-corner-all active-link').css('color',obj['tex_color']);
                    option.append(obj['tex_descripcion']);
                 
                    var option_number = $(document.createElement('div')).attr('rel',obj['tex_id']).addClass('o.pt-item-number').text(eval(idx+1));
                    option_number.attr('title',obj['tex_id']);
                    option_number.tipTip({maxWidth: "auto", edgeOffset: 0, defaultPosition:'right',activation:'click',fadeIn:0,fadeOut:0});
                    $('div#opt-items').append(option);
                    if(obj['subExamenes']>0){
               
                        loadSubExamenes(obj['tex_id'])
                        //var option_expand = $(document.createElement('div')).addClass('opt-item-ico opt-item-expand ui-helper-hidden').attr('title',expand_txt);
                        //                                $.data(option_expand.get(0),'key',obj.key);
                        //                                $.data(option_expand.get(0),'cmp',null);
                        //                                $.data(option_expand.get(0),'gn',obj.groupName);
                        //                                option_expand.click(expandOption);
                        //                                option.append(option_expand);

                        //var option = $(document.createElement('div')).addClass('opt-item ui-corner-all');
                        //option.append(obj['tex_id']);
                    }
                    
                    
                });
            }
        });
    }
    
    function loadSubExamenes(id){
        var params = new Object();
        //        if(typeof cmp !=null) params.cmp = cmp;
        params.key = id;
        $.ajax({
            url:url,
            type: 'POST',            
            dataType:'json',
            async:false,
            data:params,
            success:function(response){              
                $.each(response.data,function(idx,obj){
                    //var option = $(document.createElement('div')).addClass('opt-item ui-corner-all');                   
                    
                    var div_sp =  $(document.createElement('div')).attr('rel',obj['tex_id']).addClass('opt-item-sub ui-corner-all active-link').css('color',obj['tex_color']);
                    div_sp.append(obj['tex_descripcion']);
                    var div_p =  $(document.createElement('div')).css({clear:'both',position:'relative'}).addClass('opt-item-value ui-corner-all').append(div_sp);
                   
                    
                    $('div#opt-items').append(div_sp);
                });
                
            }
        });
    }
    //Fin de Listar Examenes
    
    // Tamanio de Objeto
    function  Objectsize(obj) {
        var size = 0, key;
        for (key in obj) {
            if (obj.hasOwnProperty(key)) size++;
        }
        return size;
    };
    
    function reinitiarObject(object){
        //var o_size = Objectsize(object);
        var key;
        for (key in object) {
            if (object.hasOwnProperty(key)) 
                delete object[key];
        }
        return object;
    }
    
    //
    //ASIGNAR FLAGS
    function fnCrearFlags(){

        var datos = new Array();
<?php
foreach ($tipos_examen as $key => $values) {

    echo "\n datos[" . $values['tex_id'] . "] = '" . $values['tex_descripcion'] . "';";
}
?>

        return datos[8];

    } 
    
    function unique(arr) {
        var hash = {}, result = [];
        for ( var i = 0, l = arr.length; i < l; ++i ) {
            if ( !hash.hasOwnProperty(arr[i]) ) { //it works with objects! in FF, at least
                hash[ arr[i] ] = true;
                result.push(arr[i]);
            
            }
        }
        return result;
    }

</script>
<div>
    <fieldset>
        <div class="divContentPadding">
            <form action="" class="orderForm" id="formHeaderExamen">
                <ul>
                    <li>
                        <div class="divLine">
                            <!--PACIENTE-->
                            <dl>
                                <dd>
                                    <label for="reg_paciente"><? echo "Paciente"; ?>:</label>
                                </dd>
                                <dd>
                                    <input class="input-xlarge" type="text" id="reg_paciente" name="reg_paciente" value="" rel="0" placeholder="Buscar Paciente…"/>

                                </dd>
                            </dl>
                            <div class="clear"></div>
                        </div>
                    </li>
                    <li>
                        <div class="divLine">
                            <!--PACIENTE-->
                            <dl>
                                <dd>
                                    <label for="reg_paciente"><? echo "M&eacute;dico"; ?>:</label>
                                </dd>
                                <dd>
                                    <input class="input-xlarge" type="text" id="reg_medicos" name="reg_medicos" value="" rel="" placeholder="Buscar Médico…"/>

                                </dd>
                            </dl>
                            <div class="clear"></div>
                        </div>
                    </li>                  
                </ul>

            </form>

            <ul style="width: 55%; margin: 0 auto;">
                <li>
                    <div id="miSearch"  class="ui-corner-all ui-widget-header ui-state-active">

                        <div id="opt-container">                            
                            <div id="opt-items">
                            </div>
                        </div>
                    </div>


                </li>
            </ul>
            <div style="clear: both;"></div>
            <lu>
                <li style="list-style-type: none;">
                    <div style="margin: 10px auto; width: 300px; text-align: center;" class="ui-corner-all ui-state-default">Detalle de Pago</div>
                </li>
            </lu>
            <div style="clear: both;"></div>
            <ul>
                <li id="li_tablaDetalle">
                    <div id="migrilla_exceso" style="height: 250px;">
                        <table id="luggageDetail_jqGrid"></table>

                    </div>
                </li>                
                <li id="li_panelPago">
                    <div class="ui-corner-all ui-widget-header ui-state-active" style="height: 235px; padding-top: 10px;">
                        <dl>
                            <dd>
                                <label for="reg_paciente"><? echo "Pago Generado"; ?>:</label>
                            </dd>
                            <dd style="text-align: center;">
                                <input class="input_form ui-widget ui-widget-content ui-corner-all input-pago" type="text" id="pago_generado" name="pago_generado" value="" rel="0" readonly/>

                            </dd>
                        </dl>

                        <dl>
                            <dd>
                                <label for="reg_paciente"><? echo "Pago Efectivo"; ?>:</label>
                            </dd>
                            <dd style="text-align: center;">
                                <input class="input_form ui-widget ui-widget-content ui-corner-all input-pago" type="text" id="pago_efectivo" name="pago_efectivo" value="" rel="0"/>

                            </dd>
                            <dd>
                                <label for="reg_pago_credito"><? echo "Activar Pago a Crédito"; ?>:</label>
                                <input style="margin: 10px;" type="checkbox" id="reg_pago_credito" name="reg_pago_credito"/>
                            </dd>
                        </dl>
                        <dl id="sec_pago_credito" style="display: none;">
                            <dd>
                                <label for="reg_pago_adelanto"><? echo "Pago de Adelanto"; ?>:</label>
                            </dd>
                            <dd style="text-align: center; ">
                                <input class="input_form ui-widget ui-widget-content ui-corner-all input-pago" type="text" id="reg_pago_adelanto" name="reg_pago_adelanto" value="0" />

                            </dd>
                        </dl>
                        <dl style="margin-top: 30px;"> 
                            <dd>
                                <label for="btn_registerPago"></label>
                            </dd>
                            <dd style="text-align: center;">
                                <button type="button" id="btn_registerPago" name="btn_registerPago" >Guardar Pago</button>
                            </dd>                        
                        </dl>
                    </div>
                </li>               
            </ul>
            <div style="clear: both;"></div>
        </div>
        <div style="clear: both;"></div>
    </fieldset>
</div>
<!--    IMPRESION  -->
<div class="none55" id="detalleIndicadoresDiv">
    <p><span style="margin-left: 30px; font-style: italic;" class="ui-corner-all ui-state-focus"><?php echo "Debe seleccionar los Indicadores requeridoas para éste examen: "; ?></span><span id="get_idIndicador" data-cod="0" data-isOrina="0" style="font-weight: bold; margin-left: 10px;"></span></p>

    <div>       
        <div style="clear: both;"></div>
        <table id="listIndicadores"></table>
        <div id="listIndicadores_paper"></div>
    </div>

    <div style="margin: 35px; float: right; font-weight: bold;">
        <?php echo "TOTAL: S/.  " ?><span id="sumTotal" style="padding: 20px;width: 35px; height: 35px; font-weight: bold; font-size: 18px;" id="squart" class="ui-state-error">0</span> 
    </div>

</div>



