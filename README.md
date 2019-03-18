# php-tushare [![Build Status](https://travis-ci.org/CantonBolo/php-tushare.svg?branch=master)](https://travis-ci.org/CantonBolo/php-tushare)

[Tushare Pro](https://tushare.pro) PHP SDK

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