<template>
    <BaseLayout>
        <div class="container mx-auto p-4 mt-20 relative  min-h-[calc(100vh-565px)]">
            <div v-if="wallet && !isLoading" class="grid grid-cols-1 md:grid-cols-3 gap-0 md:gap-4">
                <div v-if="isShowForm" class="col-span-1 bg-gray-100 dark:bg-gray-800 shadow-lg rounded-bl-lg rounded-br-lg mb-3">
                    <div class="flex flex-col w-full bg-gradient-to-r from-violet-900 to-violet-950 p-5 rounded-lg">
                        <div class="invite-bg ">
                            <h1 class="text-white tex-lg md:text-2xl font-bold">{{  $t('INVITE A FRIEND') }}:</h1>

<!--                            <div class="mt-5">-->
<!--                                <p class="mb-1 text-white tex-sm md:text-base"><strong class="text-yellow-400">$1,000.00</strong> {{ $t('REFERRAL REWARDS') }}</p>-->
<!--                                <p class="mb-1 text-white tex-sm md:text-base"><strong class="text-yellow-400">{{ state.currencyFormat(parseFloat(userData.affiliate_cpa), wallet.currency) }}%</strong> {{ $t('COMMISSION REWARDS') }}</p>-->
<!--                            </div>-->
                        </div>
                    </div>
                    <div class="mt-3 p-4">
                        <div class="flex flex-col mb-4">
                            <label for="reference-code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $t('Reference Code') }}</label>
                            <div class="relative w-full">
                                <input type="text"
                                       id="referenceCode"
                                       class="block p-4 w-full z-20 text-sm text-gray-900 border-gray-300 bg-gray-50 rounded-lg rounded-gray-100 focus:border-gray-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-gray-500"
                                       :placeholder="$t('Reference Code')"
                                       v-model="referencecode"
                                       required>
                                <button @click.prevent="copyCode" type="submit"
                                        class="absolute top-0 end-0 py-2 px-4 h-full text-gray-500 dark:text-white bg-gray-200 rounded-e-lg focus:outline-none focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                                    <i class="fa-duotone fa-copy text-2xl"></i>
                                </button>
                            </div>
                        </div>

                        <div class="flex flex-col">
                            <label for="reference-code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $t('Reference Link') }}</label>
                            <div class="relative w-full">
                                <input type="text"
                                       id="referenceLink"
                                       class="block p-4 w-full z-20 text-sm text-gray-900 border-gray-300 bg-gray-50 rounded-lg rounded-gray-100 focus:border-gray-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-gray-500"
                                       :placeholder="$t('Reference Link')"
                                       v-model="referencelink"
                                       required>
                                <button @click.prevent="copyLink" type="submit"
                                        class="absolute top-0 end-0 py-2 px-4 h-full text-gray-500 dark:text-white bg-gray-200 rounded-e-lg focus:outline-none focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                                    <i class="fa-duotone fa-copy text-2xl"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mt-16 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <button @click.prevent="generateCode" type="button" class="ui-button-yellow">
                                {{ $t('Create another code') }}
                            </button>
                            <button type="button" class="ui-button-default">
                                {{ $t('Share on social media') }}
                            </button>
                        </div>

                        <div class="mt-5 flex justify-end items-end">
                            <button @click="$router.push('/terms-conditions/reference')" type="button" class="text-gray-500 hover:text-gray-600 dark:text-gray-300 hover:dark:text-gray-400">
                                {{ $t('Terms and Conditions of Reference') }} <i class="fa-regular fa-arrow-right ml-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div v-else class="relative flex flex-col items-center justify-center text-center p-6">
                    <div v-if="!isLoadingGenerate" class="">
                        <p class="text-gray-400">
                            {{ $t('Generate the code Description') }}
                        </p>
                        <div class="mt-5 w-full">
                            <button @click.prevent="generateCode" type="button" class="ui-button-violet w-full">
                                {{ $t('Generate the code') }}
                            </button>
                        </div>
                    </div>

                    <div v-if="isLoadingGenerate" role="status" class="absolute -translate-x-1/2 -translate-y-1/2 top-2/4 left-1/2">
                        <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-green-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
                        <span class="sr-only">{{ $t('Loading') }}...</span>
                    </div>
                </div>
                <div class="col-span-2 w-full">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-0 md:gap-4">
                        <div class="flex items-center bg-white dark:bg-gray-800 p-4 shadow-lg w-full mb-3 dark:border-gray-700">
                            <div class="w-20 mr-3">
                                <img :src="`/assets/images/trophy.png`" alt="">
                            </div>
                            <div class="w-full">
                                <h1 class="text-base">{{ $t('TOTAL REWARD RECEIVED') }}:</h1>
                                <h2 class="text-yellow-400 font-bold text-2xl">{{ state.currencyFormat(parseFloat(wallet.refer_rewards), wallet.currency) }}</h2>
                            </div>
                            <button @click.prevent="opemModalWithdrawal" type="button" class="dark:bg-gray-600 py-4 px-6 h-full ml-3 flex items-center justify-center">
                                {{ $t('Withdraw') }}
                            </button>
                        </div>
                        <div class="flex items-center bg-white dark:bg-gray-800 px-4 py-2 shadow-lg w-full mb-3 dark:border-gray-700">
                            <div class="w-20 mr-3">
                                <img :src="`/assets/images/usehead.b760e9be.png`" alt="">
                            </div>
                            <div>
                                <h1 class="text-base">{{ $t('TOTAL REFERRED FRIENDS') }}:</h1>
                                <h2 class="text-yellow-400 font-bold text-2xl">{{ indications }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-0 md:gap-4 mt-3">
                        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 w-full mb-3">
                            <div class="header flex justify-between">
                                <div class="flex items-center">
                                    <img :src="`/assets/images/network.a415d3eb.png`" alt="" width="28">
                                    <h2 class="ml-3">{{ $t('REFERRAL REVSHARE') }}</h2>
                                </div>
                                <button @click.prevent="toggleCommissionRewards" type="button" class="flex items-center text-green-500 font-bold">
                                    {{ $t('Details') }}
                                    <i class="fa-solid fa-chevron-right ml-2"></i>
                                </button>
                            </div>

                            <div class="body flex flex-col justify-center items-center py-8">
                                <h1 class="text-yellow-400 font-bold text-4xl">{{ userData.affiliate_revenue_share }}%</h1>
                            </div>
                        </div>
                        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 w-full mb-3">
                            <div class="header flex justify-between">
                                <div class="flex items-center">
                                    <img :src="`/assets/images/discount.bf090f3a.png`" alt="" width="28">
                                    <h2 class="ml-3">{{ $t('COMMISSION CPA') }}</h2>
                                </div>
                                <button @click.prevent="toggleReferenceRewards" type="button" class="flex items-center text-green-500 font-bold">
                                    {{ $t('Details') }}
                                    <i class="fa-solid fa-chevron-right ml-2"></i>
                                </button>
                            </div>

                            <div class="body flex flex-col justify-center items-center py-8">
                                <h1 class="text-yellow-400 font-bold text-4xl">{{ state.currencyFormat(parseFloat(userData.affiliate_cpa), wallet.currency) }}</h1>
                            </div>
                        </div>
                    </div>

                    <div class="flex shadow dark:bg-gray-800 dark:border-gray-700 w-full rounded-lg">
                        <div class="p-4">
                            <img :src="`/assets/images/indique.png`" alt="" class="mr-3">
                        </div>
                        <div class="flex flex-col justify-center  p-4">
                            <h1 class="text-2xl font-bold mb-3">Solicite o acesso</h1>
                            <p class="text-gray-500">Nossa plataforma dispõe de um painel de afiliados avançado, permitindo que você visualize detalhes sobre ganhos e perdas. Além disso, oferece a capacidade de adicionar subafiliados.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else role="status" class="absolute -translate-x-1/2 -translate-y-1/2 top-2/4 left-1/2 h-full mt-16">
                <div class="text-center flex flex-col justify-center items-center">
                    <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-green-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
                    <span class="mt-3">{{ $t('Loading') }}...</span>
                </div>
            </div>
        </div>

        <!-- MODAL RECOMPENSAS DE REFERÊNCIA -->
        <div id="referenceRewardsEl" tabindex="-1" aria-hidden="true" class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full overflow-y-auto overflow-x-hidden p-4 md:inset-0">
            <div class="relative max-h-full w-full max-w-2xl">
                <!-- Modal content -->
                <div class="relative rounded-lg bg-white shadow dark:bg-gray-700">

                    <!-- Modal header -->
                    <div class="flex justify-between p-4 dark:bg-gray-600 rounded-t-lg">
                        <h1>{{ $t('Referral Reward Rules') }}</h1>
                        <button class="" @click.prevent="toggleReferenceRewards">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>

                    <!-- Modal body -->
                    <div class="w-full flex justify-center p-4">
                        <div class="flex items-center">
                            <div class="l"></div>
                            <div class="text-white px-3">
                                Regras de Desbloqueio
                            </div>
                            <div class="r"></div>
                        </div>


                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL RECOMPENSAS POR COMISSÃO -->
        <div id="commissionRewardsEl" tabindex="-1" aria-hidden="true" class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full overflow-y-auto overflow-x-hidden p-4 md:inset-0">
            <div class="relative max-h-full w-full max-w-2xl">
                <!-- Modal content -->
                <div class="relative rounded-lg bg-white shadow dark:bg-gray-700">

                    <!-- Modal header -->
                    <div class="flex justify-between p-4 dark:bg-gray-600 rounded-t-lg">
                        <h1>Regras de recompensas por comissão</h1>
                        <button class="" @click.prevent="toggleCommissionRewards">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>

                    <!-- Modal body -->
                    <div class="flex flex-col  w-full justify-center p-4">
                        <div class="flex items-center text-center w-full justify-center">
                            <div class="l"></div>
                            <div class="text-white px-3">
                                Taxas de comissões
                            </div>
                            <div class="r"></div>
                        </div>

                        <div class="mt-5">
                            <ul>
                                <li class="flex dark:bg-gray-800 shadow rounded-lg aposta-1 w-full p-4 mb-3">
                                    <div>
                                        <h1 class="font-mono text-4xl font-bold">7%</h1>
                                        <p class="text-gray-400 text-sm"><strong class="text-gray-400">Jogo:</strong> Os Jogos Originais</p>
                                    </div>
                                </li>
                                <li class="flex dark:bg-gray-800 shadow rounded-lg aposta-2 w-full p-4 mb-3">
                                    <div>
                                        <h1 class="font-mono text-4xl font-bold">7%</h1>
                                        <p class="text-gray-400 text-sm"><strong class="text-gray-400">Jogo:</strong> slots de terceiros, cassino ao vivo</p>
                                    </div>
                                </li>
                                <li class="flex dark:bg-gray-800 shadow rounded-lg aposta-3 w-full p-4 mb-3">
                                    <div>
                                        <h1 class="font-mono text-4xl font-bold">25%</h1>
                                        <p class="text-gray-400 text-sm"><strong class="text-gray-400">Jogo:</strong> Esportes</p>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="mt-5 ml-4">
                            <ul class="list-outside list-disc">
                                <li class="mb-3">
                                    Em qualquer ambiente público (por exemplo, universidades, escolas, bibliotecas e espaços de escritório), apenas uma comissão pode ser paga para cada usuário,
                                    endereço IP, dispositivo eletrônico, residência, número de telefone, método de cobrança, endereço de e-mail e computador e IP endereço compartilhado com outras pessoas.
                                </li>
                                <li class="mb-3">
                                    Nossa decisão de fazer uma aposta será baseada inteiramente em nosso critério depois que um depósito for feito e uma aposta for feita com sucesso.
                                </li>
                                <li class="mb-3">
                                    As comissões podem ser retiradas em nossa carteira CREDK interna do painel a qualquer momento. (Veja a extração de sua comissão no painel e visualize o saldo na carteira).
                                </li>
                                <li class="mb-3">
                                    Apoiamos a maioria das moedas no mercado.
                                </li>
                                <li class="mb-3">
                                    O sistema calcula a comissão a cada 24 horas.
                                </li>
                            </ul>
                        </div>

                        <div class="mt-5 w-full border dark:border-gray-500 p-4 rounded">
                            Se você tiver alguma dúvida sobre nossas regras, por favor <a href="" class="text-green-500 font-bold"> Contate-nos </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>


        <!-- MODAL SAQUE -->
        <div id="withdrawalEl" tabindex="-1" aria-hidden="true" class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full overflow-y-auto overflow-x-hidden p-4 md:inset-0">
            <div class="relative max-h-full w-full max-w-2xl">
                <!-- Modal content -->
                <div class="relative rounded-lg bg-white shadow dark:bg-gray-700">

                    <!-- Modal header -->
                    <div class="flex justify-between p-4 dark:bg-gray-600 rounded-t-lg">
                        <h1>Regras de recompensas por comissão</h1>
                        <button class="" @click.prevent="opemModalWithdrawal">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>

                    <!-- Modal body -->
                    <div class="flex flex-col  w-full justify-center p-4">
                        <form action="" @submit.prevent="makeWithdrawal">
                            <div class="dark:text-gray-400 mb-3">
                                <label for="">Valor do Saque</label>
                                <input v-model="withdrawalForm.amount" type="number" class="input" placeholder="Valor do saque" required>
                                <span v-if="wallet" class="text-sm italic">Saldo: {{ state.currencyFormat(parseFloat(wallet?.refer_rewards), wallet?.currency) }}</span>
                            </div>

                            <div class="dark:text-gray-400 mb-3">
                                <label for="">Chave Pix</label>
                                <input v-model="withdrawalForm.pix_key" type="text" class="input" placeholder="Digite a sua Chave pix" required>
                            </div>

                            <div class="dark:text-gray-400 mb-3">
                                <label for="">Tipo de Chave</label>
                                <select v-model="withdrawalForm.pix_type" name="type_document" class="input" required>
                                    <option value="">Selecione uma chave</option>
                                    <option value="document">CPF/CNPJ</option>
                                    <option value="email">E-mail</option>
                                    <option value="phoneNumber">Telefone</option>
                                    <option value="randomKey">Chave Aleatória</option>
                                </select>
                            </div>

                            <button type="submit" class="mt-5 w-full bg-green-800 text-white hover:bg-green-600 px-4 py-2 transition duration-700">
                                Solicitar agora <i class="fa-regular fa-arrow-right ml-2"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </BaseLayout>
</template>


<script>

import BaseLayout from "@/Layouts/BaseLayout.vue";
import { Modal } from 'flowbite';
import HttpApi from "@/Services/HttpApi.js";
import {useToast} from "vue-toastification";
import {useAuthStore} from "@/Stores/Auth.js";
import {useRouter} from "vue-router";

export default {
    props: [],
    components: { BaseLayout, Modal },
    data() {
        return {
            isLoading: false,
            referenceRewards: null,
            commissionRewards: null,
            isShowForm: false,
            isLoadingGenerate: false,
            code: '',
            urlCode: '',
            referencecode: '',
            referencelink: '',
            wallet: null,
            indications: 0,
            histories: null,
            withdrawalModal: null,
            withdrawalForm: {
                amount: 0,
                pix_key: '',
                pix_type: '',
            }
        }
    },
    setup(props) {
        const router = useRouter();
        return {
            router
        };
    },
    computed: {
        userData() {
            const authStore = useAuthStore();
            return authStore.user;
        }
    },
    mounted() {
        this.referenceRewards = new Modal(document.getElementById('referenceRewardsEl'), {
            placement: 'center',
            backdrop: 'dynamic',
            backdropClasses: 'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40',
            closable: true,
            onHide: () => {

            },
            onShow: () => {

            },
            onToggle: () => {

            },
        });

        this.commissionRewards = new Modal(document.getElementById('commissionRewardsEl'), {
            placement: 'center',
            backdrop: 'dynamic',
            backdropClasses: 'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40',
            closable: true,
            onHide: () => {

            },
            onShow: () => {

            },
            onToggle: () => {

            },
        });

        this.withdrawalModal = new Modal(document.getElementById('withdrawalEl'), {
            placement: 'center',
            backdrop: 'dynamic',
            backdropClasses: 'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40',
            closable: true,
            onHide: () => {

            },
            onShow: () => {

            },
            onToggle: () => {

            },
        });
    },
    methods: {
        copyCode: function(event) {
            const _toast = useToast();
            var inputElement = document.getElementById("referenceCode");
            inputElement.select();
            inputElement.setSelectionRange(0, 99999);  // Para dispositivos móveis

            // Copia o conteúdo para a área de transferência
            document.execCommand("copy");
            _toast.success(this.$t('Code copied successfully'));
        },
        copyLink: function(event) {
            const _toast = useToast();
            var inputElement = document.getElementById("referenceLink");
            inputElement.select();
            inputElement.setSelectionRange(0, 99999);  // Para dispositivos móveis

            // Copia o conteúdo para a área de transferência
            document.execCommand("copy");
            _toast.success(this.$t('Link copied successfully'));
        },
        getCode: function() {
            const _this = this;
            const _toast = useToast();
            _this.isLoadingGenerate = true;

            HttpApi.get('profile/affiliates/')
                .then(response => {
                    if( response.data.code !== '' && response.data.code !== undefined && response.data.code !== null) {
                        _this.isShowForm = true;
                        _this.code          = response.data.code;
                        _this.referencecode = response.data.code;
                        _this.urlCode       = response.data.url;
                    }

                    _this.indications   = response.data.indications;
                    _this.referencelink = response.data.url;
                    _this.wallet        = response.data.wallet;
                    _this.withdrawalForm.amount = response.data.wallet.refer_rewards;

                    _this.isLoadingGenerate = false;
                })
                .catch(error => {
                    _this.isShowForm = false;
                    _this.isLoadingGenerate = false;
                });
        },
        generateCode: function(event) {
            const _this = this;
            const _toast = useToast();
            _this.isLoadingGenerate = true;

            HttpApi.get('profile/affiliates/generate')
                .then(response => {
                    if(response.data.status) {
                        _this.getCode();
                        _toast.success(_this.$t('Your code was generated successfully'));
                    }

                    _this.isLoadingGenerate = false;
                })
                .catch(error => {
                    Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                        _toast.error(`${value}`);
                    });
                    _this.isLoadingGenerate = false;
                });
        },
        toggleCommissionRewards: function(event) {
            this.commissionRewards.toggle();
        },
        toggleReferenceRewards: function(event) {
            this.referenceRewards.toggle();
        },
        opemModalWithdrawal: function() {
            this.withdrawalModal.toggle();
        },
        makeWithdrawal: async function() {
            const _this = this;
            const _toast = useToast();

            _this.isLoading = true;

            HttpApi.post('profile/affiliates/request', _this.withdrawalForm)
                .then(response => {
                    _toast.success(_this.$t(response.data.message));
                    _this.isLoading = false;
                    _this.router.push({ name: 'profileWallet' });
                })
                .catch(error => {
                    Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                        _toast.error(`${value}`);
                    });
                    _this.isLoading = false;
                });
        }
    },
    created() {
      this.getCode();
    },
    watch: {

    },
};
</script>

<style scoped>

</style>
