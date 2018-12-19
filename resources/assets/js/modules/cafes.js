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

        cafeAddStatus: 0,

        cafeLikeActionStatus: 0,
        cafeUnlikeActionStatus: 0,

        cafeLiked: false
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
            commit('setCafeLikedStatus', false);

            CafeAPI.getCafe(data.id)
                .then(function (response) {
                    commit('setCafe', response.data);
                    if (response.data.likes.length > 0) {
                        commit('setCafeLikedStatus', true);
                    }
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
                    // 添加咖啡店成功后，重新载入咖啡店的数据
                    dispatch('loadCafes');
                })
                .catch(function () {
                    // status = 3 means add faild
                    commit('setCafeAddStatus', 3);
                });
        },

        // 点个“喜欢”咖啡店
        likeCafe({commit, state}, data) {
            commit('setCafeLikeActionStatus', 1);

            CafeAPI.postLikeCafe(data.id)
            .then(function (response) {
                commit('setCafeLikeActionStatus', 2);
                commit('setCafeLikedStatus', true);
            })
            .catch(function () {
                commit('setCafeLikeActionStatus', 3);
            });
        },

        // 取消“喜欢”咖啡店
        unlikeCafe({commit, state}, data) {
            commit('setCafeUnlikeActionStatus', 1);

            CafeAPI.deleteLikeCafe(data.id)
                .then(function (response) {
                    commit('setCafeUnlikeActionStatus', 2);
                    commit('setCafeLikedStatus', false);
                })
                .catch(function () {
                    commit('setCafeUnlikeActionStatus', 3);
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
        },
        setCafeLikeActionStatus(state, status) {
            state.cafeLikeActionStatus = status;
        },
        setCafeUnlikeActionStatus(state, status) {
            state.cafeUnlikeActionStatus = status;
        },
        setCafeLikedStatus(state, status) {
            state.cafeLiked = status;
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
        },
        getCafeLikedStatus(state) {
            return state.cafeLiked;
        },
        getCafeLikeActionStatus(state) {
            return state.cafeLikeActionStatus;
        },
        getCafeUnlikeActionStatus(state) {
            return state.cafeUnlikeActionStatus;
        }
    }
}