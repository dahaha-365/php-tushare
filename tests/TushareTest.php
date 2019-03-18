<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

/**
 * Class TushareTest
 */
final class TushareTest extends TestCase {

	protected $tushare = null;

	public function testCanInit(): void {
		$this->tushare = Tushare::init(strval(getenv('TUSHARE_TOKEN')));
		$this->assertInstanceOf(Tushare::class, $this->tushare);
	}

	public function testCanGetData(): void {
		if ($this->tushare === null) {
			$this->testCanInit();
		}
		$data = $this->tushare->exec('test_error');
		$this->assertNotEmpty($data['request_id']);
	}

	public function testCanCatchError(): void {
		$this->testCanGetData();
		$this->assertNotEmpty($this->tushare->error);
	}
}