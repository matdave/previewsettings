<?php

/**
 * The main PreviewSettings service class.
 *
 * @package previewsettings
 */
class PreviewSettings
{
    /** @var \modX */
    public $modx = null;
    public $options = array();
    public $namespace = 'previewsettings';

    public function __construct(modX &$modx, array $options = array())
    {
        $this->modx =& $modx;
        $this->namespace = $this->getOption('namespace', $options, 'previewsettings');

        $corePath = $this->getOption('core_path', $options, $this->modx->getOption('core_path', null, MODX_CORE_PATH) . 'components/previewsettings/');

        /* loads some default paths for easier management */
        $this->options = array_merge(array(
            'namespace' => $this->namespace,
            'corePath' => $corePath,
            'modelPath' => $corePath . 'model/',
            'pluginsPath' => $corePath . 'elements/plugins/',
        ), $options);

        $this->modx->addPackage('previewsettings', $this->getOption('modelPath'));
        $this->modx->lexicon->load('previewsettings:default');
        $this->autoload();
    }

    public function getOption($key, $options = array(), $default = null)
    {
        $option = $default;
        if (!empty($key) && is_string($key)) {
            if ($options != null && array_key_exists($key, $options)) {
                $option = $options[$key];
            } elseif (array_key_exists($key, $this->config)) {
                $option = $this->config[$key];
            } elseif (array_key_exists("{$this->namespace}.{$key}", $this->modx->config)) {
                $option = $this->modx->getOption("{$this->namespace}.{$key}");
            }
        }
        return $option;
    }

    protected function autoload()
    {
        require_once $this->getOption('modelPath') . 'vendor/autoload.php';
    }

    public function getOptions()
    {
        $options = $this->options;
        if(!empty($this->modx->user)) {
            $options = array_merge($options, $this->modx->user->getSettings());
        }
        if(!empty($this->modx->context)){
            $options = array_merge($options, $this->modx->context->config);
        }
        return $this->parseOptions($options);
    }

    public function parseOptions(array $options): array
    {
        $parsed = [];
        $keys = array_filter($options, function($key) {
            return strpos($key, 'ps.') === 0;
        }, ARRAY_FILTER_USE_KEY);
        foreach ($keys as $key) {
            $parsed[str_replace('ps.','', $key)] = $options[$key];
        }
        return $parsed;
    }

    public function setOptions(array $options): void
    {
        foreach($options as $key => $value) {
            $this->modx->setOption($key,$value);
            if($this->modx->context) {
                $this->modx->context->config[$key] = $value;
            }
        }
    }

}
