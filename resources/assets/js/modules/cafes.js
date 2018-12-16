/*
|-------------------------------------------------------------------------------
| VUEX modules/cafes.js
|-------------------------------------------------------------------------------
| The Vuex data store for the cafes
*/

import CafeAPI from '../api/cafe.js';

/**
 * status = 0 -> 数据尚未加载
 * status = 1 -> 数据开始加载
 * status = 2 -> 数据加载成功
 * status = 3 -> 数据加载失败
 */
export const cafes = {
    state: {
        cafes: [],
        cafesLoadStatus: 0,

        cafe: {},
        cafeLoadStatus: 0,

        cafeAddStatus: 0
    },

    /**
     * Defines the actions used to retrieve the data.
     */
    actions: {
        loadCafes({commit}) {
            commit('setCafesLoadStatus', 1);

            CafeAPI.getCafes()
                .then(function (response) {
                    commit('setCafes', response.data);
                    commit('setCafesLoadStatus', 2);
                })
                // 失败之后执行
                .catch(function name(params) {
                    commit('setCafes', []);
                    commit('setCafesLoadStatus', 3); 
                });
        },
        loadCafe({commit}, data) {
            commit('setCafeLoadStatus', 1);

            CafeAPI.getCafe(data.id)
                .then(function (response) {
                    commit('setCafe', response.data);
                    commit('setCafeLoadStatus', 2);
                })
                .catch(function () {
                    commit('setCafe', []);
                    commit('setCafeLoadStatus', 3);
                });
        },

        // 通过dispatch从Vue中分发动作，如新增有咖啡店后reload Cafes模块
        addCafe({commit, state, dispatch}, data) {
            // 状态1表示开始添加
            commit('setCafeAddStatus', 1);

            CafeAPI.postAddNewCafe(data.name, data.locations, data.website, data.description, data.roaster)
                .then(function (response) {
                    // 状态2表示添加成功
                    commit('setCafeAddStatus', 2);
                    dispatch('loadCafes');
                })
                .catch(function () {
                    // status = 3 means add faild
                    commit('setCafeAddStatus', 3);
                });
        }
    },

    /**
     * Defines the mutations used
     */
    mutations: {
        setCafesLoadStatus (state, status) {
            state.cafesLoadStatus = status;
        },
        setCafes (state, cafes) {
            state.cafes = cafes;
        },
        setCafeLoadStatus (state, status) {
            state.cafeLoadStatus = status;
        },
        setCafe (state, cafe) {
            state.cafe = cafe;
        },
        setCafeAddStatus(state, status) {
            state.cafeAddStatus = status;
        }
    },

    /**
     * Defines the getters used by the module
     */
    getters: {
        getCafesLoadStatus (state) {
            return state.cafesLoadStatus;
        },
        getCafes (state) {
            return state.cafes;
        },

        getCafeLoadStatus (state) {
            return state.cafeLoadStatus;
        },
        getCafe (state) {
            return state.cafe;
        },
        getCafeAddStatus (state) {
            return state.cafeAddStatus;
        }
    }
}