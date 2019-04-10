<?php

namespace Core\MVC;

use Core\Kernel;

class View extends Response {

    public function __construct()
    {
        $this->setStatus(200);
    }

    public function render($template, $params) {
        $params = array_merge(['params' => [], 'status' => 200, 'template' => 'default.php', 'HTMLHeaders' => []], $params);
        $params['template'] = __DIR__.DR.'..'.DR.'..'.DR.'App'.DR.'Views'.DR.'Templates'.DR.$params['template'];
        try {
            if (isset($params['status']))
                $this->setStatus($params['status']);
            $viewContent = $this->renderView($template, $params);
            $templateContent = $this->renderTemplate($params['template'], $params, $viewContent);
            $this->setBody($templateContent);
        } catch (\Exception $e) {
            $this->setStatus(500);
            $this->setBody($e->getMessage());
        }
    }

    private function renderView($template, $params) {
        if (!file_exists($template))
            throw new \Exception("View file $template doesn't exist.");
        extract(Kernel::getServicesExports());
        extract($params['params']);
        ob_start();
        require($template);
        return ob_get_clean();
    }

    private function renderTemplate($template, $params, $viewContent) {
        if (!file_exists($template))
            throw new \Exception("Template file $template doesn't exist.");
        extract(Kernel::getServicesExports());
        extract($params['params']);
        extract($params['HTMLHeaders']);
        ob_start();
        require($template);
        return ob_get_clean();
    }
}