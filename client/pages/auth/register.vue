<template>
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Register</h5>
      <div class="card-text">
        <form @submit.prevent="register()">
          <div class="mb-3">
            <label for="LoginInputName" class="form-label">Name</label>
            <b-form-input
              type="text"
              class="form-control"
              id="LoginInputName"
              aria-describedby="nameHelp"
              v-model="form.name"/>
          </div>
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
          <div class="mb-3">
            <label for="LoginInputPasswordConfirm" class="form-label">Password Confirmation</label>
            <b-input type="password" class="form-control" id="LoginInputPasswordConfirm" v-model="form.password_confirmation" />
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "register",
  layout: 'auth',
  auth:false,
  data() {
    return {
      form: {
        name:'',
        email:'',
        password:'',
        password_confirmation:'',
      },
      errors: {},
    }
  },
  methods: {
    async register() {
      this.$nuxt.$loading.start();
      try {
        await this.$axios.post('/auth/register',this.form)
          .then( () => {
            this.$auth.loginWith('local', { data: this.form })
        })
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
