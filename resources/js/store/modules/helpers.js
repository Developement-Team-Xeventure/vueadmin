import axios from 'axios';

const state = {
  States: [],

};

const getters = {
  allStates: state => state.States,

};

const actions = {
  async fetchStates({ commit }) {
    const response = await axios.get('/api/v1/states');
    commit('setStates', response.data.states);
  },


};

const mutations = {
  setStates: (state, States) => {
      state.States = States
  },

};

export default {
  state,
  getters,
  actions,
  mutations
};
