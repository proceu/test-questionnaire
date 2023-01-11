<template>
  <div class="card" v-if="test">
    <div class="card-body">
      <h5 class="card-title">Edit {{test.title}}</h5>
      <div class="card-text">
        <form @submit.prevent="edit()">
          <div class="mb-3">
            <label for="CreateTestInputTitle" class="form-label">Title</label>
            <b-form-input
              type="text"
              class="form-control"
              id="CreateTestInputTitle"
              aria-describedby="titleHelp"
              :value="test.title"
              @input="mergeTest({title:$event})"
            />
          </div>
          <button type="submit" class="btn btn-primary">Update</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import {mapMutations, mapState} from 'vuex';
export default {
  name: "edit",
  computed: {
    ...mapState('tests', [
      'test'
    ])
  },
  mounted() {
    this.$store.dispatch('tests/downloadTest',this.$route.params.test_id)
  },
  methods: {
    ...mapMutations({mergeTest: 'tests/MERGE_TEST'}),
    async edit() {
      this.$nuxt.$loading.start();
      try {
        await this.$axios.put('test/'+this.test.id,this.test)
        await this.$router.push({name: 'test'})
      } catch (err) {
        this.errors = err.response.data.errors;
      }
      this.$nuxt.$loading.finish();

    }
  }
}
</script>

<style scoped>

</style>
