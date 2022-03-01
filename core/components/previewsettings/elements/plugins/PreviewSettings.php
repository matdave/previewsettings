<?php
/**
 * @var modX $modx
 * @var array $scriptProperties
 */
$previewSettings = $modx->getService('previewsettings', 'PreviewSettings', $modx->getOption('previewsettings.core_path', null, $modx->getOption('core_path') . 'components/previewsettings/') . 'model/previewsettings/');
if (!($previewSettings instanceof \PreviewSettings)) return '';

if($resource){
    $scriptProperties['resource'] = $resource;
}

$plugin = new \PreviewSettings\Plugin\PreviewSettings($previewSettings, $scriptProperties);
$plugin->run();
