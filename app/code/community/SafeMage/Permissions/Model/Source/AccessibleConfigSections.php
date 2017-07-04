<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Model_Source_AccessibleConfigSections
{
    const CACHE_KEY = 'SAFEMAGE_PERMISSIONS_CONFIG_SECTIONS';

    public function getAll()
    {
        if ($s = Mage::app()->getCache()->load(self::CACHE_KEY)) {
            $items = unserialize($s);
            return $items;
        }

        $sections = Mage::getSingleton('adminhtml/config')->getSections();
        $items = array();
        foreach((array)$sections as $secId => $section) {
            $items[$secId]= array(
                'label' => (string)$section->label,
                'groups' => array(),
            );
            $refSection = &$items[$secId];
            foreach((array)$section->groups as $gId => $data) {
                $refSection['groups'][$gId]= (string)$data->label;
            }
        }

        Mage::app()->getCache()->save(serialize($items), self::CACHE_KEY);
        return $items;
    }

    public function getGridArray()
    {
        $items = array();
        $i = 0;
        foreach($this->getAll() as $secId => $section) {
            foreach($section['groups'] as $gId => $label) {
                $configId = $secId . '_' . $gId;

                if (in_array($configId, array('ambase_conflicts'))) {
                    continue;
                }

                if ($section['label'] && $label) {
                    $items[] = array(
                        'attribute_id' => $i,          // configId encoded!
                        'section_id' => $secId,
                        'cgroup' => $section['label'],
                        'cfield' => $label,
                        'config_id' => $configId,
                    );
                }
                $i++;
            }
        }

        return $items;
    }

    public function getGridArrayFiltered()
    {
        $items = array();
        foreach($this->getGridArray() as $item) {
            if ($this->_getConfigHelper()->isSystemConfigSectionAllowed($item['section_id'])) {
                $items[]= $item;
            }
        }

        return $items;
    }

    public function getSectionIdByLabel($sectionLabel)
    {
        $items = $this->getAll();
        foreach($items as $secId => $section) {
            if ($section['label'] == $sectionLabel) {
                return $secId;
            }
        }

        return null;
    }

    public function getGroupIdByLabel($groupLabel, $sectionId)
    {
        $items = $this->getAll();
        foreach($items as $secId => $section) {
            if ($secId == $sectionId) {
                foreach($section['groups'] as $gId => $gLabel) {
                    if ($gLabel == $groupLabel) {
                        return $gId;
                    }
                }
            }
        }

        return null;
    }

    public function getConfigId($sectionLabel, $groupLabel)
    {
        $secId = $this->getSectionIdByLabel($sectionLabel);
        $gId = $this->getGroupIdByLabel($groupLabel, $secId);
        if ($secId && $gId) {
            $configId = $secId . '_' . $gId;
            return $configId;
        }
        return null;
    }

    public function encodeConfigId($configId)
    {
        $items = $this->getGridArray();
        foreach($items as $i => $item) {
            if ($item['config_id'] == $configId) {
                return $item['attribute_id'];
            }
        }

        return false;
    }

    public function decodeConfigId($configIdEncoded)
    {
        $items = $this->getGridArray();
        foreach($items as $i => $item) {
            if ($item['attribute_id'] == $configIdEncoded) {
                return $item['config_id'];
            }
        }
        return false;
    }

    public function getSectionIdByConfigId($configId)
    {
        $items = $this->getGridArray();
        foreach($items as $i => $item) {
            if ($item['config_id'] == $configId) {
                return $item['section_id'];
            }
        }

        return false;
    }

    public function getSectionIdByConfigIdEncoded($configIdEncoded)
    {
        if ($configId = $this->decodeConfigId($configIdEncoded)) {
            $secId = $this->getSectionIdByConfigId($configId);
            return $secId;
        }

        return false;
    }

    protected function _getConfigHelper()
    {
        return Mage::helper('safemage_permissions/config');
    }
}
