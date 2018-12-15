import {ROAST_CONFIG} from '../config.js';

export default {
    /**
     * GET /api/v1/brew-mthods
     */
    getBrewMethods: function () {
        return axios.get(ROAST_CONFIG.API_URL + '/brew-methods');
    }
}