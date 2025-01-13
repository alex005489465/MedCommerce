<script setup>
import { useUserStore } from '@/stores/user';
import { ref } from 'vue';
import { RouterLink } from 'vue-router';

const userStore = useUserStore();
const email = ref('');
const password = ref('');

</script>

<template>
  <div>
    <h1>Login</h1>
    <form @submit.prevent="userStore.login(email, password)">
      <label for="email">Email</label>
      <input id="email" v-model="email" type="email" required autocomplete="email">
      <label for="password">Password</label>
      <input id="password" v-model="password" type="password" required autocomplete="current-password">
      <button type="submit">Login</button>
    </form>
  </div>
  <div>
    <RouterLink to="/register">Register</RouterLink>
  </div>
</template>

<style scoped>
form {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  align-items: flex-start;
}

a {
  color: #8b1085;
  text-decoration: none;
  padding: 0.5rem 1rem;
  border: 1px solid #333;
  border-radius: 4px;
  margin-top: 1rem;
  display: inline-block;
}

a:hover {
  background-color: #333;
  color: white;
}
</style>