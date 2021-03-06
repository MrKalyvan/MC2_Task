<?php

namespace Owner\TestModul\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;

/**
 * Class Cars
 * @package Owner\TestModul\Controller\Index
 */
class Cars extends Action{

    /**
     * @var PageFactory
     */
    private $resultPageFactory;


    /**
     * Cars constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(Context $context, PageFactory $resultPageFactory)
    {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * @return ResponseInterface|ResultInterface|Page
     */
    public function execute(){
        $page = $this->resultPageFactory->create();
        return $page;
    }
}
