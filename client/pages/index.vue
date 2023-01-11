<template>
  <div>
    <template v-if="$auth.loggedIn === true">
      <b-table :fields="fields" :items="tests">
        <template #cell(options)="data">
          <NuxtLink :to="{name:'test-test_id',params:{test_id:data.item.id}}">Start</NuxtLink>
        </template>
      </b-table>
    </template>
    <template v-else>
      <b-alert variant="info">Please login</b-alert>
    </template>
  </div>
</template>

<script>
import {mapState} from "vuex";

export default {
  name: 'IndexPage',
  auth: false,
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
      this.$store.dispatch('tests/downloadTests');
    }
  }
}
</script>
