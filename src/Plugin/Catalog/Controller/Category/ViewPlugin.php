<?php

namespace Meanbee\InfiniteScroll\Plugin\Catalog\Controller\Category;

use Magento\Catalog\Model\Product\ProductList\Toolbar;

class ViewPlugin
{
    /** @var \Magento\Framework\App\Request\Http $request */
    protected $request;

    /** @var \Magento\Framework\Controller\Result\JsonFactory $jsonResultFactory */
    protected $jsonResultFactory;

    /** @var \Meanbee\InfiniteScroll\Helper\Data $helper */
    protected $helper;

    public function __construct(
        \Magento\Framework\View\Element\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $jsonResultFactory,
        \Meanbee\InfiniteScroll\Helper\Data $helper
    ) {
        $this->request = $context->getRequest();

        $this->jsonResultFactory = $jsonResultFactory;
        $this->helper = $helper;
    }

    /**
     * Decide whether to render a full page of products or only product list data.
     *
     * @param \Magento\Catalog\Controller\Category\View $subject
     * @param \Magento\Framework\View\Result\Page       $page
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function afterExecute(
        \Magento\Catalog\Controller\Category\View $subject,
        \Magento\Framework\View\Result\Page $page
    ) {
        if ($productListBlock = $page->getLayout()->getBlock("category.products.list")) {
            /** @var \Magento\Catalog\Block\Product\ListProduct $productListBlock */
            if ($this->request->isAjax()) {
                // For Ajax requests, render a JSON result of product list data
                if ($json = $this->helper->getProductListJson($productListBlock)) {
                    return $this->jsonResultFactory->create()->setJsonData($json);
                }
            } else {
                // For non-Ajax requests, if a page other than the first is requested,
                // show all products up to and including the page
                if ($toolbarBlock = $productListBlock->getToolbarBlock()) {
                    $currentPage = $toolbarBlock->getCurrentPage();
                    $currentLimit = $toolbarBlock->getLimit();
                    $newLimit = $currentPage * $currentLimit;

                    if ($currentPage > 1) {
                        $this->request->setParam(Toolbar::LIMIT_PARAM_NAME, $newLimit);
                        $this->request->setParam(Toolbar::PAGE_PARM_NAME, 1);
                        // Set a pre-computed limit on the toolbar to avoid it discarding the limit
                        // set on the request because it doesn't match any of the available limits
                        $toolbarBlock->setData("_current_limit", $newLimit);
                    }
                }
            }
        }

        return $page;
    }
}
