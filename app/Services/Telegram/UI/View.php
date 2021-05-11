<?php


namespace App\Services\Telegram\UI;


class View
{
    public $menu;
    public function __construct($array)
    {

    }

    /**
     * @return mixed
     */
    public function getMenu()
    {
        return $this->menu;
    }

    /**
     * @param mixed $menu
     */
    public function setMenu($menu): void
    {
        $this->menu = $menu;
    }
}
