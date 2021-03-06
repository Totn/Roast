/*
|-------------------------------------------------------------------------------
| VUEX modules/user.js
|-------------------------------------------------------------------------------
| The Vuex data store for the user
*/

import UserAPI from '../api/user.js';

export const users = {
    state: {
        user: {},
        userLoadStatus: 0,
        userUpdateStatus: 0
    },

    actions: {

        // 加载用户信息
        loadUser({commit}) {
            // 标记开始加载用户
            commit('setUserLoadStatus', 1);

            UserAPI.getUser()
                // 加载成功
                .then(function (response) {
                    // 未登陆时data = ''
                    commit('setUser', response.data);
                    commit('setUserLoadStatus', 2);
                })
                // 加载失败
                .catch(function () {
                    commit('setUser', {});
                    commit('setUserLoadStatus', 3);
                });
        },
        
        // 更新用户信息
        editUser({commit, state, dispatch}, data) {
            // 标记开始更新用户信息
            commit('setUserUpdateStatus', 1);

            UserAPI.putUpdateUser(data.profile_visibility, data.favorite_coffee, data.flavor_notes, data.city, data.state)
                .then(function (response) {
                    commit('setUserUpdateStatus', 2);
                    dispatch('loadUser');
                })
                .catch(function () {
                    commit('setUserUpdateStatus', 3);
                });
        }
    },

    mutations: {
        //  用户数据加载到state中
        setUser(state, data) {
            state.user = data;
        },

        // 设置用户数据加载状态
        setUserLoadStatus(state, status) {
            state.userLoadStatus = status;
        },
        
        // 设置用户更新状态
        setUserUpdateStatus(state, status) {
            state.userUpdateStatus = status;
        }
    },
    
    getters: {
        getUser(state) {
            return state.user;
        },
        
        getUserLoadStatus(state) {
            // store.watch第一个参数只授受函数作为参数
            return function() {
                return state.userLoadStatus;
            }
        },

        getUserUpdateStatus(state) {
            return state.userUpdateStatus;
        }
    }
}