<template>
    <div class="flex sm:hidden">
        <div class="fixed z-40 w-full h-16 max-w-lg -translate-x-1/2 bg-white border border-gray-200 rounded-full bottom-4 left-1/2 dark:bg-gray-800 dark:border-gray-800">
            <div class="grid h-full max-w-lg grid-cols-5 mx-auto">
                <button @click="$router.push('/')" data-tooltip-target="tooltip-home" type="button" class="inline-flex flex-col items-center justify-center px-5 rounded-l-full hover:bg-gray-50 dark:hover:bg-gray-800 group">
                    <i class="fa-duotone fa-house-chimney mb-1 text-xl"></i>
                    <span class="text-[12px]">{{ $t('Home') }}</span>
                </button>
                <div id="tooltip-home" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                    {{ $t('Home') }}
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
                <button @click="$router.push('/casinos')" data-tooltip-target="tooltip-casino" type="button" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 dark:hover:bg-gray-800 group">
                    <i class="fa-duotone fa-dice mb-1 text-xl"></i>
                    <span class="text-[12px]">{{ $t('Casino') }}</span>
                </button>
                <div id="tooltip-casino" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                    {{ $t('Casino') }}
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
                <div class="flex items-center justify-center">
                    <button @click="$router.push('/profile/deposit')" data-tooltip-target="tooltip-new" type="button" class="inline-flex items-center justify-center w-10 h-10 font-medium bg-green-700 rounded-full hover:bg-green-700 group focus:ring-4 focus:ring-green-300 focus:outline-none dark:focus:ring-blue-800">
                        <i class="fa-solid fa-dollar-sign"></i>
                        <span class="sr-only">{{ $t('Deposit') }}</span>
                    </button>
                </div>
                <div id="tooltip-new" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                    {{ $t('New Deposit') }}
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
                <button @click="$router.push('/profile/affiliate')" data-tooltip-target="tooltip-sport" type="button" class="inline-flex flex-col items-center justify-center px-5 rounded-r-full hover:bg-gray-50 dark:hover:bg-gray-800 group">
                    <i class="fa-solid fa-users mb-1 text-xl"></i>
                    <span class="text-[12px]">Convidar</span>
                </button>
                <div id="tooltip-sport" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                    Convidar
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
                <button @click="$router.push('/profile/wallet')" data-tooltip-target="tooltip-wallet" type="button" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 dark:hover:bg-gray-800 group">
                    <i class="fa-duotone fa-wallet mb-1 text-xl"></i>
                    <span class="text-[12px]">{{ $t('Wallet') }}</span>
                </button>
                <div id="tooltip-wallet" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                    {{ $t('Wallet') }}
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    props: [],
    components: {},
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
