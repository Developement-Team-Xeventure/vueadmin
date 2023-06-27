
import Helpers from './modules/helpers';
import { createStore } from 'vuex'

// Create store
const store = createStore({
  modules: {
    Helpers
  }
});

export default store;