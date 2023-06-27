<template>

<div class="container-fluid">

    <TopBarUM/>
    <router-view></router-view>
</div>

</template>

<script>
import topBar from '../../widgets/topbar.vue'
export default {
        components:{
            TopBarUM:topBar
    },
    setup() {


        return {}
    }
}
</script>

<style lang="scss" scoped>

</style>
