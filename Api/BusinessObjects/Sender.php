<?php
namespace BusinessObjects;
use Psr\Http\Message\ResponseInterface;

class Sender
{
    protected $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function send(): void // era void
    {
        $this->sendHeaders();
        $this->sendContent();
        $this->clearBuffers();
    }

    protected function sendHeaders(): void
    {
        $response = $this->response;
        $headers  = $response->getHeaders();
        $version  = $response->getProtocolVersion();
        $status   = $response->getStatusCode();
        $reason   = $response->getReasonPhrase();

        $httpString = sprintf('HTTP/%s %s %s', $version, $status, $reason);

        // custom headers
        foreach ($headers as $key => $values) {
            foreach ($values as $value) {
                header($key.': '.$value, false);
            }
        }

        // status
        header($httpString, true, $status);
        echo json_encode($this->response);
    }

    protected function sendContent()
    {
        echo (string) $this->response->getBody();
    }

    protected function clearBuffers()
    {
        if (function_exists('fastcgi_finish_request')) {
            fastcgi_finish_request();
        } elseif (PHP_SAPI !== 'cli') {
            $this->closeOutputBuffers();
        }
    }

    private function closeOutputBuffers()
    {
        if (ob_get_level()) {
            ob_end_flush();
        }
    }
}