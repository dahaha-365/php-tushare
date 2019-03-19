<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

/**
 * Class TushareTest.
 *
 * @covers Tushare
 */
final class TushareTest extends TestCase
{
    protected $tushare = null;

    public function testCanNew(): void
    {
        $this->assertInstanceOf(Tushare::class, new Tushare(strval(getenv('TUSHARE_TOKEN'))));
    }

    public function testCanInit(): void
    {
        $this->tushare = Tushare::init(strval(getenv('TUSHARE_TOKEN')));
        $this->assertInstanceOf(Tushare::class, $this->tushare);
    }

    public function testCanGetData(): void
    {
        $tushare = new Tushare(strval(getenv('TUSHARE_TOKEN')));
        $tushare::$curlOptions = [
            CURLOPT_PROXY => null,
        ];
        $data = $tushare->exec('daily', [
            'ts_code'    => '000001.SZ',
            'start_date' => '20180301',
            'end_date'   => '20180401',
        ])->result;
        $this->assertNotEmpty($data['request_id']);
    }

    public function testCatchApiError(): void
    {
        $tushare = new Tushare(strval(getenv('TUSHARE_TOKEN')));
        $tushare::$curlOptions = [
            CURLOPT_PROXY => null,
        ];
        $tushare->exec('test_api_error');
        $this->assertNotEmpty($tushare->error);
    }

    public function testCatchCurlError(): void
    {
        $tushare = new Tushare(strval(getenv('TUSHARE_TOKEN')));
        $tushare::$curlOptions = [
            CURLOPT_PROXY => 999999999999999,
        ];
        $tushare->exec('daily', [
            'ts_code'    => '000001.SZ',
            'start_date' => '20180301',
            'end_date'   => '20180401',
        ]);
        $this->assertNotEmpty($tushare->error);
    }

    public function testCatchJsonError(): void
    {
        $tushare = new Tushare(strval(getenv('TUSHARE_TOKEN')));
        $tushare::$curlOptions = [
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
        ];
        $tushare->exec('');
        curl_setopt($tushare::$curl, CURLOPT_URL, 'https://www.baidu.com');
        $tushare->exec('');
        $this->assertNotEmpty($tushare->error);
    }
}
