<?php

namespace Meanbee\InfiniteScroll\Plugin\Catalog\Controller\Category;

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
     * For Ajax requests, only render the products block.
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
        if ($this->request->isAjax()) {
            if ($productListBlock = $page->getLayout()->getBlock("category.products.list")) {
                /** @var \Magento\Catalog\Block\Product\ListProduct $productListBlock */
                if ($json = $this->helper->getProductListJson($productListBlock)) {
                    return $this->jsonResultFactory->create()->setJsonData($json);
                }
            }
        }

        return $page;
    }
}
