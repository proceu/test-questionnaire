const state = () => ({
  tests: [],
  test: null,
});
const actions = {
  downloadTests({commit}, payload) {
    return new Promise(((resolve, reject) => {
      this.$axios.get('test?all='+(payload?1:0))
        .then(res => {
          commit("UPDATE_TESTS", res.data);
          resolve(res.data)
        })
        .catch(errors => {
          reject(errors.response.data)
        })
    }))
  },
  downloadTest({commit},payload) {
    return new Promise(((resolve, reject) => {
      this.$axios.get('test/'+payload)
        .then(res => {
          commit("UPDATE_TEST", res.data.test);
          resolve(res.data.test)
        })
        .catch(errors => {
          reject(errors.response.data)
        })
    }))
  },
  downloadTestWithStatistics({commit},payload) {
    return new Promise(((resolve, reject) => {
      this.$axios.get('test/'+payload+'/statistics')
        .then(res => {
          commit("UPDATE_TEST", res.data.test);
          resolve(res.data.test)
        })
        .catch(errors => {
          reject(errors.response.data)
        })
    }))
  },
  deleteTest({commit},payload) {
    return new Promise(((resolve, reject) => {
      this.$axios.delete('test/'+payload)
        .then(res => {
          commit("REMOVE_TEST", payload);
          resolve(res.data)
        })
        .catch(errors => {
          reject(errors.response.data)
        })
    }))
  },
  addQuestion({commit}, payload) {
    return new Promise(((resolve, reject) => {
      this.$axios.post('question',payload)
        .then(res => {
          commit("ADD_QUESTION", res.data.question);
          resolve(res.data.question)
        })
        .catch(errors => {
          reject(errors.response.data)
        })
    }))
  },
  updateQuestion({state}, payload) {
    return new Promise(((resolve, reject) => {
      let item = state.test.questions.find((i) => i.id === payload)
      this.$axios.put('question/'+payload, item)
        .then(res => {
          resolve(res.data.question)
        })
        .catch(errors => {
          console.log(errors)
          reject(errors.response.data)
        })
    }))
  },
  deleteQuestion({commit}, payload) {
    return new Promise(((resolve, reject) => {
      this.$axios.delete('question/'+payload)
        .then(res => {
          commit("REMOVE_QUESTION", payload);
          resolve(res.data)
        })
        .catch(errors => {
          reject(errors.response.data)
        })
    }))
  },
  addAnswer({commit}, payload) {
    return new Promise(((resolve, reject) => {
      this.$axios.post('answer',payload)
        .then(res => {
          commit("ADD_ANSWER", res.data.answer);
          resolve(res.data.answer)
        })
        .catch(errors => {
          console.log(errors)
          reject(errors.response.data)
        })
    }))
  },
  updateAnswer({state}, payload) {
    return new Promise(((resolve, reject) => {
      let item = state.test.questions[payload.key].answers.find((i) => i.id === payload.id)
      this.$axios.put('answer/'+payload.id, item)
        .then(res => {
          resolve(res.data.answer)
        })
        .catch(errors => {
          console.log(errors)
          reject(errors.response.data)
        })
    }))
  },
  deleteAnswer({commit}, payload) {
    return new Promise(((resolve, reject) => {
      this.$axios.delete('answer/'+payload.id)
        .then(res => {
          commit("REMOVE_ANSWER", payload);
          resolve(res.data)
        })
        .catch(errors => {
          reject(errors.response.data)
        })
    }))
  },
  sendTest({},payload) {
    return new Promise(((resolve, reject) => {
      this.$axios.post('test-send/',payload)
        .then(res => {
          resolve(res.data)
        })
        .catch(errors => {
          reject(errors.response.data)
        })
    }))
  }
};

const mutations = {
  UPDATE_TESTS (state, tests) {
    state.tests = tests
  },
  UPDATE_TEST (state, test) {
    state.test = test
  },
  MERGE_TEST(state, test) {
    Object.assign(state.test,test)
  },
  REMOVE_TEST(state, id) {
    state.tests = state.tests.filter( (i) => i.id !== id);
  },
  ADD_QUESTION(state, question) {
    state.test.questions.push(question);
  },
  MERGE_QUESTION(state, question) {
    let item = state.test.questions[question.key]
    Object.assign(item,question)
  },
  REMOVE_QUESTION(state, id) {
    state.test.questions = state.test.questions.filter((i) => i.id !== id)
  },
  ADD_ANSWER(state, answer) {
    let item = state.test.questions.find((i) => i.id === answer.question_id)
    item.answers.push(answer)
  },
  MERGE_ANSWER(state, answer) {
    let item = state.test.questions[answer.key].answers[answer.keyAnswer]
    Object.assign(item,answer)
  },
  REMOVE_ANSWER(state, answer) {
    let question = state.test.questions.find((i) => i.id === answer.question_id)
    question.answers = question.answers.filter((i) => i.id !== answer.id)
  }
};

export default {
  namespaced: true,
  state,
  actions,
  mutations
}
