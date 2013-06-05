<!--header("Content-Type: text/html;charset=utf-8");-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo base_url(); ?>css/style_table.css" rel="stylesheet" type="text/css" />
<?php
$this->load->model('Resultados_examen_model');

header("Content-Type: application/vnd.ms-word");

/* header("Content-Type: application/msword"); */

header("Expires: 0");
header("Cache-Control:  must-revalidate, post-check=0, pre-check=0");
header("Content-disposition: attachment; filename=\"imp_examen.doc\"");

$formula_referencial = "Fórmula Diferencial";

$data = "";

//var_dump($data); die();
//$data .="<style type='text/css'>";
//
//$data .="@import url('style_table.css')";
//
//$data .="</style>";

/* $data .= "<center><div style=\"float:left;\"><img src=\"http://localhost/proyecto_beltran/images/logo_beltran_120.png\" alt=\"Logo Lab. Beltran\"/></div>";
  $data .= "<div><label style=\"float:right; margin-top:-50px; color:#514E4B;\">Laboratorio " . "'BELTRAN'" . "</label></div>";
  $data .= "</center></br>"; */

$data.="<body leftmargin=\"0\" topmargin=\"0\" marginwidth=\"0\" marginheight=\"0\" rightmargin=\"0\">";
$data.= "<table id=\"hor-zebra22\" border=\"0\" summary=\"Employee Pay Sheet\" cellspacing=\"0\" cellpadding=\"0\" style=\"margin:0px auto; width:600px; text-align:center;\">";
$data.="<tr>";
$data.="<td width=\"40%\" style=\"font-size:16px; color:#5dbb50; font-weight:bold;\">LABORATORIO \"BELTRAN\"</td>";
$data.="<td width=\"20%\"></td>";
$data.="<td width=\"40%\" style=\"font-size:12px; color:#0068A4;\">Jr. Ayacucho N° 358 Of. 3-4 TRUJILLO</td>";
$data.="</tr>";
$data.="<tr>";
$data.="<td><img src=\"http://localhost/proyecto_beltran/images/microscopy_90.png\" alt=\"Lab. Beltran\"/></td>";
$data.="<td></td>";
$data.="<td><img src=\"http://localhost/proyecto_beltran/images/logo_beltran_120.png\" alt=\"Logo Lab. Beltran\"/></td>";
$data.="</tr>";
$data.="<tr>";
$data.="<td style=\"color:#ed2991;\">Analisis Clínicos Microbilógicos</td>";
$data.="<td></td>";
$data.="<td rowspan=\"2\"><table border=\"0\" ><tr><td style=\"font-size:12px; color:#0068A4;\">Telf. 044 233317 - Cel. 949714367</td></tr><tr><td style=\"font-size:12px; color:#0068A4;\">E-mail: beltran121@hotmail.com</td></tr></table></td>";
$data.="</tr>";
$data.="<tr>";
$data.="<td style=\"color:#0068A4; \">Su majestad el Paciente</td>";
$data.="<td></td>";
$data.="<td></td>";
$data.="</tr>";
$data.="</table>";

$data.="<br/>";

$data .= "<table id=\"hor-zebra\" rules=\"none\" summary=\"Employee Pay Sheet\" cellspacing=\"0\" cellpadding=\"0\" style=\"float:left; width:600px;\">";
foreach ($examen as $valor) {
    $data.="<tbody>";
    $data.="<tr class=\"odd\">";
    $data.="<td class=\"negrita\">Paciente:</td>
        <td colspan=\"3\" style=\text-align:left; text-transform:uppercase;\">" . $valor->pac_fullname . "</th>
            </tr>";
    $data.="<tr><td class=\"negrita\">M&eacute;dico:</td>
        <td colspan=\"3\">" . $valor->med_fullname . "</td></tr> ";
    $data.="<tr class=\"odd\">
        <td class=\"negrita\">Edad:</td>
        <td>" . $valor->pac_edad . "</td>
            <td class=\"negrita\">Telefono:</td>
            <td>" . $valor->pac_telefono . "</td>
</tr>";
    $data.="<tr><td class=\"negrita\">Direcci&oacute;n:</td>
        <td>" . $valor->pac_direccion . "</td>
            <td class=\"negrita\">Ciudad:</td>
            <td>$valor->ciu_nombre</td>";
    $data.= "</tr> ";
}
$data.="</tbody>";
$data.="</table>";

$data.="<table style=\"width:600px;\" border=\"0\">";
$data.= "<tr><td  style=\"margin:7px; font-size:15px; font-family: 'arial', serif; color:#3B5998; text-align:center; font-weight:bold;\">RESULTADOS DE ANALISIS</td></tr>";
$data.="</table>";

$data.="<table border=\"0\" id=\"t-results\" style=\"width:600px; font-size:12px; font-family: 'arial', serif; margin:0px;\"cellspacing=\"0\" cellpadding=\"0\">";
foreach ($tipo_examen as $key => $t_ex_valor) {

    if ($t_ex_valor->tex_idPadre != NULL) {
        foreach ($detalle_tipo_examen_parent[$key] as $key_p => $det_ex_valor_parent) {
            $data.="<tr>";
            //$data.="<td colspan=\"3\" style=\"background:".$t_ex_valor->tex_color."; color:#FFFFFF; text-align:center; text-transform:uppercase;\">" . $key . "</td> ";
            if ($t_ex_valor->tex_order == 1) {
                $data.="<td style=\"background:#FF7300; color:#FFFFFF; text-align:left; text-transform:uppercase; padding-top:2px; padding-left:5px;\">Examen :</td><td colspan=\"2\" style=\"background:#FF7300; color:#FFFFFF; text-align:left; text-transform:uppercase; padding-top:2px; padding-left:5px;\"><b>" . $det_ex_valor_parent->tex_descripcion . "</b></td> ";
                $data.="<td style=\"background:#FF7300; color:#FFFFFF; text-align:right;  padding-top:2px;\"></td> ";
            } else {
                $data.="<td colspan=\"4\" style=\"background:#FF7300; color:#FFFFFF; text-align:right;\"></td> ";
            }
            /* else{
              $data.="<td colspan=\"3\" style=\"background:" . $t_ex_valor->tex_color_impresion . ";  text-align:left; text-transform:uppercase;\"><b>" . $t_ex_valor->exad_nombre . "</b></td> ";
              $data.="<td style=\"background:" . $t_ex_valor->tex_color_impresion . "; color:#FFFFFF; text-align:right;\"></td> ";
              } */
            $data.="</tr>";
            if ($t_ex_valor->tex_no_indicadores != 1) {
                $data.="<tr>";
                $data.="<td colspan=\"3\" style=\"background:" . $t_ex_valor->tex_color . ";  text-align:left; text-transform:uppercase;\"><b>" . $t_ex_valor->exad_nombre . "</b></td> ";
                $data.="<td style=\"background:" . $t_ex_valor->tex_color . "; color:#FFFFFF; text-align:right;\"></td> ";
                $data.="</tr>";
            }
        }
    } else {
        $data.="<tr>";
        $data.="<td colspan=\"3\" style=\"background:" . $t_ex_valor->tex_color . "; color:#FFFFFF; text-align:center; text-transform:uppercase;\"><b>" . $t_ex_valor->exad_nombre . "</b></td> ";
        $data.="<td style=\"background:" . $t_ex_valor->tex_color . "; color:#FFFFFF; text-align:right;\">Rango Referencial</td> ";
        $data.="</tr>";
    }

    foreach ($detalle_examen_indicadores[$key] as $key_ind => $det_ex_valor) {
        if ($det_ex_valor->ind_id != 26) {
            if ($key_ind == 0)
                $data.="<tr style=\"text-align:center; background:" . $t_ex_valor->tex_color_impresion . "\"><td colspan=\"4\" style=\"padding:2px 5px; background:" . $t_ex_valor->tex_color_impresion . ";text-align:left;\"></td></tr>";
            if ($t_ex_valor->tex_no_indicadores == 1) {
                $data.="<tr style=\" text-align:center; background:" . $t_ex_valor->tex_color_impresion . "\"><td  style=\"background:" . $t_ex_valor->tex_color . ";  text-align:left; text-transform:uppercase; pagging-left:5px; color:#000; \"><b>" . $det_ex_valor->ind_descripcion . "</b></td>";
            } else {
                $data.="<tr style=\" text-align:center; background:" . $t_ex_valor->tex_color_impresion . "\"><td  style=\"padding:0px 5px; background:" . $t_ex_valor->tex_color_impresion . "; text-align:left;\">" . $det_ex_valor->ind_descripcion . "</td>";
            }
            $data.="<td style=\"padding:0px 5px;  text-align:left; background:" . $t_ex_valor->tex_color_impresion . "\">" . $det_ex_valor->indd_valor_resultante . "</td>";
            $data.="<td style=\"padding:0px 5px;  text-align:left; background:" . $t_ex_valor->tex_color_impresion . "\">" . $det_ex_valor->ind_unidad_medida . "</td>";
            if ($t_ex_valor->text_esEspecial == 1) {
                //var_dump($det_ex_valor->ind_rango_ref_especial); die();
                $data.="<td style=\"text-align:right; margin-right:20px;\">" . $det_ex_valor->ind_rango_ref_especial . "</td></tr>";
            } else {
                if ($t_ex_valor->tex_esOrina) {
                    $data.="<td style=\"text-align:right; margin-right:20px;\"></td></tr>";
                } else {
                    $data.="<td style=\"padding:0px 5px; text-align:right; margin-right:5px;\">" . $det_ex_valor->ind_rango_referencial . "</td></tr>";
                }
            }
        } else {
            $data.="<tr  style=\"background:" . $t_ex_valor->tex_color_impresion . "\"><td style=\" text-align:left;\">" . $det_ex_valor->ind_descripcion . "</td>";
            $data.="<td  colspan=\"3\" style=\"background:" . $t_ex_valor->tex_color_impresion . "; text-align:left;\">";
            $data.="
                <table border=\"0\" id=\"tbl_hemograma\">";
            foreach ($detalle_examen_indicadores_esp[$key_ind] as $ind_esp_valor) {
                $data.="<tr><td colspan=\"8\"></td></tr>";
                $data.= "<tr><td colspan=\"2\" style=\"font-size:12px; font-family: 'arial', serif; \">Leucocitos</td><td colspan=\"3\" style=\"font-size:12px; font-family: 'arial', serif; text-align:left; \">" . $ind_esp_valor->die_leucocitos . "</td></tr>";
                $data.= "<tr><td colspan=\"8\" style=\"font-size:12px; font-family: 'arial', serif;\">" . $formula_referencial . "</td></tr>";
                $data.= "<tr>";
                $data.= "<td  style=\"width:50px; font-size:12px; font-family: 'arial', serif; text-align:center;\">Mielo</td>";
                $data.= "<td  style=\"width:50px; font-size:12px; font-family: 'arial', serif; text-align:center;\">Juv.</td>";
                $data.= "<td  style=\"width:50px; font-size:12px; font-family: 'arial', serif; text-align:center;\">Ab.</td>";
                $data.= "<td  style=\"width:50px; font-size:12px; font-family: 'arial', serif; text-align:center;\">Seg.</td>";
                $data.= "<td  style=\"width:50px; font-size:12px; font-family: 'arial', serif; text-align:center;\">Eo.</td>";
                $data.= "<td  style=\"width:50px; font-size:12px; font-family: 'arial', serif; text-align:center;\">Bas.</td>";
                $data.= "<td  style=\"width:50px; font-size:12px; font-family: 'arial', serif; text-align:center;\">Mon.</td>";
                $data.= "<td  style=\"width:50px; font-size:12px; font-family: 'arial', serif; text-align:center;\">Linf.</td>";
                $data.= "</tr>";
                $data.= "<tr>";
                $data.= "<td  style=\"font-size:12px; font-family: 'arial', serif; text-align:center;\">" . $ind_esp_valor->die_mielo . "</td>";
                $data.= "<td  style=\"font-size:12px; font-family: 'arial', serif; text-align:center;\">" . $ind_esp_valor->die_juv . "</td>";
                $data.= "<td  style=\"font-size:12px; font-family: 'arial', serif; text-align:center;\">" . $ind_esp_valor->die_abs . "</td>";
                $data.= "<td  style=\"font-size:12px; font-family: 'arial', serif; text-align:center;\">" . $ind_esp_valor->die_seg . "</td>";
                $data.= "<td  style=\"font-size:12px; font-family: 'arial', serif; text-align:center;\">" . $ind_esp_valor->die_eo . "</td>";
                $data.= "<td  style=\"font-size:12px; font-family: 'arial', serif; text-align:center;\">" . $ind_esp_valor->die_bas . "</td>";
                $data.= "<td  style=\"font-size:12px; font-family: 'arial', serif; text-align:center;\">" . $ind_esp_valor->die_mon . "</td>";
                $data.= "<td  style=\"font-size:12px; font-family: 'arial', serif; text-align:center;\">" . $ind_esp_valor->die_linf . "</td>";
                $data.= "</tr>";
                $data.="<tr><td></td><td colspan=\"2\" style=\"font-size:12px; font-family: 'arial', serif; text-align:right;\">Neutrófilos:</td><td  style=\"font-size:12px; font-family: 'arial', serif; text-align:center;\">" . $ind_esp_valor->die_neutrofilos . "</td></tr>";
                $data.="<tr><td colspan=\"8\">&nbsp;</td></tr>";
                $data.="<tr><td colspan=\"2\" style=\"font-size:12px; font-family: 'arial', serif; \">Observaciones</td><td colspan=\"8\" style=\"font-size:12px; font-family: 'arial', serif; text-align:center;\">" . $ind_esp_valor->die_observaciones . "</td></tr>";
                //$data.="<tr><td colspan=\"8\" style=\"font-size:12px; font-family: 'arial', serif; color:#686461; text-align:center;\">" . $ind_esp_valor->die_observaciones . "</td></tr>";
            }
            $data.="</table>";
            $data.="</td>";

            if ($t_ex_valor->text_esEspecial == 1) {
                $data.="<td style=\"text-align:right;\">" . $det_ex_valor->ind_rango_ref_especial . "</td>";
            } else {
                $data.="<td style=\"background:#fff; text-align:right;\">" . $det_ex_valor->ind_rango_referencial . "</td>";
            }
            $data.="</tr>";
        }
    }
    if ($t_ex_valor->tex_esOrina) {
        $data.="<tr style=\"height:10px; background:" . $t_ex_valor->tex_color_impresion . "\"><td colspan=\"4\" style=\"height:5px; background:" . $t_ex_valor->tex_color_impresion . "\"></td></tr>";
        //if($t_ex_valor->tex_idPadre == NULL)
        $num_children = $this->Resultados_examen_model->retornar_num_children_array($t_ex_valor->tex_idPadre);
        //var_dump($num_children);
        foreach ($num_children as $v_num) {
            if ($t_ex_valor->tex_order == trim($v_num->num_children))
                $data.="<tr><td colspan=\"4\" style=\"height:5px;\"></td></tr>";
            //$data.="<tr style=\"height:10px; background:" . $t_ex_valor->tex_color_impresion . "\"><td colspan=\"4\" style=\"height:10px; background:" . $t_ex_valor->tex_color_impresion . "\"></td></tr>";
        }
        //if()
    } else {
        $data.="<tr><td colspan=\"4\" style=\"height:5px;\"></td></tr>";
    }
}

$data.="</table>";

//$data.= "<div style=\"clear:both;\">";
$data.="<br/>";

$data.="<table style=\"width:600px;\" border=\"0\">";
$data.= "<tr><td style=\"font-size:13px; font-family: 'Lucida Sans Unicode', 'Lucida Grande', Sans-Serif; padding:0px; margin-left:20px; text-align:left; \">Trujillo, 28 de mayo del 2012</td><td style=\"font-size:16px; margin-left:100px; text-align:left; \">_______________________________</td></tr>";
$data.="<tr><td></td><td style=\"font-size:12px; margin-left:115px; padding:0px; text-align:left; \">Dr. JOSÉ MANUEL BELTRAN MORALES</td></tr>";
$data.="<tr><td></td><td style=\"font-size:12px; margin-left:195px; padding:0px; text-align:left; \">CBP: 0972</td></tr>";
$data.="</table>";

$data.="</body>";

/* $output = $this->load->view("myreport", $mydata); */
echo $data;
exit;
?>
