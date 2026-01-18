<template>
  <div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Item</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Name</label>
            <input v-model="form.name" class="form-control" />
          </div>

          <div class="mb-3">
            <label class="form-label">Status</label>
            <select v-model="form.status" class="form-select">
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
            </select>
          </div>
        </div>

        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">
            Cancel
          </button>
          <button class="btn btn-primary" @click="save">
            Save
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
    item: Object
  },
  data() {
    return {
      form: { ...this.item }
    };
  },
  watch: {
    item(newVal) {
      this.form = { ...newVal };
    }
  },
  methods: {
    async save() {
      await axios.put(`/api/items/${this.form.id}`, this.form);
      this.$emit('saved');
      bootstrap.Modal.getInstance(
        document.getElementById('editModal')
      ).hide();
    }
  }
};
</script>
