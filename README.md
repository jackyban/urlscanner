# Urlscanner
从传入包含url的数组进行扫描并报告不可访问的URL
> * 支持传入url数组返回有效链接
> * 支持传入单条url验证有效性 
> * 也可以支持从CSV文件扫描URL，但须加载额外的插件 `league/csv`，已经包含在`composer.json`里。
非必须加载，但是要自己解析成数组再传入进行验证。


# 安装说明
推荐使用`composer`安装，使用`composer`能更好的控制版本
> `composer require jackyban/urlsanner dev-master`

也可以使用git方式
> `git clone https://github.com/jackyban/urlscanner.git`

# 使用说明
首先需要引入`composer`自动加载类，如果使用git或其它方式，可能需要手动添加`autoload.php`或者自己写自动加载。
大部分框架都支持自动加载，这里推荐使用`lavaral`;
```php
  require "vendor/autoload.php";
  // 传入的url数组
  $urls = [
      "http://darlingsky.cn",
      "http://laravel-academy.org",
      "https://packagist.org"
  ];
  // 实例化scanner对象
  $scanner =  new \JackyBan\UrlScanner\Url\Scanner($urls);
```
返回所有不可访问的链接：
```php
  $arr = $scanner->getInvalidUrls();
  print_r($arr);  
  
  //输出：
  array (
    0 =>
    array (
      'url' => 'http://darlingsky.cn',
      'status' => 500,
    ),
    1 =>
    array (
      'url' => 'http://packagist.org',
      'status' => 500,
    ),
  )
  // 这里只是示例，以实际返回结果为准。返回结果为二维数组，每个子数组包含`url`和`status`两个参数。没有则返回空数组。
```
返回所有可访问的链接：
```php
  $arr = $scanner->getValidUrls();
  print_r($arr);  
  
  //输出：
  array (
    'url' => 'http://darlingsky.cn',
    'url' => 'http://packagist.org',
  )
  // 这里只是示例，以实际返回结果为准。返回一维数组，所有可访问的链接。没有则返回空数组。
```
验证单条链接有效性：
```php
  $bool = $scanner->verifyUrl();
  var_dump($bool);  
  
  //输出：
  true or false
  // 返回结果为`Boolean`类型。
```
从url数组里取出一条可访问的链接：
```php
  $url = $scanner->getOneValidUrls();
  print_r($url);  
  
  //输出：
  'http://darlingsky.cn' or false
  // 返回一条可访问的链接，如果都不能访问则返回false。
```
