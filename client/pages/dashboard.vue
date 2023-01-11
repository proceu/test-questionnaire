<template>
  <b-row>
    <b-col cols="6">
      <b-row class="justify-content-center">
        <b-col cols="12">
          <h2 class="text-center">User statistics</h2>
        </b-col>
        <b-col cols="6">
          <client-only placeholder="Loading...">
            <chart
              :chart-options="{}"
              :chart-data="chartData"
              :height="50"
              :width="150"
              chart-id="lineChart"
            />
          </client-only>
        </b-col>
      </b-row>
    </b-col>
    <b-col cols="6">
      <b-table :fields="fields" :items="users.data">
      </b-table>
    </b-col>
  </b-row>
</template>

<script>

import {mapState} from "vuex";

export default {
  name: "dashboard",
  auth:true,
  middleware:['admin'],
  data() {
    return {
      chartData: {
        datasets: [
          {
            data: [],
            backgroundColor: ['#198754','#ffc107'],
          },
        ],
        labels: ['Passed','Not pass'],
      },
      fields:[
        { key: 'id', label: '#ID' },
        { key: 'name', label: 'Name' },
        { key: 'email', label: 'Email' }
      ],
    };
  },
  computed:{
    ...mapState({
      users: (state) => state.users.users,
    }),
  },
  mounted() {
    this.$store.dispatch('users/downloadUsers');
    this.getStatistics();
  },
  methods: {
    async getStatistics() {
      try {
        await this.$axios.get('/statistics')
          .then( (res) => {
            this.chartData.datasets[0].data = [res.data.passed,res.data.not_passed]
          })
      } catch (err) {
        console.log({err})
      }
    }
  }
}
</script>

<style scoped>

</style>
