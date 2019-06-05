# GoodView - Extremely simple and standard compliant view implementation of MVC pattern

## 1. What is GoodView?

By default GoodView uses PHP as template engine but it can be adapted to use any. It supports PSR-7 stream rendering 
so it can be easily used in HTTP middleware. GoodView supports nested view and layout views. Short example:

## 2. Installation

```
composer require idealogica/good-view:~1.0.0
```

## 3. Basic example

```
$viewFactory = ViewFactory::createStreamViewFactory(
    new StreamFactory(),
    ['content' => '<div>'],
    [__DIR__ . '/templates']
);
$view = $viewFactory->create('test');
$stream = $view->render(); // StreamInterface instance
$contents = $stream->getContents(); // rendered string
```
