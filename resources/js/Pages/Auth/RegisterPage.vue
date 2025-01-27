<template>
    <AuthLayout>
        <LoadingComponent :isLoading="isLoading">
            <div class="text-center">
                <span>{{ $t('Loading') }}</span>
            </div>
        </LoadingComponent>
        <div v-if="!isLoading" class="my-auto">
            <div class="px-4 py-5">
                <div class="min-h-[calc(100vh-565px)] text-center flex flex-col items-center justify-center">
                    <div class="w-full bg-white rounded-lg shadow-lg md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-700 dark:border-gray-700">
                        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                            <h1 class="mb-8 text-3xl text-center">{{ $t('Register') }}</h1>

                            <div class="mt-4 px-4">
                                <form @submit.prevent="registerSubmit" method="post" action="" class="">
                                    <div class="relative mb-3">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                            <i class="fa-regular fa-user text-success-emphasis"></i>
                                        </div>
                                        <input type="text"
                                               name="name"
                                               v-model="registerForm.name"
                                               class="input-group"
                                               :placeholder="$t('Enter name')"
                                               required
                                        >
                                    </div>

                                    <div class="relative mb-3">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                            <i class="fa-regular fa-envelope text-success-emphasis"></i>
                                        </div>
                                        <input type="email"
                                               name="email"
                                               v-model="registerForm.email"
                                               class="input-group"
                                               :placeholder="$t('Enter email or phone')"
                                               required
                                        >
                                    </div>

                                    <div class="relative mb-3">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                            <i class="fa-light fa-address-card text-success-emphasis"></i>
                                        </div>
                                        <input type="text"
                                               name="cpf"
                                               v-model="registerForm.cpf"
                                               class="input-group"
                                               :placeholder="$t('Enter cpf')"
                                               required
                                        >
                                    </div>

                                    <div class="relative mb-3">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                            <i class="fa-regular fa-lock text-success-emphasis"></i>
                                        </div>
                                        <input :type="typeInputPassword"
                                               name="password"
                                               v-model="registerForm.password"
                                               class="input-group pr-[40px]"
                                               :placeholder="$t('Type the password')"
                                               required
                                        >
                                        <button type="button" @click.prevent="togglePassword" class="absolute inset-y-0 right-0 flex items-center pr-3.5 ">
                                            <i v-if="typeInputPassword === 'password'" class="fa-regular fa-eye"></i>
                                            <i v-if="typeInputPassword === 'text'" class="fa-sharp fa-regular fa-eye-slash"></i>
                                        </button>
                                    </div>

                                    <div class="relative mb-3">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                            <i class="fa-regular fa-lock text-success-emphasis"></i>
                                        </div>
                                        <input :type="typeInputPassword"
                                               name="password_confirmation"
                                               v-model="registerForm.password_confirmation"
                                               class="input-group pr-[40px]"
                                               :placeholder="$t('Confirm the Password')"
                                               required
                                        >
                                        <button type="button" @click.prevent="togglePassword" class="absolute inset-y-0 right-0 flex items-center pr-3.5">
                                            <i v-if="typeInputPassword === 'password'" class="fa-regular fa-eye"></i>
                                            <i v-if="typeInputPassword === 'text'" class="fa-sharp fa-regular fa-eye-slash"></i>
                                        </button>
                                    </div>
                                    <div class="relative mb-3">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                            <i class="fa-regular fa-phone"></i>
                                        </div>
                                        <input type="text"
                                               name="phone"
                                               v-maska
                                               data-maska="[
                                    '(##) ####-####',
                                    '(##) #####-####'
                                  ]"
                                               v-model="registerForm.phone"
                                               class="input-group"
                                               :placeholder="$t('Enter your phone')"
                                               required
                                        >
                                    </div>

                                    <div class="mb-3 mt-5">
                                        <button @click.prevent="isReferral = !isReferral" type="button" class="flex justify-between w-full">
                                            <p>{{ $t('Enter Referral/Promo Code') }}</p>
                                            <div class="">
                                                <i v-if="isReferral" class="fa-solid fa-chevron-up"></i>
                                                <i v-if="!isReferral" class="fa-solid fa-chevron-down"></i>
                                            </div>
                                        </button>

                                        <div v-if="isReferral" class="relative mb-3 mt-1">
                                            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                                <i class="fa-regular fa-user text-success-emphasis"></i>
                                            </div>
                                            <input type="text" name="name" v-model="registerForm.reference_code" class="input-group" :placeholder="$t('Code')">
                                        </div>
                                    </div>

                                    <hr class="mb-3 mt-2 dark:border-gray-600">

                                    <div class="mb-3 mt-11">
                                        <div class="flex">
                                            <input id="term-a" v-model="registerForm.term_a" name="term_a" required type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="term-a" class="ml-2 text-sm font-medium text-left text-gray-900 dark:text-gray-300">{{ $t('I agree to the User Agreement & confirm I am at least 18 years old') }}</label>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="flex items-center">
                                            <input id="term-agreement" v-model="registerForm.agreement" name="term_b" required type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="term-agreement" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $t('I agree with the') }} <a href="#" class="text-primary hover:underline">{{ $t('terms and conditions') }}</a>.</label>
                                        </div>
                                    </div>

                                    <div class="mt-5 w-full">
                                        <button type="submit" class="ui-button-blue rounded w-full mb-3">
                                            {{ $t('Register') }}
                                        </button>
                                    </div>
                                </form>

                                <div class="login-wrap mt-5">
                                    <div class="line-text">
                                        <div class="l"></div>
                                        <div class="t">{{ $t('Register with your social networks') }}</div>
                                        <div class="l"></div>
                                    </div>

                                    <div class="social-group mt-3">
                                        <a :href="redirectSocialTo()" class="text-social-button hover:text-white focus:ring-4 focus:outline-none font-medium text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:hover:text-white ">
                                            <i class="fa-brands fa-google"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthLayout>
</template>


<script>

import {useToast} from "vue-toastification";
import {useAuthStore} from "@/Stores/Auth.js";
import HttpApi from "@/Services/HttpApi.js";
import AuthLayout from "@/Layouts/AuthLayout.vue";
import {useRoute, useRouter} from "vue-router";
import {onMounted, reactive} from "vue";
import {useSpinStoreData} from "@/Stores/SpinStoreData.js";
import LoadingComponent from "@/Components/UI/LoadingComponent.vue";

export default {
    props: [],
    components: {LoadingComponent, AuthLayout },
    data() {
        return {
            isLoading: false,
            typeInputPassword: 'password',
            isReferral: false,
            registerForm: {
                name: '',
                email: '',
                password: '',
                cpf: '',
                password_confirmation: '',
                reference_code: '',
                term_a: false,
                agreement: false,
                spin_data: null
            },
        }
    },
    setup() {
        const router = useRouter();
        const routeParams = reactive({
            code: null,
        });

        onMounted(() => {
            const params = new URLSearchParams(window.location.search);
            if (params.has('code')) {
                routeParams.code = params.get('code');
            }
        });

        return {
            routeParams,
            router
        };
    },
    computed: {
        isAuthenticated() {
            const authStore = useAuthStore();
            return authStore.isAuth;
        },
    },
    beforeUnmount() {

    },
    mounted() {
        const router = useRouter();
        if(this.isAuthenticated) {
            router.push({ name: 'home' });
        }

        if (this.router.currentRoute.value.params.code) {
            try {
                const str = atob(this.router.currentRoute.value.params.code);
                const obj = JSON.parse(str);


                this.registerForm.spin_token = this.router.currentRoute.value.params.code;
            } catch (e) {
                this.registerForm.reference_code = this.routeParams.code;
                this.isReferral = true;
            }
        }else if(this.routeParams.code) {
            this.registerForm.reference_code = this.routeParams.code;
            this.isReferral = true;
        }
    },
    methods: {
        redirectSocialTo: function() {
            return '/auth/redirect/google'
        },
        togglePassword: function() {
            if(this.typeInputPassword === 'password') {
                this.typeInputPassword = 'text';
            }else{
                this.typeInputPassword = 'password';
            }
        },
        registerSubmit: async function(event) {
            const _this = this;
            const _toast = useToast();
            _this.isLoading = true;

            const authStore = useAuthStore();
            await HttpApi.post('auth/register', _this.registerForm)
                .then(response => {
                    if(response.data.access_token !== undefined) {
                        authStore.setToken(response.data.access_token);
                        authStore.setUser(response.data.user);
                        authStore.setIsAuth(true);

                        _this.registerForm = {
                            name: '',
                            email: '',
                            password: '',
                            password_confirmation: '',
                            reference_code: '',
                            term_a: false,
                            agreement: false,
                            spin_data: null
                        };

                        _this.router.push({ name: 'profileDeposit' });
                        _toast.success(_this.$t('Your account has been created successfully'));
                    }

                    _this.isLoading = false;
                })
                .catch(error => {
                    const _this = this;
                    Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                        _toast.error(`${value}`);
                    });
                    _this.isLoading = false;
                });
        },
    },
    created() {

    },
    watch: {

    },
};
</script>

<style scoped>

</style>
