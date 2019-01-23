// 筛选文本字段
export const CafeTextFilter = {
    methods: {
        processCafeTextFilter(cafe, text) {
            // 筛选文本不为空时才处理
            let flag = true;
            if (text.length > 0) {
                // 如果咖啡店名称、位置、地址或城市与筛选文本匹配，则返回true，否则返回false
                flag = false;
                let preg_str = '[^,]*' + text.toLowerCase() + '[,$]*';
                if (cafe.name.toLowerCase().match(preg_str)
                    || cafe.location_name.toLowerCase().match(preg_str)
                    || cafe.city.toLowerCase().match(preg_str)) {
                    flag = true;
                }
            }
            return flag;
        }
    }
}