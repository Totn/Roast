<style scoped lang="scss">
    @import '~@/abstracts/_variables.scss';
    @import '~@/components/_validations.scss';
</style>

<template>
    <div class="page">
        <form action="">
            <div class="grid-container">
                <div class="grid-x grid-padding">
                    <div class="large-12 medinum-12 samll-12 cell">
                        <label for="">名称
                            <input type="text" placeholder="咖啡店名" v-model="name">
                        </label>
                        <span class="validation" v-show="!validations.name.is_valid">{{ validations.name.text }}</span>
                    </div>
                    
                    <div class="large-12 medinum-12 samll-12 cell">
                        <label for="">网址
                            <input type="text" placeholder="网址" v-model="website">
                        </label>
                        <span class="validation" v-show="!validations.website.is_valid">{{ validations.website.text }}</span>
                    </div>
                    
                    <div class="large-12 medinum-12 samll-12 cell">
                        <label for="">简介
                            <input type="text" placeholder="简介" v-model="description">
                        </label>
                    </div>
                    <div class="grid-x grid-padding-x" v-for="(location, key) in locations" :key="key">
                        <div class="large-12 medinum-12 samll-12 cell">
                            <h3>位置</h3>
                        </div>
                        <div class="large-6 medium-6 small-12 cell">
                            <label for="">详细地址
                                <input type="text" placeholder="地址"  v-model="locations[key].address">
                            </label>
                            <span class="validation" v-show="!validations.locations[key].address.is_valid">{{ validations.locations[key].address.text }}</span>
                        </div>
                        <div class="large-6 medium-6 small-12 cell">
                            <label for="">城市
                                <input type="text" placeholder="城市" v-model="locations[key].city">
                            </label>
                            <span class="validation" v-show="!validations.locations[key].city.is_valid">{{ validations.locations[key].city.text }}</span>
                        </div>
                        <div class="large-6 medium-6 small-12 cell">
                            <label for="">省份
                                <input type="text" placeholder="省份" v-model="locations[key].state">
                            </label>
                            <span class="validation" v-show="!validations.locations[key].state.is_valid">{{ validations.locations[key].state.text }}</span>
                        </div>
                        <div class="large-6 medium-6 small-12 cell">
                            <label for="">邮编
                                <input type="text" placeholder="邮编" v-model="locations[key].zip">
                            </label>
                            <span class="validation" v-show="!validations.locations[key].zip.is_valid">{{ validations.locations[key].zip.text }}</span>
                        </div>
                        <!-- 支持的冲泡方法 -->
                        <div class="large-12 medium-12 small-12 cell">
                            <label for="">支持的冲泡方法</label>
                            <span class="brew-method" :key="brewMethod.id" v-for="brewMethod in brewMethods">
                                <input type="checkbox" :id="'brew-method-'+brewMethod.id+'-'+key"
                                    :value="brewMethod.id"
                                    v-model="locations[key].methodsAvailable">
                                <label v-bind:for="'brew-method-'+brewMethod.id+'-'+key">{{ brewMethod.method }}</label>
                            </span>
                        </div>
                        <!-- 标签输入框 -->
                        <div class="large-12 medium-12 small-12 cell">
                            <tags-input v-bind:unique="key"></tags-input>
                        </div>
                        <div class="large-12 medium-12 small-12 cell">
                            <a class="button" v-on:click="removeLocation(key)">移除位置</a>
                        </div>
                    </div>

                    <div class="grid-x grid-padding-x">
                        <div class="large-12 medium-12 small-12 cell">
                            <a class="button" v-on:click="addLocation()">新增位置</a>
                        </div>
                        <div class="large-12 medium-12 small-12 cell">
                            <a class="button" v-on:click="submitNewCafe">提交</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    import TagsInput from "../components/global/forms/TagsInput.vue";
    import { EventBus } from "../event-bus.js";
    export default {
        components: {
            TagsInput
        },
        created() {
            this.addLocation();
        },
        mounted() {
            EventBus.$on('tags-edited', function (tagsAdded) {
                // 绑定方法，组件中触发tags-edited方法
                this.locations[tagsAdded.unique].tags = tagsAdded.tags;
            }.bind(this));
        },
        data() {
            return {
                name: '',
                locations: [],
                website: '',
                description: '',
                roaster: '',
                validations: {
                    name: {
                        is_valid: true,
                        text: ''
                    },
                    locations: [],
                    oneLocation: {
                        is_valid: true,
                        text: ''
                    },
                    website: {
                        is_valid: true,
                        text: ''
                    }

                }
            }
        },
        computed: {
            brewMethods() {
                return this.$store.getters.getBrewMethods;
            },
            addCafeStatus() {
                return this.$store.getters.getCafeAddStatus;
            }
        },
        methods: {
            submitNewCafe () {
                if (this.validateNewCafe()) {
                    this.$store.dispatch('addCafe', {
                        name: this.name,
                        locations: this.locations,
                        website: this.website,
                        description: this.description,
                        roaster: this.roaster
                    });
                }

            },
            validateNewCafe () {
                let validNewCafeForm = true;

                for (let index in this.locations) {
                    let _ele = {};
                    if (this.locations.hasOwnProperty(index)) {
                        _ele = this.validations.locations[index];
                        
                        _ele.address.is_valid = true;
                        _ele.city.is_valid = true;
                        _ele.state.is_valid = true;
                        _ele.zip.is_valid = true;

                        _ele.address.text = '';
                        _ele.city.text = '';
                        _ele.state.text = '';
                        _ele.zip.text = '';
                        
                        // 确保地址字段不为空
                        if (this.locations[index].address.trim() === '') {
                            validNewCafeForm = false;
                            _ele.address.is_valid = false;
                            _ele.address.text = '请输入新咖啡店的详细地址';
                        }
                        // 确保城市字段不为空
                        if (this.locations[index].city.trim() === '') {
                            validNewCafeForm = false;
                            _ele.city.is_valid = false;
                            _ele.city.text = '请输入新咖啡店所在城市';
                        }
                        // 确保省份字段不为空
                        if (this.locations[index].state.trim() === '') {
                            validNewCafeForm = false;
                            _ele.state.is_valid = false;
                            _ele.state.text = '请输入新咖啡店所在省份';
                        }
                        // 确保邮编字段不为空
                        if (this.locations[index].zip.trim() === '' || !this.locations[index].zip.match(/(^\d{6}$)/)) {
                            validNewCafeForm = false;
                            _ele.zip.is_valid = false;
                            _ele.zip.text = '请输入新咖啡店的正确邮编号码';
                        }
                    }
                    
                }

                this.validations.name.is_valid = true;
                this.validations.website.is_valid = true;

                this.validations.name.text = '';
                this.validations.website.text = '';

                if (this.name.trim() === '') {
                    validNewCafeForm = false;
                    this.validations.name.is_valid = false;
                    this.validations.name.text = '请输入咖啡店的名字！';
                }

                if (this.website.trim() === '' && !this.website.match(/^((https?):\/\/)?([w|W]{3}\.)+[a-zA-Z0-9\-\.]{3,}\.[a-zA-Z]{2,}(\.[a-zA-Z]{2,})?$/)) {
                    validNewCafeForm = false;
                    this.validations.website.is_valid = false;
                    this.validations.website.text = '请输入有效的网址URL！';
                    
                }


                return validNewCafeForm;
            },
            addLocation() {
                this.locations.push({
                    name: '',
                    address: '',
                    city: '',
                    state: '',
                    zip: '',
                    methodsAvailable: []
                });
                this.validations.locations.push({
                    address: {
                        is_valid: true,
                        text: ''
                    },
                    city: {
                        is_valid: true,
                        text: ''
                    },
                    state: {
                        is_valid: true,
                        text: ''
                    },
                    zip: {
                        is_valid: true,
                        text: ''
                    }
                });
            },
            removeLocation(key) {
                this.locations.splice(key, 1);
                this.validations.locations.splice(key, 1)
            },
            clearForm() {
                this.name = '';
                this.locations = [];
                this.website = '';
                this.description = '';
                this.roaster = false;
                this.validations = {
                    name: {
                        is_valid: true,
                        text: ''
                    },
                    locations: [],
                    oneLocation: {
                        is_valid: true,
                        text: ''
                    },
                    website: {
                        is_valid: true,
                        text: ''
                    }
                };

                // 清理输入标签
                EventBus.$emit('clear-tags');
            }
        },
        watch: {
            addCafeStatus: function () {
                if (this.addCafeStatus === 2) {
                    // 添加成功
                    this.clearForm();
                    $("#cafe-added-successfully").show().delay(5000).fadeOut();
                }

                if (this.addCafeStatus === 3) {
                    // 添加失败
                    $("#cafe-added-unsuccessfully").show().delay(5000).fadeOut();
                    
                }
            }
        }
    };
</script>