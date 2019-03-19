<?php

/**
 * Class Tushare.
 */
class Tushare
{
    public static $token = '';

    public static $instance = null;

    public static $curl = null;

    public static $curlOptions = [];

    public $error = [];

    public $rawResult = '';

    public $result = [];

    /**
     * Tushare constructor.
     *
     * @param string $token
     *
     * @return Tushare
     */
    public function __construct(string $token)
    {
        $this->setToken($token);

        return $this;
    }

    public function __destruct()
    {
        if (self::$curl !== null) {
            curl_close(self::$curl);
            self::$curl = null;
        }
    }

    /**
     * @param string $token
     *
     * @return Tushare
     */
    public static function init(string $token)
    {
        $_instance = new self($token);
        self::$instance = $_instance;

        return $_instance;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token)
    {
        self::$token = $token;
    }

    /**
     * @param array $options
     */
    protected function initCurl(array $options = [])
    {
        if (self::$curl === null) {
            self::$curl = curl_init();
            curl_setopt_array(self::$curl, self::$curlOptions + $options);
            curl_setopt(self::$curl, CURLOPT_POST, true);
            curl_setopt(self::$curl, CURLOPT_URL, 'http://api.tushare.pro/');
            curl_setopt(self::$curl, CURLOPT_RETURNTRANSFER, true);
        }
    }

    /**
     * @param string $api_name
     * @param array  $params
     * @param string $fields
     *
     * @return bool|mixed|string
     */
    public function exec(string $api_name, array $params = [], string $fields = '')
    {
        $this->initCurl();
        $body = [];
        $body['api_name'] = $api_name;
        $body['token'] = self::$token;
        $body['params'] = $params;
        $body['fields'] = $fields;
        $payload = json_encode($body, JSON_UNESCAPED_UNICODE);
        curl_setopt(self::$curl, CURLOPT_POSTFIELDS, $payload);
        curl_setopt(self::$curl, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Content-Length: '.strlen($payload), ]
        );
        $result = curl_exec(self::$curl);
        if (curl_errno(self::$curl)) {
            $this->error = [
                'code' => curl_errno(self::$curl),
                'msg'  => curl_error(self::$curl),
            ];

            return false;
        }
        $this->rawResult = $result;
        $result = json_decode($result, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->error = [
                'code' => json_last_error(),
                'msg'  => json_last_error_msg(),
            ];

            return false;
        }
        if ($result['code'] != 0) {
            $this->error = [
                'code'       => $result['code'],
                'msg'        => $result['msg'],
                'request_id' => $result['request_id'],
            ];
        }
        $this->result = $result;

        return $this;
    }
}
