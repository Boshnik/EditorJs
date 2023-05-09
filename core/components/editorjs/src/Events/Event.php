<?php

namespace Boshnik\EditorJs\Events;

abstract class Event
{

    /** @var modX $modx */
    protected $modx;

    /** @var EditorJs $editorjs */
    protected $editorjs;

    /** @var array $scriptProperties */
    protected $scriptProperties;

    public $modxversion;

    public function __construct($modx, &$scriptProperties)
    {
        $this->modx = $modx;
        $this->scriptProperties =& $scriptProperties;

        if ($this->modx->services instanceof MODX\Revolution\Services\Container) {
            $this->editorjs = $this->modx->services->get('editorjs');
        } else {
            $this->editorjs = $this->modx->getService('editorjs', 'EditorJs', MODX_CORE_PATH . 'components/editorjs/model/');
        }
        $this->modxversion = $this->editorjs->config['modxversion'];
    }

    abstract public function run();
}