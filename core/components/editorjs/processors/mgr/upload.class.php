<?php

class EditorJsFileUploadProcessor extends modProcessor {

    /** @var modMediaSource $source */
    public $source;

    public function process()
    {
        $this->modx->lexicon->load('core:file');

        if (!$this->getSource()) {
            return $this->failure($this->modx->lexicon('permission_denied'));
        }
        $this->source->setRequestProperties($this->getProperties());
        $this->source->initialize();
        if (!$this->source->checkPolicy('create')) {
            return $this->failure($this->modx->lexicon('permission_denied'));
        }
        $properties = $this->source->getPropertyList();
        $info = new SplFileInfo($_FILES['file']['name']);
        $extension = strtolower($info->getExtension());
        $filetitle = $info->getBasename('.' . $extension);
        $filename = $info->getFilename();
        $filesize = filesize($_FILES['file']['tmp_name']);
        $allowed_extensions = [];
        if (!empty($properties['allowedFileTypes'])) {
            $allowed_extensions = array_map('trim', explode(',', strtolower($properties['allowedFileTypes'])));
        }
        $filetype = $this->getProperty('filetype');
        if ($filetype === 'image') {
            if (!empty($allowed_extensions) && !in_array($extension, $allowed_extensions)) {
                @unlink($_FILES['file']);
                return $this->failure($this->modx->lexicon('file_err_ext_not_allowed', [
                    'ext' => $extension
                ]));
            }
        }

        $path = preg_replace('/[\.]{2,}/', '', htmlspecialchars($this->getProperty('path')));
        if (empty($path)) {
            $path = $this->modx->getOption('editorjs_source_path');
        }
        $path = ltrim($path, '/');
        $this->source->createContainer($path, '/');
        $this->source->errors = [];

        // core/model/modx/sources/modfilemediasource.class.php
        if ($filetype === 'file') {
            $this->source->setOption('allowedFileTypes', $this->modx->getOption('upload_files'));
        }
        $success = $this->source->uploadObjectsToContainer($path,$_FILES);

        if (empty($success)) {
            $msg = '';
            $errors = $this->source->getErrors();
            foreach ($errors as $k => $msg) {
                $this->modx->error->addField($k,$msg);
            }
            if (empty($msg)) $msg = 'Unknown error';
            return $this->failure($msg);
        }

        $source_url = $this->source->getBaseUrl();
        $url = "{$source_url}{$path}{$filename}";
        return $this->success('', [
            'url' => $url,
            'title' => $filetitle,
            'name' => $filename,
            'size' => $filesize,
            'extension' => $extension,
        ]);
    }


    /**
     * Get the active Source
     * @return modMediaSource|boolean
     */
    public function getSource() {
        $this->modx->loadClass('sources.modMediaSource');
        $this->source = modMediaSource::getDefaultSource($this->modx,$this->getProperty('source'));
        if (empty($this->source) || !$this->source->getWorkingContext()) {
            return false;
        }
        return $this->source;
    }

}

return  'EditorJsFileUploadProcessor';