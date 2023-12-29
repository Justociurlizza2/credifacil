<?php
namespace Router;

class AdminTemplate {
    public function __construct()
    {
    }
    public function render (string $route): void
    {
        echo $this->getContentRender($route);
    }
    
    public function getContentRender($route): string
    {
        if(!str_contains('.', $route)) $route = $route.'.php';
        return '<!DOCTYPE html id="page">
        <html lang="en" dir="ltr" data-bs-theme="dark" data-color-theme="Blue_Theme">'.
        $this->getStringFromPage('static/head.html').
        $this->getStringFromPage('static/dependencies.html').
        '<body>'.
            $this->getStringFromPage('static/preloader.html').
            '<div id="main-wrapper">'. 
                $this->getStringFromPage('components/aside.html').
                '<div class="page-wrapper">'.
                    $this->getStringFromPage('components/header.html').
                    $this->getStringFromPage('components/sidebarScroll.html').
                    $this->getStringFromPage('components/extras.html').
                    $this->getStringFromPage($route).
                    $this->getStringFromPage('components/afterBody.html').
                '</div>'.
            '</div>'.
            '<div class="dark-transparent sidebartoggler"></div>'.
        '</body>'.
        '</html>';
    }
    private function getStringFromPage(string $page): string
    {
        $base = $_SERVER['DOCUMENT_ROOT'].'/public/admin/';
        return file_get_contents($base. $page);
    }
}

if(isset($_POST['render'])) {
    $render = new AdminTemplate();
    echo $render->getContentRender($_POST['render']);
}