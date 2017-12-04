<?php
/**
 * Created by PhpStorm.
 * User: Barbazul
 * Date: 4/12/2017
 * Time: 3:57 PM
 */

namespace SemExpert\StoreInfoBlocks\Block;

use Magento\Framework\DataObject;
use Magento\Framework\View\Element\Template as MagentoTemplate;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\Information;

class Template extends MagentoTemplate
{
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var Information
     */
    private $storeInformation;

    protected $_template = 'storeinfo.phtml';

    public function __construct(Context $context, Information $storeInformation, array $data = [])
    {
        MagentoTemplate::__construct($context, $data);
        $this->storeInformation = $storeInformation;
        $this->storeManager = $context->getStoreManager();
    }

    /**
     * @return DataObject
     */
    public function getStoreInformation()
    {
        return $this->storeInformation->getStoreInformationObject($this->storeManager->getStore());
    }
}
