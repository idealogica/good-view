<?php
namespace Idealogica\GoodView;

use Idealogica\GoodView\Exception\ViewException;

/**
 * Class StringView
 * @package Idealogica\GoodView
 */
class StringView extends AbstractView
{
    /**
     * @param array $params
     *
     * @return string
     * @throws ViewException
     */
    public function render(array $params = [])
    {
        if(!$this->templateExists()) {
            throw new ViewException('View "' . $this->templateName . '" is not found"');
        }
        $__params = array_merge(
            self::$globalParams,
            $this->templateParams,
            $params
        );
        $__templatePath = $this->getTemplatePath();
        $renderer = function () use ($__templatePath, $__params) {
            unset($__params['__templatePath']);
            extract($__params);
            unset($__params);
            ob_start();
            require($__templatePath);
            return ob_get_clean();
        };
        $content = $renderer();
        if ($this->parentView instanceof ViewInterface) {
            $content = $this->parentView->render(['content' => $content]);
        }
        return $content;
    }
}
