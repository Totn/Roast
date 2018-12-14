<style lang="scss">
    div#cafe-map {
        width: 100%;
        height: 400px;
    }
</style>

<template>
    <div id="cafe-map"></div>
</template>

<script>
export default {
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
            markers: []
        };
    },
    mounted() {
        this.map = new AMap.Map('cafe-map', {
            center: [this.latitude, this.longitude],
            zoom: this.zoom
        });
        this.clearMarkers();
        this.buildMarkers();
    },
    computed: {
        cafes() {
            return this.$store.getters.getCafes;
        }
    },
    methods: {
        // 为所有咖啡店创建点标记
        buildMarkers() {
            // 清空点标记数组
            this.markers = [];

            // 遍历所有咖啡店并为每个咖啡店创建标记
            for (var i = 0; i < this.cafes.length; i++) {
                
                // 通过高德地图API为每个咖啡店创建点标记并设置经纬度
                if (!this.cafes[i].latitude || !this.cafes[i].longitude) {
                    continue;
                }
                var marker = new AMap.Marker({
                    position: AMap.LngLat(parseFloat(this.cafes[i].latitude), parseFloat(this.cafes[i].longitude)),
                    title: this.cafes[i].name
                });

                // 将每个点标记放到标记数组中
                this.markers.push(marker);
            }
            // console.log({cafes: this.cafes, markers: this.markers});
            // 将所有点标记显示到地图上
            this.map.add(this.markers);
        },
        // 从地图上清理点标记
        clearMarkers() {
            for (var index = 0; index < this.markers.length; index++) {
                this.markers[index].setMap(null);
                
            }
        }
    },
    watch: {
        // 一旦cafes有更新立即重构地图点标记
        cafes() {
            this.clearMarkers();
            this.buildMarkers();
        }
    }
}
</script>
