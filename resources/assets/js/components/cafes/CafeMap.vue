<style lang="scss">
    @import '~@/abstracts/_variables.scss';
    div#cafe-map-container {
        position: absolute;
        top: 50px;
        left: 0px;
        right: 0px;
        bottom: 50px;

        div#cafe-map {
            position: absolute;
            top: 0px;
            left: 0px;
            right: 0px;
            bottom: 0px;
        }

        div.cafe-info-window {
            div.cafe-name {
                display: block;
                text-align: center;
                color: $dark-color;
                font-family: 'Josefin Sans', sans-serif;
            }
            div.cafe-address {
                display: block;
                text-align: center;
                margin-top: 5px;
                color: $grey;
                font-family: 'Lato', sans-serif;
                span.street {
                    font-size: 14px;
                    display: block;
                }
                span.city {
                    font-size: 12px;
                }
                span.state {
                    font-size: 12px;
                }
                span.zip {
                    font-size: 12px;
                    display: block;
                }
                a {
                    color: $secondary-color;
                    font-weight: bold;
                }
            }
        }
    }
</style>

<template>
    <div id="cafe-map-container">
        <div id="cafe-map">

        </div>
        <cafe-map-filter></cafe-map-filter>
    </div>
</template>

<script>
import { ROAST_CONFIG } from '../../config.js';
import CafeMapFilter from './CafeMapFilter.vue';
import { EventBus } from "../../event-bus.js";
import { CafeIsRoasterFilter } from "../../mixins/filters/CafeIsRoasterFilter.js";
import { CafeBrewMethodsFilter } from "../../mixins/filters/CafeBrewMethodsFilter.js";
import { CafeTextFilter } from "../../mixins/filters/CafeTextFilter.js";

export default {
    components: {
        CafeMapFilter
    },
    props: {
        // 经度
        'latitude': {
            type: Number,
            default: function () {
                return 120.21;
            }
        },
        // 纬度
        'longitude': {
            type: Number,
            default: function () {
                return 30.29;
            }
        },
        // 缩放级别
        'zoom': {
            type: Number,
            default: function () {
                return 4;
            }
        }
    },
    data() {
        return {
            markers: [],
            infoWindows: []
        };
    },
    mounted() {
        this.map = new AMap.Map('cafe-map', {
            center: [this.latitude, this.longitude],
            zoom: this.zoom
        });
        this.clearMarkers();
        this.buildMarkers();
        // 监听总线fiters-updated 事件过滤点标记
        EventBus.$on('filters-updated', function (filters) {
            this.processFilters(filters);
        }.bind(this));

    },
    computed: {
        cafes() {
            return this.$store.getters.getCafes;
        }
    },
    methods: {
        // 为所有咖啡店创建点标记
        buildMarkers() {
            // 初始化点标记数组
            this.markers = [];

            // 自定义点标记图标
            var image = ROAST_CONFIG.APP_URL + '/storage/img/coffee-marker.png';
            var icon = new AMap.Icon({
                image: image,
                // 设置图标尺寸
                imageSize: new AMap.Size(19, 33)
            });

            // 遍历所有咖啡店并为每个咖啡店创建标记
            var infoWindow = new AMap.InfoWindow();
            for (var i = 0; i < this.cafes.length; i++) {
                
                // 通过高德地图API为每个咖啡店创建点标记并设置经纬度
                if (!this.cafes[i].latitude || !this.cafes[i].longitude) {
                    continue;
                }
                var marker = new AMap.Marker({
                    position: new AMap.LngLat(parseFloat(this.cafes[i].latitude), parseFloat(this.cafes[i].longitude)),
                    title: this.cafes[i].location_name,
                    icon: icon,
                    map: this.map,
                    extData: {
                        'cafe': this.cafes[i]
                    }
                });
                // 自定义窗体信息
                var contentString = '<div class="cafe-info-window">' + 
                        '<div class="cafe-name">' + this.cafes[i].name + this.cafes[i].location_name + '</div>' +
                        '<div class="cafe-address">' + 
                            '<span class="street">' + this.cafes[i].address + '</span>' +
                            '<span class="city">' + this.cafes[i].city + '</span>' +
                            '<span class="state">' + this.cafes[i].state + '</span>' +
                            '<span class="zip">' + this.cafes[i].zip + '</span>' +
                            '<a href="/#/cafes/' + this.cafes[i].id + '">Visit</a>' + 
                        '</div>' +
                    '</div>';
                marker.content = contentString;
                // 为每个咖啡店创建信息窗体
                // var infoWindow = new AMap.InfoWindow({
                //     content: this.cafes[i].name
                // });
                // this.infoWindows.push(infoWindow);

                // 绑定点击事件到点标记对象，点击打开上面创建的信息窗体
                marker.on('click', mpClick);
                // 将每个点标记放到标记数组中
                this.markers.push(marker);
            }

            function mpClick(mapEvent) {
                infoWindow.setContent(mapEvent.target.content);
                infoWindow.open(this.getMap(), this.getPosition());
            }

            // 将所有点标记显示到地图上
            this.map.add(this.markers);
        },
        // 从地图上清理点标记
        clearMarkers() {
            for (var index = 0; index < this.markers.length; index++) {
                this.markers[index].setMap(null);
                
            }
        },
        // 处理条件过滤
        processFilters(filters) {
            for (let index = 0; index < this.markers.length; index++) {
                // 初始条件
                if (filters.text === ''
                    && filters.roaster === false
                    && filters.brew_methods.length === 0) {
                    // 设置地图
                    this.markers[index].setMap(this.map);
                } else {
                    var textPassed = false;
                    var brewMethodsPassed = false;
                    var roasterPassed = false;
                    var _cafe = this.markers[index].getExtData().cafe;

                    // 烘焙师过滤
                    if (filters.roaster && this.processCafeIsRoasterFilter(_cafe)) {
                        roasterPassed = true;
                    } else if (!filters.roaster) {
                        roasterPassed = true;
                    }

                    // 文本过滤
                    if (filters.text !== '' && this.processCafeTextFilter(_cafe, filters.text)) {
                        textPassed = true;
                    } else if (filters.text === '') {
                        textPassed = true;
                    }

                    // 冲泡方法过滤
                    if (filters.brew_methods.length > 0 && this.processCafeBrewMethodsFilter(_cafe, filters.brew_methods)) {
                        brewMethodsPassed = true;
                    } else if (filters.brew_methods.length === 0) {
                        brewMethodsPassed = true;
                    }

                    // 由判断结果决定该咖啡店是否显示
                    if (roasterPassed && brewMethodsPassed && textPassed) {
                        this.markers[index].setMap(this.map);
                    } else {
                        this.markers[index].setMap(null);
                    }
                }
                
            }
        }
    },
    watch: {
        // 一旦cafes有更新立即重构地图点标记
        cafes() {
            this.clearMarkers();
            this.buildMarkers();
        }
    },
    mixins: [
        CafeIsRoasterFilter,
        CafeBrewMethodsFilter,
        CafeTextFilter
    ]
}
</script>
