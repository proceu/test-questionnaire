<template>
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Login</h5>
        <div class="card-text">
          <form @submit.prevent="login()">
            <div class="mb-3">
              <label for="LoginInputEmail" class="form-label">Email address</label>
              <b-form-input
                type="email"
                class="form-control"
                id="LoginInputEmail"
                aria-describedby="emailHelp"
                v-model="form.email"/>
            </div>
            <div class="mb-3">
              <label for="LoginInputPassword" class="form-label">Password</label>
              <b-input type="password" class="form-control" id="LoginInputPassword" v-model="form.password" />
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
      </div>
    </div>
</template>

<script>
export default {
  layout: 'auth',
  name: "login",
  data() {
    return {
      form: {
        email:'',
        password:'',
      },
      errors: {},
    }
  },
  methods: {
    async login() {
      this.$nuxt.$loading.start();
      try {
        await this.$auth.loginWith("local", { data: this.form });
        await this.$router.push({name: 'dashboard'})
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
