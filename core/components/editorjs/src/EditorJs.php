<?php

namespace Boshnik\EditorJs;

use modX;
use PDO;

require_once MODX_CORE_PATH . 'model/modx/smarty/modsmarty.class.php';

/**
 * class EditorJs
 */
class EditorJs
{
    /** @var modX $modx */
    public $modx;

    /**
     * The namespace
     * @var string $namespace
     */
    public $namespace = 'editorjs';

    /**
     * The package name
     * @var string $packageName
     */
    public $packageName = 'EditorJs';

    /**
     * The version
     * @var string $version
     */
    public $version = '1.0.0';

    /**
     * The class config
     * @var array $config
     */
    public $config = [];


    /**
     * @param modX $modx
     * @param array $config
     */
    function __construct(modX &$modx, array $config = [])
    {
        $this->modx =& $modx;

        $corePath = MODX_CORE_PATH . 'components/editorjs/';
        $assetsUrl = MODX_ASSETS_URL . 'components/editorjs/';

        $modxversion = $this->modx->getVersionData();

        $this->config = array_merge([
            'namespace' => $this->namespace,
            'version' => $this->version,
            'corePath' => $corePath,
            'modelPath' => $corePath . 'model/',
            'processorsPath' => $corePath . 'processors/',
            'connectorUrl' => $assetsUrl . 'connector.php',
            'assetsUrl' => $assetsUrl,
            'cssUrl' => $assetsUrl . 'css/',
            'jsUrl' => $assetsUrl . 'js/',

            'modxversion' => $modxversion['version'],
            'is_admin' => $this->modx->user->isMember('Administrator'),

            'templates_custom' => $this->modx->getOption('editorjs_templates_custom_url', $config, '', true),
            'templates' => $this->modx->getOption('editorjs_templates_url', $config, ''),
        ], $config);

        $this->modx->addPackage($this->namespace, $this->config['modelPath']);
        $this->modx->lexicon->load("$this->namespace:default");
    }


    /**
     * @param $blocks
     * @return string
     */
    public function render($blocks)
    {
        $result = [];
        $offset = 0;
        foreach ($blocks as $idx => $block) {
            $block['data']['id'] = $block['id'];
            $block['data']['idx'] = $idx;

            if ($block['type'] == 'toggle') {
                $wrapper = [];
                $offset = $block['data']['items'];
                foreach ($blocks as $idx2 => $block2) {
                    if ($idx2 > $idx && $idx2 < ($idx+$block['data']['items'])) {
                        $block2['data']['id'] = $block2['id'];
                        $block2['data']['idx'] = $idx2;
                        $wrapper[] = $this->fetchTemplate($block2['type'], $block2['data']);
                    }
                }
                $block['data']['wrapper'] = implode($wrapper);
                $result[] = $this->fetchTemplate($block['type'], $block['data']);
            }
            if (!$offset) {
                $result[] = $this->fetchTemplate($block['type'], $block['data']);
            } else {
                --$offset;
            }
        }

        $html = implode($result);

        return $html;
    }

    /**
     * @param $tpl
     * @param $data
     * @return mixed
     */
    public function fetchTemplate($tpl, $data)
    {
        $templatePath = MODX_BASE_PATH . ($this->config['templates_custom'] ?: $this->config['templates']);
        $this->modx->smarty = new \modSmarty($this->modx);
        $this->modx->smarty->setTemplatePath($templatePath);
        $this->setPlaceholders($data);
        $this->setPlaceholder('modx', $this->modx);

        return $this->modx->smarty->fetch($tpl.'.tpl');
    }

    /**
     * @param $keys
     */
    public function setPlaceholders($keys)
    {
        foreach ($keys as $k => $v) {
            $this->setPlaceholder($k,$v);
        }
    }

    /**
     * @param $k
     * @param $v
     */
    public function setPlaceholder($k,$v) {
        $this->placeholders[$k] = $v;
        $this->modx->smarty->assign($k,$v);
    }

}