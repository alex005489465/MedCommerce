<script setup>

</script>

<template>
  <div>
    <nav>
      <RouterLink to="/hello">Hello</RouterLink>
      <RouterLink to="/world">World</RouterLink>
    </nav>
  </div>
</template>

<style scoped>
nav {
  display: flex;
  justify-content: space-around; /* 子元素在主軸上均勻分布 */
  background-color: #333; /* 背景色 */
  padding: 1rem; /* 內邊距 */
}

nav a {
  color: white; /* 文字顏色 */
  font-size: 1.2rem; /* 字體大小 */
  text-decoration: underline; /* 下劃線 */
  padding: 0.5rem 1rem; /* 內邊距 */
  transition: background-color 0.3s ease; /* 過渡效果 */
}

nav a:hover {
  background-color: #555; /* 懸停時的背景色 */
}
</style>
