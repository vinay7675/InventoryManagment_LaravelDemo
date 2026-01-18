<template>
  <div class="modal fade" id="productModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">

        <!-- Header -->
        <div class="modal-header">
          <h5 class="modal-title">
            {{ isEdit ? 'Edit Product' : 'Create Product' }}
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <form @submit.prevent="save">

            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Product Name *</label>
                <input v-model="form.name" class="form-control" required />
              </div>

              <div class="col-md-6">
                <label class="form-label">Product Code *</label>
                <input
                    type="text"
                    class="form-control"
                    v-model="form.product_code"
                    disabled
                />
                </div>

              <div class="col-md-6">
                <label class="form-label">HSN Code</label>
                <input v-model="form.hsn_code" class="form-control" />
              </div>

              <div class="col-md-3">
                <label class="form-label">Quantity *</label>
                <input
                  v-model.number="form.quantity"
                  type="number"
                  min="0"
                  class="form-control"
                  required
                />
              </div>

              <div class="col-md-3">
                <label class="form-label">Price ($) *</label>
                <input
                  v-model.number="form.price"
                  type="number"
                  min="0"
                  step="0.01"
                  class="form-control"
                  required
                />
              </div>

              <div class="col-md-12">
                <label class="form-label">Description</label>
                <textarea
                  v-model="form.description"
                  class="form-control"
                  rows="3"
                ></textarea>
              </div>

              <div class="col-md-4">
                <label class="form-label">Status *</label>
                <select v-model="form.status" class="form-select">
                  <option value="active">Active</option>
                  <option value="inactive">Inactive</option>
                </select>
              </div>
            </div>

            <div v-if="error" class="alert alert-danger mt-3">
              {{ error }}
            </div>
          </form>
        </div>

        <!-- Footer -->
        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">
            Cancel
          </button>

          <button class="btn btn-primary" @click="save">
            {{ isEdit ? 'Update Product' : 'Create Product' }}
          </button>
        </div>

      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  props: {
    product: Object,
    createTrigger: Number
  },

  data() {
    return {
      form: {
        name: '',
        product_code: '',
        hsn_code: '',
        description: '',
        quantity: 0,
        price: 0,
        status: 'active'
      },
      error: null
    };
  },

  computed: {
    isEdit() {
      return !!this.product;
    }
  },

  watch: {
    createTrigger: {
    immediate: true,
    async handler() {
      if (!this.product) {
        this.reset();
        const res = await axios.get('/api/products/next-code');
        this.form.product_code = res.data.code;
      }
    }
  },

  product: {
    immediate: true,
    handler(value) {
      if (value) {
        this.form = {
          name: value.name,
          product_code: value.product_code,
          hsn_code: value.hsn_code,
          description: value.description,
          quantity: value.quantity,
          price: value.price,
          status: value.status
        };
      }
    }
  }
  },

  methods: {
    reset() {
      this.form = {
        name: '',
        product_code: '',
        hsn_code: '',
        description: '',
        quantity: 0,
        price: 0,
        status: 'active'
      };
    },

    async save() {
      this.error = null;

      try {
        if (this.isEdit) {
          await axios.put(`/api/products/${this.product.id}`, this.form);
        } else {
          await axios.post('/api/products', this.form);
        }

        this.$emit('saved');
        this.reset();

        bootstrap.Modal.getInstance(
          document.getElementById('productModal')
        ).hide();
      } catch (e) {
        this.error =
          e.response?.data?.message || 'Something went wrong';
      }
    }
  }
};
</script>
