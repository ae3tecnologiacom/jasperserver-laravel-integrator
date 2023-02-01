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

    /**
     * @return string[]
     */
    public static function downloadable(): array
    {
        return [
            self::PDF,
            self::XML,
            self::CSV,
            self::DOCX,
            self::ODT,
            self::ODS,
            self::XLSX,
        ];
    }

    /**
     * @param string $format
     * @return string
     */
    public static function getMimeType(string $format): string
    {
        switch ($format) {
            case self::PDF:
                return 'application/pdf';
            case self::XML:
                return 'application/xml';
            case self::CSV:
                return 'text/csv';
            case self::DOCX:
                return 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
            case self::ODT:
                return 'application/vnd.oasis.opendocument.text';
            case self::XLSX:
            case self::ODS:
                return 'application/vnd.oasis.opendocument.spreadsheet';
            default:
                return 'text/html';
        }
    }
}