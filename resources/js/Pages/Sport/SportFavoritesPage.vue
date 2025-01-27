<template>
    <BaseLayout>
        <div class="p-4">
            <div class="bets-header font-bold">
                <div class="flex items-center text-3xl">
                    <svg data-cy="ic-favourites-title" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg" style="fill: currentcolor; color: rgb(255, 190, 3); width: auto; height: 32px;">
                        <path d="M15.0554 4.71739C15.3667 3.82183 16.6333 3.82183 16.9446 4.71739L19.2982 11.4886C19.4356 11.8837 19.8043 12.1516 20.2224 12.1601L27.3896 12.3061C28.3375 12.3254 28.7289 13.53 27.9733 14.1028L22.2609 18.4337C21.9276 18.6864 21.7867 19.1198 21.9078 19.5201L23.9837 26.3816C24.2583 27.2891 23.2336 28.0336 22.4554 27.492L16.5712 23.3975C16.2279 23.1586 15.7721 23.1586 15.4288 23.3975L9.54463 27.492C8.76639 28.0336 7.74174 27.2891 8.01629 26.3816L10.0922 19.5201C10.2133 19.1198 10.0724 18.6864 9.73915 18.4337L4.02666 14.1028C3.27112 13.53 3.6625 12.3254 4.61043 12.3061L11.7776 12.1601C12.1957 12.1516 12.5644 11.8837 12.7018 11.4886L15.0554 4.71739Z" fill="#FFBE03"></path>
                    </svg>
                    <h1 class="ml-2 xl">{{ $t('Favorites') }}</h1>
                </div>
            </div>

            <div class=" mt-16 mb-16">
                <div class="flex flex-col w-full text-center justify-center items-center ">
                    <div class="mt-5">
                        <p class="text-2xl">
                            Você precisa fazer o login para ver seus eventos favoritos.
                        </p>
                    </div>

                    <RouterLink :to="{ name: 'home' }" class="uppercase mt-5 text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" active-class="top-menu-active" >
                        Iniciar sessão
                    </RouterLink>

                </div>
            </div>
        </div>
    </BaseLayout>
</template>


<script>

import BaseLayout from "@/Layouts/BaseLayout.vue";

export default {
    props: [],
    components: {BaseLayout},
    data() {
        return {
            isLoading: false,
        }
    },
    setup(props) {


        return {};
    },
    computed: {

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
