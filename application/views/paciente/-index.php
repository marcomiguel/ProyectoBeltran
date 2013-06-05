
<script type="text/javascript">
    $(document).ready(function(){
        jQuery("#list2").jqGrid({
            url:'<?php echo site_url("paciente/listar"); ?>',
            datatype: "json",
            mtype:"POST",
            colNames:['Id','Nombres', 'Apellido paterno', 'Apellido materno','Edad','Telefono','Direccion','Ciudad'],
            colModel:[
                {name:'pac_id',index:'pac_id', width:55,hidden:true},
                {name:'pac_nombres',index:'pac_nombres', width:90},
                {name:'pac_apellido_paterno',index:'pac_apellido_paterno', width:100},
                {name:'pac_apellido_materno',index:'pac_apellido_materno', width:80, align:"right"},
                {name:'pac_edad',index:'pac_edad', width:80, align:"right"},		
                {name:'pac_telefono',index:'pac_telefono', width:80,align:"right"},		
                {name:'pac_direccion',index:'pac_direccion', width:150, sortable:false},
                {name:'ciu_nombre',index:'ciu_nombre', width:150, sortable:false}		
            ],
            rowNum:10,
            rowList:[10,20,30],
            pager: '#pager2',
            sortname: 'pac_id',
            viewrecords: true,
            sortorder: "desc"
        });
        jQuery("#list2").jqGrid('navGrid','#pager2',{edit:false,add:false,del:false});
    });
</script>

<!-- Content Start-->


<table id="list2"></table>
<div id="pager2"></div>
<!-- Content End--> 
