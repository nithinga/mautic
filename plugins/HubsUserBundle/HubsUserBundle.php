<?php
/**
 * @package     diginlab
 * @copyright   2016 Digital Innaovation Lab. All rights reserved.
 * @author      Christian Wittwer
 * @link        http://diginlab.com
 */

namespace MauticPlugin\HubsUserBundle;

use Mautic\PluginBundle\Bundle\PluginBundleBase;

class HubsUserBundle extends PluginBundleBase
{
   public function getParent()
    {
        return 'MauticUserBundle';
    }
}
