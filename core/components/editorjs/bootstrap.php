<?php
/** @var MODX\Revolution\modX $modx */

require_once MODX_CORE_PATH . 'components/editorjs/vendor/autoload.php';

$modx->services['editorjs'] = $modx->services->factory(function($c) use ($modx) {
    return new Boshnik\EditorJs\EditorJs($modx);
});