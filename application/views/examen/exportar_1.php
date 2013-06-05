<!--header("Content-Type: text/html;charset=utf-8");-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<?php
/* var_dump($examen);
  die(); */
header("Content-Type: application/vnd.ms-word");

/* header("Content-Type: application/msword"); */

header("Expires: 0");
header("Cache-Control:  must-revalidate, post-check=0, pre-check=0");
header("Content-disposition: attachment; filename=\"imp_examen.doc\"");

$data = "";
$data .= "<center><div style=\"float:left;\"><img src=\"http://localhost/proyecto_beltran/images/logo_beltran_120.png\" alt=\"Logo Lab. Beltran\"/></div>";
$data .= "<div><label style=\"float:right; margin-top:-50px; color:#514E4B;\">Laboratorio " . "'BELTRAN'" . "</label></div>";
$data .= "</center></br>";

$data .= "<table width=\"350\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\" style=\"float:left;\">";
foreach ($examen as $valor) {
    $data.="<tr>";
    $data.="<td style=\"text-transform:uppercase;\">Paciente:</td><td style=\"color:#514E4B; text-align:left;\">" . $valor->pac_fullname . "</td></tr>";
    $data.="<tr><td style=\"text-transform:uppercase;\">M&eacute;dico:</td><td style=\"color:#514E4B; text-align:left;\">" . $valor->med_fullname . "</td> ";
    $data.="<tr><td style=\"text-transform:uppercase;\">Edad:</td><td style=\"color:#514E4B; text-align:left; \">" . $valor->pac_edad . "</td> ";
    $data.="<tr><td style=\"text-transform:uppercase;\">Direcci&oacute;n:</td><td style=\"color:#514E4B; text-align:left;\">" . $valor->pac_direccion . "</td> ";
    $data.= "</tr> ";
}
$data.="</table>";


$data.="<table width=\"600\" cellspacing=\"1\" cellpadding=\"1\">";
foreach ($tipo_examen as $key => $t_ex_valor) {

    if ($t_ex_valor->tex_idPadre != NULL) {
        foreach ($detalle_tipo_examen_parent[$key] as $det_ex_valor_parent) {
            $data.="<tr>";
//            $data.="<td colspan=\"3\" style=\"background:".$t_ex_valor->tex_color."; color:#FFFFFF; text-align:center; text-transform:uppercase;\">" . $det_ex_valor_parent->tex_descripcion . "</td> ";

            $data.="<td colspan=\"3\" style=\"background:" . $t_ex_valor->tex_color . "; color:#FFFFFF; text-align:center; text-transform:uppercase;\">" . $t_ex_valor->tex_descripcion . "</td> ";
            $data.="<td style=\"background:" . $t_ex_valor->tex_color . "; color:#FFFFFF; text-align:right;\">Rango Referencial</td> ";
            $data.="</tr>";
            $data.="<tr>";
            $data.="<td colspan=\"3\" style=\"background:" . $t_ex_valor->tex_color . "; color:#FFFFFF; text-align:center; text-transform:uppercase;\">" . $t_ex_valor->exad_nombre . "</td> ";

            $data.="</tr>";
        }
    } else {
        $data.="<tr>";
        $data.="<td colspan=\"3\" style=\"background:" . $t_ex_valor->tex_color . "; color:#FFFFFF; text-align:center; text-transform:uppercase;\">" . $t_ex_valor->exad_nombre . "</td> ";
        $data.="<td style=\"background:" . $t_ex_valor->tex_color . "; color:#FFFFFF; text-align:right;\">Rango Referencial</td> ";
        $data.="</tr>";
    }
//    $data.="<tr>";
//    $data.="<td  style=\"background:#E07F3A; color:#FFFFFF; text-align:center; \">Indicador</td>";
//    $data.="<td style=\"background:#E07F3A; color:#FFFFFF; text-align:center; \">Resultado</td>";
//    $data.="<td  style=\"background:#E07F3A; color:#FFFFFF; text-align:center; \">Und. Medida</td>";
//    $data.="<td style=\"background:#E07F3A; color:#FFFFFF; text-align:center; \">Rango Referencial</td>";
//    $data.="</tr>";
//$data.="<td colspan=\"3\" style=\"background:#333; color:#FFFFFF; text-align:center; text-transform:uppercase;\">" . $t_ex_valor->med_fullname . "</td> ";
    //$data.="<tr>";
    // for ($i = 0; $i < count($detalle_examen_indicadores); $i++) {
    //foreach ($detalle_examen_indicadoresas as $key => $det_ex_valor) {
    //print_r($detalle_examen_indicadores[$i]); die();
    foreach ($detalle_examen_indicadores[$key] as $key_ind => $det_ex_valor) {
        if ($det_ex_valor->ind_id != 26) {
            $data.="<tr style=\"color:#686461; text-align:center; background:" . $t_ex_valor->tex_color_impresion . "\"><td  style=\"background:" . $t_ex_valor->tex_color_impresion . "; color:#686461; text-align:left;\">" . $det_ex_valor->ind_descripcion . "</td>";
            $data.="<td>" . $det_ex_valor->indd_valor_resultante . "</td>";
            $data.="<td>" . $det_ex_valor->ind_unidad_medida . "</td>";
            if ($t_ex_valor->text_esEspecial == 1) {
                $data.="<td style=\"text-align:right; margin-right:20px;\">" . $det_ex_valor->ind_rango_ref_especial . "</td></tr>";
            } else {
                $data.="<td style=\"text-align:right; margin-right:20px;\">" . $det_ex_valor->ind_rango_referencial . "</td></tr>";
            }
        } else {
            $data.="<tr  style=\"background:" . $t_ex_valor->tex_color_impresion . "\"><td style=\" color:#686461; text-align:left;\">" . $det_ex_valor->ind_descripcion . "</td>";
            $data.="<td  colspan=\"3\" style=\"background:" . $t_ex_valor->tex_color_impresion . "; color:#686461; text-align:left;\">";
            $data.="
                <table>";
            foreach ($detalle_examen_indicadores_esp[$key_ind] as $ind_esp_valor) {
                $data.= "<tr><td colspan=\"8\">Fórmula Referencial</tr>";
                $data.= "<tr><td>Leucocitos</td><td  style=\"color:#686461; text-align:left;\">" . $ind_esp_valor->die_leucocitos . "</td></tr>";
                $data.= "<tr>";
                $data.= "<td  style=\"color:#686461; text-align:right;\">Mielo</td>";
                $data.= "<td  style=\"color:#686461; text-align:right;\">Juv.</td>";
                $data.= "<td  style=\"color:#686461; text-align:right;\">Ab.</td>";
                $data.= "<td  style=\"color:#686461; text-align:right;\">Seg.</td>";
                $data.= "<td  style=\"color:#686461; text-align:right;\">Eo.</td>";
                $data.= "<td  style=\"color:#686461; text-align:right;\">Bas.</td>";
                $data.= "<td  style=\"color:#686461; text-align:right;\">Mon.</td>";
                $data.= "<td  style=\"color:#686461; text-align:right;\">Linf.</td>";
                $data.= "</tr>";
                $data.= "<tr>";
                $data.= "<td  style=\"color:#686461; text-align:right;\">" . $ind_esp_valor->die_mielo . "</td>";
                $data.= "<td  style=\"color:#686461; text-align:right;\">" . $ind_esp_valor->die_juv . "</td>";
                $data.= "<td  style=\"color:#686461; text-align:right;\">" . $ind_esp_valor->die_abs . "</td>";
                $data.= "<td  style=\"color:#686461; text-align:right;\">" . $ind_esp_valor->die_seg . "</td>";
                $data.= "<td  style=\"color:#686461; text-align:right;\">" . $ind_esp_valor->die_eo . "</td>";
                $data.= "<td  style=\"color:#686461; text-align:right;\">" . $ind_esp_valor->die_bas . "</td>";
                $data.= "<td  style=\"color:#686461; text-align:right;\">" . $ind_esp_valor->die_mon . "</td>";
                $data.= "<td  style=\"color:#686461; text-align:right;\">" . $ind_esp_valor->die_linf . "</td>";
                $data.= "</tr>";
                $data.="<tr><td>Neutrófilos</td><td  style=\"color:#686461; text-align:right;\">" . $ind_esp_valor->die_neutrofilos . "</td></tr>";
                $data.="<tr><td colspan=\"8\">Observaciones</td></tr>";
                $data.="<tr><td colspan=\"8\" style=\"color:#686461; text-align:center;\">" . $ind_esp_valor->die_observaciones . "</td></tr>";
            }
            $data.="</table>";
            $data.="</td>";

            if ($t_ex_valor->text_esEspecial == 1) {
                $data.="<td style=\"background:#fff; color:#686461; text-align:right;\">" . $det_ex_valor->ind_rango_ref_especial . "</td>";
            } else {
                $data.="<td style=\"background:#fff; color:#686461; text-align:right;\">" . $det_ex_valor->ind_rango_referencial . "</td>";
            }
            $data.="</tr>";
        }
    }
$data.="<tr><td style=\"height:5px;\"></td></tr>";
// }/$data.= "</tr> ";
}

$data.="</table>";

/* $output = $this->load->view("myreport", $mydata); */
echo $data;
exit;
?>
