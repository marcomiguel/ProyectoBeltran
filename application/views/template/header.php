<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Laboratorio Beltran</title>

        <!-- Inicio CSS -->
        <!-- Reset -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/login/reset.css" />
        <!-- Template -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/custom.theme.forms.css" />
        <style type="text/css">
            .negrita{
                font-weight:bold;
            }
            #usuario{
                background: url("<?php echo base_url() ?>images/global-sprite.png") no-repeat scroll -233px -200px transparent;
                display: inline-block;
                position: relative;
                height: 16px;
                width: 17px;
                top:2px;
            }

            #salir{

                background: url("<?php echo base_url() ?>images/global-sprite.png") no-repeat scroll -178px 0 transparent;
                border: 0 none;
                cursor: pointer;

                float: right;
                height: 17px;
                position: relative;
                top:8px;
                margin-left: 4px;
                width: 17px;
            }

            #navigation span{
                margin:0;
                padding:0;
                display:inline-block;
                padding-left:30px;
                line-height:24px;
                cursor:pointer;
            }
            #navigation .idiomas{
                background:url("<?php echo base_url() ?>resources/img/icons/light/globe.png") center left no-repeat;
            }
            #navigation .niveles{
                background:url("<?php echo base_url() ?>resources/img/icons/light/graph.png") center left no-repeat;
            }
            #navigation .programas{
                background:url("<?php echo base_url() ?>resources/img/icons/light/grid.png") center left no-repeat;
            }
            #navigation .alumnos{
                background:url("<?php echo base_url() ?>resources/img/icons/light/running_man.png") center left no-repeat;
            }
            #navigation .docentes{
                background:url("<?php echo base_url() ?>resources/img/icons/light/male_contour.png") center left no-repeat;
            }
            #navigation .personal{
                background:url("<?php echo base_url() ?>resources/img/icons/light/admin_user.png") center left no-repeat;
            }

            #simplemodal-overlay {background: #aaaaaa url(<?php echo base_url() ?>resources/css/custom-theme/images/diagonals_thick.png) 0 0 repeat; opacity: .30;filter:Alpha(Opacity=30);
            }

        </style>
        <!-- jQueryUI -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/south-street/jquery-ui-1.8.17.custom.css" />
        <!-- JqGrid -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jqgrid/ui.jqgrid.css" />
        <!-- Menu -->
<!--        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/sooperfish.css" />-->
<!--        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/sooperfish-theme-large.css" />-->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style_menu.css" />
        <!-- Fin CSS -->

        <!-- Inicio JS -->
        <!-- jQuery -->
        <script type="text/javascript" src="<?php echo base_url() ?>/js/jquery-1.7.1.min.js"></script>
        <!-- jQueryUI -->
        <script type="text/javascript" src="<?php echo base_url() ?>/js/jquery-ui-1.8.17.custom.min.js"></script>              
        <!-- JqGrid -->
        <script type="text/javascript" src="<?php echo base_url() ?>/js/jqgrid/i18n/grid.locale-es.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>/js/jqgrid/jquery.jqGrid.min.js"></script>
        <!-- Validate -->
        <script type="text/javascript" src="<?php echo base_url() ?>/js/jquery.validate.min.js"></script>
        <!-- Menu -->
<!--        <script type="text/javascript" src="<?php echo base_url() ?>/js/jquery.easing-sooper.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>/js/jquery.sooperfish.min.js"></script>        -->
        <script type="text/javascript" src="<?php echo base_url() ?>/js/dropmenu.js"></script>        
        <!-- ADICIONALES -->
        <script type="text/javascript" src="<?php echo base_url() ?>/js/jquery.hotkeys.js"></script>
        <!-- Fin JS -->
    </head>
    <body>

        <!-- Header Start -->
        <div class="Header">
<!--            <div class="Logo">
                <a href="#"><img src="<?php echo base_url() ?>images/logo_beltran_min.png" alt="" width="60" height="60"/></a>
            </div>-->
            <div class="Wrap">            
                <div class="Box clearfix">
                    <div class="Center">
                        <span class="negrita" id="usuario"></span> 
                        <?php echo $_SESSION['bienvenido']; ?>
                        <a href="<?php echo site_url("admin/salir"); ?>" id="salir"></a>
                    </div>        	
                </div>
            </div>
        </div>
        <!-- Header End -->
        <!--        <div  class="Wrap">-->




