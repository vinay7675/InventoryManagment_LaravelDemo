<template>
  <div class="auth-container">
    <div class="card auth-card">
      <h2 class="text-center mb-4">Login</h2>

      <div v-if="error" class="alert alert-danger">
        {{ error }}
      </div>

      <div class="mb-3">
        <label class="form-label">Email</label>
        <input
          type="email"
          class="form-control"
          v-model="email"
        />
      </div>

      <div class="mb-3">
        <label class="form-label">Password</label>
        <input
          type="password"
          class="form-control"
          v-model="password"
        />
      </div>

      <button class="btn btn-primary w-100" @click="login">
        Login
      </button>

      <div class="text-center mt-3">
        Don’t have an account?
        <a href="/register">Register</a>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      email: '',
      password: '',
      error: null,
    };
  },
  methods: {
    async login() {
      this.error = null;

      try {
        await axios.post('/login', {
          email: this.email,
          password: this.password,
        });

        // Redirect after success
        window.location.href = '/items';

      } catch (err) {
        this.error =
          err.response?.data?.message ||
          'Login failed. Please try again.';
      }
    },
  },
};
</script>

<style scoped>
.auth-container {
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
}
.auth-card {
  width: 420px;
  padding: 30px;
}
</style>
