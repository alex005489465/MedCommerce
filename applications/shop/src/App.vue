<script setup>
import { RouterLink, RouterView } from 'vue-router'
import { defineAsyncComponent } from 'vue'
//import SiteHeader from './components/tops/SiteHeader.vue'
import NavigationBar from './components/tops/NavigationBar.vue'
import { useIndexStore } from '@/stores/index'

const indexStore = useIndexStore()
indexStore.start()

const SiteHeader = defineAsyncComponent(() => import('./components/tops/SiteHeader.vue'));

</script>

<template>
  <header>
    <SiteHeader />
    <NavigationBar />
  </header>
  <div>
    <RouterView />
  </div>

</template>

<style scoped>

</style>
