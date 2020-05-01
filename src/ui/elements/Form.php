<?php
class Form
{
    private $instance;

    private $action;
    private $method;
    private $inputs;
    private $buttons;

    public function __construct(string $action, string $method, array $inputs, Button $button)
    {
        $this->instance = MagicUI::getInstance();
        $this->action = $action;
        $this->method = $method;
        $this->inputs = $inputs;
        $this->button = $button;
    }

    public function getHtml(): string
    {
        $form = "<form action='".$this->action."' method='".$this->method."'>";
        foreach ($this->inputs as $input) {
            $form .= $input->getHtml()."<br />\n";
        }
        $form .= $this->button->getHtml()."<br />\n";
        $form .= "</form>";

        return $form;
    }
}