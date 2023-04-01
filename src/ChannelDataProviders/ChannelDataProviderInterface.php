<?php

namespace App\ChannelDataProviders;

interface ChannelDataProviderInterface
{
    public function getData(): string;
}