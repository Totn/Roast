export const CafeTagsFilter = {
    methods: {
        // 标签过滤
        processCafeTagsFilter(cafe, tags) {
            // 如果标签不为空则进行处理
            if (tags.length > 0) {
                var cafeTags = [];
                
                // 将咖啡店所有标签推送到CafeTags数组中
                for (let index = 0; index < cafe.tags.length; index++) {
                    cafeTags.push(cafe.tags[index].name);
                }

                // 遍历所有待处理标签，如果标签在cafeTags数组中返回true;
                for (let i = 0; i < tags.length; i++) {
                    if (cafeTags.indexOf(tags[i]) > -1) {
                        return true;
                    }
                }

                // 如果所有待处理标签都不在cafeTags数组中，则返回false
                return false;
            } else {
                return true;
            }
        }
    }
}