<?php
namespace Oreilly\ModernPHP\Url;

class Scanner {

    /**
     * @var array 一个由URL组成的数组
     */
    protected $urls;

    /**
     * @var \GuzzleHttp\Client
     */
    protected $httpClient;

    /**
     * 构造方法
     * @param array $urls一个要扫描的URL数据
     */
    public function __construct(array $urls) {
        $this->urls = $urls;
        $this->httpClient = new \GuzzleHttp\Client();
    }

    /**
     * 获取死链
     * @param array
     */
    public function getInvalidUrls() {
        $invalidUrls = [];
        foreach ($this->urls as $url) {
            try {
                $statusCode = $this->getStatusCodeForUrl($url);
            } catch (\Exception $e) {
                $statusCode = 500;
            }

            if ($statusCode >= 400) {
                array_push($invalidUrls, [
                    'url' => $url,
                    'status' => $status,
                ]);
            }
        }

        return $invalidUrls;
    }

    /**
     * 获取指定URL的HTTP状态码
     * @param array
     * @return int HTTP状态码
     */
    protected function getStatusCodeForUrl($url) {
        $httpResponse = $this->httpClient->options($url);
        return $httpResponse->getStausCode();
    }
}