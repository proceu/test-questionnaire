<template>
  <div class="card" v-if="test">
    <div class="card-body">
      <h5 class="card-title">Fill {{test.title}}</h5>
      <div class="card-text">
        <template v-for="(question,key) in test.questions">
          <p class="d-flex justify-content-between" :key="key" v-if="editQuestion !== question.id">
            <strong>{{question.title}}</strong>
            <span>
              <b-btn @click="showEditQuestion(question.id)" variant="warning">Edit</b-btn>
              <b-btn @click="deleteQuestion(question.id)" variant="danger">Delete</b-btn>
            </span>
          </p>
          <b-form @submit.prevent="updateQuestion" inline v-else>
            <div class="mb-3 mr-3">
              <label for="FillTestInputQuestionTitle" class="form-label">Title</label>
              <b-form-input
                type="text"
                class="form-control"
                id="FillTestInputQuestionTitle"
                aria-describedby="titleHelp"
                :value="question.title"
                @input="mergeQuestion({title:$event, key})"
              />
            </div>
            <div class="mb-3 mr-3">
              <label for="FillTestInputQuestionWeight" class="form-label">Weight</label>
              <b-form-input
                type="number"
                class="form-control"
                id="FillTestInputQuestionWeight"
                aria-describedby="weightHelp"
                min="1"
                max="5"
                step="1"
                :value="question.weight"
                @input="mergeQuestion({weight:$event, key})"
              />
            </div>
            <b-btn type="submit" variant="primary" class="mt-2">Update</b-btn>
            <b-btn @click="closeEditQuestion" variant="secondary" class="mt-2">Close</b-btn>
          </b-form>
          <template v-for="(answer,keyAnswer) in question.answers">
            <p class="px-2 d-flex justify-content-between" :class="answer.aright?'text-success':'text-danger'" v-if="editAnswer !== answer.id">
              <span>{{answer.title}}</span>
              <span>
                <b-btn @click="showEditAnswer(answer.id)" variant="warning">Edit</b-btn>
                <b-btn @click="deleteAnswer(answer)" variant="danger">Delete</b-btn>
              </span>
            </p>
            <b-form @submit.prevent="updateAnswer(key)" inline v-else>
              <div class="mb-3 mr-3">
                <label for="FillTestInputAnswerTitleUpdate" class="form-label">Title</label>
                <b-form-input
                  type="text"
                  class="form-control"
                  id="FillTestInputAnswerTitleUpdate"
                  aria-describedby="titleHelp"
                  :value="answer.title"
                  @input="mergeAnswer({title:$event, keyAnswer, key})"
                />
              </div>
              <div class="mb-3 mr-3">
                <b-form-checkbox
                  id="checkbox-1"
                  name="checkbox-1"
                  :value="1"
                  :unchecked-value="0"
                  :checked="answer.aright"
                  @input="changeCheckbox($event, keyAnswer,key)"
                >
                  Aright
                </b-form-checkbox>
              </div>
              <b-btn type="submit" variant="primary" class="mt-2">Update</b-btn>
              <b-btn @click="closeEditAnswer" variant="secondary" class="mt-2">Close</b-btn>
            </b-form>
          </template>
          <b-btn variant="primary" @click="openAddAnswerForm(question.id)" v-if="newAnswer.question_id !== question.id">Add Answer</b-btn>
          <b-form @submit.prevent="createAnswer(question.id)" inline v-if="newAnswer.question_id === question.id">
            <div class="mb-3 mr-3">
              <label for="FillTestInputAnswerTitle" class="form-label">Title</label>
              <b-form-input
                type="text"
                class="form-control"
                id="FillTestInputQuestionTitle"
                aria-describedby="titleHelp"
                v-model="newAnswer.title"
              />
            </div>
            <div class="mb-3 mr-3">
              <b-form-checkbox
                id="checkbox-1"
                v-model="newAnswer.aright"
                name="checkbox-1"
              >
                Aright
              </b-form-checkbox>
            </div>
            <b-btn type="submit" variant="primary" class="mt-2">Add Answer</b-btn>
          </b-form>
        </template>
        <b-form @submit.prevent="createQuestion" inline>
          <div class="mb-3 mr-3">
            <label for="FillTestInputQuestionTitle" class="form-label">Title</label>
            <b-form-input
              type="text"
              class="form-control"
              id="FillTestInputQuestionTitle"
              aria-describedby="titleHelp"
              v-model="newQuestion.title"
            />
          </div>
          <div class="mb-3 mr-3">
            <label for="FillTestInputQuestionWeight" class="form-label">Weight</label>
            <b-form-input
              type="number"
              class="form-control"
              id="FillTestInputQuestionWeight"
              aria-describedby="weightHelp"
              min="1"
              max="5"
              step="1"
              v-model="newQuestion.weight"
            />
          </div>
          <b-btn type="submit" variant="primary" class="mt-2">Add Question</b-btn>
        </b-form>
      </div>
    </div>
  </div>
</template>

<script>
import {mapMutations, mapState} from "vuex";

export default {
  name: "fill",
  data() {
    return {
      newQuestion: {
        title: '',
        weight:1,
        test_id: this.$route.params.test_id,
      },
      newAnswer:{
        title:'',
        aright:false,
        question_id:null,
      },
      editAnswer: null,
      editQuestion: null
    }
  },
  methods: {
    ...mapMutations({mergeQuestion:'tests/MERGE_QUESTION',mergeAnswer: 'tests/MERGE_ANSWER'}),
    createQuestion() {
      this.$store.dispatch('tests/addQuestion', this.newQuestion)
        .then(() => {
          this.newQuestion = {
            title: '',
            weight:1,
            test_id: this.$route.params.test_id,
          }
        })
    },
    showEditQuestion(id) {
      this.editQuestion = id;
    },
    closeEditQuestion() {
      this.editQuestion = null;
    },
    updateQuestion() {
      this.$store.dispatch('tests/updateQuestion', this.editQuestion)
        .then(() => {
          this.closeEditQuestion();
        });
    },
    deleteQuestion(id) {
      this.$store.dispatch('tests/deleteQuestion', id);
    },
    openAddAnswerForm(id) {
      this.newAnswer.question_id = id;
    },
    createAnswer() {
      this.$store.dispatch('tests/addAnswer', this.newAnswer)
        .then(() => {
          this.newAnswer = {
            title:'',
            aright:false,
            question_id:null,
          }
        })
    },
    showEditAnswer(id) {
      this.editAnswer = id;
    },
    closeEditAnswer() {
      this.editAnswer = null;
    },
    updateAnswer(key) {
      this.$store.dispatch('tests/updateAnswer',{id:this.editAnswer, key})
      this.closeEditAnswer();
    },
    deleteAnswer(item) {
      this.$store.dispatch('tests/deleteAnswer', {id:item.id, question_id:item.question_id});
    },
    changeCheckbox(e, keyAnswer, key) {
      this.mergeAnswer({aright:e, keyAnswer, key})
    }
  },
  computed:{
    ...mapState({
      test: (state) => state.tests.test
    }),
  },
  mounted() {
    this.$store.dispatch('tests/downloadTest',this.$route.params.test_id);
  },
}
</script>

<style scoped>

</style>
