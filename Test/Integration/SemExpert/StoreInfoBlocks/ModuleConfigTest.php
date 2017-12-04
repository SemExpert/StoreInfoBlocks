<?php
/**
 * Created by PhpStorm.
 * User: Barbazul
 * Date: 29/11/2017
 * Time: 7:51 PM
 */

namespace SemExpert\StoreInfoBlocks;

use PHPUnit\Framework\TestCase;
use Magento\Framework\Component\ComponentRegistrar;

class ModuleConfigTest extends TestCase
{
    protected $moduleName = 'SemExpert_StoreInfoBlocks';

    public function testModuleIsRegistered()
    {
        $registrar = new ComponentRegistrar();
        $this->assertArrayHasKey($this->moduleName, $registrar->getPaths(ComponentRegistrar::MODULE));
    }
}
