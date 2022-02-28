<?php
namespace PreviewSettings\Plugin;

abstract class Plugin
{

    /** @var \modX $modx */
    protected $modx;

    /** @var \PreviewSettings $previewSettings */
    protected $previewSettings;

    /** @var array $scriptProperties */
    protected $scriptProperties;

    public function __construct(\PreviewSettings &$previewSettings, array $scriptProperties = [])
    {
        $this->previewSettings =& $previewSettings;
        $this->modx =& $this->previewSettings->modx;
        $this->scriptProperties = $scriptProperties;
    }

    abstract public function run();
}
