<?php
/**
 * Created by PhpStorm.
 * User: Barbazul
 * Date: 4/12/2017
 * Time: 6:41 PM
 */

namespace SemExpert\StoreInfoBlocks\Block;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\DataObject;
use Magento\Framework\EntityManager\EventManager;
use Magento\Framework\Escaper;
use Magento\Framework\Filter\FilterManager;
use Magento\Framework\View\Element\Context;
use Magento\Store\Model\Information;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class ValueTest
 * @package SemExpert\StoreInfoBlocks\Block
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class ValueTest extends TestCase
{
    /**
     * @var Context|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $contextMock;

    /**
     * @var Value
     */
    protected $block;

    /**
     * @var EventManager|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $eventManagerMock;

    /**
     * @var ScopeConfigInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $scopeConfigMock;

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

    /**
     * @var FilterManager|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $filterManagerMock;

    public function setUp()
    {
        parent::setUp();
        $this->contextMock = $this->createMock(Context::class);
        $this->eventManagerMock = $this->createMock(EventManager::class);
        $this->scopeConfigMock = $this->createMock(ScopeConfigInterface::class);
        $this->contextMock->method('getEventManager')->willReturn($this->eventManagerMock);
        $this->contextMock->method('getScopeConfig')->willReturn($this->scopeConfigMock);
        $this->contextMock->method('getEscaper')->willReturn(new Escaper());
        $this->filterManagerMock = $this->createMock(FilterManager::class);
        $this->filterManagerMock->method('__call')
            ->with('stripTags', $this->anything())
            ->willReturnCallback(
                function ($methodName, $args) {
                    if ($methodName == 'stripTags') {
                        return strip_tags($args[0]);
                    }

                    return $args[0];
                }
            );
        $this->contextMock->method('getFilterManager')->willReturn($this->filterManagerMock);
        $this->storeInfoMock = $this->createMock(Information::class);
        $this->storeManagerMock = $this->createMock(StoreManagerInterface::class);
        $this->storeMock = $this->createMock(Store::class);
        $this->storeManagerMock->method('getStore')->willReturn($this->storeMock);
        $this->block = new Value($this->contextMock, $this->storeManagerMock, $this->storeInfoMock);
    }

    public function testEmptyKeyGeneratesNoOutput()
    {
        $data = $this->dataProvider();
        $this->setStoreData($data);
        $this->assertEquals('', $this->block->toHtml());
    }

    public function testGetOutputWithCorrectKey()
    {
        $data = $this->dataProvider();
        $this->setStoreData($data);
        $this->block->setData('key', 'city');
        $this->assertEquals('TEST-CITY', $this->block->toHtml());
    }

    public function testOutputIsHtmlEscaped()
    {
        $data = $this->dataProvider();
        $data['city'] = '<!-- HTML COMMENT --><a href="http://unsafedomain.com">TEST-CITY</a>';
        $this->setStoreData($data);
        $this->block->setData('key', 'city');
        $escapedString = 'TEST-CITY';
        $this->assertEquals($escapedString, $this->block->toHtml());
    }

    public function testOutputIsEmptyOnWrongKey()
    {
        $data = $this->dataProvider();
        $this->setStoreData($data);
        $this->block->setData('key', 'invalid');
        $this->assertEquals('', $this->block->toHtml());
    }

    /**
     * @return array
     */
    public function dataProvider()
    {
        return [
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
    }

    /**
     * @param $data
     */
    private function setStoreData($data): void
    {
        $this->storeInfoMock->method('getStoreInformationObject')->willReturn(new DataObject($data));
    }
}
