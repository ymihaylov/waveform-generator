<?php

declare(strict_types=1);

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
