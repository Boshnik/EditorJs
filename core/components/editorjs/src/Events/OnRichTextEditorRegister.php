<?php

namespace Boshnik\EditorJs\Events;


/**
 * class OnRichTextEditorRegister
 */
class OnRichTextEditorRegister extends Event
{
    public function run()
    {
        $this->modx->event->output('EditorJs');
    }
}