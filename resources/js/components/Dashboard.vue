<template>
  <div class="min-vh-100 bg-light">

    <!-- Header -->
    <nav class="navbar navbar-light bg-white shadow-sm">
      <div class="container">
        <span class="navbar-brand fw-bold">
          Inventory Management System
        </span>

        <div class="ms-auto">
          <a href="/login" class="btn btn-outline-primary me-2">
            Login
          </a>
          <a href="/register" class="btn btn-primary">
            Get Started
          </a>
        </div>
      </div>
    </nav>
    <section class="container py-5">
      <div class="row align-items-center">
        <div class="col-md-6">

          <h1 class="fw-bold mb-3">
            Simplify Your Inventory<br />
            <span class="text-primary">Management Workflow</span>
          </h1>

          <p class="text-muted mb-4">
            Manage products, track stock levels, control pricing, and monitor
            availability effortlessly using a centralized inventory dashboard.
          </p>

          <ul class="list-unstyled text-muted mb-4">
            <li>✔ Product & stock tracking</li>
            <li>✔ Auto-generated product codes</li>
            <li>✔ Status & availability control</li>
            <li>✔ Secure authentication & access</li>
          </ul>

          <a href="/register" class="btn btn-primary btn-lg me-2">
            Create Account
          </a>

          <a href="/login" class="btn btn-outline-secondary btn-lg">
            Login
          </a>
        </div>
        <div class="col-md-6 text-center">
          <img
            src="../../assets/download.png"
            alt="Inventory Illustration"
            class="img-fluid"
            style="min-height: 450px"
          />
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="text-center text-muted py-4">
      © {{ new Date().getFullYear() }} Inventory Management System. All rights reserved.
    </footer>

  </div>
</template>

<script>
export default {
  name: 'Dashboard'
};
</script>

<style scoped>
h1 {
  line-height: 1.2;
}
</style>
