<script setup>
import { ref } from 'vue';
import { useUserStore } from '@/stores/user';

const name = ref('');
const email = ref('');
const password = ref('');
const confirmPassword = ref('');

const userStore = useUserStore();

const register = () => {
  if (password.value !== confirmPassword.value) {
    alert('Passwords do not match');
    return;
  }
  userStore.register({
    name: name.value,
    email: email.value,
    password: password.value,
    password_confirmation: confirmPassword.value,
  });
};
</script>

<template>
  <div>
    <h1>Register</h1>
    <form @submit.prevent="register">
      <label for="name">Name</label>
      <input id="name" v-model="name" type="text" required autocomplete="name">
      
      <label for="email">Email</label>
      <input id="email" v-model="email" type="email" required autocomplete="email">

      <label for="password">Password</label>
      <input id="password" v-model="password" type="password" required autocomplete="new-password">

      <label for="confirmPassword">Confirm Password</label>
      <input id="confirmPassword" v-model="confirmPassword" type="password" required autocomplete="new-password">

      <button type="submit">Register</button>
    </form>
  </div>
</template>

<style scoped>
form {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  align-items: flex-start;
}

button {
  margin-top: 1rem;
}

h1 {
  margin-bottom: 1rem;
}
</style>
