<?php

/**
     * Plugin Name: Libro de Reclamaciones Perú
     * Plugin URI: https://www.markethinkers.pe/plugins/libro-de-reclamaciones-peru
     * Description: Plugin creado con los estandares que debe contar un libro de reclamaciones en Perú, validado con todos los requerimientos de Indecopi. Este plugin también puede ser usado y optimizado para distintos paises del mundo.
     * Version: 1.0
     * Author: Markethinkers.pe [Jenner]
     * Author URI: https://www.markethinkers.pe
     * License:      GPL2
     * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
     * Text Domain:  libro-reclamaciones-peru
     * Domain Path:  /languages
      
     
     Libro de Reclamaciones Perú is free software: you can redistribute it and/or modify
     it under the terms of the GNU General Public License as published by
     the Free Software Foundation, either version 2 of the License, or
     any later version.
     
     Libro de Reclamaciones Perú es software libre: puede redistribuirlo y/o modificarlo
     bajo los términos de la Licencia Pública General GNU publicada por la
     publicada por la Free Software Foundation, ya sea la versión 2 de la
     cualquier versión posterior.

*/

defined( 'ABSPATH' ) || die( 'No script kiddies please!' );

register_activation_hook(__FILE__, 'Libro_Reclamaciones_init');

/** DB */
function Libro_Reclamaciones_init(){

     global $wpdb;
     $tabla_reclamos = $wpdb->prefix . 'reclamos';
     $charset_collate = $wpdb->get_charset_collate();

     $query = "CREATE TABLE IF NOT EXISTS $tabla_reclamos(
         id mediumint(9) NOT NULL AUTO_INCREMENT,
         fecha_reclamo date NOT NULL,
         tipopersona varchar(20),
         razonsocial varchar(100),
         ruc varchar(15),
         nombre varchar(50),
         apepaterno varchar(30),
         apematerno varchar(30),
         tipodocumento varchar(5),
         numdocumento varchar(20),
         esmenoredad varchar(2),
         nomapoderado varchar(100),
         telefonofijo varchar(20),
         telefonocelular varchar(20),
         email varchar(50),
         direccion varchar(100),
         pais varchar(50),
         departamento varchar(50),
         ciudad varchar(50),
         biencontratado varchar(25),
         monotoreclamado varchar(25),
         descripcionbiencontratado varchar(400),
         tiporeclamo varchar(25),
         detallesreclamo varchar(1200),
         pedidoreclamo varchar(300),
         observacioneslrd varchar(300),
         
         UNIQUE (id)
     ) $charset_collate;";

     include_once ABSPATH . 'wp-admin/includes/upgrade.php';
     dbDelta($query);

}

add_shortcode( 'libro_reclamaciones', 'Libro_Reclamaciones' );

/** Formulario */
function Libro_Reclamaciones(){
     global $wpdb;
     if($_POST['txt_nombres'] != ''){
         $tabla_reclamos = $wpdb->prefix . 'reclamos';
         $fecha_reclamo = date('Y-m-d');
         $tipopersona = $_POST['rbtn_tiposerona'];
         $razonsocial = sanitize_text_field($_POST['txt_razonsocial']);
         $ruc = sanitize_text_field($_POST['txt_ruc']);
         $nombre = sanitize_text_field($_POST['txt_nombres']);
         $apepaterno = sanitize_text_field($_POST['txt_apell_paterno']);
         $apematerno = sanitize_text_field($_POST['txt_apell_materno']);
         $tipodocumento = $_POST['selc_documento'];
         $numdocumento = sanitize_text_field($_POST['txt_ndocumento']);
         $esmenoredad = $_POST['ckb_menoredad'];
         $nomapoderado = sanitize_text_field($_POST['txt_nombreapoderado']);
         $telefonofijo = sanitize_text_field($_POST['txt_telefonofijo']);
         $telefonocelular = sanitize_text_field($_POST['txt_teledonomovil']);
         $email = sanitize_text_field($_POST['txt_email']);
         $direccion = sanitize_text_field($_POST['txt_direccion']);
         $pais = sanitize_text_field($_POST['selc_pais']);
         $departamento = sanitize_text_field($_POST['selc_departamento']);
         $ciudad = sanitize_text_field($_POST['txt_ciudad']);
         $biencontratado = $_POST['bien_contratado'];
         $monotoreclamado = sanitize_text_field($_POST['txt_montoreclamado']);
         $descripcionbiencontratado = sanitize_text_field($_POST['txt_descripcionbiencontratado']);
         $tiporeclamo = $_POST['rbtn_tipo_reclamo'];
         $detallesreclamo = sanitize_text_field($_POST['txt_detallereclamo']);
         $pedidoreclamo = sanitize_text_field($_POST['txt_pedidoreclamo']);
         $observacioneslrd = sanitize_text_field($_POST['txt_observaciondelproveedor']);
         
         $wpdb->insert(
             $tabla_reclamos,
             array(
                 'fecha_reclamo' => $fecha_reclamo,
                 'tipopersona' => $tipopersona,
                 'razonsocial' => $razonsocial,
                 'ruc' => $ruc,
                 'nombre' => $nombre,
                 'apepaterno' => $apepaterno,
                 'apematerno' => $apematerno,
                 'tipodocumento' => $tipodocumento,
                 'numdocumento' => $numdocumento,
                 'esmenoredad' => $esmenoredad,
                 'nomapoderado' => $nomapoderado,
                 'telefonofijo' => $telefonofijo,
                 'telefonocelular' => $telefonocelular,
                 'email' => $email,
                 'direccion' => $direccion,
                 'pais' => $pais,
                 'departamento' => $departamento,
                 'ciudad' => $ciudad,
                 'biencontratado' => $biencontratado,
                 'monotoreclamado' => $monotoreclamado,
                 'descripcionbiencontratado' => $descripcionbiencontratado,
                 'tiporeclamo' => $tiporeclamo,
                 'detallesreclamo' => $detallesreclamo,
                 'pedidoreclamo' => $pedidoreclamo,
                 'observacioneslrd' => $observacioneslrd,
                 
             )
         );
         $adminmail = get_option('admin_email');
         $nameweb = bloginfo( 'name' );
         $para = $nombre.'<'.$email.'>, '.$nameweb.' <'.$adminmail.'>';
         $titulo = 'Reclamo de '.$nombre.' el '.$fecha_reclamo;
         $mensaje = "Un Reclamo desde la Página Web \r\n";
         $mensaje .= "Fecha del Reclamo: $fecha_reclamo \r\n";
         $mensaje .= "Datos del Cliente: \r\n";
         $mensaje .= "Tipo de Persona: $tipopersona \r\n";
         $mensaje .= "Razón Social: $razonsocial \r\n";
         $mensaje .= "RUC: $ruc \r\n";
         $mensaje .= "nombre: $nombre \r\n";
         $mensaje .= "Apellido Paterno: $apepaterno \r\n";
         $mensaje .= "Apellido Materno: $apematerno \r\n";
         $mensaje .= "Tipo de Documento: $tipodocumento \r\n";
         $mensaje .= "Número de Documento: $numdocumento \r\n";
         $mensaje .= "¿Es Menor de Edad?: $esmenoredad \r\n";
         $mensaje .= "Apoderado: $nomapoderado \r\n";
         $mensaje .= "Teléfono Fijo: $telefonofijo \r\n";
         $mensaje .= "Celular: $telefonocelular \r\n";
         $mensaje .= "Email: $email \r\n";
         $mensaje .= "Dirección: $direccion \r\n";
         $mensaje .= "Pais: $pais \r\n";
         $mensaje .= "Departamento: $departamento \r\n";
         $mensaje .= "Ciudad: $ciudad \r\n";
         $mensaje .= "Detalles del Reclamo: \r\n";
         $mensaje .= "Bien Contratado: $biencontratado \r\n";
         $mensaje .= "Monto Reclamado: $monotoreclamado \r\n";
         $mensaje .= "Descripción: $descripcionbiencontratado \r\n";
         $mensaje .= "Tipo de Reclamo: $tiporeclamo \r\n";
         $mensaje .= "Detalle: $detallesreclamo \r\n";
         $mensaje .= "Pedido: $pedidoreclamo \r\n";
         $mensaje .= "Observación: $observacioneslrd \r\n";
         
         
         $cabeceras = "MIME-Version: 1.0" . "\r\n";
         $cabeceras .= "Content-type:text/html;charset=UTF-8" . "\r\n";
         $cabeceras = "From: <".$adminmail.">";
         
         $success = mail($para, $titulo, $mensaje, $cabeceras);
         echo "<p class='exito'>Hola $nombre. <b>Tu reclamo fue registrado exitosamente</b>.</p>";
         // echo '<p><a href="#">Regresar a la página de Inicio</a></p>';
         if (!$success) {
             $errorMessage = error_get_last()['message'];
             echo '<p>Pero tuvimos un error al Enviar el Email: ' . $errorMessage .'</p>';
         } else {
             echo '<p>Te Enviamos un Correo con los detalles de tu reclamo.</p>';
         }
     }
     wp_enqueue_style( 'css_ldr', plugins_url( 'style.css', __FILE__ ));
     wp_enqueue_script( 'js_ldr', plugins_url( 'app.js', __FILE__ ));
     ob_start();
 ?>
     <form action="<?php get_the_permalink(); ?>" method="post" id="form_ldr" class="section_form_ldr">
         <?php wp_nonce_field('grabar_reclamo', 'reclamo_nonce') ?>
         <div class="seccion-libro">
             <h3><?php e_('1. Identificación del consumidor reclamante', 'libro-reclamaciones-peru') ?></h3>
             <div class="contenido-inputs">
                 <div class="inline-inputs">
                     <input type="radio" name="rbtn_tiposerona" id="rbtn_personnatural" value="Natural"><label for="rbtn_personnatural"><?php _e('Persona Natural', 'libro-reclamaciones-peru') ?></label>
                     <input type="radio" name="rbtn_tiposerona" id="rbtn_empresa" value="Empresa"><label for="rbtn_empresa"><?php _e('Empresa', 'libro-reclamaciones-peru') ?></label>
                 </div>
                 <div class="input-one">
                     <label for="txt_razonsocial"><?php _e('Razón Social', 'libro-reclamaciones-peru') ?></label><input type="text" name="txt_razonsocial" id="txt_razonsocial">
                 </div>
                 <div class="input-one">
                     <label for="txt_ruc"><?php _e('Ruc', 'libro-reclamaciones-peru') ?></label><input type="text" name="txt_ruc" id="txt_ruc">
                 </div>
                 <div class="input-one">
                     <label for="txt_nombres"><?php _e('Nombres', 'libro-reclamaciones-peru') ?></label><input type="text" name="txt_nombres" id="txt_nombres" require>
                 </div>
                 <div class="input-one">
                     <label for="txt_apell_paterno"><?php _e('Apellido paterno', 'libro-reclamaciones-peru') ?></label><input type="text" name="txt_apell_paterno" id="txt_apell_paterno require">
                 </div>
                 <div class="input-one">
                     <label for="txt_apell_materno"><?php _e('Apellido materno', 'libro-reclamaciones-peru') ?></label><input type="text" name="txt_apell_materno" id="txt_apell_materno" require>
                 </div>
                 <div class="input-one">
                     <label for="selc_documento"><?php _e('Documento', 'libro-reclamaciones-peru') ?></label>
                     <select name="selc_documento" id="selc_documento">
                         <option value="DNI"><?php _e('DNI', 'libro-reclamaciones-peru') ?></option>
                         <option value="CE"><?php _e('Carnet de Extranjería', 'libro-reclamaciones-peru') ?></option>
                     </select>
                 </div>
                 <div class="input-one">
                     <label for="txt_ndocumento"><?php _e('Número de documento', 'libro-reclamaciones-peru') ?></label><input type="text" name="txt_ndocumento" id="txt_ndocumento" require>
                 </div>
                 <div class="input-inline">
                     <input type="checkbox" name="ckb_menoredad" id="ckb_menoredad" value="Si"> <label for="ckb_menoredad"><?php e_('Soy menor de edad', 'libro-reclamaciones-peru') ?></label>
                 </div>
                 <div class="input-one">
                     <label for="txt_nombreapoderado"><?php e_('Nombre completo del apoderado', 'libro-reclamaciones-peru') ?></label><input type="text" name="txt_nombreapoderado" id="txt_nombreapoderado">
                 </div>
                 <div class="input-one">
                     <label for="txt_telefonofijo"><?php e_('Teléfono fijo', 'libro-reclamaciones-peru') ?></label><input type="tel" name="txt_telefonofijo" id="txt_telefonofijo">
                 </div>
                 <div class="input-one">
                     <label for="txt_teledonomovil"><?php e_('Celular', 'libro-reclamaciones-peru') ?></label><input type="tel" name="txt_teledonomovil" id="txt_teledonomovil">
                 </div>
                 <div class="input-one">
                     <label for="txt_email"><?php e_('Email', 'libro-reclamaciones-peru') ?></label><input type="email" name="txt_email" id="txt_email">
                 </div>
                 <div class="input-one">
                     <label for="txt_direccion"><?php e_('Dirección', 'libro-reclamaciones-peru') ?></label><input type="text" name="txt_direccion" id="txt_direccion">
                 </div>
                 <div class="input-one">
                     <label for="selc_pais"><?php e_('País', 'libro-reclamaciones-peru') ?></label>
                     <select name="selc_pais" id="selc_pais">
                         <option value="-">--<?php e_('Seleccionar Pais', 'libro-reclamaciones-peru') ?>--</option>
                         <option value="Perú"><?php e_('Perú', 'libro-reclamaciones-peru') ?></option>
                     </select>
                 </div>
                 <div class="input-one">
                     <label for="selc_departamento"><?php e_('Departamento', 'libro-reclamaciones-peru') ?></label>
                     <select name="selc_departamento" id="selc_departamento">
                         <option value="-">--<?php e_('Seleccionar Departamento', 'libro-reclamaciones-peru') ?>--</option>
                         <option value="Amazonas"><?php e_('Amazonas', 'libro-reclamaciones-peru') ?></option>
                         <option value="Ancash"><?php e_('Ancash', 'libro-reclamaciones-peru') ?></option>
                         <option value="Apurimac"><?php e_('Apurimac', 'libro-reclamaciones-peru') ?></option>
                         <option value="Arequipa"><?php e_('Arequipa', 'libro-reclamaciones-peru') ?></option>
                         <option value="Ayacucho"><?php e_('Ayacucho', 'libro-reclamaciones-peru') ?></option>
                         <option value="Cajamarca"><?php e_('Cajamarca', 'libro-reclamaciones-peru') ?></option>
                         <option value="Callao"><?php e_('Callao', 'libro-reclamaciones-peru') ?></option>
                         <option value="Cusco"><?php e_('Cusco', 'libro-reclamaciones-peru') ?></option>
                         <option value="Huancavelica"><?php e_('Huancavelica', 'libro-reclamaciones-peru') ?></option>
                         <option value="Huanuco"><?php e_('Huanuco', 'libro-reclamaciones-peru') ?></option>
                         <option value="Ica"><?php e_('Ica', 'libro-reclamaciones-peru') ?></option>
                         <option value="Junin"><?php e_('Junin', 'libro-reclamaciones-peru') ?></option>
                         <option value="La Libertad"><?php e_('La Libertad', 'libro-reclamaciones-peru') ?></option>
                         <option value="Lambayeque"><?php e_('Lambayeque', 'libro-reclamaciones-peru') ?></option>
                         <option value="Lima"><?php e_('Lima', 'libro-reclamaciones-peru') ?></option>
                         <option value="Loreto"><?php e_('Loreto', 'libro-reclamaciones-peru') ?></option>
                         <option value="Madre De Dios"><?php e_('Madre De Dios', 'libro-reclamaciones-peru') ?></option>
                         <option value="Moquegua"><?php e_('Moquegua', 'libro-reclamaciones-peru') ?></option>
                         <option value="Pasco"><?php e_('Pasco', 'libro-reclamaciones-peru') ?></option>
                         <option value="Piura"><?php e_('Piura', 'libro-reclamaciones-peru') ?></option>
                         <option value="Puno"><?php e_('Puno', 'libro-reclamaciones-peru') ?></option>
                         <option value="San Martin"><?php e_('San Martin', 'libro-reclamaciones-peru') ?></option>
                         <option value="Tacna"><?php e_('Tacna', 'libro-reclamaciones-peru') ?></option>
                         <option value="Tumbes"><?php e_('Tumbes', 'libro-reclamaciones-peru') ?></option>
                         <option value="Ucayali"><?php e_('Ucayali', 'libro-reclamaciones-peru') ?></option>
                     </select>
                 </div>
                 <div class="input-one">
                     <label for="txt_ciudad"><?php e_('Ciudad', 'libro-reclamaciones-peru') ?></label><input type="text" name="txt_ciudad" id="txt_ciudad">
                 </div>
             </div>
         </div>
         <div class="seccion-libro">
             <h3><?php e_('2. Identificación del bien contratado', 'libro-reclamaciones-peru') ?></h3>
             <div class="contenido-inputs">
                 <div class="input-inline">
                     <input type="radio" name="bien_contratado" id="bien_producto" value="Producto"> <label for="bien_producto"><?php _e('Producto', 'libro-reclamaciones-peru') ?></label>
                 </div>
                 <div class="input-inline">
                     <input type="radio" name="bien_contratado" id="bien_servicio" value="Servicio"> <label for="bien_servicio"><?php _e('Servicio', 'libro-reclamaciones-peru') ?></label>
                 </div>
                 <div class="input-one">
                     <label for="txt_montoreclamado"><?php _e('Monto reclamado', 'libro-reclamaciones-peru') ?></label><input type="text" name="txt_montoreclamado" id="txt_montoreclamado" placeholder="S/.">
                 </div>
                 <div class="input-one">
                     <label for="txt_descripcionbiencontratado"><?php _e('Descripción', 'libro-reclamaciones-peru') ?> <span style="color: #CC0000;">*</span></label>
                     <textarea name="txt_descripcionbiencontratado" id="txt_descripcionbiencontratado" rows="4" require></textarea>
                     <p><small><?php _e('Número de caracteres', 'libro-reclamaciones-peru') ?>: <span class="cant-caracteres">0</span> (400 <?php _e('máximo', 'libro-reclamaciones-peru') ?>)</small></p>
                 </div>
             </div>
         </div>
         <div class="seccion-libro">
             <h3><?php e_('3. Detalle de la reclamación', 'libro-reclamaciones-peru') ?></h3>
             <div class="contenido-inputs">
                 <div class="input-inline">
                     <input type="radio" name="rbtn_tipo_reclamo" id="tipo_reclamo" value="Reclamo">    
                     <label for="tipo_reclamo"><?php _e('Reclamo (Disconformidad relacionada a los productos o servicios)', 'libro-reclamaciones-peru') ?></label>
                 </div>
                 <div class="input-inline">
                     <input type="radio" name="rbtn_tipo_reclamo" id="tipo_queja" value="Queja">    
                     <label for="tipo_queja"><?php _e('Queja (Disconformidad no relacionada a los productos o servicios; o, malestar o descontento respecto a la atención al público)', 'libro-reclamaciones-peru') ?></label>
                 </div>
                 <div class="input-one">
                     <label for="txt_detallereclamo"><?php _e('Detalle', 'libro-reclamaciones-peru') ?></label>
                     <textarea name="txt_detallereclamo" id="txt_detallereclamo" rows="4"></textarea>
                     <p><small><?php _e('Número de caracteres', 'libro-reclamaciones-peru') ?>: <span class="cant-caracteres">0</span> (1200 <?php _e('máximo', 'libro-reclamaciones-peru') ?>)</small></p>
                 </div>
                 <div class="input-one">
                     <label for="txt_pedidoreclamo"><?php _e('Pedido', 'libro-reclamaciones-peru') ?></label>
                     <textarea name="txt_pedidoreclamo" id="txt_pedidoreclamo" rows="4"></textarea>
                     <p><small><?php _e('Número de caracteres', 'libro-reclamaciones-peru') ?>: <span class="cant-caracteres">0</span> (300 <?php _e('máximo', 'libro-reclamaciones-peru') ?>)</small></p>
                 </div>
             </div>
         </div>
         <div class="seccion-libro">
             <h3><?php e_('4. Observaciones y acciones adoptadas por el proveedor', 'libro-reclamaciones-peru') ?></h3>
             <div class="contenido-inputs">
                 <div class="input-one">
                     <label for="txt_observaciondelproveedor"><?php _e('Observaciones', 'libro-reclamaciones-peru') ?></label>
                     <textarea name="txt_observaciondelproveedor" id="txt_observaciondelproveedor" rows="4"></textarea>
                     <p><small><?php _e('Número de caracteres', 'libro-reclamaciones-peru') ?>: <span class="cant-caracteres">0</span> (300 <?php _e('máximo', 'libro-reclamaciones-peru') ?>)</small></p>
                 </div>
                 <div class="input-one">
                     <p><small>* <?php _e('La formulación del reclamo no impide acudir a otras vías de solución de controversias y no es requisito previo para imponer una denuncia ante el INDECOPI', 'libro-reclamaciones-peru') ?></small></p>
                     <p><small>* <?php _e('El proveedor deberá dar respuesta al reclamo en un plazo no mayor a treinta (30) días calendario, pudiendo ampliar el plazo hasta por treinta (30) días más, previa comunicación al consumidor.', 'libro-reclamaciones-peru') ?></small></p>
                     <p><small><strong><?php _e('NOTA', 'libro-reclamaciones-peru') ?>:</strong> <?php _e('La respuesta a la presente queja o reclamo será brindada mediante comunicación electrónica enviada a la dirección que usted ha consignado en la presente Hoja de Reclamación. En caso de que usted desee que la respuesta le sea enviada a su domicilio deberá expresar ello en el detalle del reclamo o queja.', 'libro-reclamaciones-peru') ?></small></p>
                 </div>
             </div>
         </div>
         <div class="seccion-libro">
             <input type="submit" value="<?php _e('Enviar', 'libro-reclamaciones-peru') ?>">
         </div>
     </form>
 <?php
     return ob_get_clean();
 }
 
 /**
  * Hook Admin Menu
  */
 add_action("admin_menu", "Libro_Reclamaciones_menu");
 
 /**
  * Agreguemos el menu del pluginal escritorio de wordpress
  */
 function Libro_Reclamaciones_menu(){
     add_menu_page( 
         'Formulario Reclamos', 'Reclamos', 'manage_options', 'libro_reclamaciones_menu', 'Libro_Reclamaciones_admin', 'dashicons-feedback', 75
     );
 }
 
 /**
  * Crear el contenido para el panel de administración del Plugin
 */
 function Libro_Reclamaciones_admin(){
     global $wpdb;
     $tabla_reclamos = $wpdb->prefix . 'reclamos';
     echo '<div class="wrap"><h1>'.e_('Lista de Reclamos', 'libro-reclamaciones-peru').'</h1>';
     echo '<p>'._e('Inicia insertando el shortcode a tu página de Reclamos', 'libro-reclamaciones-peru').': <b>[libro_reclamaciones]</b></p>';
     echo '<p>'._e('Gracias por usar nuestro plugin', 'libro-reclamaciones-peru').', '._e('desarrollado por', 'libro-reclamaciones-peru').' <a href="https://markethinkers.pe" target="_blank"><b>Markethinkers.pe [Creador: Jenner Acosta]</b></a></p>';
     echo '<h2>'._e('Tus Reclamos', 'libro-reclamaciones-peru').'</h2>';
     echo '<p>'._e('Analisa el  detalle de los reclamos de tus usuarios', 'libro-reclamaciones-peru').'</p>';
     echo '<div class="table-responsive" style="display: block;width: 100%;overflow-x: auto;">';
     echo '<table class="table wp-list-table widefat striped" style="width: 100%;max-width: 100%;margin-bottom: 1rem;">';
     echo '<thead><tr><th style="white-space: nowrap;"><b>N°</b></th><th style="white-space: nowrap;">Fecha</th><th style="white-space: nowrap;">Tipo</th><th style="white-space: nowrap;">Razón Social</th><th style="white-space: nowrap;">RUC</th><th style="white-space: nowrap;">Nombre</th><th style="white-space: nowrap;">Apellido P.</th><th style="white-space: nowrap;">Apellido M.</th><th style="white-space: nowrap;">Documento</th><th style="white-space: nowrap;">N. Documento</th><th style="white-space: nowrap;">¿Menor Edad?</th><th style="white-space: nowrap;">Apoderado</th><th style="white-space: nowrap;">Fijo</th><th style="white-space: nowrap;">Celular</th><th style="white-space: nowrap;">Email</th><th style="white-space: nowrap;">Dirección</th><th style="white-space: nowrap;">Pais</th><th style="white-space: nowrap;">Departamento</th><th style="white-space: nowrap;">Ciudad</th><th style="white-space: nowrap;">Bien contratado</th><th style="white-space: nowrap;">Monoto reclamado</th><th style="white-space: nowrap;">Descripcion bien contratado</th><th style="white-space: nowrap;">Tipo de reclamo</th><th style="white-space: nowrap;">Detalles de reclamo</th><th style="white-space: nowrap;">Pedido</th><th style="white-space: nowrap;">Observaciones</th> </tr> </thead>';
     echo '<tbody id="the-list">';
     $reclamos = $wpdb->get_results("SELECT * FROM $tabla_reclamos");
     foreach($reclamos as $reclamo){
         $id = esc_textarea( $reclamo->id );
         $fecha_reclamo = esc_textarea( $reclamo->fecha_reclamo );
         $tipopersona = esc_textarea( $reclamo->tipopersona );
         $razonsocial = esc_textarea( $reclamo->razonsocial );
         $ruc = esc_textarea( $reclamo->ruc );
         $nombre = esc_textarea( $reclamo->nombre );
         $apepaterno = esc_textarea( $reclamo->apepaterno );
         $apematerno = esc_textarea( $reclamo->apematerno );
         $tipodocumento = esc_textarea( $reclamo->tipodocumento );
         $numdocumento = esc_textarea( $reclamo->numdocumento );
         $esmenoredad = esc_textarea( $reclamo->esmenoredad );
         $nomapoderado = esc_textarea( $reclamo->nomapoderado );
         $telefonofijo = esc_textarea( $reclamo->telefonofijo );
         $telefonocelular = esc_textarea( $reclamo->telefonocelular );
         $email = esc_textarea( $reclamo->email );
         $direccion = esc_textarea( $reclamo->direccion );
         $pais = esc_textarea( $reclamo->pais );
         $departamento = esc_textarea( $reclamo->departamento );
         $ciudad = esc_textarea( $reclamo->ciudad );
         $biencontratado = esc_textarea( $reclamo->biencontratado );
         $monotoreclamado = esc_textarea( $reclamo->monotoreclamado );
         $descripcionbiencontratado = esc_textarea( $reclamo->descripcionbiencontratado );
         $tiporeclamo = esc_textarea( $reclamo->tiporeclamo );
         $detallesreclamo = esc_textarea( $reclamo->detallesreclamo );
         $pedidoreclamo = esc_textarea( $reclamo->pedidoreclamo );
         $observacioneslrd = esc_textarea( $reclamo->observacioneslrd );
         
         echo "<tr><td><b>$id</td><td>$fecha_reclamo</td><td>$tipopersona</td><td>$razonsocial</td><td>$ruc</td><td>$nombre</td><td>$apepaterno</td><td>$apematerno</td><td>$tipodocumento</td><td>$numdocumento</td><td>$esmenoredad</td><td>$nomapoderado</td><td>$telefonofijo</td><td>$telefonocelular</td><td>$email</td><td>$direccion</td><td>$pais</td><td>$departamento</td><td>$ciudad</td><td>$biencontratado</td><td>$monotoreclamado</td><td>$descripcionbiencontratado</td><td>$tiporeclamo</td><td>$detallesreclamo</td><td>$pedidoreclamo</td><td>$observacioneslrd</td></tr>";
     }
     echo '</tbody></table></div></div>';
 }


?>
