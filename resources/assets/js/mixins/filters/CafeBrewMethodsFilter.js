export const CafeBrewMethodsFilter = {
    methods: {
        processCafeBrewMethodsFilter(cafe, brewMethods) {

            // 如果冲泡方法不为空，则进行处理
            if (brewMethods.length > 0) {

                let cafeBrewMethods = [];

                // 将咖啡店所有冲泡方法都推送到cafeBrewMethods数组
                for (let index = 0; index < brewMethods.length; index++) {
                    if (cafe.brew_methods[index] === undefined) {
                        break;
                    }
                    cafeBrewMethods.push(cafe.brew_methods[index].method);
                }

                // 遍历所有待处理冲泡方法，如果在cafeBrewMethods数组中则返回true
                for (let i = 0; i < brewMethods.length; i++) {
                    if (cafeBrewMethods.indexOf(brewMethods[i]) > -1) {
                        return true;
                    }
                }

                // 如果都不在cafeBrewMethods数组中，则返回false
                return false;

            } else {
                return true;
            }
        }
    }
}