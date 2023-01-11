<template>
  <b-card v-if="test">
    <b-card-title class="text-center">{{test.title}}</b-card-title>
    <b-card-text>
      <b-form @submit.prevent="sendTest" v-if="test.questions">
        <b-form-group class="px-5" label-size="lg" :label="question.title" v-slot="{ ariaDescribedby }" v-for="question in test.questions" :key="question.id">
          <b-form-radio v-model="form[question.id]" :aria-describedby="ariaDescribedby" v-for="answer in question.answers" :value="answer.id" :key="answer.id">
            {{ answer.title }}</b-form-radio>
        </b-form-group>
        <button type="submit" class="btn btn-primary px-5 mx-5">Submit</button>
      </b-form>
    </b-card-text>
  </b-card>
</template>

<script>
import {mapState} from "vuex";

export default {
  name: "index",
  data() {
    return {
      form:{},
    }
  },
  computed:{
    ...mapState({
      test: (state) => state.tests.test,
    }),
  },
  mounted() {
    this.$store.dispatch('tests/downloadTest',this.$route.params.test_id);
  },
  methods: {
    sendTest() {
      this.$store.dispatch('tests/sendTest', {answers:Object.values(this.form)})
        .then( () => {
        this.$router.push({name:'test-test_id-statistics', params:{test_id:this.$route.params.test_id}});
      }).catch( (err) => {
        console.log({err})
      })
    }
  }
}
</script>

<style scoped>

</style>
