<style lang="">
    
</style>

<template>
    <div id="cafes">
        <div id="grid-x">
            <div class="large-9 medium-9 small-12 cell">
                <cafe-map></cafe-map>
            </div>
            <div class="large-3 medium-3 small-12 cell">

            </div>
        </div>
    </div>
</template>

<script>
    import CafeMap from '../components/cafes/CafeMap.vue';
    export default {
        components: {
            CafeMap
        }
    }
</script>