<?php

/**
 * Plugin Name: WP ZGZ 3D
 * Plugin URI: https://zaragoza.wordcamp.org/2023/
 * Description: Plugin de Ejemplo para añadir un 3D en WP
 * Version: 0.1
 * Author: Rafael del Molino
 * Author URI: https://zaragoza.wordcamp.org/2023/session/como-anadir-modelos-3d-en-nuestros-productos/
 **/



// Filtro para importar GLB
add_filter('upload_mimes', function ($mime_types) {
    $mime_types['gltf'] = 'model/gltf+json';
    $mime_types['glb'] = 'model/gltf-binary';
    return $mime_types;
});


add_filter('wp_check_filetype_and_ext', function ($data, $file, $filename, $mime_types, $real_mime_type) {
    if (
        empty($data['ext'])
        || empty($data['type'])
    ) {
        $file_type = wp_check_filetype($filename, $mime_types);

        if ('gltf' === $file_type['ext']) {
            $data['ext']  = 'gltf';
            $data['type'] = 'model/gltf+json';
        }

        if ('glb' === $file_type['ext']) {
            $data['ext']  = 'glb';
            $data['type'] = 'model/glb-binary';
        }
    }

    return $data;
}, 10, 5);


// Shortcode
function wp_zgz_3d_plugin_demo($atts)
{
    include dirname(__FILE__) . '/template.php';
}
add_shortcode('producto-3d', 'wp_zgz_3d_plugin_demo');
