<?php

namespace App\SilenceReversers;

use App\Conversation\Monologue;

interface SilenceToMonologueReverserInterface
{
    /**
     * @param string $content
     * @return Monologue
     */
    public function reverseSilenceContentToMonologue(string $content): Monologue;
}