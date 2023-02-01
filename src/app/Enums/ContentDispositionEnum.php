<?php

namespace Ae3\JasperServer\Laravel\Integrator\app\Enums;

class ContentDispositionEnum
{
    public const INLINE = "inline";
    public const ATTACHMENT = "attachment";

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
