<?php
namespace Idealogica\GoodView;

use Idealogica\GoodView\Exception\ViewException;
use Psr\Http\Message\StreamInterface;

/**
 * Interface ViewInterface
 * @package Idealogica\GoodView
 */
interface ViewInterface
{
    /**
     * @param array $templateParams
     *
     * @return $this
     */
    public function setTemplateParams(array $templateParams): self;

    /**
     * @param string $name
     * @param mixed $value
     *
     * @return $this
     */
    public function setTemplateParam(string $name, $value): self;

    /**
     * @param array $globalParams
     *
     * @return $this
     */
    public function setGlobalParams(array $globalParams): self;

    /**
     * @param string $name
     * @param mixed $value
     *
     * @return $this
     */
    public function setGlobalParam(string $name, $value): self;

    /**
     * Returns a template path.
     *
     * @return string|null
     */
    public function getTemplatePath(): ?string;

    /**
     * Checks if a template exists.
     *
     * @return bool
     */
    public function templateExists(): bool;

    /**
     * @param array $params
     *
     * @return string|StreamInterface
     * @throws ViewException
     */
    public function render(array $params = []);

    /**
     * @param string $templateName
     * @param array $templateParams
     *
     * @return $this
     */
    public function setLayout(string $templateName, array $templateParams = []): self;

    /**
     * @return ViewFactory
     */
    public function getViewFactory(): ViewFactory;

    /**
     * Escapes a string.
     *
     * @param string $string
     * @param int $flags
     *
     * @return string
     */
    public function e(string $string, int $flags = ENT_COMPAT): string;

    /**
     * @param array $params
     *
     * @return string|StreamInterface
     */
    public function __invoke(array $params = []);
}
