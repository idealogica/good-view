<?php
use GuzzleHttp\Psr7\Stream;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;

/**
 * Class StreamFactory
 * @package Proxy\Http
 */
class StreamFactory implements StreamFactoryInterface
{
    /**
     * @param string $content
     *
     * @return StreamInterface
     */
    public function createStream(string $content = ''): StreamInterface
    {
        $body = $this->createStreamFromFile('php://temp', 'wb+');
        $body->write($content);
        $body->rewind();
        return $body;
    }

    /**
     * @param string $filename
     * @param string $mode
     *
     * @return StreamInterface
     */
    public function createStreamFromFile(string $filename, string $mode = 'r'): StreamInterface
    {
        return $this->createStreamFromResource(fopen($filename, $mode));
    }

    /**
     * @param resource $resource
     *
     * @return StreamInterface
     */
    public function createStreamFromResource($resource): StreamInterface
    {
        return new Stream($resource);
    }
}
