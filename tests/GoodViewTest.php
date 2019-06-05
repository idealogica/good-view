<?php
use Idealogica\GoodView\StreamView;
use Idealogica\GoodView\StringView;
use Idealogica\GoodView\ViewFactory;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;

/**
 * Class GoodViewTest
 */
class GoodViewTest extends TestCase
{
    /**
     *
     */
    public function testViewFactory()
    {
        $viewFactory = ViewFactory::createStringViewFactory();
        self::assertTrue($viewFactory instanceof ViewFactory);
        self::assertTrue($viewFactory->create('test') instanceof StringView);
        /**
         * @var StreamFactoryInterface $streamFactory
         */
        $viewFactory = ViewFactory::createStreamViewFactory(new StreamFactory());
        self::assertTrue($viewFactory instanceof ViewFactory);
        self::assertTrue($viewFactory->create('test') instanceof StreamView);
    }

    /**
     * @throws \Idealogica\GoodView\Exception\ViewException
     */
    public function testStringView()
    {
        $viewFactory = ViewFactory::createStringViewFactory(
            ['content' => '<div>'],
            [__DIR__ . '/templates']
        );
        $view = $viewFactory->create('test');
        self::assertEquals('!&lt;div&gt;!', trim($view->render()));
    }

    /**
     * @throws \Idealogica\GoodView\Exception\ViewException
     */
    public function testStreamView()
    {
        $viewFactory = ViewFactory::createStreamViewFactory(
            new StreamFactory(),
            ['content' => '<div>'],
            [__DIR__ . '/templates']
        );
        $view = $viewFactory->create('test');
        self::assertTrue($view->render() instanceof StreamInterface);
        self::assertEquals('!&lt;div&gt;!', trim($view->render()->getContents()));
    }
}
