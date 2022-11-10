<?php

namespace Common\Routing;

class Router
{
    private array $arguments;

    public function __construct($arguments)
    {
        if (count($arguments) !== 3) {
            return;
        }
        $this->arguments = $arguments;
    }

    public function getMask(): string
    {
        $params = $this->getParams();
        $path   = $this->arguments[0];
        foreach ($params as $param) {
            $path = preg_replace("/{[a-z]\w*}/", "(\w*)", $path);
        }
        return '~' . $path . '?$~';
    }

    public function getParams(): array
    {
        $params = [];
        preg_match_all('/{([a-z]\w*)}/', $this->arguments[0], $params);

        return $params[1];
    }
}