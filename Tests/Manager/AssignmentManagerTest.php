<?php

namespace Claroline\AssignmentBundle\Manager;

use \Mockery as m;
use Claroline\CoreBundle\Library\Testing\MockeryTestCase;

class AssignementManagerTest
{
    public function setUp()
    {
        parent::setUp();
    }

    private function getManager(array $mockedMethods = array())
    {
        if (count($mockedMethods) === 0) {
            return new AssignmentManager(

            );
        }

        $stringMocked = '[';
        $stringMocked .= array_pop($mockedMethods);

        foreach ($mockedMethods as $mockedMethod) {
            $stringMocked .= ",{$mockedMethod}";
        }

        $stringMocked .= ']';

        return $this->mock(
            'Claroline\AssignmentBundle\Manager\AssignmentManager' . $stringMocked,
            array(
            )
        );
    }
}