<script type="text/javascript">
    $(document).ready(function(){
        $("#nav-one").dropmenu();
    });
</script>

<div class="espacio"></div>
<div id="Menu">
    <div class="Wrap">   
        <ul id="nav-one" class="dropmenu"> 
            <li> 
                <a href="#">Inicio</a>
            </li> 
            <li> 
                <a href="#a">Administracion</a>
                <div class="products">
                    <ul>                        
                        <li><a href="<?php echo site_url('admin/pacientes'); ?>"><img src="<?php echo base_url('images/patient.png') ?>" width="40" height="40" alt="Patient Record" border="0" /><h5>Pacientes</h5></a></li> 
                        <li><a href="<?php echo site_url('admin/medicos'); ?>"><img src="<?php echo base_url('images/physician.png') ?>" width="40" height="40" alt="Patient Record" border="0" /><h5>M&eacute;dicos</h5></a></li>                          
                    </ul> 
                </div>
            </li>           
            <li> 
                <a href="#a">Examenes</a>
                <div class="products">
                    <ul>                        
                        <li><a href="<?php echo site_url('admin/examen'); ?>"><img src="<?php echo base_url('images/reg_exames.png') ?>" width="40" height="40" alt="Patient Record" border="0" /><h5>Examen</h5></a></li> 
                        <li><a href="<?php echo site_url('admin/resultados'); ?>"><img src="<?php echo base_url('images/lab.png') ?>" width="40" height="40" alt="Patient Record" border="0" /><h5>Resultados</h5></a></li>                          
                    </ul> 
                </div>
            </li> 
            <li> 
                <a href="#">Reportes</a> 
                <div class="tutorials">
                    <ul class="left"> 
                        <li><a href="#">Ventas</a></li> 
                        <li><a href="#">Python</a></li> 
                        <li><a href="#">PHP</a></li> 
                    </ul>
                    <ul class="right"> 
                        <li><a href="#">HTML/CSS</a></li> 
                        <li><a href="#">ASP.NET</a></li> 
                        <li><a href="#">Actionscript</a></li> 
                    </ul>
                    <div class="small">View <a href="#">all categories</a> or a <a href="#">list of the best tutorials</a>.</div>
                </div>
            </li>
            <li> 
                <a href="#">Ayuda</a> 
                <ul> 
                    <li><a href="#">Acerca de</a></li>                  
                </ul> 
            </li>


        </ul> 

    </div>
</div>
<div class="espacio"></div>
