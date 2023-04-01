<?php

namespace App\SilenceReversers;

use App\Conversation\Monologue;

interface SilenceToMonologueReverserInterface
{
    public function reverseSilenceContentToMonologue(string $content): Monologue;
}