<?php
namespace ScholaPro\Core;

class Template
{
    private $variables = [];
    private $path = 'templates/';

    public function assign(array $variables): void
    {
        $this->variables = array_merge($this->variables, $variables);
    }

    public function render(string $template, array $vars = []): string
    {
        $this->assign($vars);
        extract($this->variables);
        
        ob_start();
        include $this->path . $template . '.php';
        return ob_get_clean();
    }

    public function display(string $template, array $vars = []): void
    {
        echo $this->render($template, $vars);
    }

    public function partial(string $template, array $vars = []): void
    {
        $this->display($template, $vars);
    }

    public function canAccess(string $feature): bool
    {
        return SubscriptionService::userCanAccess($feature);
    }
}