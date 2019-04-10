<?php

namespace App\Services;

use Core\Request;

class FlashService {
    private $flash;
    private $next = [];

    public function retrieveLastFlash(Request $request) {
        $this->flash = $request->getFromSession('flash');
        $request->clearFromSession('flash');
    }

    public function saveFlash(Request $request) {
        $request->addToSession('flash', $this->next);
    }

    public function add($key, $message) {
        $this->next[$key][] = $message;
    }

    public function get($key) {
        if (isset($this->flash[$key]))
            return $this->flash[$key];
        else
            return [];
    }

    public function getExports() {
        return ['flash' => $this];
    }
}