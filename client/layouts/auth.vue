<template>
<b-container fluid>
  <b-row class="justify-content-center pt-5">
    <b-col cols="4">
      <nuxt/>
    </b-col>
  </b-row>
</b-container>
</template>

<script>
export default {
  name: "auth"
}
</script>

<style scoped>
div#__nuxt,
#__layout,
#__layout > div,
#app {
  min-height: 100vh;
}
</style>
