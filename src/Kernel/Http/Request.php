<?php


namespace App\Kernel\Http;


class Request
{
    /**
     * @var array
     */
    private $query;
    /**
     * @var array
     */
    private $request;
    /**
     * @var array
     */
    private $server;
    /**
     * @var string
     */
    private $content;
    /**
     * @var string
     */
    private $method;

    public function __construct($query = [], $request = [], $server = [])
    {
        $this->query = $query;
        $this->request = $request;
        $this->server = $server;
        $this->headers = $this->initHeaders();
    }

    /**
     * @return static
     */
    public static function fromGlobals(): Request
    {
        return new static($_GET, $_POST, $_SERVER);
    }

    /**
     * Returns the request body content.
     * @return string
     */
    public function getContent(): string
    {
        if (null === $this->content) {
            $this->content = file_get_contents('php://input');
        }

        return $this->content;
    }

    /**
     * Returns request method
     * @return string
     */
    public function getMethod(): string
    {
        if (null === $this->method) {
            $this->method = strtoupper($this->server['REQUEST_METHOD']) ?: 'GET';
        }

        return $this->method;
    }

    /**
     * Returns a header value by name.
     *
     * @param string  $key     The header name
     * @param mixed $default The default value
     *
     * @return string|null
     */
    public function getHeader($key): ?string
    {
        $key = strtr(strtolower($key), '_', '-');

        if (!array_key_exists($key, $this->headers)) {
            return null;
        }

        return $this->headers[$key];
    }

    /**
     * Returns the requested URI (path and query string).
     * @return string
     */
    public function getRequestUri(): string
    {
        return $this->server['REQUEST_URI'];
    }

    /**
     * Returns the requested URI (path without query string).
     * @return string
     */
    public function getPathInfo(): string
    {
        if ('/' === ($requestUri = $this->getRequestUri())) {
            return $requestUri;
        }

        // Remove the query string from REQUEST_URI
        if ($pos = strpos($requestUri, '?')) {
            return substr($requestUri, 0, $pos);
        }

        return $requestUri;
    }

    /**
     * Checks request content type that is json
     * @return bool
     */
    public function isJson(): bool
    {
        return false !== strpos($this->getHeader('Accept'), 'application/json');
    }

    /**
     * Find and save http header
     *
     * @return array
     */
    private function initHeaders(): array
    {
        $headers = [];
        $contentHeaders = ['CONTENT_LENGTH' => true, 'CONTENT_MD5' => true, 'CONTENT_TYPE' => true];

        foreach ($this->server as $key => $value) {
            if (0 === strpos($key, 'HTTP_')) {
                $headers[strtr(strtolower(substr($key, 5)), '_', '-')] = $value;
            }

            elseif (isset($contentHeaders[$key])) {
                $headers[strtr(strtolower($key), '_', '-')] = $value;
            }
        }

        return $headers;
    }
}