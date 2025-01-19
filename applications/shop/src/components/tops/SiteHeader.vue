<script setup>
import { useUserStore } from '@/stores/user';
import { computed } from 'vue';
import { useRouter } from 'vue-router';

const userStore = useUserStore();
const isLogin = userStore.isLogin;

const handleLogout = async () => {
  await userStore.logout();
};
</script>

<template>
  <header>
    <img src="/logo.png" alt="Shop Logo" style="height: 50px; margin-right: 20px;">
    <div class="header-content">
      <h1>Welcome to Health Shop</h1>
      <RouterLink v-if="!isLogin" to="/login">Login</RouterLink>
      <RouterLink v-else @click.prevent="handleLogout" to="/">Logout</RouterLink>
    </div>
  </header>
</template>

<style scoped>
header {
    display: flex;
    align-items: center; /* 垂直方向居中對齊 */
}

header img {
    height: 100px; /* 固定高度 */
    margin-right: 50px; /* 與 h1 的間距 */
    width: auto; /* 自動調整寬度以維持比例 */
}

.header-content {
    display: flex;
    justify-content: space-between; /* h1 靠左，RouterLink 靠右 */
    align-items: center; /* 垂直方向居中對齊 */
    width: 100%; /* 佔據剩餘的空間 */
}

header h1 {
    margin: 0; /* 移除默認的外邊距 */
    font-size: 2rem; /* 字體大小 */
}

header a {
    text-decoration: none; /* 移除文字裝飾 */
    font-size: 1rem; /* 字體大小 */
    color: #007BFF; /* 字體顏色 */
    padding: 0.5rem 1rem; /* 內邊距 */
    transition: background-color 0.3s; /* 背景色過渡效果 */
}

header a:hover {
    background-color: #0056b3; /* 懸停背景色 */
    color: white; /* 懸停文字顏色 */
}
</style>
