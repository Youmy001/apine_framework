<?php
/**
 * Parameter
 *
 * @license MIT
 * @copyright 2018 Tommy Teasdale
 */
declare(strict_types=1);

namespace Apine\Core\Routing;


class Parameter
{
    private $type;
    
    private $name;
    
    private $default;
    
    public function __construct(
        string $type,
        string $name,
        $default = null
    ) {
        $this->type = $type;
        $this->name = $name;
        $this->default = $default;
    }
    
    public function isBuiltIn() : bool
    {
        switch (strtolower($this->type)) {
            case 'string':
            case 'int':
            case 'float':
            case 'array':
            case 'bool':
            case 'null':
            case 'resource':
            case '':
                return true;
            default:
                return false;
        }
    }
    
    public function getType() : string
    {
        return $this->type;
    }
    
    public function getName() : string
    {
        return $this->name;
    }
    
    public function getDefaultValue()
    {
        return $this->default;
    }
}