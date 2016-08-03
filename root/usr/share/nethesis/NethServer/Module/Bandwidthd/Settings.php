<?php

namespace NethServer\Module\Bandwidthd;

/*
 * Copyright (C) 2011 Nethesis S.r.l.
 * 
 * This script is part of NethServer.
 * 
 * NethServer is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * NethServer is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with NethServer.  If not, see <http://www.gnu.org/licenses/>.
 */

use Nethgui\System\PlatformInterface as Validate;

/**
 * Change lightsquid settings
 *
 * @author Giacomo Sanchietti<giacomo.sanchietti@nethesis.it>
 */
class Settings extends \Nethgui\Controller\AbstractController
{

    private $zones = array();

    private function listZones()
    {
        if ($this->zones) {
            return $this->zones;
        }
        $invalid_roles = array('bridged', 'alias', 'slave', 'xdsl');
        $networks = $this->getPlatform()->getDatabase('networks')->getAll();
        foreach ($networks as $key => $values) {
            if(isset($values['role'])  && $values['role'] && ! preg_match("/(".implode('|',$invalid_roles).")/", $values['role'])) {
               if (isset($values['ipaddr']) && $values['ipaddr']) {
                   $this->zones[$values['role']] = '';
               }
            }
        }
        $this->zones = array_keys($this->zones);
        return $this->zones;
    }


    public function initialize()
    {
        parent::initialize();
        $v = $this->createValidator()->collectionValidator($this->createValidator()->memberOf($this->listZones()))->notEmpty();
        $this->declareParameter('Subnets', $v, array('configuration', 'bandwidthd', 'Subnets',','));
    }

    protected function onParametersSaved($changes)
    {
        $this->getPlatform()->signalEvent('nethserver-bandwidthd-save');
    }


    public function prepareView(\Nethgui\View\ViewInterface $view)
    {
        parent::prepareView($view);

        if( ! $this->getRequest()->isValidated()) {
            return;
        }

        $view['SubnetsDatasource'] = array_map(function($fmt) use ($view) {
            $label = $view->translate($fmt . '_label');
            if ($label == $fmt . '_label') {
                $label = $fmt;
            }

            return array($fmt, $label);
        }, $this->listZones());

        if ($this->getRequest()->isValidated()) {
            $view->getCommandList()->show();
        }
    }

}
