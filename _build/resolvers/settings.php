<?php

/** @var xPDOTransport $transport */
/** @var array $options */
/** @var modX $modx */

if ($transport->xpdo) {
    /** @var modX $modx */
    $modx =& $transport->xpdo;

    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
        case xPDOTransport::ACTION_UPGRADE:

            $settings = [
                'which_editor' => 'EditorJs',
            ];
            foreach ($settings as $key => $value) {
                /** @var modSystemSetting $setting */
                if ($setting = $modx->getObject(modSystemSetting::class, ['key' => $key])) {
                    $setting->set('value', $value);
                    $setting->save();
                }
            }
            break;

        case xPDOTransport::ACTION_UNINSTALL:
            break;
    }
}

return true;