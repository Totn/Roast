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
        userLoadStatus: 0
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
        }
    },
    
    getters: {
        getUser(state) {
            return state.user;
        },
        
        getUserLoadStatus(state) {
            return state.userLoadStatus;
        }
    }
}