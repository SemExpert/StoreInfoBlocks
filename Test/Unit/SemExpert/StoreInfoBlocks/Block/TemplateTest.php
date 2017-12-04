<?php
/**
 * Created by PhpStorm.
 * User: Barbazul
 * Date: 29/11/2017
 * Time: 7:51 PM
 */

namespace SemExpert\StoreInfoBlocks\Block;

use Magento\Framework\DataObject;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\Information;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;
use PHPUnit\Framework\TestCase;

class TemplateTest extends TestCase
{
    /**
     * @var Context
     */
    protected $contextMock;

    /**
     * @var Template
     */
    protected $template;

    /**
     * @var Information|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $storeInfoMock;

    /**
     * @var StoreManagerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $storeManagerMock;

    /**
     * @var Store|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $storeMock;

    public function setUp()
    {
        parent::setUp();
        $this->contextMock = $this->createMock(Context::class);
        $this->storeManagerMock = $this->createMock(StoreManagerInterface::class);
        $this->contextMock->method('getStoreManager')->willReturn($this->storeManagerMock);
        $this->storeMock = $this->createMock(Store::class);
        $this->storeManagerMock->method('getStore')->willReturn($this->storeMock);
        $this->storeInfoMock = $this->createMock(Information::class);
        $this->template = new Template($this->contextMock, $this->storeInfoMock);
    }

    public function testGetStoreInformation()
    {
        $data = [
           'name' => 'TEST-NAME',
           'phone' => '123456789',
           'hours' => 'TEST-HOURS',
           'street_line1' => 'TEST-STREET1',
           'street_line2' => 'TEST-STREET2',
           'city' => 'TEST-CITY',
           'postcode' => '1234567890',
           'region_id' => '1234567890',
           'region' => 'TEST-REGION',
           'country_id' => '1234567890',
           'country' => 'TEST-COUNTRY',
           'vat_number' => '1234567890',
        ];

        $this->storeInfoMock->method('getStoreInformationObject')->willReturn(new DataObject($data));

        $info = $this->template->getStoreInformation();

        $this->assertEquals($data, $info->getData());
    }
}
