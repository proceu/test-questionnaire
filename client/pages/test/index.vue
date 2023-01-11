<template>
  <div>
    <b-row class="justify-content-end py-2">
      <b-col cols="2">
        <b-btn variant="primary" block :to="{name:'test-new'}">New</b-btn>
      </b-col>
    </b-row>
    <b-table :fields="fields" :items="tests">
      <template #cell(options)="data">
        <NuxtLink :to="{name:'test-test_id',params:{test_id:data.item.id}}">Show</NuxtLink>
        <NuxtLink :to="{name:'test-test_id-fill',params:{test_id:data.item.id}}">Fill</NuxtLink>
        <NuxtLink :to="{name:'test-test_id-edit',params:{test_id:data.item.id}}">Edit</NuxtLink>
        <b-link @click="deleteItem(data.item.id)">Delete</b-link>
      </template>
    </b-table>
  </div>
</template>

<script>
import {mapState} from "vuex";

export default {
  name: "index",
  middleware: 'admin',
  data() {
    return {
      fields:[
        { key: 'id', label: '#ID' },
        { key: 'title', label: 'Title' },
        { key: 'options', label: 'Options' }
      ],
    }
  },
  computed:{
    ...mapState({
      tests: (state) => state.tests.tests
    }),
  },
  mounted() {
    if (this.$auth.loggedIn) {
      this.$store.dispatch('tests/downloadTests', 'all');
    }
  },
  methods: {
    deleteItem(id) {
      this.$store.dispatch('tests/deleteTest', id);
    }
  }
}
</script>

<style scoped>

</style>
