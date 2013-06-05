<script type="text/javascript">
    $(document).ready(function() {
        $('ul.sf-menu').sooperfish({ 
            hoverClass: '', 
            delay: '100ms', 
            dualColumn: 7, 
            tripleColumn: 14, 
            //animationShow: {height:'show',opacity:'show'}, 
            speedShow: '2000ms', 
            easingShow: 'swing', 
            //animationHide: {width:'hide',opacity:'hide'}, 
            //speedHide: '750ms', 
            //easingHide: 'easeInTurbo3', 
            autoArrows: true });
    });
</script>
<div class="espacio"></div>
<div id="Menu">
    <div class="Wrap">   
        <ul class="sf-menu" id="nav">
            <li class="current">
                <a href="#a">Inicio</a>
            </li>
            <li class="current">
                <a href="#a">Administracion</a>
                <ul>
                    <li>
                        <a href="<?php echo site_url('admin/pacientes'); ?>">Pacientes</a>
                    </li>
                    <li class="current">
                        <a href="<?php echo site_url('admin/medicos'); ?>">Medicos</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#">Examenes</a>
                <ul>
                    <li>
                        <a href="#">Registro</a>
                        <ul>
                            <li><a href="<?php echo site_url('admin/examen'); ?>">Examenes</a></li>
                            <li><a href="#">Perfiles</a></li>                           
                        </ul>
                    </li>

                    <li>
                        <a href="<?php echo site_url('admin/resultados'); ?>">Resultados</a>
                        <ul>
                            <li><a href="#">Cyan others</a></li>                          

                        </ul>
                    </li>
                    <li><a href="#">Unique thing</a></li>
                </ul>
            </li>
            <li>
                <a href="#">Reportes</a>
            </li>
            <li>
                <a href="#">Algo mas</a>
            </li>
        </ul>
    </div>
</div>
<div class="espacio"></div>
