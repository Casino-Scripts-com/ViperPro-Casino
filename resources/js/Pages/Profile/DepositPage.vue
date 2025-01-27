<template>
    <BaseLayout>
        <div class="md:w-4/6 2xl:w-4/6 mx-auto p-4 mt-20">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 z-[999999]">
                <div class="col-span-1 hidden md:block">
                    <WalletSideMenu />
                </div>
                <div class="col-span-2 relative">
                    <DepositWidget />
                </div>
            </div>
        </div>
    </BaseLayout>
</template>


<script>

import { RouterLink } from "vue-router";
import BaseLayout from "@/Layouts/BaseLayout.vue";
import DepositWidget from "@/Components/Widgets/DepositWidget.vue";
import WalletSideMenu from "@/Pages/Profile/Components/WalletSideMenu.vue";
import {useAuthStore} from "@/Stores/Auth.js";

export default {
    props: [],
    components: {WalletSideMenu, DepositWidget, BaseLayout, RouterLink },
    data() {
        return {
            isLoading: false,

        }
    },
    setup(props) {


        return {};
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
    created() {

    },
    watch: {

    },
};
</script>

<style scoped>

</style>
