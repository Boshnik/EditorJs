<?php
/**
 * EditorJs connector
 *
 * @var modX $modx
 */

require_once dirname(__FILE__, 4) . '/config.core.php';
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
require_once MODX_CONNECTORS_PATH . 'index.php';

/** @var EditorJs $editorjs */
if ($modx->services instanceof MODX\Revolution\Services\Container) {
    $editorjs = $modx->services->get('editorjs');
} else {
    $editorjs = $modx->getService('editorjs', 'EditorJs', MODX_CORE_PATH . 'components/editorjs/model/');
}

// Handle request
$modx->request->handleRequest([
    'processors_path' => $editorjs->config['processorsPath'],
    'location' => ''
]);