<?php

namespace Meanbee\InfiniteScroll\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * Get the product list data as a JSON string.
     *
     * @param \Magento\Catalog\Block\Product\ListProduct $productListBlock
     *
     * @return string
     */
    public function getProductListJson(\Magento\Catalog\Block\Product\ListProduct $productListBlock)
    {
        $originalTemplate = $productListBlock->getTemplate();

        $json = $productListBlock
            ->setTemplate("Meanbee_InfiniteScroll::product/list_json.phtml")
            ->toHtml();

        $productListBlock->setTemplate($originalTemplate);

        return $json;
    }
}
