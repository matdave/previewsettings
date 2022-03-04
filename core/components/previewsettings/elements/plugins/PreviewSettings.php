<?php
/**
 * @var modX $modx
 * @var array $scriptProperties
 */
$previewSettings = $modx->getService('previewsettings', 'PreviewSettings', $modx->getOption('previewsettings.core_path', null, $modx->getOption('core_path') . 'components/previewsettings/') . 'model/previewsettings/');
if (!($previewSettings instanceof \PreviewSettings)) return '';

$plugin = new \PreviewSettings\Plugin\PreviewSettings($previewSettings, $scriptProperties);
switch($modx->event->name) {
    case 'OnLoadWebDocument':
        if($plugin->canRun() && $modx->resource){
            $modx->resource->set('cacheable', 0);
        }
        break;
    case 'OnMODXInit':
        $plugin->run();
        break;
}
return;
