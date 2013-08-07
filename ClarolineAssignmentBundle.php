<?php

namespace Claroline\AssignmentBundle;

use Claroline\CoreBundle\Library\PluginBundle;

/**
 * Bundle class.
 */
class ClarolineAssignmentBundle extends PluginBundle
{
    public function getRoutingPrefix()
    {
        return 'assignment';
    }
}