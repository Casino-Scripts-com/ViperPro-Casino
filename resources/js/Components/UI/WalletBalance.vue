<template>
    <button v-if="wallet?.total_balance === undefined || isLoadingWallet" disabled type="button" class="flex justify-center items-center mr-3 pt-1">
        <svg aria-hidden="true" role="status" class="inline w-4 h-4 mr-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
        </svg>
        {{ $t('Loading') }}...
    </button>
    <button @click="$router.push('/profile/wallet')" v-else type="button" class="flex justify-center items-center mr-3 pt-1 wallet-money">
        <div class="mr-2">
            <img :src="`/assets/images/coin/`+wallet?.currency+`.png`" alt="" width="20">
        </div>
        <div>
            <strong>{{ state.currencyFormat(wallet?.total_balance, wallet?.currency) }}</strong>
        </div>
<!--        <div class="ml-2 text-sm">-->
<!--            <i class="fa-solid fa-chevron-down"></i>-->
<!--        </div>-->
    </button>
</template>

<script>
    import HttpApi from "@/Services/HttpApi.js";
    import {onMounted, ref, watch, watchEffect} from "vue";
    import {useRoute} from "vue-router";

    export default {
        props: [],
        components: {},
        data() {
            return {
                isLoadingWallet: true,
                wallet: null,
                processInterval: null,
            }
        },
        setup(props) {
            const route = useRoute();
            const isCasinoPlayPage = ref(false);

            watchEffect(() => {
                checkRoute();
            });

            onMounted(() => {
                checkRoute();
            });

            function checkRoute() {
                // Verifique se a rota atual é 'casinoPlayPage'
                isCasinoPlayPage.value = route.name === 'casinoPlayPage';
            }

            return {
                isCasinoPlayPage
            };
        },
        computed: {

        },
        beforeUnmount() {
            clearInterval(this.processInterval);
        },
        mounted() {

        },
        methods: {
            getWallet: async function() {
                const _this = this;

                await HttpApi.get('profile/wallet')
                    .then(response => {
                        _this.wallet = response.data.wallet;
                        _this.isLoadingWallet = false;
                    })
                    .catch(error => {
                        Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                            console.log(`${value}`);
                        });
                        _this.isLoadingWallet = false;
                    });
            },
        },
        async created() {
            if(this.isCasinoPlayPage) {
                this.processInterval = setInterval(async  () => {
                    await this.getWallet(); // Substitua 'seuMetodo' pelo nome do seu método
                }, 5000);
            }

            await this.getWallet(); // Substitua 'seuMetodo' pelo nome do seu método
        },
        watch: {

        },
    };
</script>

<style scoped>

</style>
