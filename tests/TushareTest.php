<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

/**
 * Class TushareTest
 * @covers Tushare
 */
final class TushareTest extends TestCase {

	protected $tushare = null;

	public function testCanNew(): void {
		$this->assertInstanceOf(Tushare::class, new Tushare(strval(getenv('TUSHARE_TOKEN'))));
	}

	public function testCanInit(): void {
		$this->tushare = Tushare::init(strval(getenv('TUSHARE_TOKEN')));
		$this->assertInstanceOf(Tushare::class, $this->tushare);
	}

	public function testCanGetData(): void {
		if ($this->tushare === null) {
			$this->testCanInit();
		}
		$data = $this->tushare->exec('daily', [
			'ts_code' => '000001.SZ',
			'start_date' => '20180301',
			'end_date' => '20180401',
		]);
		$this->assertNotEmpty($data['request_id']);
	}

	public function testCatchApiError(): void {
		if ($this->tushare === null) {
			$this->testCanInit();
		}
		$this->tushare->exec('test_api_error');
		$this->assertNotEmpty($this->tushare->error);
	}

	public function testCatchCurlError(): void {
		if ($this->tushare === null) {
			$this->testCanInit();
		}
		$this->tushare->exec('test_api_error');
		$this->assertNotEmpty($this->tushare->error);
	}
}