<template>
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">New Test</h5>
      <div class="card-text">
        <form @submit.prevent="create()">
          <div class="mb-3">
            <label for="CreateTestInputTitle" class="form-label">Title</label>
            <b-form-input
              type="text"
              class="form-control"
              id="CreateTestInputTitle"
              aria-describedby="titleHelp"
              v-model="form.title"/>
          </div>
          <button type="submit" class="btn btn-primary">Create</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "new",
  data() {
    return {
      form: {
        title:'',
      },
      errors: {},
    }
  },
  methods: {
    async create() {
      this.$nuxt.$loading.start();
      try {
        await this.$axios.post('test', this.form)
        await this.$router.push({name: 'test'})
      } catch (err) {
        this.errors = err.response.data.errors;
      }
      this.$nuxt.$loading.finish();
    },
  },
}
</script>

<style scoped>

</style>
