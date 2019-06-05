<?php
namespace Idealogica\GoodView;

use Psr\Http\Message\StreamInterface;

/**
 * Class AbstractView
 * @package Idealogica\GoodView
 */
abstract class AbstractView implements ViewInterface
{
    /**
     * @var array
     */
    protected static $globalParams = [];

    /**
     * @var string
     */
    protected $templateName = '';

    /**
     * @var null|ViewFactory
     */
    protected $viewFactory;

    /**
     * @var array
     */
    protected $templateDirs = [];

    /**
     * @var array
     */
    protected $templateParams = [];

    /**
     * @var ViewInterface|null
     */
    protected $parentView;

    /**
     * @var string|null
     */
    protected $templatePath;

    /**
     * View constructor.
     *
     * @param string $templateName
     * @param ViewFactory $viewFactory
     * @param array $templateDirs
     */
    public function __construct(
        string $templateName,
        ViewFactory $viewFactory,
        array $templateDirs = ['templates']
    ) {
        $this->templateName = $templateName;
        $this->viewFactory = $viewFactory;
        $this->templateDirs = $templateDirs;
        // check for the template in different folders
        foreach ($this->templateDirs as $templateDir) {
            $templatePath = $templateDir . '/' . $this->templateName . '.phtml';
            if (file_exists($templatePath)) {
                $this->templatePath = $templatePath;
                break;
            }
        }
    }

    /**
     * @param array $templateParams
     *
     * @return $this
     */
    public function setTemplateParams(array $templateParams): ViewInterface
    {
        $this->templateParams = array_merge($this->templateParams, $templateParams);
        return $this;
    }

    /**
     * @param string $name
     * @param mixed $value
     *
     * @return $this
     */
    public function setTemplateParam(string $name, $value): ViewInterface
    {
        $this->templateParams[$name] = $value;
        return $this;
    }

    /**
     * @param array $globalParams
     *
     * @return $this
     */
    public function setGlobalParams(array $globalParams): ViewInterface
    {
        static::$globalParams = array_merge(static::$globalParams, $globalParams);
        return $this;
    }

    /**
     * @param string $name
     * @param mixed $value
     *
     * @return $this
     */
    public function setGlobalParam(string $name, $value): ViewInterface
    {
        static::$globalParams[$name] = $value;
        return $this;
    }

    /**
     * Returns a template path by its name.
     *
     * @return string|null
     */
    public function getTemplatePath(): ?string
    {
        return $this->templatePath;
    }

    /**
     * Checks if a template exists by a given template name.
     *
     * @return bool
     */
    public function templateExists(): bool
    {
        return isset($this->templatePath);
    }

    /**
     * @param $templateName
     * @param array $templateParams
     * @param array $templateDirs
     *
     * @return $this
     */
    public function setLayout(string $templateName, array $templateParams = [], array $templateDirs = []): ViewInterface
    {
        $this->parentView = $this->viewFactory->create($templateName, $templateParams, $templateDirs);
        return $this;
    }

    /**
     * @return ViewFactory
     */
    public function getViewFactory(): ViewFactory
    {
        return $this->viewFactory;
    }

    /**
     * Escapes a string.
     *
     * @param string $string
     * @param int $flags
     *
     * @return string
     */
    public function e(string $string, int $flags = ENT_COMPAT): string
    {
        return htmlspecialchars($string, $flags, 'UTF-8');
    }

    /**
     * @param array $params
     *
     * @return string|StreamInterface
     * @throws Exception\ViewException
     */
    public function __invoke(array $params = [])
    {
        return $this->render($params);
    }
}
