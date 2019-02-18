/*
 |-------------------------------------------------------------------------------
 | VUEX store.js
 |-------------------------------------------------------------------------------
 | Builds the data store from all of the modules for the Roast app.
 */

/**
 * Adds the promise polyfill for IE11
 */
require('es6-promise').polyfill();
/**
 * Import Vue and Vuex
 */
import Vue from 'vue';
import Vuex from 'vuex';

/**
 * Initializes Vuex on Vue
 */
Vue.use(Vuex)

/**
 * Imports all of the modules used in the appliction to build the data store.
 */
import {cafes} from './modules/cafes.js';
import {brewMethods} from './modules/brewMethods.js';
import {users} from './modules/users.js';

export default new Vuex.Store({
    modules: {
        cafes,
        brewMethods,
        users
    }
});