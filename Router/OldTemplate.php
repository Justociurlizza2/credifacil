<?php
namespace Router;

class AdminTemplate {
    public function __construct()
    {

    }
    public function render (string $route): void
    {
        echo '<!DOCTYPE html id="page">
        <html lang="en" dir="ltr" data-bs-theme="dark" data-color-theme="Blue_Theme">';
        require_once $_SERVER['DOCUMENT_ROOT'].'/public/admin/static/head.html';
        // require_once $_SERVER['DOCUMENT_ROOT'].'/public/admin/static/head.html');
        echo '<body>';
            require_once $_SERVER['DOCUMENT_ROOT'].'/public/admin/static/preloader.html';
            echo '<div id="main-wrapper">'; 
                require_once $_SERVER['DOCUMENT_ROOT'].'/public/admin/components/aside.html';
                echo '<div class="page-wrapper">';
                    require_once $_SERVER['DOCUMENT_ROOT'].'/public/admin/components/header.html';
                    require_once $_SERVER['DOCUMENT_ROOT'].'/public/admin/components/sidebarScroll.html';
                    require_once $_SERVER['DOCUMENT_ROOT'].'/public/admin/'.$route.'.php';
                    require_once $_SERVER['DOCUMENT_ROOT'].'/public/admin/components/afterBody.html';
                echo '</div>';
                require_once $_SERVER['DOCUMENT_ROOT'].'/public/admin/components/extras.html';
            echo '</div>';
            echo '<div class="dark-transparent sidebartoggler"></div>';
            require_once $_SERVER['DOCUMENT_ROOT'].'/public/admin/static/dependencies.html';
        echo '</body>';
        echo '</html>';
    }
    public function getContentRender($route): string
    {
        // return $this->getStringFromPage('static/head1.html');
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
                    $this->getStringFromPage($route.'.php').
                    $this->getStringFromPage('components/afterBody.html').
                '</div>'.
                $this->getStringFromPage('components/extras.html').
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