<style lang="scss">
    @import '~@/abstracts/_variables.scss';

    div#home{
        a.add-cafe-button{
            float: right;
            display: block;
            margin-top: 10px;
            margin-bottom: 10px;
            background-color: $dark-color;
            color: white;
            padding: 10px 5px 10px 5px;
        }
    }
</style>

<template>
    <div id="home">

        <div class="grid-container">
            <div class="grid-x">
                <div class="large-12 medium-12 small-12 columns">
                    <!-- 跳转新增咖啡店的页面 -->
                    <router-link class="add-cafe-button" :to="{ name: 'newcafe' }" v-if="user !=='' && userLoadStatus === 2">+ 新增咖啡店</router-link>
                    <!-- 登陆操作 -->
                    <a class="add-cafe-text" v-if="user === '' && userLoadStatus === 2" v-on:click="login()">登陆后添加咖啡店</a>
                </div>
            </div>
        </div>
        <cafe-filter></cafe-filter>
        <div class="grid-container">
            <div class="grid-x grid-padding-x">
                <loader v-show="cafesLoadStatus == 1" :width="100" :height="100"></loader>
                <cafe-card v-for="cafe in cafes" :key="cafe.id" :cafe="cafe"></cafe-card>
            </div>
        </div>
    </div>
</template>

<script>
    import { EventBus } from "../event-bus.js";
    import CafeFilter from "../components/cafes/CafeFilter.vue";
    import CafeCard from "../components/cafes/CafeCard.vue";
    import Loader from "../components/global/Loader.vue";

    export default {
        components: {
            CafeFilter,
            CafeCard,
            Loader
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
            },
            // 获取brewMethods
            brewMethods() {
                return this.$store.getters.getBrewMethods;
            },
            // 用户信息
            user() {
                return this.$store.getters.getUser;
            },
            // 用户加载状态
            userLoadStatus() {
                return this.$store.getters.getUserLoadStatus();
            }
        },
        methods: {
            login() {
                EventBus.$emit('prompt-login');
            }
        }
    }
</script>