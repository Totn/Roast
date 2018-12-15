<style>

</style>

<template>
    <div id="app-layout">
        <navigation></navigation>
        <router-view></router-view>
    </div>
</template>

<script>
import Navigation from '../components/global/Navigation.vue';

export default {
    components: {
        Navigation
    },
    // 在组件创建之后绑定的声明周期钩子created()被会调用，
    // 我们将在这个钩子函数中分配起加载咖啡店的动作
    created () {
        // 分发加载咖啡店的动作
        this.$store.dispatch('loadCafes');
        // 使用Vue存储器分发loadCafes动作来调用API
        // 加载咖啡店，并将数据保存到cafes模块中的cafes数组

        // 加载冲泡方法
        this.$store.dispatch('loadBrewMethods');
    },
}
</script>

