<template>
  <b-row v-if="test && show">
    <b-col cols="12"><h1>{{test.title}}</h1></b-col>
    <b-col cols="12" v-for="question in test.questions" :key="question.id">
      <b-row>
        <b-col cols="6">
          <p class="px-2 d-flex justify-content-between" v-for="(answer,key) in question.answers">
            <span :class="question.user_answers[key]?'text-primary':''">{{answer.title}}</span>
          </p>
        </b-col>
        <b-col cols="6">
          <bar-chart
            :height="200"
            :chart-options="{indexAxis: 'y',plugins:{legend:{display:false}}}"
            :chart-data="{
              labels: question.titles,
              datasets: [{
                axis: 'y',
                data: question.statistics_data,
                backgroundColor:question.user_answers.map( element => {
                  return element?'#0d6efd':'#0dcaf0';
                }),
              }],
            }"
          />
        </b-col>
      </b-row>
    </b-col>
  </b-row>
</template>

<script>
import {mapState} from "vuex";

export default {
  name: "statistics",
  data() {
    return {
      show:false,
    }
  },
  computed:{
    ...mapState({
      test: (state) => state.tests.test,
    }),
  },
  mounted() {
    this.$store.dispatch('tests/downloadTestWithStatistics',this.$route.params.test_id)
      .then(() => {
        this.show = true;
      });
  },
}
</script>

<style scoped>

</style>
