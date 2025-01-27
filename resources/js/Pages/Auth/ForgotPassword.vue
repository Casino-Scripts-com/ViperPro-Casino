<template>
    <AuthLayout>
        <LoadingComponent :isLoading="isLoading">
            <div class="text-center">
                <span>{{ $t('Loading') }}</span>
            </div>
        </LoadingComponent>
        <div v-if="!isLoading" class="my-auto mt-36">
            <div class="px-4 py-5">
                <div class="min-h-[calc(100vh-565px)] text-center flex flex-col items-center justify-center">
                    <div class="w-full rounded-lg shadow-lg border-none md:mt-0 sm:max-w-md xl:p-0 bg-base">
                        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                            <h1 class="mb-8 text-3xl text-center">{{ $t('Forgot Password') }}</h1>

                            <div class="mt-4 px-4">
                                <form @submit.prevent="forgotPasswordSubmit" method="post" action="" class="">
                                    <div class="relative mb-3">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                            <i class="fa-regular fa-envelope text-success-emphasis"></i>
                                        </div>
                                        <input type="email"
                                               name="email"
                                               v-model="form.email"
                                               class="input-group"
                                               :placeholder="$t('Enter email or phone')"
                                               required
                                        >
                                    </div>
                                    <div class="mt-5 w-full">
                                        <button type="submit" class="ui-button-blue rounded w-full mb-3">
                                            {{ $t('Reset Password') }}
                                        </button>
                                    </div>
                                </form>
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
import {useRouter} from "vue-router";
import LoadingComponent from "@/Components/UI/LoadingComponent.vue";

export default {
    props: [],
    components: {LoadingComponent, AuthLayout },
    data() {
        return {
            isLoading: false,
            form: {
                email: '',
            },
        }
    },
    setup(props) {
        const router = useRouter();
        return {
            router
        };
    },
    computed: {
        isAuthenticated() {
            const authStore = useAuthStore();
            return authStore.isAuth;
        },
    },
    mounted() {
        const router = useRouter();
        if(this.isAuthenticated) {
            router.push({ name: 'home' });
        }
    },
    methods: {
        forgotPasswordSubmit: async function(event) {
            const _this = this;
            const _toast = useToast();
            _this.isLoading = true;

            await HttpApi.post('auth/forget-password', _this.form)
                .then(async response =>  {

                    _this.isLoading = false;
                    _toast.success('Um token foi enviado para você em sua caixa de E-mail!');
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
    watch: {

    },
};
</script>

<style scoped>

</style>
