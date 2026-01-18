<template>
  <div class="container vh-100 d-flex align-items-center justify-content-center">
    <div class="card p-4 shadow" style="width: 420px">
      <h4 class="text-center mb-3">Create Account</h4>

      
      <div class="mb-2">
        <label class="form-label">Name</label>
        <input
          type="text"
          class="form-control"
          v-model="form.name"
        />
      </div>

      
      <div class="mb-2">
        <label class="form-label">Email</label>
        <input
          type="email"
          class="form-control"
          v-model="form.email"
        />
      </div>

      
      <div class="mb-2">
        <label class="form-label">Password</label>
        <div class="input-group">
          <input
            :type="showPassword ? 'text' : 'password'"
            class="form-control"
            v-model="form.password"
          />
          <span class="input-group-text icon-btn" @click="showPassword = !showPassword">
            <i :class="showPassword ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
          </span>
        </div>
      </div>

      
      <div class="mb-3">
        <label class="form-label">Re-enter Password</label>
        <div class="input-group">
          <input
            :type="showConfirmPassword ? 'text' : 'password'"
            class="form-control"
            v-model="form.confirmPassword"
          />
          <span class="input-group-text icon-btn" @click="showConfirmPassword = !showConfirmPassword">
            <i :class="showConfirmPassword ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
          </span>
        </div>
      </div>

      
      <div v-if="error" class="alert alert-danger py-2">
        {{ error }}
      </div>

      
      <button class="btn btn-primary w-100" @click="register">
        Register
      </button>

      <p class="text-center mt-3 mb-0">
        Already have an account?
        <a href="/login">Login</a>
      </p>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'Register',

  data() {
    return {
      form: {
        name: '',
        email: '',
        password: '',
        confirmPassword: '',
      },
      showPassword: false,
      showConfirmPassword: false,
      error: null,
    };
  },

  methods: {
    async register() {
      this.error = null;

      const { name, email, password, confirmPassword } = this.form;

      if (!name || !email || !password || !confirmPassword) {
        this.error = 'All fields are required.';
        return;
      }

      if (password !== confirmPassword) {
        this.error = 'Passwords do not match.';
        return;
      }

      try {
        await axios.post('/register', {
          name,
          email,
          password,
          password_confirmation: confirmPassword
        });

        
        window.location.href = '/items';

      } catch (e) {
        if (e.response?.status === 422) {
          const errors = e.response.data.errors;
          this.error = Object.values(errors)[0][0];
        } else {
          this.error = 'Registration failed. Please try again.';
        }
      }
    }
  }
};
</script>


<style scoped>
.icon-btn {
  cursor: pointer;
  background-color: #f8f9fa;
}
</style>
