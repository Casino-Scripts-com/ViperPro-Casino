<template>
    <button @click.prevent="toggleModal" class="text-[28px] text-gray-500 dark:text-gray-500 mr-3 mt-1">
        <i class="fa-light fa-earth-americas"></i>
    </button>

    <div id="drawer-language" class="fixed top-0 right-0 z-40 h-screen p-4 overflow-y-auto transition-transform translate-x-full bg-white w-80 dark:bg-gray-800" tabindex="-1" >
        <h5 class="inline-flex items-center mb-4 text-base font-semibold text-gray-500 dark:text-gray-400">
            <svg class="w-4 h-4 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            {{ $t('Select language') }}
        </h5>
        <button @click.prevent="toggleModal" type="button" aria-controls="drawer-right-example" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 right-2.5 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white" >
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
            <span class="sr-only">Close menu</span>
        </button>

        <div class="relative h-[calc(100%_-_64px)] w-full px-10">
            <div class="grid grid-cols-3 py-6">
                <div class="relative my-4 flex items-center justify-center">
                    <div class="relative">
                        <input type="radio" v-model="language" value="en" name="language_selection" class="peer absolute start-0 top-0 z-20 h-full w-full cursor-pointer opacity-0" />
                        <div class="border-gray-200 peer-checked:border-primary-500 dark:border-gray-600 flex h-14 w-14 items-center justify-center rounded-full border-2 shadow-lg transition-all duration-300">
                            <img class="h-10 w-10 rounded-full" :src="`/assets/images/lang/united-states-of-america.svg`" alt="flag icon" />
                        </div>
                        <div class="bg-primary-500 dark:border-gray-800 absolute -end-1 -top-1 hidden h-7 w-7 items-center justify-center rounded-full border-4 border-white text-white peer-checked:flex">
                            <svg data-v-26e5b7b0="" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="icon h-3 w-3" width="1em" height="1em" viewBox="0 0 24 24">
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 6L9 17l-5-5"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="relative my-4 flex items-center justify-center">
                    <div class="relative">
                        <input type="radio" v-model="language" value="pt_BR" name="language_selection" class="peer absolute start-0 top-0 z-20 h-full w-full cursor-pointer opacity-0" />
                        <div class="border-gray-200 peer-checked:border-primary-500 dark:border-gray-600 flex h-14 w-14 items-center justify-center rounded-full border-2 shadow-lg transition-all duration-300">
                            <img class="h-10 w-10 rounded-full" :src="`/assets/images/lang/brasil.svg`" alt="flag icon" />
                        </div>
                        <div class="bg-primary-500 dark:border-gray-800 absolute -end-1 -top-1 hidden h-7 w-7 items-center justify-center rounded-full border-4 border-white text-white peer-checked:flex">
                            <svg data="" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="icon h-3 w-3" width="1em" height="1em" viewBox="0 0 24 24">
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 6L9 17l-5-5"></path>
                            </svg>
                        </div>
                    </div>
                </div>
<!--                <div class="relative my-4 flex items-center justify-center">-->
<!--                    <div class="relative">-->
<!--                        <input type="radio" v-model="language" value="es" name="language_selection" class="peer absolute start-0 top-0 z-20 h-full w-full cursor-pointer opacity-0" />-->
<!--                        <div class="border-gray-200 peer-checked:border-primary-500 dark:border-gray-600 flex h-14 w-14 items-center justify-center rounded-full border-2 shadow-lg transition-all duration-300">-->
<!--                            <img class="h-10 w-10 rounded-full" :src="`/assets/images/lang/spain.svg`" alt="flag icon" />-->
<!--                        </div>-->
<!--                        <div class="bg-primary-500 dark:border-gray-800 absolute -end-1 -top-1 hidden h-7 w-7 items-center justify-center rounded-full border-4 border-white text-white peer-checked:flex">-->
<!--                            <svg data-v-26e5b7b0="" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="icon h-3 w-3" width="1em" height="1em" viewBox="0 0 24 24">-->
<!--                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 6L9 17l-5-5"></path>-->
<!--                            </svg>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
            </div>
            <div>
                <img :src="`/assets/images/lang/translation.svg`" class="mx-auto w-full max-w-[280px] dark:hidden" alt="illustration" />
                <img :src="`/assets/images/lang/translation-dark.svg`" class="mx-auto hidden w-full max-w-[280px] dark:block" alt="illustration" />
            </div>
        </div>

    </div>
</template>

<script>
    import { initFlowbite, Drawer } from 'flowbite';
    import {onMounted, reactive} from "vue";
    import HttpApi from "@/Services/HttpApi.js";
    import { loadLanguageAsync } from 'laravel-vue-i18n';
    import {useRouter} from "vue-router";

    export default {
        props: [],
        components: { Drawer },
        data() {
            return {
                isLoading: false,
                drawer: null,
                language: 'en',
            }
        },
        setup(props) {
            const router = useRouter();
            const routeParams = reactive({
                lang: null,
            });

            onMounted(() => {
                initFlowbite();

                const params = new URLSearchParams(window.location.search);
                if (params.has('lang')) {
                    routeParams.lang = params.get('lang');
                }
            });


            return {
                routeParams,
                router
            };
        },
        computed: {

        },
        mounted() {
            if(document.getElementById('drawer-language')) {
                const options = {
                    placement: 'right',
                    backdrop: true,
                    bodyScrolling: false,
                    edge: false,
                    edgeOffset: '',
                    backdropClasses: 'bg-gray-900 bg-opacity-50 dark:bg-opacity-80 fixed inset-0 z-30',
                    onHide: () => {

                    },
                    onShow: () => {

                    },
                    onToggle: () => {

                    }
                };

                this.drawer = new Drawer(document.getElementById('drawer-language'), options);
            }

            if(this.routeParams.lang) {
                this.updateLangWithParam(this.routeParams.lang);
            }
        },
        methods: {
            updateLangWithParam: async function(language) {
                if(language === 'pt-br') {
                    language = 'pt_BR';
                }
                loadLanguageAsync(language);

                await HttpApi.put('/profile/updateLanguage', { language: language })
                    .then(response => {

                    })
                    .catch(error => { });
            },
            toggleModal() {
                this.drawer.toggle();
            },
            getLanguage: async function() {
                const _this = this;
                _this.isLoading = true;

                await HttpApi.post('/profile/getLanguage', {  })
                    .then(response => {
                        loadLanguageAsync(response.data.language);
                        _this.language = response.data.language;
                        _this.isLoading = false;
                    })
                    .catch(error => {
                        const _this = this;
                        Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {

                        });
                        _this.isLoading = false;
                    });
            },
            updateLanguage: async function() {
                const _this = this;

                if(!this.routeParams.lang) {
                    _this.isLoading = true;
                    loadLanguageAsync(_this.language);

                    await HttpApi.put('/profile/updateLanguage', { language: _this.language })
                        .then(response => {
                            _this.isLoading = false;
                        })
                        .catch(error => {
                            const _this = this;
                            Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {

                            });
                            _this.isLoading = false;
                        });
                }
            }
        },
        created() {
            this.getLanguage();
        },
        watch: {
            language(newValue, oldValue) {
                this.language = newValue;
                this.updateLanguage();
            }
        },
    };
</script>

<style scoped>

</style>

