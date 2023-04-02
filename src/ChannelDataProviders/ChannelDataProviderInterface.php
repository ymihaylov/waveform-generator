<?php
declare(strict_types=1);

namespace App\ChannelDataProviders;

interface ChannelDataProviderInterface
{
    /**
     * @return string
     */
    public function getData(): string;
}
