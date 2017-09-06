<?php

namespace Meanbee\InfiniteScroll\Plugin\CatalogSearch\Controller\Result;

class IndexPlugin extends \Meanbee\InfiniteScroll\Plugin\ProductList\ActionPlugin
{
    protected $productListBlockName = "search_result_list";

    /**
     * Prevent the catalogsearch/result/index action from rendering
     * the page inside the execute() method.
     *
     * @param \Magento\CatalogSearch\Controller\Result\Index $subject
     */
    public function beforeExecute(
        \Magento\CatalogSearch\Controller\Result\Index $subject
    ) {
        $subject->getActionFlag()->set("", "no-renderLayout", true);
    }

    /**
     * Decide whether to render a full page of products or only product list data.
     *
     * @param \Magento\CatalogSearch\Controller\Result\Index $subject
     *
     * @return \Magento\Framework\Controller\ResultInterface|null
     */
    public function afterExecute(
        \Magento\CatalogSearch\Controller\Result\Index $subject
    ) {
        $subject->getActionFlag()->set("", "no-renderLayout", false);

        if ($result = $this->processActionResult(null)) {
            return $result;
        } else {
            $this->view->renderLayout();
        }
    }
}
