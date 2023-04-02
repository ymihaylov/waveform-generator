<?php

declare(strict_types=1);

namespace App\Exceptions\SilenceReverserErrors;

class UnknownLineException extends \Exception
{
    /**
     * @param string $line
     */
    public function __construct(string $line)
    {
        parent::__construct("Unknown line while parsing silence content: {$line}");
    }
}
