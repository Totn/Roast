/*
|-------------------------------------------------------------------------------
| VUEX modules/brewmethods.js
|-------------------------------------------------------------------------------
| The Vuex data store for the brew methods
*/
import BrewMethodAPI from '../api/brewMethods.js';

export const brewMethods = {
    /**
     * Defines the state being monitored for the module
     */
    state: {
        brewMethods: [],
        brewMethodsLoadStatus: 0
    },

    actions: {
        loadBrewMethods({commit}) {
            commit('setBrewMethodsLoadStatus', 1);

            // call the api to load the brew methods.
            BrewMethodAPI.getBrewMethods()
                .then(function (response) {
                    commit('setBrewMethods', response.data);
                    commit('setBrewMethodsLoadStatus', 2);
                })
                .catch(function () {
                    // clears the brew methods on failure;
                    commit('setBrewMethodsLoadStatus', 3);
                    commit('setBrewMethods', []);
                });
        }
    },

    // Vuex中store数据改变的唯一方法就是mutations，
    // mutations是装有着改变数据方法的集合
    mutations: {
        // Sets the brew methods
        setBrewMethods(state, brewMethods) {
            state.brewMethods = brewMethods;
        },

        // Sets the brew methods load status
        setBrewMethodsLoadStatus(state, status) {
            state.brewMethodsLoadStatus = status;
        }
    },

    /**
     * Defines the getters used by the module.
     */
    getters: {
        // Returns the brew methods.
        getBrewMethods(state) {
            return state.brewMethods;
        },

        // Returns the brew methods load status.
        getBrewMethodsLoadStatus(state) {
            return state.brewMethodsLoadStatus;
        }
    }
};