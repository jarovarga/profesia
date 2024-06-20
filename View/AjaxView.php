<?php

declare(strict_types=1);

namespace App\View;

class AjaxView extends AppView
{
    /**
     * @var string LAYOUT_TYPE - The constant representing the layout type 'ajax'
     */
    public const LAYOUT_TYPE = 'ajax';

    /**
     * Assigns the value of the constant LAYOUT_TYPE to the variable $layout.
     *
     * @param string $layout The layout type to assign.
     */
    public string $layout = self::LAYOUT_TYPE;

    /**
     * Initializes the response by setting the type to the specified layout type.
     *
     * @return void
     */
    public function initialize(): void
    {
        $this->response = $this->response->withType(self::LAYOUT_TYPE);
    }
}
