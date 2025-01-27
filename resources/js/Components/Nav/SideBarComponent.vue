<template>
    <aside :class="[
              sidebar === true ? 'translate-x-0' : '-translate-x-full',
              //isAuthenticated ? 'top-[65px]' : 'top-[115px]'
            ]"
           class="fixed top-[67px] left-0 z-50 w-64 w-full-mobile h-screen transition-transform -translate-x-full sm:translate-x-0 sidebar-color custom-side-shadow"
           aria-label="Sidebar">
        <div class="h-full pb-4 overflow-y-auto sidebar-color p-4">
            <ul>
                <li class="mb-3">
                    <div class="flex justify-between w-full gap-4">
                        <button @click.prevent="toggleMissionModal" class="btn-menu-mission border border-violet-800">
                            <div class="btn-menu-mission-text">
                                <h1>{{ $t('Mission') }}</h1>
                            </div>
                            <img :src="`/assets/images/quests.png`" alt="" width="38">
                        </button>
                        <button v-if="!isAuthenticated && setting && setting.disable_spin" @click.prevent="$router.push('/landing/spin')" class="btn-menu-rotate border border-red-500">
                            <div class="btn-menu-rotate-text">
                                <h1>{{ $t('Rotate') }} </h1>
                            </div>
                            <div class="spin-anim">
                                <img class="img-spinbg" src="data:image/png;base64,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" alt=""><img class="img-turntable" src="data:image/png;base64,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" alt=""><img class="img-pointer" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACIAAAA8CAMAAAA0RZgbAAAC91BMVEUAAABYDARfCwRRAABLAABJAABIAABKAABKBQP/1JyIRA2HRAxJAACNUBf80JqJRA355n7905uIRRCIRA2HRQ2HRQ6JRxH//9v+05v5zJn4y5jcroCJRQ6HQw3/87+CQAuISBD/+beIRQ6HRQ6JRw+OSRa5LPH577R8x5750ZT/88/+76/xvpr2xpn45YHvupznqKXzx5P66bDxxZDtwY7KoFyvfDfgsoOWWR2IRQ6FQgz+8K3+7p51PSz/8pv/98+STBP/9ND97aT88srz7cL86pX76In/8L776qPqwILYV9PRc8r14ZbxtKXXgbTkoKThw37/88v24YvXtXPXtm397aLpvIr+8r/nzHDmuIj854SmcDf+8sGjaSqKSRp9OQv/8sb96Y/QoXT765L/88DLmHB+NwuIRg+IRg/86YefaU1nIwX/87NdFQdjKB/a5sDxzYin1bbMM/GdKevdOfG0MemkLufW5L7wd/TFOebaZez24X3WQ+Xq0XPN4rGvRtzkc+X033m1SdX/9M/97J3/89Dsis/hbsL97aru1oPcdb3Ne7vqoqzUhq7+76znzXD/8sj233rev2P765H754Tau3X/88/Tr2Lnzo7/8tHJoU7/883ozW755H+6jEK2h0Xr0HPCl0fXqHfly3CmbEKRURX/77L97JjQoHb/9NLEk2xzMQm5hmG3g2CqdFmFUDr/9NL977D/1Jz/8syzOvOgJO+aJO+mLvGvK+7YYvfhUO/KO+7WRu28M+0KmpEIoY7md/nARfUMmJjlzHD+8sgNlKAMlpz865cIoIf66IDzcf6+M+7+8cL977X97aYMnZX76YvsefrNUffdM/bETPX/88/87J776pAInYv66IXx23nmZ/vCSfXMMfP+8Lz97qoOkaTpb/rVWffVMPbeQ/LUQO/LO++tKu6Bxq2/26tVsKtIqqtsvapgt6qh0aMwoaIinp7jcvinL/HCLvGnJfDcSu+xKu+t1rTr6a7R36o6o6Y1s5M3sJB1vDZKAAAAsXRSTlMABgQKDhIbGB/8ZTsVDe5w/vNQQzUwGwT45t1+elo7KycKXkgiFv7+/fzv3dza2djRw7q5q6KRiIRrV081KiAVEvv7+vrz8fDr5t/a19LR0czCt6+kop6WlpWSj4mJh4aAe25kY15dVU1MOy8pJiX9/fr5+ff19PTy8e/v6+vq6ejl4+Hg2trV1dTT09PQzsvIx8LBwcC7ubeysK6uraubl5OSiXh4cGpmWlpUTEpCMC39GEEeAAADgklEQVRIx9WTVVQbQRSGs9lslEaA0CRAKNDiDsUp1N3d3d3d3d3dXZgqdUkb0iZpCi0Ub5HiUteHDix0Z8jpc0+/zcnZm/3OzL9zb1j/OY7R0Y5/e6Qe1nPHUo/GryCNPZbv7nf6Ul1MqNu56WUzPPZiziaNpunMyQUlpUXFxUWlJQVfJ2o0ms6YMkjfLP7evecPnzx+8/jJw7t3X8fHN9MMwhS1Xv8TV37p9Wo8TMtMN1xxy2yJ540JMCyAyvOK8h/lFVVKYWZAHUSoYy3sZnAtK/wWS+P6vczN1dDV3oH9RyHk9n1ja2Ew9LWsx2KoZ2nnGevZ80SEOnLcOHXEsH4BnrGtJFY2iGJjJdmVtQoNtyGrk1CEhREJGxqNjZgforOMDcPlLBR5eGiTJkOZOsJoDB1VH1Pqj7Jrl9SdqbsntQuzaoApDazCuia1Ys5qWdJ2J2sYBTsZp2CtNrKmbKTVHhzpwMJxGGnXXDu4pjqpbX7cGUbBwzhLuiRvram6JK8OE8EoeBj42qZkx+qmtkje6WRN1FIIa6f+JtNouog0mYItmShID3xS+tD3g1NaSJxtzBQbZ8m+FB/6flvKRqEoxkyJEQkP63RVPXCU6vbYy5koyECESnVVPRit0/VnBgEPs1m6n8Vms/pIFyODgA9EN+lcgiAJH+kWZBDwgQhOTT3Uq9fR1NQD9nJmJtGTGTFw/iOaAeEOhLlDkGNHDOw0yV0A3N1bDzg7nqQdzKDGHmsNBN7t2/uKgezIeIvaDpukuEMUsnWznlayQgUCJ0AHMwgOb7hAuSjt7QvI27Q0PxDIp0g2tojFRbF4Ttz7+zRx2X7Alssh0CQcbg/QNiEhrprshASVOAougyaZIPN9AEl/CUlPh3dtgS2PJNB9hoO1V3Bk/uhOBMkLAQuvo3y47qvkUwQeZeo1nI4KqLARpTeYcRXHT4YpJM8WLMm/gZD/yUvF52Bxz4H1X57duQM/8AteLtMFQVxUISi+Uuny7BbNO3i5dACn0JeGYeBOHT7m3a4hY7ZYhXcAnh3fW9AmI+9mFZ8zpngJzvA4BD4LFmPEijU5ibnQyM2Z5w1CYBJ27VaPUQGvldMSExPbdFQIbPkUnQR3onrLgECsVADgf55LMSOFOBQ3akhQoH9QyAW+BYcxUIfkUDwuhAcFZhfMgRLJgcDnyBLmViXwH/kP+A0MspdQULbX5QAAAABJRU5ErkJggg==" alt="">
                            </div>
                        </button>
                        <button v-if="isAuthenticated" @click.prevent="$router.push('/profile/affiliate')" class="btn-refer border border-yellow-300">
                            <div class="btn-menu-rotate-text">
                                <h1>{{ $t('Refer') }}</h1>
                            </div>
                            <div class="spin-anim">
                                <img class="img-spinbg" src="data:image/png;base64,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" alt="">
                                <img :src="`/assets/images/refer.webp`" alt="" width="26">
                            </div>
                        </button>
                    </div>
                </li>
                <li v-if="!isAuthenticated" class="mb-4">
                    <button @click.prevent="$router.push('/register')"
                            type="button"
                            class="promo-register transition duration-700 text-sm ease-in-out font-bold py-2 rounded-lg px-3 w-full">
                        <div class="flex justify-center text-center self-center items-center">
                            <img :src="`/assets/images/refer.webp`" alt="" width="38" class="mr-3">
                            {{ $t('Double your balance') }}
                        </div>
                    </button>
                </li>
            </ul>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <RouterLink :to="{ name: 'home' }" active-class="category-active" class="site-menu-item flex flex-col items-center justify-center text-center p-3  rounded-xl">
                        <img :src="`/assets/images/icons/home.svg`" alt="" width="35">
                        <span class="text-[12px] mt-2">{{ $t('Home') }}</span>
                    </RouterLink>
                </div>
                <div>
                    <RouterLink :to="{ name: 'casinos' }" active-class="category-active" class="site-menu-item flex flex-col items-center justify-center text-center p-3 rounded-xl">
                        <img :src="`/assets/images/icons/fortune.svg`" alt="" width="35">
                        <span class="text-[12px] mt-2">{{ $t('Casino') }}</span>
                    </RouterLink>
                </div>
            </div>

            <div class="mt-4">
                <div class="grid grid-cols-2 gap-4 mb-4" v-if="isLoading">
                    <div v-for="i in 10" class="flex items-center justify-center h-20 max-w-sm rounded-xl animate-pulse bg-gray-100 dark:bg-gray-700">

                    </div>
                </div>

                <div v-else class="grid grid-cols-2 gap-4 mt-4 mb-4">
                    <RouterLink v-for="(category, index) in categories" :key="index" :to="{ name: 'casinosAll', params: { provider: 'all', category: category.slug }}" active-class="category-active" class="h-20 site-menu-item flex flex-col items-center justify-center text-center p-3 rounded-xl">
                        <img :src="`/storage/`+category.image" alt="" width="35">
                        <span class="text-[12px] mt-2">{{ $t(category.name) }}</span>
                    </RouterLink>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">

                <div>
                    <RouterLink :to="{ name: 'profileWallet' }" active-class="category-active" class="site-menu-item flex flex-col items-center justify-center text-center p-3 rounded-xl">
                        <img :src="`/assets/images/icons/wallet-money.svg`" alt="" width="35">
                        <span class="text-[12px] mt-2">{{ $t('Wallet') }}</span>
                    </RouterLink>
                </div>
                <div>
                    <RouterLink :to="{ name: 'favoritePage' }" active-class="category-active" class="site-menu-item flex flex-col items-center justify-center text-center p-3 rounded-xl">
                        <img :src="`/assets/images/icons/folder-favourite.svg`" alt="" width="35">
                        <span class="text-[12px] mt-2">{{ $t('Favorites') }}</span>
                    </RouterLink>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mt-4">
                <div>
                    <RouterLink :to="{ name: 'eventsPage' }" active-class="category-action" class="relative">
                        <img :src="`/assets/images/eventos.png`" alt="" class="w-full">
                        <h1 class="button-title-menu">Eventos</h1>
                    </RouterLink>
                </div>
                <div>
                    <RouterLink :to="{ name: 'recentsPage' }" active-class="category-action" class="relative">
                        <img :src="`/assets/images/juros.png`" alt="" class="w-full">
                        <h1 class="button-title-menu">{{ $t('Recents') }}</h1>
                    </RouterLink>
                </div>
                <div>
                    <RouterLink :to="{ name: 'awardsPage' }" active-class="category-action" class="relative">
                        <img :src="`/assets/images/pendente.png`" alt="" class="w-full">
                        <h1 class="button-title-menu">{{ $t('Awards') }}</h1>
                    </RouterLink>
                </div>
                <div>
                    <RouterLink :to="{ name: 'recordPage' }" active-class="category-action" class="relative">
                        <img :src="`/assets/images/rebate.png`" alt="" class="w-full">
                        <h1 class="button-title-menu">{{ $t('Records') }}</h1>
                    </RouterLink>
                </div>
                <div>
                    <RouterLink :to="{ name: 'vipPage' }" active-class="category-action" class="relative">
                        <img :src="`/assets/images/vip.png`" alt="" class="w-full">
                        <h1 class="button-title-menu">{{ $t('Vip') }}</h1>
                    </RouterLink>
                </div>
                <div>
                    <RouterLink :to="{ name: 'bonusPage' }" active-class="category-action" class="relative">
                        <img :src="`/assets/images/coletas.png`" alt="" class="w-full">
                        <h1 class="button-title-menu">{{ $t('Bonus') }}</h1>
                    </RouterLink>
                </div>
            </div>

            <ul class="font-medium mt-5 mb-[200px]">
                <li class="px-3">
                    <a @click="$router.push('/support')" href="#" class="l-5 flex items-center w-full p-2 text-gray-700 font-normal transition duration-700 rounded-lg group dark:text-gray-400 dark:hover:text-white">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.2 13.6V14.024C15.1937 14.3381 15.0645 14.6372 14.8402 14.857C14.6158 15.0769 14.3141 15.2001 14 15.2H10V16H14C14.5304 16 15.0391 15.7893 15.4142 15.4142C15.7893 15.0391 16 14.5304 16 14V12.8C15.7748 13.1052 15.5052 13.3748 15.2 13.6Z" fill="#414952"></path><path d="M0 10.5839C0.049109 9.80103 0.327312 9.04988 0.8 8.42389V8.30389C0.289133 8.88313 0.00499042 9.62758 0 10.3999C0 10.4639 0 10.5199 0 10.5839Z" fill="#414952"></path><path d="M8 0C5.87827 0 3.84344 0.842855 2.34315 2.34315C0.842855 3.84344 0 5.87827 0 8H0C0.244633 7.6957 0.529976 7.42651 0.848 7.2C1.05156 5.44594 1.89262 3.82784 3.21126 2.65338C4.5299 1.47892 6.23417 0.829998 8 0.829998C9.76583 0.829998 11.4701 1.47892 12.7887 2.65338C14.1074 3.82784 14.9484 5.44594 15.152 7.2C15.47 7.42651 15.7554 7.6957 16 8C16 5.87827 15.1571 3.84344 13.6569 2.34315C12.1566 0.842855 10.1217 0 8 0V0Z" fill="#414952"></path><path d="M3.2 7.20001C2.35131 7.20001 1.53737 7.53715 0.937258 8.13727C0.337142 8.73739 0 9.55132 0 10.4C0 11.2487 0.337142 12.0626 0.937258 12.6628C1.53737 13.2629 2.35131 13.6 3.2 13.6V7.20001Z" fill="#8C9099"></path><path d="M12.8 13.6C13.6487 13.6 14.4626 13.2629 15.0627 12.6628C15.6628 12.0626 16 11.2487 16 10.4C16 9.55132 15.6628 8.73739 15.0627 8.13727C14.4626 7.53715 13.6487 7.20001 12.8 7.20001V13.6Z" fill="#8C9099"></path><path d="M3.20001 7.20001H4.00001C4.21219 7.20001 4.41567 7.2843 4.5657 7.43433C4.71573 7.58436 4.80001 7.78784 4.80001 8.00001V12.8C4.80001 13.0122 4.71573 13.2157 4.5657 13.3657C4.41567 13.5157 4.21219 13.6 4.00001 13.6H3.20001V7.20001Z" fill="#414952"></path><path d="M12 7.20001H12.8V13.6H12C11.7878 13.6 11.5844 13.5157 11.4343 13.3657C11.2843 13.2157 11.2 13.0122 11.2 12.8V8.00001C11.2 7.78784 11.2843 7.58436 11.4343 7.43433C11.5844 7.2843 11.7878 7.20001 12 7.20001Z" fill="#414952"></path><path d="M6.8 14H9.2C9.41217 14 9.61566 14.0843 9.76569 14.2343C9.91571 14.3843 10 14.5878 10 14.8V16H6.8C6.58783 16 6.38434 15.9157 6.23431 15.7657C6.08429 15.6157 6 15.4122 6 15.2V14.8C6 14.5878 6.08429 14.3843 6.23431 14.2343C6.38434 14.0843 6.58783 14 6.8 14Z" fill="#8C9099"></path></svg>
                        <span class="ml-3">{{ $t('Support') }}</span>
                    </a>
                </li>
                <li class="px-3">
                    <a @click="$router.push('/support')" href="#" class="l-5 flex items-center w-full p-2 text-gray-700 font-normal transition duration-700 rounded-lg group dark:text-gray-400 dark:hover:text-white">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8 10C10.7614 10 13 7.76142 13 5C13 2.23858 10.7614 0 8 0C5.23858 0 3 2.23858 3 5C3 7.76142 5.23858 10 8 10Z" fill="#8C9099"></path><path d="M13.8 8.89999C12.7 10.6 10.8 11.8 8.60001 12L10.5 16L12.4 12.9L16 13.4L13.8 8.89999Z" fill="#414952"></path><path d="M2.2 8.89999L0 13.4L3.6 12.9L5.4 16L7.3 12C5.2 11.8 3.3 10.6 2.2 8.89999Z" fill="#414952"></path></svg>
                        <span class="ml-3">{{ $t('Promotions') }}</span>
                    </a>
                </li>
                <li class="px-3">
                    <a @click="$router.push('/support')" href="#" class="l-5 flex items-center w-full p-2 text-gray-700 font-normal transition duration-700 rounded-lg group dark:text-gray-400 dark:hover:text-white">
                        <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.1787 9.63885L10.0651 10.062L9.64343 10.1738L7.47002 10.7646L6.30222 16.6091C6.43671 16.7378 6.59606 16.8387 6.77085 16.9058C6.94564 16.9728 7.1323 17.0047 7.31982 16.9995C7.50733 16.9942 7.69187 16.9521 7.86254 16.8754C8.03321 16.7988 8.18652 16.6892 8.31343 16.5532L16.561 8.30548C16.8332 8.04213 16.9905 7.68478 16.9996 7.30918C17.0087 6.93358 16.8688 6.56926 16.6097 6.29346L10.7707 7.45915L10.1787 9.63885Z" fill="#414952"></path><path d="M9.7004 1.43115L1.43658 9.67885C1.16573 9.94455 1.00948 10.3029 1.00042 10.6792C0.991353 11.0556 1.13017 11.4208 1.38792 11.6989L9.49765 9.48723L11.6954 1.38324C11.5612 1.25742 11.4032 1.15886 11.2303 1.09317C11.0574 1.02748 10.8731 0.995965 10.6878 1.00041C10.5026 1.00486 10.32 1.04519 10.1506 1.1191C9.98117 1.193 9.82819 1.29904 9.7004 1.43115Z" fill="#8C9099"></path><path d="M1.18518 1.39122L6.26187 1.38324" stroke="#8C9099" stroke-miterlimit="10" stroke-linecap="round"></path><path d="M1.18518 3.7865H4.42907" stroke="#8C9099" stroke-miterlimit="10" stroke-linecap="round"></path><path d="M1.18518 6.18176H1.99615" stroke="#8C9099" stroke-miterlimit="10" stroke-linecap="round"></path><path d="M6.52948 11.1639L2.07724 12.3775L5.58065 15.8906L6.52948 11.1639Z" fill="#8C9099"></path><path d="M15.8879 5.57496L12.3845 2.06989L11.1681 6.52508L15.8879 5.57496Z" fill="#8C9099"></path></svg>
                        <span class="ml-3">{{ $t('Refer a friend') }}</span>
                    </a>
                </li>
                <li class="px-3">
                    <a @click="$router.push('/support-center')" href="#" class="transition duration-700 bg-gray-100 dark:bg-transparent hover:bg-gray-200 dark:hover:bg-transparent flex items-center p-2 text-gray-700 font-normal rounded-lg dark:text-gray-400 dark:hover:text-white group">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_31_225)"><path d="M4 8H0V12.9C0 13.9 0.7 14.8 1.7 15C2.9 15.2 4 14.2 4 13V8Z" fill="#414952"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M15 1H6.99999C6.39999 1 5.99999 1.4 5.99999 2V13C5.99999 13.7 5.79999 14.4 5.39999 15H13C14.7 15 16 13.7 16 12V2C16 1.4 15.6 1 15 1ZM13.6 5H8.79999V7H13.6V5ZM8.79999 9H13.6V11H8.79999V9Z" fill="#8C9099"></path></g><defs><clipPath id="clip0_31_225"><rect width="16" height="16" fill="white"></rect></clipPath></defs></svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">{{ $t('Support Center') }}</span>
                    </a>
                </li>
            </ul>
        </div>

    </aside>
</template>

<script>
import {onMounted} from "vue";
import { sidebarStore } from "@/Stores/SideBarStore.js";
import { RouterLink } from "vue-router";
import HttpApi from "@/Services/HttpApi.js";
import {useToast} from "vue-toastification";
import {useAuthStore} from "@/Stores/Auth.js";
import {useSettingStore} from "@/Stores/SettingStore.js";
import {missionStore} from "@/Stores/MissionStore.js";

export default {
    props: [],
    components: { RouterLink },
    data() {
        return {
            sidebar: false,
            isLoading: true,
            categories: [],
            sportsCategories: [],
            modalMission: null,
            setting: null,
        }
    },
    setup(props) {
        onMounted(() => {

        });

        return {};
    },
    computed: {
        sidebarMenuStore() {
            return sidebarStore()
        },
        sidebarMenu() {
            const sidebar = sidebarStore()
            return sidebar.getSidebarStatus;
        },
        isAuthenticated() {
            const authStore = useAuthStore();
            return authStore.isAuth;
        },
    },
    mounted() {
    },
    methods: {
        toggleMenu() {
            this.sidebarMenuStore.setSidebarToogle();
        },
        toggleMissionModal: function() {
            const missionDataStore = missionStore();
            missionDataStore.setMissionToogle();
        },
        getCasinoCategories: function() {
            const _this = this;
            const _toast = useToast();
            _this.isLoading = true;

            HttpApi.get('categories')
                .then(response => {
                    _this.categories = response.data.categories;
                    _this.isLoading = false;
                })
                .catch(error => {
                    Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                        _toast.error(`${value}`);
                    });
                    _this.isLoading = false;
                });
        },
        getSetting: function() {
            const _this = this;
            const settingStore = useSettingStore();
            const settingData = settingStore.setting;

            if(settingData) {
                _this.setting = settingData;
            }
        },
    },
    created() {
        this.getCasinoCategories();
        this.getSetting();
    },
    watch: {
        sidebarMenu(newVal, oldVal) {
            this.sidebar = newVal;
        }
    },
};
</script>

<style scoped>

</style>
