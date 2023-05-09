<?php
/**
 * EditorJs
 *
 * @var modX $modx
 * @var array $scriptProperties
 */

/** @var EditorJs $editorjs */
if ($modx->services instanceof MODX\Revolution\Services\Container) {
    $editorjs = $modx->services->get('editorjs');
} else {
    $editorjs = $modx->getService('editorjs', 'EditorJs', MODX_CORE_PATH . 'components/editorjs/model/');
}

$className = 'Boshnik\EditorJs\Events\\' . $modx->event->name;
if (class_exists($className)) {
    $handler = new $className($modx, $scriptProperties);
    $handler->run();
}