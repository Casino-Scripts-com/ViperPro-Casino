<template>
    <NavTopComponent :simple="false" />
    <div class="" :class="''">
        <div class="relative">
            <slot></slot>

            <FooterComponent v-once />
            <BottomNavComponent v-once/>
        </div>
    </div>

    <CookiesComponent v-once />
</template>

<script>
import NavTopComponent from "@/Components/Nav/NavTopComponent.vue";
import SideBarComponent from "@/Components/Nav/SideBarComponent.vue";
import FooterComponent from "@/Components/UI/FooterComponent.vue";
import BottomNavComponent from "@/Components/Nav/BottomNavComponent.vue";
import CookiesComponent from "@/Components/UI/CookiesComponent.vue";
import {useAuthStore} from "@/Stores/Auth.js";

export default {
    props: [],
    components: {CookiesComponent, BottomNavComponent, FooterComponent, SideBarComponent, NavTopComponent },
    data() {
        return {
            logo: '/assets/images/logo_verde.png',
            isLoading: false,
        }
    },
    computed: {
        isAuthenticated() {
            const authStore = useAuthStore();
            return authStore.isAuth;
        },
    },
};
</script>
