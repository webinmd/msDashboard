<?php

class msDashboardItemCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'msDashboardItem';
    public $classKey = 'msDashboardItem';
    public $languageTopics = ['msdashboard'];
    //public $permission = 'create';


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $name = trim($this->getProperty('name'));
        if (empty($name)) {
            $this->modx->error->addField('name', $this->modx->lexicon('msdashboard_item_err_name'));
        } elseif ($this->modx->getCount($this->classKey, ['name' => $name])) {
            $this->modx->error->addField('name', $this->modx->lexicon('msdashboard_item_err_ae'));
        }

        return parent::beforeSet();
    }

}

return 'msDashboardItemCreateProcessor';