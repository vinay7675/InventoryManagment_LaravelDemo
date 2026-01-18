<template>
  <div>
    <!-- Header -->
    <nav class="navbar navbar-light bg-white shadow-sm px-4">
      <span class="navbar-brand fw-bold">
        Inventory Management Dashboard
      </span>

      <div class="d-flex align-items-center gap-3">
        <span class="fw-semibold text-muted">
          Welcome, {{ user?.name }}!
        </span>

        <button class="btn btn-outline-danger btn-sm" @click="logout">
          Logout
        </button>
      </div>
    </nav>

    <div class="container mt-4">
      
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
          <select
            class="form-select w-auto d-inline"
            v-model="statusFilter"
            @change="fetchProducts"
          >
            <option value="">All</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
          </select>

          <span class="ms-3 text-muted">
            Total Products:
            <strong>{{ products.length }}</strong>
          </span>
        </div>

        <button class="btn btn-primary" @click="openCreate">
          <i class="bi bi-plus-lg"></i> Create Product
        </button>
      </div>

      <!-- Inventory Table -->
      <div class="card shadow-sm">
        <table class="table table-hover mb-0 inventory-table">
          <thead class="table-light">
            <tr>
              <th style="width: 60px;">S.no</th>
              <th class="col-name" @click="toggleSort('name')" role="button">
                Name
                <span v-if="sortBy === 'name'">
                  <i v-if="sortDir === 'asc'" class="bi bi-caret-up-fill"></i>
                  <i v-else class="bi bi-caret-down-fill"></i>
                </span>
              </th>
              <th class="col-code">Product Code</th>
              <th class="col-hsn">HSN</th>
              <th class="col-qty">Qty</th>
              <th class="col-price">Price</th>
              <th class="col-status">Status</th>
              <th class="col-actions text-end">Actions</th>
            </tr>
          </thead>

          <tbody>
            <tr v-for="(product, index) in products" :key="product.id">
              
              <td class="fw-semibold text-muted">
                {{ index + 1 }}
              </td>
              <td class="col-name">
                <div class="product-name">
                  {{ product.name }}
                </div>
                <div
                  class="product-desc"
                  :title="product.description"
                >
                  {{ product.description }}
                </div>
              </td>

              <td class="col-code">
                {{ product.product_code }}
              </td>

              <td class="col-hsn">
                {{ product.hsn_code || '-' }}
              </td>

              <td class="col-qty">
                {{ product.quantity }}
              </td>

              <td class="col-price">
                $ {{ product.price }}
              </td>

              <td class="col-status">
                <span
                  class="badge"
                  :class="product.status === 'active'
                    ? 'bg-success'
                    : 'bg-secondary'"
                >
                  {{ product.status }}
                </span>
              </td>

              <td class="col-actions text-end">
                <i
                  class="bi bi-pencil text-primary me-3"
                  role="button"
                  @click="openEdit(product)"
                ></i>

                <i
                  class="bi bi-trash text-danger"
                  role="button"
                  @click="askDelete(product)"
                ></i>
              </td>
            </tr>

            <tr v-if="products.length === 0">
              <td colspan="7" class="text-center text-muted py-4">
                No products found
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Product Modal -->
    <ProductModal
      :product="selectedProduct"
      :create-trigger="createTrigger"
      @saved="fetchProducts"
    />

    <!-- DELETE CONFIRMATION -->
    <div v-if="showDeleteModal">
      <div class="modal-backdrop fade show"></div>

      <div class="modal d-block" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">

            <div class="modal-header">
              <h5 class="modal-title text-danger">
                Confirm Delete
              </h5>
              <button
                type="button"
                class="btn-close"
                @click="cancelDelete"
              ></button>
            </div>

            <div class="modal-body">
              <p>
                Are you sure you want to delete
                <strong>{{ productToDelete?.name }}</strong>?
              </p>
              <p class="text-muted mb-0">
                This action cannot be undone.
              </p>
            </div>

            <div class="modal-footer">
              <button class="btn btn-secondary" @click="cancelDelete">
                Cancel
              </button>
              <button class="btn btn-danger" @click="confirmDelete">
                Delete
              </button>
            </div>

          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
import axios from 'axios';
import ProductModal from './ProductModal.vue';

export default {
  components: { ProductModal },

  data() {
    return {
      products: [],
      statusFilter: '',
      sortBy: 'name',
      sortDir: 'asc',
      showDeleteModal: false,
      productToDelete: null,
      selectedProduct: null,
      createTrigger: 0,
      user: null
    };
  },

  mounted() {
    this.fetchUser();
    this.fetchProducts();
  },

  methods: {
    toggleSort(column) {
      if (this.sortBy === column) {
        this.sortDir = this.sortDir === 'asc' ? 'desc' : 'asc';
      } else {
        this.sortBy = column;
        this.sortDir = 'asc';
      }
      this.fetchProducts();
    },

    async fetchProducts() {
      const res = await axios.get('/api/products', {
        params: {
          status: this.statusFilter,
          sort_by: this.sortBy,
          sort_dir: this.sortDir
        }
      });
      this.products = res.data;
    },

    openCreate() {
     this.selectedProduct = null;
     this.createTrigger++;
     this.$nextTick(() => {
     const modal = new bootstrap.Modal(
      document.getElementById('productModal')
      );
      modal.show();
     });
    },

    openEdit(product) {
      this.selectedProduct = { ...product };
      new bootstrap.Modal('#productModal').show();
    },

    async logout() {
      const res = await axios.post('/logout');
      window.location.href = res.data.redirect;
    },

    askDelete(product) {
      this.productToDelete = product;
      this.showDeleteModal = true;
    },

    async confirmDelete() {
      await axios.delete(`/api/products/${this.productToDelete.id}`);
      this.showDeleteModal = false;
      this.productToDelete = null;
      this.fetchProducts();
    },

    cancelDelete() {
      this.showDeleteModal = false;
      this.productToDelete = null;
    },

    async fetchUser() {
      const res = await axios.get('/me');
      this.user = res.data;
    }
  }
};
</script>

<style scoped>
.inventory-table {
  table-layout: fixed;
  width: 100%;
}

.inventory-table tbody tr {
  height: 72px;           
  max-height: 72px;
}

.inventory-table td {
  vertical-align: middle;
  overflow: hidden;
    padding-left: 20px;
    padding-right: 20px;
}
.inventory-table th{
    padding-left: 20px;
    padding-right: 20px;
}
.col-name    { width: 32%; }
.col-code    { width: 14%; }
.col-hsn     { width: 10%; }
.col-qty     { width: 6%; text-align: center; }
.col-price   { width: 8%; white-space: nowrap; }
.col-status  { width: 10%; }
.col-actions { width: 10%; }
.col-code,
.col-hsn,
.col-qty,
.col-price,
.col-status,
.col-actions {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.product-name {
  font-weight: 600;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.product-desc {
  font-size: 0.85rem;
  color: #6c757d;
  line-height: 1.2rem;

  max-height: 2.4rem;    
  overflow: hidden;

  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
}
</style>
