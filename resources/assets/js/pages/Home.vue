<style lang="">
    
</style>

<template>
    <div id="home">
        <span v-show="cafesLoadStatus == 1">加载中...</span>
        <span v-show="cafesLoadStatus == 2">数据加载成功！</span>
        <span v-show="cafesLoadStatus == 3">数据加载失败！</span>

        <ul v-show="cafesLoadStatus">
            <li v-for="cafe in cafes" :key="cafe.id">{{ cafe.name }}</li>
        </ul>
    </div>
</template>

<script>

    export default {

        /**
         * 定义组件的计算属性
         */
        computed: {
            // 获取cafes加载状态
            cafesLoadStatus () {
                return this.$store.getters.getCafesLoadStatus;
            },
            // 获取cafes
            cafes () {
                return this.$store.getters.getCafes;
            }
        }
    }
</script>