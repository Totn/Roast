
## About Roast

 一个关于城市咖啡店的小应用

## Instatll

```
git clone ssh://git@119.29.2.174:10022/RushDuck/Roast.git
```
clone代码之后， 复制.env.emaple为 .env文件，编辑.env文件配置数据库信息。

``` composer install ``` 初始化时，可能遇到遇到速度慢的问题。可以配置laravel的composer镜像
```
$ composer config -g repo.packagist composer https://packagist.laravel-china.org
```
安装过程结束时可能会遇到报错如下：
```

  [Symfony\Component\Process\Exception\RuntimeException]                                   
  The Process class relies on proc_open, which is not available on your PHP installation.

```
解决方式为编辑``` php.ini ```文件，找到disable_funcions一行，将其中的``` proc_open, proc_get_status, symlink ```删除后保存，然后重启php-fpm

再执行一次``` composer update ``` 确保初始化成功


## Setting
#### 配置程序
若初始化过程没有自动生成密钥，则需要手动生成，执行
```
php artisan key:generate
```
为程序创建数据库
```
php artisan migrate
```
程序使用了passport扩展，需要安装令牌
```
php artisan passport:insall
```
设置storage的软链
```
php artisan storage:link
```
#### 配置github登陆
打开[GITHUB](https://github.com/settings/developers)，注册并配置一个Oauth App，然后编辑.env文件
```
GIT_CLIENT_ID=github应用的Client ID
GIT_CLIENT_SECRET=github应用的密钥Client Secret
GIT_REDIRECT=github应用的授权回调URL
```

#### 配置高德地图应用
向高德地图[申请KEY](https://lbs.amap.com/api/webservice/guide/create-project/get-key)，配置到.env文件中
```
GAODE_MAPS_WS_API_KEY={YOUR_API_KEY}
```
申请JS API Key， 配置到``` resources/assets/js/config.js ```
```
/**
 * Defines the API route we are using.
 */
var api_url = '';
var gaode_maps_js_api_key = '{YOUR API KEY HERE}';

switch( process.env.NODE_ENV ){
    case 'development':
        api_url = 'http://{your.testdomain}/api/v1';
        break;
    case 'production':
        api_url = 'http://{you.productiondomain}/api/v1';
        break;
}
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
