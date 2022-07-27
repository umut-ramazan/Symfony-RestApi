<?php

namespace App\Message;

class MailNotification
{
    private string $from;
    private string $description;

    public function __construct(string $description,string $from)
    {
        $this->description=$description;
        $this->from=$from;
    }

    public  function  getDescription(): string
    {
        return $this->description;
    }

    public function  getFrom(): string
    {
        return $this->from;
    }
}