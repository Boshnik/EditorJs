<?php

namespace Boshnik\EditorJs\Events;

/**
 * class OnDocFormPrerender
 */
class OnDocFormPrerender extends Event
{
    public function run()
    {

        /** @var \modResource $resource */
        $resource = $this->scriptProperties['resource'];
        if (!$resource || !$resource->richtext) {
            return false;
        }

        $which_editor = $this->modx->getOption('which_editor');
        if ($which_editor !== 'EditorJs') {
            return false;
        }

        $config = $this->editorjs->config;
        $cssUrl = $config['cssUrl'];
        $jsUrl = $config['jsUrl'];

        $this->modx->controller->addCss($cssUrl . 'main.css');
        $this->modx->controller->addCss('https://cdn.jsdelivr.net/npm/editorjs-tooltip/src/index.min.css');

        $scripts = [
            'config' => $jsUrl . 'editor.js',
            // https://github.com/codex-team/editor.js
            'core' => 'https://cdn.jsdelivr.net/npm/@editorjs/editorjs@latest',
            // https://github.com/editor-js/header
            'header' => 'https://cdn.jsdelivr.net/npm/@editorjs/header@latest',
            // https://github.com/wandersonsousa/header-with-alignment
            'header-alignment' => $jsUrl . 'header-alignment.js',
            // https://github.com/editor-js/quote
            'quote' => 'https://cdn.jsdelivr.net/npm/@editorjs/quote@latest',
            // https://github.com/editor-js/simple-image
            // 'simple-image' => 'https://cdn.jsdelivr.net/npm/@editorjs/simple-image@latest',
            // https://github.com/editor-js/image
            'image' => 'https://cdn.jsdelivr.net/npm/@editorjs/image@latest',
            // https://github.com/editor-js/nested-list
            'list' => 'https://cdn.jsdelivr.net/npm/@editorjs/nested-list@latest',
            // https://github.com/editor-js/checklist
            'checklist' => 'https://cdn.jsdelivr.net/npm/@editorjs/checklist@latest',
            // https://github.com/editor-js/link
            'link' => 'https://cdn.jsdelivr.net/npm/@editorjs/link/dist/bundle.min.js',
            // https://github.com/editor-js/embed
            'embed' => 'https://cdn.jsdelivr.net/npm/@editorjs/embed@latest',
            // https://github.com/editor-js/table
            'table' => $jsUrl . 'table.js',
            // https://github.com/editor-js/delimiter
            'delimiter' => 'https://cdn.jsdelivr.net/npm/@editorjs/delimiter/dist/bundle.min.js',
            // https://github.com/editor-js/warning
            'warning' => 'https://cdn.jsdelivr.net/npm/@editorjs/warning@latest',
            // https://github.com/editor-js/code
            'code' => 'https://cdn.jsdelivr.net/npm/@editorjs/code/dist/bundle.min.js',
            // https://github.com/editor-js/raw
            'raw' => 'https://cdn.jsdelivr.net/npm/@editorjs/raw',
            // https://github.com/editor-js/attaches
            'attaches' => 'https://cdn.jsdelivr.net/npm/@editorjs/attaches@latest',
            // https://github.com/editor-js/marker
            'marker' => 'https://cdn.jsdelivr.net/npm/@editorjs/marker@latest',
            // https://github.com/editor-js/inline-code
            'inline-code' => 'https://cdn.jsdelivr.net/npm/@editorjs/inline-code/dist/bundle.min.js',
            // https://github.com/SotaProject/strikethrough
            'strikethrough' => $jsUrl . 'strikethrough.js',
            // https://github.com/editor-js/underline
            'underline' => 'https://cdn.jsdelivr.net/npm/@editorjs/underline@latest',
            // https://github.com/kommitters/editorjs-tooltip
            'tooltip' => 'https://cdn.jsdelivr.net/npm/editorjs-tooltip',
            // https://github.com/maziyank/editorjs-change-case
            'case' => $jsUrl . 'case.js',
            // https://github.com/hata6502/editorjs-style
            'style' => 'https://cdn.jsdelivr.net/npm/editorjs-style@latest',
            // https://github.com/hata6502/editorjs-inline-template
//            'template' => 'https://cdn.jsdelivr.net/npm/editorjs-inline-template@latest',
            // https://github.com/trinhtam/editorjs-hyperlink
//            'hyperlink' => $jsUrl . 'hyperlink.js',
            // https://github.com/calumk/editorjs-columns
            'columns' => 'https://cdn.jsdelivr.net/npm/@calumk/editorjs-columns@latest',
            // https://github.com/VolgaIgor/editorjs-gallery
            'gallery' => $jsUrl . 'gallery.js',
            // https://github.com/mr8bit/carousel-editorjs
//            'carousel' => $jsUrl . 'carousel.js',
            // https://github.com/kommitters/editorjs-toggle-block
            'toggle' => 'https://cdn.jsdelivr.net/npm/editorjs-toggle-block',
            // https://github.com/Aleksst95/header-with-anchor
            'anchor' => $jsUrl . 'anchor.js',
            // https://github.com/kaaaaaaaaaaai/paragraph-with-alignment
            'alignment' => 'https://cdn.jsdelivr.net/npm/editorjs-paragraph-with-alignment@3.0.0',
            // https://github.com/vishaltelangre/editorjs-alert
            'alert' => 'https://cdn.jsdelivr.net/npm/editorjs-alert@latest',
            // https://github.com/kommitters/editorjs-drag-drop
            'drop' => 'https://cdn.jsdelivr.net/npm/editorjs-drag-drop',
        ];

        foreach ($scripts as $url) {
            $this->modx->controller->addJavascript($url);
        }

//        $resource->content = trim($resource->content, '<p>,</p>');

        $config = $this->editorjs->config;
        $this->modx->controller->addHtml('<script>
            Ext.onReady(() => {
                window.EditorJs = {};
                EditorJs.config = ' . json_encode($config) . ';
                EditorJs.resource = ' . json_encode($resource->toArray()) . ';
                window.dispatchEvent(new CustomEvent("EditorJsLoad"));
            });
        </script>');
    }
}