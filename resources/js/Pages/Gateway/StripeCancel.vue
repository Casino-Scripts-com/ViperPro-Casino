<template>
    <AuthLayout>
        <div class="my-auto mt-36">
            <div class="px-4 py-5">
                <div class="min-h-[calc(100vh-565px)] text-center flex flex-col items-center justify-center">
                    <img :src="`/assets/images/error.png`" alt="" class="w-36">
                    <div class="mt-5 mb-5 text-center">
                        <h1 class="text-2xl">{{ $t('Transaction Canceled') }}</h1>
                    </div>
                    <button @click="$router.push('/')" class="ui-button-blue rounded">{{ $t('Click here to return') }}</button>
                </div>
            </div>
        </div>
    </AuthLayout>
</template>


<script>

import {useAuthStore} from "@/Stores/Auth.js";
import AuthLayout from "@/Layouts/AuthLayout.vue";

export default {
    props: [],
    components: { AuthLayout },
    data() {
        return {
            isLoading: false,

        }
    },
    setup(props) {

    },
    computed: {
        isAuthenticated() {
            const authStore = useAuthStore();
            return authStore.isAuth;
        },
    },
    mounted() {

    },
    methods: {

    },
    watch: {

    },
};
</script>

<style scoped>

</style>
