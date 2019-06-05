<?php
namespace Idealogica\GoodView;

use Psr\Http\Message\StreamFactoryInterface;

/**
 * Class ViewFactory
 * @package Idealogica\GoodView
 */
class ViewFactory
{
    /**
     * @var null|callable
     */
    protected $viewResolver = null;

    /**
     * @var string
     */
    protected $templateDirs = '';

    /**
     * @var array
     */
    protected $defaultParams = [];

    /**
     * @param array $defaultParams
     * @param array $templateDirs
     *
     * @return static
     */
    public static function createStringViewFactory(
        array $defaultParams = [],
        array $templateDirs = ['templates']
    ): self {
        return new static(
            function ($templateName, ViewFactory $viewFactory, $templatesDir) {
                return new StringView($templateName, $viewFactory, $templatesDir);
            },
            $defaultParams,
            $templateDirs
        );
    }

    /**
     * @param StreamFactoryInterface $streamFactory
     * @param array $defaultParams
     * @param $templateDirs
     *
     * @return static
     */
    public static function createStreamViewFactory(
        StreamFactoryInterface $streamFactory,
        array $defaultParams = [],
        array $templateDirs = ['templates']
    ): self {
        return new static(
            function ($templateName, ViewFactory $viewFactory, $templatesDir) use ($streamFactory) {
                return new StreamView($templateName, $viewFactory, $streamFactory, $templatesDir);
            },
            $defaultParams,
            $templateDirs
        );
    }

    /**
     * ViewFactory constructor.
     *
     * @param callable|null $viewResolver
     * @param array $templateDirs
     * @param array $defaultParams
     */
    public function __construct(
        callable $viewResolver,
        array $defaultParams = [],
        array $templateDirs = ['templates']
    ) {
        $this->viewResolver = $viewResolver;
        $this->defaultParams = $defaultParams;
        foreach ($templateDirs as &$templateDir) {
            $templateDir = rtrim($templateDir, DIRECTORY_SEPARATOR);
        }
        $this->templateDirs = $templateDirs;
    }

    /**
     * Creates a view form a template and its arguments.
     *
     * @param string $templateName
     * @param array $templateParams
     * @param array $templateDirs
     *
     * @return ViewInterface
     */
    public function create(string $templateName, array $templateParams = [], array $templateDirs = []): ViewInterface
    {
        $viewResolver = $this->viewResolver;
        /**
         * @var ViewInterface $view
         */
        return $viewResolver($templateName, $this, $templateDirs ?: $this->templateDirs)
            ->setTemplateParams(
                array_merge($this->defaultParams, $templateParams)
            );
    }

    /**
     * @param array $defaultParams
     *
     * @return $this
     */
    public function setDefaultParams(array $defaultParams): self
    {
        $this->defaultParams = $defaultParams;
        return $this;
    }

    /**
     * @param string $name
     * @param mixed $value
     *
     * @return ViewFactory
     */
    public function addDefaultParam(string $name, $value): self
    {
        $this->defaultParams[$name] = $value;
        return $this;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function removeDefaultParam(string $name): self
    {
        unset($this->defaultParams[$name]);
        return $this;
    }
}
