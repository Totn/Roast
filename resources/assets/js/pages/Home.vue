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
    // 首页路由中加载所有咖啡店的数据
    export default {
        // 在组件创建之后绑定的声明周期钩子created()被会调用，
        // 我们将在这个钩子函数中分配起加载咖啡店的动作
        created () {
            // 分发加载咖啡店的动作
            this.$store.dispatch('loadCafes');
            // 使用Vue存储器分发loadCafes动作来调用API
            // 加载咖啡店，并将数据保存到cafes模块中的cafes数组
        },

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