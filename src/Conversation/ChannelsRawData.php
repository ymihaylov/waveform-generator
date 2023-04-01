<?php

namespace App\Conversation;

use App\ChannelDataProviders\ChannelDataProviderInterface;

class ChannelsRawData
{
    private string $userChannelRawData;
    private string $customerChannelRawData;

    /**
     * @param ChannelDataProviderInterface $userChannelProvider
     * @param ChannelDataProviderInterface $customerChannelProvider
     */
    public function __construct(ChannelDataProviderInterface $userChannelProvider, ChannelDataProviderInterface $customerChannelProvider)
    {
        $this->userChannelRawData = $userChannelProvider->getData();
        $this->customerChannelRawData = $customerChannelProvider->getData();
    }

    /**
     * @return string
     */
    public function getUserChannelRawData(): string
    {
        return $this->userChannelRawData;
    }

    /**
     * @return string
     */
    public function getCustomerChannelRawData(): string
    {
        return $this->customerChannelRawData;
    }
}