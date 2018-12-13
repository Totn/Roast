<?php
namespace App\Utilities;

use GuzzleHttp\Client;


class GaodeMaps
{
    /**
     * 通过真实地址获取对应的经纬度
     *
     * @param string $address 详细地址
     * @param string $city    城市
     * @param string $state   省份
     * @return mixed
     */
    public static function geocodeAddress($address, $city, $state)
    {
        // 省、市、区、详细地址
        $address = urlencode($state . $city. $address);
        // web服务API Key
        $api_key = config('services.gaode.ws_api_key');
        // 构建地理编码API请求URL，默认返回JSON格式响应
        $url = 'https://restapi.amap.com/v3/geocode/geo?address=' . $address . '&key=' . $api_key;

        // 创建Guzzle HTTP客户端发起请求
        $client = new Client();

        // 发送请求并获取响应数据
        $geocodeResponse = $client->get($url)->getBody();
        $geocodeData = json_decode($geocodeResponse);

        // 初始化地址编码位置
        $coordinates['lat'] = null;
        $coordinates['lng'] = null;

        // 如果响应数据不为空则解析出经纬度
        if (!empty($geocodeData)
            && $geocodeData->status // 0: 失败， 1： 成功
            && isset($geocodeData->geocodes)
            && isset($geocodeData->geocodes[0])) {
            list($lat, $lng) = explode(',', $geocodeData->geocodes[0]->location);
            $coordinates['lat'] = $lat;
            $coordinates['lng'] = $lng;
        }

        return $coordinates;
    }
}
