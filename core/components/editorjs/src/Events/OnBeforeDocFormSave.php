<?php

namespace Boshnik\EditorJs\Events;


/**
 * class OnBeforeDocFormSave
 */
class OnBeforeDocFormSave extends Event
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

        if (!empty($resource->content)) {
            $properties = json_decode($resource->properties,1);
            $content = json_decode($resource->content,1);
            $properties['editorjs'] = $content;
            $resource->set('properties', json_encode($properties,1));
            $resource->set('content', $this->editorjs->render($content['blocks']));
            $resource->set('ta', '');
        }
    }
}