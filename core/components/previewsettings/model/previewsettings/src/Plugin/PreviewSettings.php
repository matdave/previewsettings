<?php

namespace PreviewSettings\Plugin;

class PreviewSettings extends Plugin
{
    public function run(string $event)
    {
        if (!$this->modx->user) {
            return;
        }

        $psGroups = $this->previewSettings->getOption('preview_groups');
        if(!empty($psGroups))
        {
            $psGroups = explode(',', $psGroups);
            if(!$this->modx->user->isMember($psGroups) && !$this->modx->user->sudo) {
                return;
            }
        }

        $managerOnly = (int)$this->previewSettings->getOption('manager_only', $this->scriptProperties, 1) === 1;
        if($managerOnly && !$this->modx->user->hasSessionContext('mgr'))
        {
            return;
        }

        if(!$managerOnly && empty($psGroups) && !$this->modx->user->sudo)
        {
            return;
        }

        $options = $this->previewSettings->getOptions();
        if(!empty($options)) {
            $this->previewSettings->setOptions($options);
        }
    }
}
