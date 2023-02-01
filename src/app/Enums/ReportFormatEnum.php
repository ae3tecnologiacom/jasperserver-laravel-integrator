<?php

namespace Ae3\JasperServer\Laravel\Integrator\app\Enums;

class ReportFormatEnum
{
    const PDF = "pdf";
    const HTML = "html";
    const XML = "xml";
    const CSV = "csv";
    const DOCX = "docx";
    const ODT = "odt";
    const ODS = "ods";
    const XLSX = "xlsx";

    /**
     * @return array
     */
    public static function all(): array
    {
        return [
            self::PDF,
            self::HTML,
            self::XML,
            self::CSV,
            self::DOCX,
            self::ODT,
            self::ODS,
            self::XLSX,
        ];
    }
}