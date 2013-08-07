<?php

namespace Claroline\AssignmentBundle\Controller;

use \Mockery as m;
use Claroline\CoreBundle\Library\Testing\MockeryTestCase;

class AssignementManagerTest
{
    public function setUp()
    {
        parent::setUp();
    }

    private function getController(array $mockedMethods = array())
    {
        if (count($mockedMethods) === 0) {
            return new AssignmentController(

            );
        }

        $stringMocked = '[';
        $stringMocked .= array_pop($mockedMethods);

        foreach ($mockedMethods as $mockedMethod) {
            $stringMocked .= ",{$mockedMethod}";
        }

        $stringMocked .= ']';

        return $this->mock(
            'Claroline\AssignmentBundle\Controller\AssignmentController' . $stringMocked,
            array(
            )
        );
    }
}