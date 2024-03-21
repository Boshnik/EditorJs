<?php
/** @var modX $modx */
/** @var string $input */

if ($modx->services instanceof MODX\Revolution\Services\Container) {
    $editorjs = $modx->services->get('editorjs');
} else {
    $editorjs = $modx->getService('editorjs', 'EditorJs', MODX_CORE_PATH . 'components/editorjs/model/');
}

$content = json_decode($input,1);
if (isset($content['blocks'])) {
    return $editorjs->render($content['blocks']);
}

return $input;