<?php

namespace Ae3\JasperServer\Laravel\Integrator\app\Services;

use Ae3\JasperServer\Laravel\Integrator\app\Enums\ContentDispositionEnum;
use Ae3\JasperServer\Laravel\Integrator\app\Enums\ReportFormatEnum;
use Ae3\JasperServer\Laravel\Integrator\app\Services\Contracts\JasperServerRequestServiceContract;
use Jaspersoft\Client\Client;

class JasperServerRequestService implements JasperServerRequestServiceContract
{
    /**
     * @var Client|null
     */
    protected $client = null;

    /**
     * @var string
     */
    protected $format = null;

    /**
     * @var null
     */
    protected $pages = null;

    /**
     * @var null
     */
    protected $attachmentsPrefix = null;

    /**
     * @var null
     */
    protected $inputControls = null;

    /**
     * @var bool
     */
    protected $interactive = true;

    /**
     * @var bool
     */
    protected $onePagePerSheet = false;

    /**
     * @var bool
     */
    protected $freshData = true;

    /**
     * @var bool
     */
    protected $saveDataSnapshot = false;

    /**
     * @var null
     */
    protected $transformerKey = null;

    /**
     * @var int
     */
    protected $requestTimeout = 60;

    /**
     * @var string
     */
    protected $contentDisposition;

    /**
     * @var string
     */
    protected $report;

    /**
     * @param Client $client
     */
    public function __construct(
        Client $client
    ) {
        $this->client = $client;
        $this->setFormat(ReportFormatEnum::HTML);
        $this->setContentDisposition(ContentDispositionEnum::INLINE);
    }

    /**
     * @param string $key
     * @param $value
     * @return $this
     */
    public function addInputControl(string $key, $value): self
    {
        if (!$this->inputControls) {
            $this->inputControls = [];
        }
        $this->inputControls[$key] = $value;
        return $this;
    }

    /**
     * @param int $timeout
     * @return $this
     */
    public function setRequestTimeout(int $timeout): self
    {
        $this->requestTimeout = $timeout;
        return $this;
    }

    /**
     * @param string $format
     * @return $this
     */
    public function setFormat(string $format): self
    {
        $this->format = $format;
        return $this;
    }

    /**
     * @param $attachmentsPrefix
     * @return $this
     */
    public function setAttachmentsPrefix($attachmentsPrefix): self
    {
        $this->attachmentsPrefix = $attachmentsPrefix;
        return $this;
    }

    /**
     * @param bool $freshData
     * @return $this
     */
    public function setFreshData(bool $freshData): self
    {
        $this->freshData = $freshData;
        return $this;
    }

    /**
     * @param bool $interactive
     * @return $this
     */
    public function setInteractive(bool $interactive): self
    {
        $this->interactive = $interactive;
        return $this;
    }

    /**
     * @param bool $onePagePerSheet
     * @return $this
     */
    public function setOnePagePerSheet(bool $onePagePerSheet): self
    {
        $this->onePagePerSheet = $onePagePerSheet;
        return $this;
    }

    /**
     * @param string $pages
     * @return $this
     */
    public function setPages(string $pages): self
    {
        $this->pages = $pages;
        return $this;
    }

    /**
     * @param bool $saveDataSnapshot
     * @return $this
     */
    public function setSaveDataSnapshot(bool $saveDataSnapshot): self
    {
        $this->saveDataSnapshot = $saveDataSnapshot;
        return $this;
    }

    /**
     * @param string $transformerKey
     * @return $this
     */
    public function setTransformerKey(string $transformerKey): self
    {
        $this->transformerKey = $transformerKey;
        return $this;
    }

    /**
     * @param string $contentDisposition
     * @return $this
     */
    public function setContentDisposition(string $contentDisposition): self
    {
        $this->contentDisposition = $contentDisposition;
        return $this;
    }

    /**
     * @return string Binary data of report
     */
    public function getReport(): string
    {
        return $this->report;
    }

    /**
     * @param string $uri
     * @return $this
     */
    public function call(string $uri): self
    {
        $this->report = $this->client->reportService()->runReport(
            $uri,
            $this->format,
            $this->pages,
            $this->attachmentsPrefix,
            $this->inputControls,
            $this->interactive,
            $this->onePagePerSheet,
            $this->freshData,
            $this->saveDataSnapshot,
            $this->transformerKey
        );

        return $this;
    }

    /**
     * @return void
     */
    public function inline(): void
    {
        $this->setContentDisposition(ContentDispositionEnum::INLINE);
        $this->setHeader($this->report);
        echo $this->getReport();
    }

    /**
     * @param string|null $filename
     * @return void
     */
    public function download(?string $filename = null): void
    {
        if (in_array($this->format, ReportFormatEnum::downloadable())) {
            $this->setContentDisposition(ContentDispositionEnum::ATTACHMENT);
            $this->setHeader($this->report, $filename);
        }

        echo $this->getReport();
    }

    /**
     * @param string $report
     * @param string|null $filename
     * @return void
     */
    private function setHeader(string $report, ?string $filename = null)
    {
        if (!$filename) {
            $filename = uniqid();
        }

        $filename = $this->appendFormatExtension($filename);

        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Description: File Transfer');
        header("Content-Disposition: $this->contentDisposition;filename=$filename");
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . strlen($report));
        header('Content-Type: ' . ReportFormatEnum::getMimeType($this->format));
    }

    /**
     * @param string $filename
     * @return string
     */
        private function appendFormatExtension(string $filename): string
    {
        return $filename . '.' . $this->format;
    }
}
