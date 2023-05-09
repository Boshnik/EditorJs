<?php

namespace Boshnik\EditorJs\Events;


/**
 * class OnHandleRequest
 */
class OnHandleRequest extends Event
{
    public function run()
    {

        if (!$this->modx->checkSiteStatus()) return false;
        if ($this->modx->context->key === 'mgr') return false;

        $alias = $this->modx->getOption('request_param_alias');
        if (empty($_REQUEST[$alias])) {
            $id = $this->modx->getOption('site_start', [], 1, true);
            $this->modx->resource = $this->modx->getObject(\modResource::class, $id);
        } else {
            $alias = $_REQUEST[$alias];
            $this->modx->resource = $this->modx->getObject(\modResource::class, ['alias' => $alias]);
            if (!$this->modx->resource) {
                $this->modx->resource = $this->modx->getObject(\modResource::class, ['uri' => $alias]);
            }
        }

        if ($this->modx->resource && !empty($this->modx->resource->content)) {
            if ($this->modx->resource->richtext) return false;

            $content = json_decode($this->modx->resource->content,1);
            if ($content && isset($content['blocks'])) {
                $this->modx->resource->set('content', $this->editorjs->render($content['blocks']));
            }

            $this->modx->request->prepareResponse();
        }
    }
}