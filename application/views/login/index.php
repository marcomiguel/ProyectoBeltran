<title>Login | Panel de administracion</title> 

<script src="<?php echo base_url(); ?>js/jquery-1.7.1.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.validate.min.js"></script>

<link rel="stylesheet" href="<?php echo base_url(); ?>css/login/reset.css" type="text/css"/>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/login/text.css" type="text/css"/>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/login/form.css" type="text/css"/>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/login/buttons.css" type="text/css"/>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/login/login.css" type="text/css" media="screen" title="no title" />
<style type="text/css">
    label.error{ 
        -moz-border-bottom-colors: none;
        -moz-border-image: none;
        -moz-border-left-colors: none;
        -moz-border-right-colors: none;
        -moz-border-top-colors: none;
        clear: none;
        color: #689C29;
        display: inline;
        float: none;
        font-size: 10px;
        margin: 0 0 0 10px;
        padding: 0;
        text-align: left;
        width: auto;
    }

    .message {
        margin: 10px;
        font-weight: bold;
        overflow: hidden;
        -webkit-border-radius: 1px;
        -moz-border-radius: 1px;
        border-radius: 1px;
    }

    .message.errormsg {
        border: 1px solid #FF1E00;
        background: #ffecea url(<?php echo base_url(); ?>images/x_alt_24x24.png) 5px 5px no-repeat;
        color: #FF1E00;
        margin-left: 15px;
        width: 70%;
        height: 35px;
    }



    }
</style>

<div id="login">
    <p><img src="<?php echo base_url(); ?>images/logo_beltran.png" width="100px" height="100px" alt="Logo"/></p>
    <div id="login_panel">

        <form id="form-login">		
            <div class="login_fields">
                <div class="field">
                    <label for="email">Usuario</label>
                    <input type="text" name="txt_usuario" value="" id="usuario" tabindex="1"/>		
                </div>

                <div class="field">
                    <label for="password">Contrasena</label>
                    <input type="password" name="txt_contrasena" value="" id="password" tabindex="2"/>			
                </div>
            </div> <!-- .login_fields -->
            <div class="message errormsg" style="display: none;"><p style="vertical-align: text-bottom; text-align: center;">Usuario y/o contrasena invalidos</p></div>
            <div class="login_actions">
                <button type="submit" class="btn btn-green" tabindex="3">Entrar</button>
            </div>
        </form>
    </div> <!-- #login_panel -->		
</div> <!-- #login -->

<script>
    $(document).ready ( function ()
    {
        $("#form-login").validate({
            rules: {
                txt_usuario: {
                    required: true
                },
                txt_contrasena: {
                    required: true
                }

            },
            messages: {
                txt_usuario: {
                    required: "Ingrese su nombre de usuario"
                },
                txt_contrasena: {
                    required: "Ingrese su contrasena"
                }
            },
            submitHandler:function(form){
                var datastring = $(form).serialize();
                var url = "<?php echo site_url("admin/autenticar"); ?>";
                $.ajax({
                    type: 'POST',
                    
                    url: url,
                    data: datastring,
                    dataType:'json',
                    error: function(){
                        $('.message').show();
                    },
                    success: function(e){
                        if (e.value==1) {
                            window.location.href=e.url;
                        } else {
                            $('.message').show();
                        }
                    }
                });
                
            }
        });
    });
</script>

