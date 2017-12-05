<?php
/**
 * Created by PhpStorm.
 * User: Barbazul
 * Date: 4/12/2017
 * Time: 6:40 PM
 */

namespace SemExpert\StoreInfoBlocks\Block;

use Magento\Framework\View\Element\AbstractBlock;
use Magento\Framework\View\Element\Context;
use Magento\Store\Model\Information;
use Magento\Store\Model\StoreManagerInterface;

class Value extends AbstractBlock
{
    /**
     * @var Information
     */
    private $storeInformation;
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        Information $storeInformation,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->storeInformation = $storeInformation;
        $this->storeManager = $storeManager;
    }

    protected function _toHtml()
    {
        $storeInformation = $this->storeInformation->getStoreInformationObject($this->storeManager->getStore());

        return $this->escapeHtml($this->stripTags($storeInformation->getData($this->getData('key'))));
    }
}
