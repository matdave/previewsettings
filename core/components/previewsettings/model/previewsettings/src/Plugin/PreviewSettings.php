<?php

namespace PreviewSettings\Plugin;

class PreviewSettings extends Plugin
{
    public function run()
    {
        if(!$this->canRun()) return;
        if($this->modx->context && $this->modx->context->key === 'mgr') {
            $contexts = $this->modx->getCollection('modContext', ['key:!=' => 'mgr']);
            foreach($contexts as $context) {
                $this->modx->switchContext($context->key);
                $this->setSettings();
            }
            $this->modx->switchContext('mgr');
        }
        $this->setSettings();
    }

    private function setSettings(): void
    {
        $options = $this->previewSettings->getOptions();
        if(!empty($options)) {
            $this->previewSettings->setOptions($options);
        }
    }

    public function canRun(): bool
    {
        if (!$this->modx->user) {
            return false;
        }

        $psGroups = $this->previewSettings->getOption('preview_groups');
        if(!empty($psGroups))
        {
            $psGroups = explode(',', $psGroups);
            if(!$this->modx->user->isMember($psGroups) && !$this->modx->user->sudo) {
                return false;
            }
        }

        $managerOnly = (int)$this->previewSettings->getOption('manager_only', $this->scriptProperties, 1) === 1;
        if($managerOnly && !$this->modx->user->hasSessionContext('mgr'))
        {
            return false;
        }

        if(!$managerOnly && empty($psGroups) && !$this->modx->user->sudo)
        {
            return false;
        }
        return true;
    }
}
