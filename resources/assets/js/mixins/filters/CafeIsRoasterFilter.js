export const CafeIsRosterFilter = {
    methods: {
        processCafeIsRoasterFilter(cafe) {
            // 检查咖啡店是否是烘焙店
            if (cafe.roster === 1) {
                return true;
            } else {
                return false;
            }
        }
    }
}