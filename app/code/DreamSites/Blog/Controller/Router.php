<?php
/**
 * Custom Router for Blog Single Page URLs
 * Handles URLs like /blog/{page_id}/{permalink}
 *
 * @package DreamSites_Blog
 */
namespace DreamSites\Blog\Controller;

use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\RouterInterface;
use Magento\Framework\App\ResponseInterface;

class Router implements RouterInterface
{
    /**
     * @var ActionFactory
     */
    protected $actionFactory;

    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @param ActionFactory $actionFactory
     * @param ResponseInterface $response
     */
    public function __construct(
        ActionFactory $actionFactory,
        ResponseInterface $response
    ) {
        $this->actionFactory = $actionFactory;
        $this->response = $response;
    }

    /**
     * Match blog single page URLs
     *
     * @param RequestInterface $request
     * @return \Magento\Framework\App\ActionInterface|null
     */
    public function match(RequestInterface $request)
    {
        $identifier = trim($request->getPathInfo(), '/');

        // blog/{page_id} or blog/{page_id}/{permalink}
        if (preg_match('#^blog/(\d+)(/[a-zA-Z0-9\-\_]+)?$#', $identifier, $matches)) {
            $pageId = $matches[1];

            $request->setModuleName('blog')
                ->setControllerName('view')
                ->setActionName('index')
                ->setParam('id', $pageId);

            return $this->actionFactory->create(
                \Magento\Framework\App\Action\Forward::class
            );
        }

        return null;
    }
}
