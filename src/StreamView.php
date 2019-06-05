<?php
namespace Idealogica\GoodView;

use Idealogica\GoodView\Exception\ViewException;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;

/**
 * Class StreamView
 * @package Idealogica\GoodView
 */
class StreamView extends StringView
{
    /**
     * @var null|StreamFactoryInterface
     */
    protected $streamFactory;

    /**
     * StreamView constructor.
     *
     * @param StreamFactoryInterface $streamFactory
     * @param ViewFactory $templateName
     * @param ViewFactory $viewFactory
     * @param array $templatesDirs
     */
    public function __construct(
        $templateName,
        ViewFactory $viewFactory,
        StreamFactoryInterface $streamFactory,
        array $templatesDirs = ['templates']
    ) {
        parent::__construct($templateName, $viewFactory, $templatesDirs);
        $this->streamFactory = $streamFactory;
    }

    /**
     * @param array $params
     *
     * @return StreamInterface
     * @throws ViewException
     */
    public function render(array $params = [])
    {
        return $this->streamFactory->createStream(parent::render($params));
    }
}
