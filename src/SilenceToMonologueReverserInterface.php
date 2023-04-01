<?php

namespace App;

interface SilenceToMonologueReverserInterface
{
    public function reverseSilenceContentToMonologue(string $content): Monologue;
}