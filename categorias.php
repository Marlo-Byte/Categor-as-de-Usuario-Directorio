<?php
// Función para cargar Font Awesome si es necesario
function cargar_font_awesome_si_es_necesario() {
    if (!wp_script_is('font-awesome', 'enqueued')) {
        wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css', array(), null);
    }
}
add_action('wp_enqueue_scripts', 'cargar_font_awesome_si_es_necesario');

// Función para cargar jQuery si es necesario
function cargar_jquery_si_es_necesario() {
    if (!wp_script_is('jquery', 'enqueued')) {
        wp_enqueue_script('jquery');
    }
}
add_action('wp_enqueue_scripts', 'cargar_jquery_si_es_necesario');

// Definir constantes para los nombres de las taxonomías
define('CATEGORIA_USUARIO', 'categoria_usuario');
define('PROVINCIA_USUARIO', 'provincia_usuario');

// Registrar taxonomías personalizadas para usuarios
function registrar_taxonomia_usuario() {
    register_taxonomy(
        CATEGORIA_USUARIO,
        'user',
        array(
            'label' => 'Categoría de Usuario',
            'rewrite' => array('slug' => 'categoria-usuario'),
            'hierarchical' => true,
        )
    );

    register_taxonomy(
        PROVINCIA_USUARIO,
        'user',
        array(
            'label' => 'Provincia de Usuario',
            'rewrite' => array('slug' => 'provincia-usuario'),
            'hierarchical' => true,
        )
    );
}
add_action('init', 'registrar_taxonomia_usuario');

// Agregar la pestaña de categorías y provincias de usuarios
function agregar_pestana_categorias_usuario() {
    add_users_page('Categorías de Usuarios', 'Categorías de Usuarios', 'edit_users', 'edit-tags.php?taxonomy=' . CATEGORIA_USUARIO);
    add_users_page('Provincias de Usuarios', 'Provincias de Usuarios', 'edit_users', 'edit-tags.php?taxonomy=' . PROVINCIA_USUARIO);
}
add_action('admin_menu', 'agregar_pestana_categorias_usuario');

// Mostrar campos de categoría y provincia en el perfil de usuario
function mostrar_campo_categoria_provincia_usuario($user) {
    $nombre_empresa = get_user_meta($user->ID, 'nombre_empresa', true);
    $categoria_usuario = get_user_meta($user->ID, 'categoria_usuario', true);
    $provincia_usuario = get_user_meta($user->ID, 'provincia_usuario', true);
    $mostrar_en_lista = get_user_meta($user->ID, 'mostrar_en_lista', true);
    $whatsapp = get_user_meta($user->ID, 'whatsapp', true);
    $facebook = get_user_meta($user->ID, 'facebook', true);
    $linkedin = get_user_meta($user->ID, 'linkedin', true);
    $web = get_user_meta($user->ID, 'web', true);
    $instagram = get_user_meta($user->ID, 'instagram', true); // Nuevo campo de Instagram
    $descripcion_personalizada = get_user_meta($user->ID, 'descripcion_personalizada', true);
    $user_avatar = get_user_meta($user->ID, 'user_avatar', true); // Obtener la URL del avatar del usuario
    ?>

    <h3>Categoría y Provincia de Usuario</h3>
    <table class="form-table">
        <tr>
            <th><label for="nombre_empresa">Nombre de Empresa</label></th>
            <td>
                <input type="text" name="nombre_empresa" id="nombre_empresa" value="<?php echo esc_attr($nombre_empresa); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="user_avatar">Foto de Perfil</label></th>
            <td>
                <?php if ($user_avatar) : ?>
                    <img src="<?php echo esc_url($user_avatar); ?>" alt="Avatar" style="width: 100px; height: 100px; border-radius: 50%;" />
                <?php endif; ?>
                <input type="file" name="user_avatar" id="user_avatar" />
            </td>
        </tr>
        <tr>
            <th><label for="categoria_usuario_nueva">Seleccionar Categoría</label></th>
            <td>
                <?php
                $categorias = get_terms(array(
                    'taxonomy' => CATEGORIA_USUARIO,
                    'hide_empty' => false,
                ));
                if (!empty($categorias)) {
                    ?>
                    <select name="categoria_usuario_nueva" id="categoria_usuario_nueva">
                        <option value="">Seleccionar categoría</option>
                        <?php
                        foreach ($categorias as $categoria) {
                            ?>
                            <option value="<?php echo esc_attr($categoria->term_id); ?>" <?php selected($categoria->term_id, $categoria_usuario); ?>><?php echo esc_html($categoria->name); ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <?php
                } else {
                    echo 'No hay categorías disponibles.';
                }
                ?>
            </td>
        </tr>
        <tr>
            <th><label for="provincia_usuario_nueva">Seleccionar Provincia</label></th>
            <td>
                <?php
                $provincias = get_terms(array(
                    'taxonomy' => PROVINCIA_USUARIO,
                    'hide_empty' => false,
                ));
                if (!empty($provincias)) {
                    ?>
                    <select name="provincia_usuario_nueva" id="provincia_usuario_nueva">
                        <option value="">Seleccionar provincia</option>
                        <?php
                        foreach ($provincias as $provincia) {
                            ?>
                            <option value="<?php echo esc_attr($provincia->term_id); ?>" <?php selected($provincia->term_id, $provincia_usuario); ?>><?php echo esc_html($provincia->name); ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <?php
                } else {
                    echo 'No hay provincias disponibles.';
                }
                ?>
            </td>
        </tr>
        <tr>
            <th><label for="whatsapp">WhatsApp</label></th>
            <td>
                <input type="text" name="whatsapp" id="whatsapp" value="<?php echo esc_attr($whatsapp); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="facebook">Facebook</label></th>
            <td>
                <input type="url" name="facebook" id="facebook" value="<?php echo esc_attr($facebook); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="linkedin">LinkedIn</label></th>
            <td>
                <input type="url" name="linkedin" id="linkedin" value="<?php echo esc_attr($linkedin); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="web">Web</label></th>
            <td>
                <input type="url" name="web" id="web" value="<?php echo esc_attr($web); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="instagram">Instagram</label></th> <!-- Nuevo campo de Instagram -->
            <td>
                <input type="url" name="instagram" id="instagram" value="<?php echo esc_attr($instagram); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="descripcion_personalizada">Descripción</label></th>
            <td>
                <textarea name="descripcion_personalizada" id="descripcion_personalizada" rows="5" class="regular-text"><?php echo esc_textarea($descripcion_personalizada); ?></textarea>
            </td>
        </tr>
        <tr>
            <th><label for="mostrar_en_lista">Mostrar en la lista de usuarios</label></th>
            <td>
                <input type="checkbox" name="mostrar_en_lista" id="mostrar_en_lista" value="1" <?php checked($mostrar_en_lista, '1'); ?> />
            </td>
        </tr>
    </table>
    <?php
}
add_action('show_user_profile', 'mostrar_campo_categoria_provincia_usuario');
add_action('edit_user_profile', 'mostrar_campo_categoria_provincia_usuario');

// Guardar la categoría y provincia seleccionadas cuando se actualiza el perfil de usuario
function guardar_categorias_provincias_usuario($user_id) {
    if (current_user_can('edit_user', $user_id)) {
        if (isset($_POST['nombre_empresa'])) {
            update_user_meta($user_id, 'nombre_empresa', sanitize_text_field($_POST['nombre_empresa']));
        }

        if (isset($_FILES['user_avatar']) && !empty($_FILES['user_avatar']['name'])) {
            require_once(ABSPATH . 'wp-admin/includes/file.php');
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            require_once(ABSPATH . 'wp-admin/includes/media.php');

            $attachment_id = media_handle_upload('user_avatar', 0);
            if (is_wp_error($attachment_id)) {
                // Handle error.
            } else {
                $avatar_url = wp_get_attachment_url($attachment_id);
                update_user_meta($user_id, 'user_avatar', $avatar_url);
            }
        }

        if (isset($_POST['categoria_usuario_nueva'])) {
            update_user_meta($user_id, 'categoria_usuario', sanitize_text_field($_POST['categoria_usuario_nueva']));
        }

        if (isset($_POST['provincia_usuario_nueva'])) {
            update_user_meta($user_id, 'provincia_usuario', sanitize_text_field($_POST['provincia_usuario_nueva']));
        }

        if (isset($_POST['whatsapp'])) {
            update_user_meta($user_id, 'whatsapp', sanitize_text_field($_POST['whatsapp']));
        }

        if (isset($_POST['facebook'])) {
            update_user_meta($user_id, 'facebook', esc_url_raw($_POST['facebook']));
        }

        if (isset($_POST['linkedin'])) {
            update_user_meta($user_id, 'linkedin', esc_url_raw($_POST['linkedin']));
        }

        if (isset($_POST['web'])) {
            update_user_meta($user_id, 'web', esc_url_raw($_POST['web']));
        }

        if (isset($_POST['instagram'])) { // Guardar el nuevo campo de Instagram
            update_user_meta($user_id, 'instagram', esc_url_raw($_POST['instagram']));
        }

        if (isset($_POST['descripcion_personalizada'])) {
            update_user_meta($user_id, 'descripcion_personalizada', sanitize_textarea_field($_POST['descripcion_personalizada']));
        }

        if (isset($_POST['mostrar_en_lista'])) {
            update_user_meta($user_id, 'mostrar_en_lista', '1');
        } else {
            update_user_meta($user_id, 'mostrar_en_lista', '0');
        }
    }
}
add_action('personal_options_update', 'guardar_categorias_provincias_usuario');
add_action('edit_user_profile_update', 'guardar_categorias_provincias_usuario');

// Añadir estilos para la tabla de usuarios y cuadros de información
// Añadir estilos para la tabla de usuarios y cuadros de información
function estilo_tabla_usuarios() {
    echo '<style>
        .user-grid-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh; /* Altura mínima para centrar verticalmente */
        }
        .user-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr); /* Establecer tres columnas */
            gap: 20px;
            max-width: 1200px; /* Limitar el ancho máximo para centrar la cuadrícula */
            width: 100%;
        }
        .user-box {
            width: 100%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            background-color: #fff;
            overflow: hidden;
            box-sizing: border-box;
            text-align: left;
            transition: box-shadow 0.3s ease;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 400px; /* Establecer una altura mínima para los cuadros */
        }
        .user-box:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        .user-box .user-avatar {
            margin-bottom: 10px;
            text-align: center;
        }
        .user-avatar img {
            border-radius: 50%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            width: 150px; /* Cambiar de 100px a 150px */
            height: 150px; /* Cambiar de 100px a 150px */
        }
        .user-box .user-info {
            font-size: 16px;
            line-height: 1.6;
            color: #333;
            flex-grow: 1; /* Permitir que crezca para ocupar el espacio disponible */
        }
        .user-info .nombre {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
            text-align: center; /* Añadir esta línea para centrar el texto */
        }
        .user-info .descripcion {
            font-size: 16px;
            color: #333;
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 10px;
            max-height: 100px; /* Altura máxima para la descripción */
            overflow: hidden;
            position: relative;
            transition: max-height 0.3s ease;
        }
        .user-info .descripcion.expanded {
            max-height: 200px; /* Altura máxima cuando está expandida */
            overflow-y: auto; /* Añadir scroll vertical */
        }
        .user-info .descripcion .ver-mas {
            display: block;
            text-align: center;
            background: #fff;
            color: #0077b5;
            cursor: pointer;
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 5px;
        }
        .user-info .descripcion .ver-mas:hover {
            text-decoration: underline;
        }
        .user-info .descripcion strong {
            display: block;
            font-size: 18px; /* Ajusta el tamaño del título según tus necesidades */
            margin-bottom: 5px;
        }
        .categoria-provincia {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }
        .categoria-provincia .categoria, .categoria-provincia .provincia {
            font-size: 16px;
            color: #333;
            background-color: #ffebcc;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 48%;
            white-space: normal;
            overflow: visible;
            text-overflow: clip;
            text-align: center; /* Centrar el texto */
        }
        .categoria-provincia .categoria strong, .categoria-provincia .provincia strong {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .categoria-provincia-separador {
            width: 100%;
            height: 2px;
            background-color: #FF4605;
            margin: 20px 0;
        }
        .redes-sociales {
            display: flex;
            flex-wrap: wrap; /* Permitir que los elementos se envuelvan */
            justify-content: center;
            align-items: center;
            margin-top: 10px;
        }
        .redes-sociales div {
            margin: 5px; /* Reducir el margen para más espacio */
        }
        .redes-sociales a {
            text-decoration: none;
            color: #333;
            display: flex;
            align-items: center;
            transition: color 0.3s ease;
        }
        .redes-sociales a:hover {
            color: #0077b5;
        }
        .redes-sociales i {
            font-size: 20px; /* Reducir el tamaño del icono */
            margin-right: 5px;
        }
        .whatsapp i {
            color: #25D366;
        }
        .facebook i {
            color: #1877F2;
        }
        .linkedin i {
            color: #0077B5;
        }
        .web i {
            color: #1DA1F2;
        }
        .instagram i { /* Estilo para el icono de Instagram */
            color: #E1306C;
        }
        @media only screen and (max-width: 900px) {
            .user-grid {
                grid-template-columns: repeat(2, 1fr); /* Dos columnas para pantallas medianas */
            }
        }
        @media only screen and (max-width: 600px) {
            .user-grid {
                grid-template-columns: repeat(1, 1fr); /* Una columna para pantallas pequeñas */
            }
        }
        .seleccion-categoria-provincia {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .seleccion-categoria, .seleccion-provincia {
            width: 48%;
            margin-bottom: 10px;
        }
        .seleccion-categoria select, .seleccion-provincia select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        .seleccion-categoria label, .seleccion-provincia label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        @media only screen and (max-width: 600px) {
            .seleccion-categoria, .seleccion-provincia {
                width: 100%;
            }
        }
        .buscar-btn {
            width: 100%;
            padding: 10px;
            background-color: #FF4605;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .buscar-btn:hover {
            background-color: #fc7b50;
        }
    </style>';
}
add_action('wp_enqueue_scripts', 'estilo_tabla_usuarios');

// Registrar el shortcode para mostrar selectores de categoría y provincia con filtro de usuarios
function mostrar_selectores_categoria_provincia() {
    ob_start();

    // Obtener todas las categorías de usuario
    $categorias = get_terms(array(
        'taxonomy' => CATEGORIA_USUARIO,
        'hide_empty' => false,
    ));

    // Obtener todas las provincias de usuario
    $provincias = get_terms(array(
        'taxonomy' => PROVINCIA_USUARIO,
        'hide_empty' => false,
    ));
    ?>

    <div class="seleccion-categoria-provincia">
        <div class="seleccion-categoria">
            <label for="categoria_usuario_shortcode">Seleccionar Categoría</label>
            <select id="categoria_usuario_shortcode" name="categoria_usuario_shortcode">
                <option value="">Seleccionar categoría</option>
                <?php
                foreach ($categorias as $categoria) {
                    ?>
                    <option value="<?php echo esc_attr($categoria->term_id); ?>"><?php echo esc_html($categoria->name); ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
        <div class="seleccion-provincia">
            <label for="provincia_usuario_shortcode">Seleccionar Provincia</label>
            <select id="provincia_usuario_shortcode" name="provincia_usuario_shortcode">
                <option value="">Seleccionar provincia</option>
                <?php
                foreach ($provincias as $provincia) {
                    ?>
                    <option value="<?php echo esc_attr($provincia->term_id); ?>"><?php echo esc_html($provincia->name); ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
        <button class="buscar-btn" id="buscar_usuarios">Buscar</button>
        <div id="usuarios_resultado"></div>
    </div>

    <script>
jQuery(document).ready(function($) {
    function filtrar_usuarios() {
        var categoria = $('#categoria_usuario_shortcode').val();
        var provincia = $('#provincia_usuario_shortcode').val();
        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'filtrar_usuarios_por_categoria_provincia',
                categoria: categoria,
                provincia: provincia
            },
            success: function(response) {
                $('#usuarios_resultado').html(response);
            }
        });
    }

    $('#buscar_usuarios').click(filtrar_usuarios);

    // Funcionalidad de "Ver Más"
    $(document).on('click', '.ver-mas', function() {
        var descripcion = $(this).closest('.descripcion');
        descripcion.toggleClass('expanded');

        if (descripcion.hasClass('expanded')) {
            $(this).html('Ver Menos <i class="fas fa-chevron-up"></i>');

            // Fijar el botón "Ver Menos" en la parte inferior de la pantalla
            var boton_ver_menos = $(this);
            var pantalla_ancho = $(window).width();
            var boton_ancho = boton_ver_menos.outerWidth();
            var margen_derecho = (pantalla_ancho - boton_ancho) / 2;

            boton_ver_menos.css({
                'position': 'fixed',
                'bottom': '20px',
                'right': margen_derecho + 'px'
            });
        } else {
            $(this).html('Ver Más <i class="fas fa-chevron-down"></i>');

            // Restaurar la posición original del botón "Ver Menos"
            boton_ver_menos.css({
                'position': 'static'
            });
        }
    });
});
    </script>

    <?php
    return ob_get_clean();
}
add_shortcode('seleccion_categoria_provincia', 'mostrar_selectores_categoria_provincia');

// Función AJAX para filtrar los usuarios por categoría y provincia
function filtrar_usuarios_por_categoria_provincia() {
    $categoria = isset($_POST['categoria']) ? intval($_POST['categoria']) : '';
    $provincia = isset($_POST['provincia']) ? intval($_POST['provincia']) : '';

    $args = array(
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => 'mostrar_en_lista',
                'value' => '1',
                'compare' => '='
            ),
        ),
    );

    if ($categoria) {
        $args['meta_query'][] = array(
            'key' => 'categoria_usuario',
            'value' => $categoria,
            'compare' => '='
        );
    }

    if ($provincia) {
        $args['meta_query'][] = array(
            'key' => 'provincia_usuario',
            'value' => $provincia,
            'compare' => '='
        );
    }

    $usuarios = get_users($args);

    if (!empty($usuarios)) {
        echo '<div class="user-grid-container"><div class="user-grid">';
        foreach ($usuarios as $usuario) {
            $nombre_empresa = get_user_meta($usuario->ID, 'nombre_empresa', true);
            $whatsapp = get_user_meta($usuario->ID, 'whatsapp', true);
            $facebook = get_user_meta($usuario->ID, 'facebook', true);
            $linkedin = get_user_meta($usuario->ID, 'linkedin', true);
            $web = get_user_meta($usuario->ID, 'web', true);
            $instagram = get_user_meta($usuario->ID, 'instagram', true); // Nuevo campo de Instagram
            $descripcion_personalizada = get_user_meta($usuario->ID, 'descripcion_personalizada', true);
            $categoria_usuario = get_user_meta($usuario->ID, 'categoria_usuario', true);
            $provincia_usuario = get_user_meta($usuario->ID, 'provincia_usuario', true);
            $categoria_nombre = get_term($categoria_usuario)->name;
            $provincia_nombre = get_term($provincia_usuario)->name;
            $user_avatar = get_user_meta($usuario->ID, 'user_avatar', true); // Obtener la URL del avatar del usuario
            ?>

            <div class="user-box">
                <div class="user-avatar">
                    <?php if ($user_avatar) : ?>
                        <img src="<?php echo esc_url($user_avatar); ?>" alt="Avatar" style="width: 150px; height: 150px; border-radius: 50%;" />
                    <?php else : ?>
                        <?php echo get_avatar($usuario->ID, 150); ?>
                    <?php endif; ?>
                </div>
                <div class="user-info">
                    <div class="nombre"><?php echo esc_html($nombre_empresa); ?></div>
                    <?php if ($descripcion_personalizada) { ?>
                        <div class="descripcion">
                            <strong>Descripción:</strong>
                            <?php echo esc_html($descripcion_personalizada); ?>
                            <span class="ver-mas">Ver Más</span>
                        </div>
                    <?php } ?>
                </div>
                <div class="redes-sociales">
                    <?php if ($whatsapp) { ?>
                        <div class="whatsapp"><a href="https://wa.me/<?php echo esc_attr($whatsapp); ?>" target="_blank"><i class="fab fa-whatsapp"></i>Whatsapp</a></div>
                    <?php } ?>
                    <?php if ($facebook) { ?>
                        <div class="facebook"><a href="<?php echo esc_url($facebook); ?>" target="_blank"><i class="fab fa-facebook"></i>Facebook</a></div>
                    <?php } ?>
                    <?php if ($linkedin) { ?>
                        <div class="linkedin"><a href="<?php echo esc_url($linkedin); ?>" target="_blank"><i class="fab fa-linkedin"></i>LinkedIn</a></div>
                    <?php } ?>
                    <?php if ($web) { ?>
                        <div class="web"><a href="<?php echo esc_url($web); ?>" target="_blank"><i class="fas fa-globe"></i>Web</a></div>
                    <?php } ?>
                    <?php if ($instagram) { ?> <!-- Nuevo enlace de Instagram -->
                        <div class="instagram"><a href="<?php echo esc_url($instagram); ?>" target="_blank"><i class="fab fa-instagram"></i>Instagram</a></div>
                    <?php } ?>
                </div>
                <div class="categoria-provincia-separador"></div>
                <div class="categoria-provincia">
                    <div class="categoria"><strong>Categoría:</strong><?php echo esc_html($categoria_nombre); ?></div>
                    <div class="provincia"><strong>Provincia:</strong><?php echo esc_html($provincia_nombre); ?></div>
                </div>
            </div>

            <?php
        }
        echo '</div></div>';
    } else {
        echo 'No se encontraron usuarios.';
    }

    wp_die();
}
add_action('wp_ajax_filtrar_usuarios_por_categoria_provincia', 'filtrar_usuarios_por_categoria_provincia');
add_action('wp_ajax_nopriv_filtrar_usuarios_por_categoria_provincia', 'filtrar_usuarios_por_categoria_provincia');