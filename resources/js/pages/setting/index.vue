<template>

       <router-view v-slot="{ Component }">
           <transition name="scale" mode="out-in">
           <component :is="Component" />
           </transition>
       </router-view>
  
</template>

<script>
</script>

<style lang="scss" scoped>

</style>
