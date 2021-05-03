<?php


namespace App\Services\Telegram\Core;


class Update
{
    private $chatID;
    private $data;

    /**
     * @param String $data
     */
    public function setData(String $data): void
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param String $chatID
     */
    public function setChatID(String $chatID): void
    {
        $this->chatID = $chatID;
    }

    /**
     * @return mixed
     */
    public function getChatID()
    {
        return $this->chatID;
    }

}
