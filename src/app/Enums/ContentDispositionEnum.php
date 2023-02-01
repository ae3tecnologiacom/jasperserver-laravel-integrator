<?php

namespace Ae3\JasperServer\Laravel\Integrator\app\Enums;

class ContentDispositionEnum
{
    const INLINE = "inline";
    const ATTACHMENT = "attachment";

    /**
     * @return array
     */
    public static function all(): array
    {
        return [
            self::INLINE,
            self::ATTACHMENT
        ];
    }
}