<?php

namespace Meanbee\InfiniteScroll\Plugin\Catalog\Controller\Category;

class ViewPlugin extends \Meanbee\InfiniteScroll\Plugin\ProductList\ActionPlugin
{
    protected $productListBlockName = "category.products.list";

    /**
     * Decide whether to render a full page of products or only product list data.
     *
     * @param \Magento\Catalog\Controller\Category\View     $subject
     * @param \Magento\Framework\Controller\ResultInterface $result
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function afterExecute(
        \Magento\Catalog\Controller\Category\View $subject,
        \Magento\Framework\Controller\ResultInterface $result
    ) {
        return $this->processActionResult($result);
    }
}
