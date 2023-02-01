<?php

namespace Ae3\JasperServer\Laravel\Integrator\app\Services\Contracts;

use Ae3\JasperServer\Laravel\Integrator\app\Services\JasperServerRequestService;

interface JasperServerRequestServiceContract
{
    /**
     * @param string $key
     * @param $value
     * @return $this
     */
    public function addInputControl(string $key, $value): JasperServerRequestService;

    /**
     * @param int $timeout
     * @return $this
     */
    public function setRequestTimeout(int $timeout): JasperServerRequestService;

    /**
     * @param string $format
     * @return $this
     */
    public function setFormat(string $format): JasperServerRequestService;

    /**
     * @param $attachmentsPrefix
     * @return $this
     */
    public function setAttachmentsPrefix($attachmentsPrefix): JasperServerRequestService;

    /**
     * @param bool $freshData
     * @return $this
     */
    public function setFreshData(bool $freshData): JasperServerRequestService;

    /**
     * @param bool $interactive
     * @return $this
     */
    public function setInteractive(bool $interactive): JasperServerRequestService;

    /**
     * @param bool $onePagePerSheet
     * @return $this
     */
    public function setOnePagePerSheet(bool $onePagePerSheet): JasperServerRequestService;

    /**
     * @param string $pages
     * @return $this
     */
    public function setPages(string $pages): JasperServerRequestService;

    /**
     * @param bool $saveDataSnapshot
     * @return $this
     */
    public function setSaveDataSnapshot(bool $saveDataSnapshot): JasperServerRequestService;

    /**
     * @param string $transformerKey
     * @return $this
     */
    public function setTransformerKey(string $transformerKey): JasperServerRequestService;

    /**
     * @param string $contentDisposition
     * @return $this
     */
    public function setContentDisposition(string $contentDisposition): JasperServerRequestService;

    /**
     * @param string $uri
     * @param string|null $filename
     * @return string
     */
    public function call(string $uri, ?string $filename = null): string;
}
