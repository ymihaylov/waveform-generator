<?php

namespace App\ChannelDataProviders;

interface ChannelDataProviderInterface
{
    /**
     * @return string
     */
    public function getData(): string;
}