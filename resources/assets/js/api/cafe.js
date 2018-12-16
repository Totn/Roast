/**
 * Imports the Roast API URL from the config.
 */

import { ROAST_CONFIG } from '../config.js';
// import Axios from 'axios';

export default {
    /**
     * GET /api/v1/cafes
     */
    getCafes: function () {
        return axios.get(ROAST_CONFIG.API_URL + '/cafes');
    },

    /**
     * GET /api/v1/cafes/cafeID
     * @param {int} cafeID 
     */
    getCafe: function (cafeID) {
        return axios.get(ROAST_CONFIG.API_URL + '/cafes/' + cafeID);
    },

    /**
     * POST /api/v1/cafes
     * @param {string} name 
     * @param {string} address 
     * @param {string} city 
     * @param {string} state 
     * @param {string} zip 
     */
    postAddNewCafe: function (name, locations, website, description, roaster) {
        return axios.post(ROAST_CONFIG.API_URL + '/cafes',
        {
            name: name,
            locations: locations,
            website: website,
            description: description,
            roaster: roaster
        });
    }
}