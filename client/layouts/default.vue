<template>
  <div>
    <b-navbar toggleable="lg" type="dark" variant="info">
      <b-navbar-brand :to="{name:'index'}">NavBar</b-navbar-brand>

      <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

      <b-collapse id="nav-collapse" is-nav>
        <template v-if="$auth.loggedIn && $auth.user.isAdmin">
          <NuxtLink class="navbar-text nav-link" :to="{name:'test'}">Tests</NuxtLink>
          <NuxtLink class="navbar-text nav-link" :to="{name:'dashboard'}">Statistics</NuxtLink>
        </template>
        <!-- Right aligned nav items -->
        <b-navbar-nav class="ml-auto">
          <template v-if="!$auth.loggedIn">
            <b-nav-item href="/auth/login">Login</b-nav-item>
            <b-nav-item href="/auth/register">Register</b-nav-item>
          </template>
          <template v-else>
            <b-nav-item-dropdown right v-if="$auth.loggedIn">
              <!-- Using 'button-content' slot -->
              <template #button-content>
                <em>{{ $auth.user.name }}</em>
              </template>
              <b-dropdown-item @click="logout()">Sign Out</b-dropdown-item>
            </b-nav-item-dropdown>
          </template>
        </b-navbar-nav>
      </b-collapse>
    </b-navbar>
    <b-container fluid>
      <b-row class="justify-content-center pt-5">
        <b-col cols="10">
          <nuxt/>
        </b-col>
      </b-row>
    </b-container>
  </div>
</template>

<script>
export default {
  name: "default",
  methods: {
    async logout() {
      this.$nuxt.$loading.start();
      this.$auth.logout();
      this.$nuxt.$loading.finish();
      this.$router.push({name:"auth-login"});
    },
  },
}
</script>

<style scoped>

</style>
