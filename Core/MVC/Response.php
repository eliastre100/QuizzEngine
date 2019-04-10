<?php

namespace Core\MVC;

class Response {
    private $status;
    private $body;
    private $headers = [];

    public function __construct($status = 204, $body = '')
    {
        $this->setStatus($status);
        $this->setBody($body);
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function getBoody() {
        return $this->body;
    }

    public function setBody($body) {
        $this->body = $body;
    }

    public function addHeader($name, $value) {
        $this->headers[] = [
            'name' => $name,
            'value' => $value
        ];
    }

    public function getHeaders() {
        return $this->headers;
    }
}