<template>
  <div class="login-page">
    <div class="login-card">
      <div class="logo-container">
        <h1 class="logo-text">
          Medi<span class="green-text">sin</span>
        </h1>
      </div>

      <div class="form-container">
        <input
          v-model="email"
          type="text"
          placeholder="Username"
          class="custom-input"
        />

        <input
          v-model="password"
          type="password"
          placeholder="Password"
          class="custom-input"
        />

        <p v-if="error" class="error-msg">{{ error }}</p>

        <button @click="login" class="login-btn">
          LOGIN
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import api from '../api/api'

const email = ref('')
const password = ref('')
const error = ref('')
const router = useRouter()

const login = async () => {
  error.value = ''

  try {
    await api.post('/login', {
      email: email.value,
      password: password.value
    })

    router.push('/dashboard')

  } catch (err) {
    error.value =
      err.response?.data?.message ||
      'Login gagal'
  }
}
</script>

<style scoped>
.login-page {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background-color: #0061d5;
  margin: 0;
}

.login-card {
  background-color: white;
  width: 100%;
  max-width: 450px;
  padding: 50px 40px;
  border-radius: 35px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
  text-align: center;
}

.logo-container {
  margin-bottom: 30px;
}

.logo-text {
  font-size: 48px;
  font-weight: 800;
  color: #1a3a5a;
  margin: 0;
}

.green-text {
  color: #2ecc71;
}

.form-container {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.custom-input {
  background-color: #e0e0e0;
  border: none;
  padding: 16px 25px;
  border-radius: 30px;
  font-size: 16px;
  outline: none;
}

.login-btn {
  background-color: #0061d5;
  color: white;
  border: none;
  padding: 14px;
  border-radius: 30px;
  font-weight: bold;
  font-size: 16px;
  cursor: pointer;
  margin-top: 10px;
}

.login-btn:hover {
  opacity: 0.9;
}

.error-msg {
  color: #e74c3c;
  font-size: 14px;
}
</style>
