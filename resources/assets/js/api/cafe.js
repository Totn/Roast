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
    postAddNewCafe: function (name, locations, website, description, roaster, picture) {
        let data = new FormData();
        let config  = {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        };
        data.append('name', name);
        data.append('locations', JSON.stringify(locations));
        data.append('website', website);
        data.append('description', description);
        data.append('roaster', roaster);
        data.append('picture', picture);
        console.log(data);

        return axios.post(ROAST_CONFIG.API_URL + '/cafes', data, config);
    },

    /**
     * POST /api/v1/cafes/{cafeID}/like
     * @param {integer} cafeID 
     */
    postLikeCafe: function (cafeID) {
        return axios.post(ROAST_CONFIG.API_URL + '/cafes/' + cafeID + '/like');
    },

    /**
     * DELETE /api/v1/cafes/{cafeID}/like
     * @param {integer} cafeID 
     */
    deleteLikeCafe: function (cafeID) {
        return axios.delete(ROAST_CONFIG.API_URL + '/cafes/' + cafeID + '/like');
    }
}