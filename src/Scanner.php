<?php
namespace JackyBan\UrlScanner\Url;

use GuzzleHttp\Client;

/**
 * 检测链接有效性
 * @author jakcy
 * @since  2019-04-13
 */
class Scanner
{
    protected $urls;

    protected $httpClient;

    /**
     * @param  array      $urls 需要检测链接数组
     */
    public function __construct(array $urls)
    {
        $this->urls       = $urls;
        $this->httpClient = new Client();
    }

    /**
     * 获取访问指定URL的HTTP状态码
     *
     * @param $url
     * @return int
     */
    public function getStatusCodeForUrl($url)
    {
        $httpResponse = $this->httpClient->get($url);
        return $httpResponse->getStatusCode();
    }

    /**
     * 获取死链
     *
     * @return array
     */
    public function getInvalidUrls()
    {
        $invalidUrls = [];
        foreach ($this->urls as $url) {
            try {
                $statusCode = $this->getStatusCodeForUrl($url);
            } catch (\Exception $e) {
                $statusCode = 500;
            }

            if ($statusCode >= 400) {
                array_push($invalidUrls, ['url' => $url, 'status' => $statusCode]);
            }
        }
        return $invalidUrls;
    }

    /**
     * 获取有效链接
     *
     * @return array
     */
    public function getValidUrls()
    {
        $validUrls = [];
        foreach ($this->urls as $url) {
            try {
                $statusCode = $this->getStatusCodeForUrl($url);
                if ($statusCode >= 400) {
                    throw new Exception("Error Processing Request", 1);
                }
                array_push($validUrls, $url);
            } catch (\Exception $e) {
                // do nothings
            }
        }
        return $validUrls;
    }

    /**
     * 获取一条有效链接
     *
     * @return array
     */
    public function getOneValidUrls()
    {
        foreach ($this->urls as $url) {
            try {
                $statusCode = $this->getStatusCodeForUrl($url);
                if ($statusCode >= 400) {
                    throw new Exception("Error Processing Request", 1);
                }
                return $url;
            } catch (\Exception $e) {
                // do nothings
            }
        }
        return false;
    }

    /**
     * 验证链接有效性
     *
     * @return Boolean
     */
    public function verifyUrl()
    {
        $ret = false;
        foreach ($this->urls as $url) {
            try {
                $statusCode = $this->getStatusCodeForUrl($url);
                if ($statusCode >= 400) {
                    throw new Exception("Error Processing Request", 1);
                }
                return true;
            } catch (\Exception $e) {
                return false;
            }
        }
    }
}
