# php-tushare

[![Build Status](https://travis-ci.org/CantonBolo/php-tushare.svg?branch=master)](https://travis-ci.org/CantonBolo/php-tushare)
[![codecov](https://codecov.io/gh/CantonBolo/php-tushare/branch/master/graph/badge.svg)](https://codecov.io/gh/CantonBolo/php-tushare)
[![StyleCI](https://github.styleci.io/repos/176181004/shield?branch=master)](https://github.styleci.io/repos/176181004)

[Tushare Pro](https://tushare.pro/register?reg=245045) 金融大数据平台 PHP SDK

# 安装

```bash
composer require cantonbolo/php-tushare
```

# 使用

```php
// 请求接口
$tushare = Tushare::init($token);
$tushare->exec(string $api_name[, array $params = [], string $fields = '']);
// 捕获错误
if ($tushare->error) {
 ...
}
// 处理结果
$result = $tushare->result;
...
```
