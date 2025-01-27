<template>
    <nav class="fixed navbar top-0 z-50 w-full navtop-color border-none custom-box-shadow">
        <div class="px-3 lg:px-5 lg:pl-3 nav-menu">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start py-3">
                    <button @click.prevent="toggleMenu" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                        </svg>
                    </button>
                    <a v-if="setting" href="/" class="flex ml-2 md:mr-24">
                        <div class="hidden sm:block">
                            <img :src="`/storage/`+setting.software_logo_black" alt="" class="h-8 mr-3 block dark:hidden " />
                            <img :src="`/storage/`+setting.software_logo_white" alt=""  class="h-8 mr-3 hidden dark:block" />
                        </div>
                        <div class="block sm:hidden">
                            <img :src="`/storage/`+setting.software_favicon" class="h-10 mr-3" alt="" />
                        </div>
                    </a>
                </div>
                <div class="hidden md:block">

                </div>
                <div v-if="!simple" class="flex items-center py-3">

                    <div v-if="!isAuthenticated" class="flex ml-5">
                        <button @click.prevent="loginToggle">{{ $t('Log in') }}</button>
                        <button @click.prevent="registerToggle" class="ui-button-blue ml-3 mr-3 rounded">{{ $t('Register') }}</button>
                    </div>


                    <div v-if="isAuthenticated" class="flex items-center">
                        <WalletBalance />
                        <MakeDeposit :showMobile="false" :title="$t('Deposit')" />
                        <LanguageSelector />
                        <DropdownDarkLight/>

                        <div class="flex items-center ml-3">
                            <div>
                                <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" aria-expanded="false" data-dropdown-toggle="dropdown-user">
                                    <span class="sr-only">Open user menu</span>
                                    <img class="w-8 h-8 rounded-full" :src="userData?.avatar ? '/storage/'+userData.avatar : `/assets/images/profile.jpg`" alt="">
                                </button>
                            </div>
                            <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600" id="dropdown-user">
                                <div class="px-4 py-3" role="none">
                                    <p class="text-sm text-gray-900 dark:text-white" role="none">
                                        {{ userData?.name }}
                                    </p>
                                    <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none">
                                        {{ userData?.email }}
                                    </p>
                                </div>
                                <ul class="py-1" role="none">
                                    <li>
                                        <RouterLink :to="{ name: 'home' }" active-class="link-active" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white">
                                            <span class="w-8 h-8 mr-3">
                                                <i class="fa-duotone fa-house"></i>
                                            </span>
                                            {{ $t('Dashboard') }}
                                        </RouterLink>
                                    </li>
                                    <li>
                                        <RouterLink :to="{ name: 'profileAffiliate' }" active-class="profile-menu-active" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white">
                                            <span class="w-8 h-8 mr-3">
                                                <i class="fa-duotone fa-people-group"></i>
                                            </span>
                                            {{ $t('Affiliate') }}
                                        </RouterLink>
                                    </li>
                                    <li>
                                        <RouterLink :to="{ name: 'profileDeposit' }" active-class="profile-menu-active" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white">
                                            <span class="w-8 h-8 mr-3">
                                                <i class="fa-regular fa-money-bill-trend-up"></i>
                                            </span>
                                            {{ $t('Deposit') }}
                                        </RouterLink>
                                    </li>
                                    <li>
                                        <RouterLink :to="{ name: 'profileWithdraw' }" active-class="profile-menu-active" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white">
                                            <span class="w-8 h-8 mr-3">
                                                <i class="fa-light fa-money-bill-transfer"></i>
                                            </span>
                                            {{ $t('Withdraw') }}
                                        </RouterLink>
                                    </li>
                                    <li>
                                        <RouterLink :to="{ name: 'profileWallet' }" active-class="profile-menu-active" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white">
                                            <span class="w-8 h-8 mr-3">
                                              <i class="fa-duotone fa-wallet"></i>
                                            </span>
                                            {{ $t('My Wallet') }}
                                        </RouterLink>
                                    </li>
                                    <li>
                                        <a href="#" @click.prevent="profileToggle" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">
                                            <span class="w-8 h-8 mr-3">
                                               <i class="fa-regular fa-id-card-clip"></i>
                                            </span>
                                            {{ $t('My Profile') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a @click.prevent="logoutAccount" href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">
                                             <span class="w-8 h-8 mr-3">
                                               <i class="fa-duotone fa-right-from-bracket"></i>
                                            </span>
                                            {{ $t('Sign out') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <transition name="fade">
            <div v-if="showSearchMenu" class="fixed top-0 left-0 right-0 bottom-0 flex items-center justify-center ">
                <div @click="toggleSearch" class="absolute inset-0 carousel_banners opacity-50 cursor-pointer"></div>

                <!-- Start searchbar action -->
                <div class="search-menu p-4 sm:ml-64">

                    <div class="mb-5 w-full">
                        <div class="md:w-4/6 2xl:w-4/6 mx-auto">
                            <div class="flex flex-col">
                                <div class="relative w-full">
                                    <input type="search"
                                           v-model="searchTerm"
                                           class="block dark:focus:border-green-500 p-2.5 w-full z-20 text-sm text-gray-900 input-color-primary rounded-lg border focus:outline-none dark:border-gray-600 dark:placeholder-gray-400 dark:text-white "
                                           placeholder="Nome do jogo | Provedor"
                                           required>

                                    <button v-if="searchTerm.length > 0" @click.prevent="clearData" type="button" class="absolute top-0 end-0 h-full p-2.5 text-sm font-medium text-white rounded-e-lg dark:bg-[#1C1E22] ">
                                        <span class="">Recusar</span>
                                    </button>
                                </div>
                                <div class="text-center mt-4">
                                    <p>A pesquisa requer pelo menos 3 caracteres</p>
                                </div>
                            </div>

                            <div v-if="!isLoadingSearch" class="mt-8 grid grid-cols-3 md:grid-cols-6 gap-4 py-5">
                                <CassinoGameCard
                                    v-if="games"
                                    v-for="(game, index) in games?.data"
                                    :index="index"
                                    :title="game.game_name"
                                    :cover="game.cover"
                                    :gamecode="game.game_code"
                                    :type="game.distribution"
                                    :game="game"
                                />
                            </div>
                            <div v-else class="relative items-center block max-w-sm p-6 bg-white border border-gray-100 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-800 dark:hover:bg-gray-700">
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white opacity-20">Noteworthy technology acquisitions 2021</h5>
                                <p class="font-normal text-gray-700 dark:text-gray-400 opacity-20">Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological order.</p>
                                <div role="status" class="absolute -translate-x-1/2 -translate-y-1/2 top-2/4 left-1/2">
                                    <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End searchbar action -->


            </div>
        </transition>

    </nav>

    <div id="modalElAuth" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full overflow-x-hidden overflow-y-auto md:inset-0 h-screen md:h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-3xl max-h-full bg-base rounded-lg shadow-lg">
            <div class="flex md:justify-between">
                <div class="w-full p-0 hidden md:block">
                    <img :src="`/assets/images/br_bg.png`" alt="" class="w-full h-full">
                </div>
                <div class="w-full relative p-5">
                    <div v-if="isLoadingLogin" class="absolute top-0 left-0 right-0 bottom-0 bg-white/70 dark:bg-gray-800/70 z-[999]">
                        <div role="status" class="absolute -translate-x-1/2 -translate-y-1/2 top-2/4 left-1/2">
                            <svg aria-hidden="true" class="w-10 h-10 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-green-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>

                    <form @submit.prevent="loginSubmit" method="post" action="" class="">
                        <div class="flex justify-between mb-6">
                            <h5 class="mb-3 font-bold text-xl">{{ $t('Log in') }}</h5>
                            <a @click.prevent="loginToggle" href="">
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                        </div>

                        <div class="relative mb-3">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                <i class="fa-regular fa-envelope text-success-emphasis"></i>
                            </div>
                            <input required type="text" v-model="loginForm.email" name="email" class="input-group" :placeholder="$t('Enter email or phone')">
                        </div>

                        <div class="relative mb-6">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                <i class="fa-regular fa-lock text-success-emphasis"></i>
                            </div>
                            <input required :type="typeInputPassword"
                                   v-model="loginForm.password"
                                   name="password"
                                   class="input-group pr-[40px]"
                                   :placeholder="$t('Type the password')">
                            <button type="button" @click.prevent="togglePassword" class="absolute inset-y-0 right-0 flex items-center pr-3.5 ">
                                <i v-if="typeInputPassword === 'password'" class="fa-regular fa-eye"></i>
                                <i v-if="typeInputPassword === 'text'" class="fa-sharp fa-regular fa-eye-slash"></i>
                            </button>
                        </div>
                        <a href="/forgot-password" class="text-white text-sm">{{ $t('Forgot password') }}</a>

                        <div class="mt-3 w-full">
                            <button type="submit" class="ui-button-blue rounded w-full mb-3">
                                {{ $t('Log in') }}
                            </button>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-300 mb-6">Novo por aqui? <a href="" @click.prevent="hideLoginShowRegisterToggle"><strong>Criar conta</strong></a></p>
                    </form>

                    <div class="login-wrap mt-5">
                        <div class="line-text">
                            <div class="l"></div>
                            <div class="t">{{ $t('Log in directly with') }}</div>
                            <div class="l"></div>
                        </div>

                        <div class="social-group mt-3">
                            <a :href="redirectSocialTo()" class="text-green-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                                <i class="fa-brands fa-google"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="modalElRegister" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full overflow-x-hidden overflow-y-auto md:inset-0 h-screen md:h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-3xl max-h-full bg-base rounded-lg shadow-lg">
            <div v-if="isLoadingRegister" class="absolute top-0 left-0 right-0 bottom-0 bg-white/70 dark:bg-gray-800/70 z-[999]">
                <div role="status" class="absolute -translate-x-1/2 -translate-y-1/2 top-2/4 left-1/2">
                    <svg aria-hidden="true" class="w-10 h-10 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
                    <span class="sr-only">Loading...</span>
                </div>
            </div>

            <div class="flex md:justify-between h-full">
                <div class="w-full p-0 hidden md:block dark:bg-[#1A1C1F]">
                    <img :src="`/assets/images/br_bg.png`" alt="" class="w-full h-full">
                </div>
                <div class="w-full relative p-5 m-auto">
                    <form @submit.prevent="registerSubmit" method="post" action="" class="">
                        <div class="flex justify-between mb-6">
                            <h5 class="mb-3 font-bold text-xl">{{ $t('Register') }}</h5>
                            <a @click.prevent="registerToggle" href="">
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                        </div>

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
                                <input id="link-checkbox" v-model="registerForm.term_a" name="term_a" required type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="link-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $t('I agree to the User Agreement & confirm I am at least 18 years old') }}</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="flex items-center">
                                <input id="link-checkbox-b" v-model="registerForm.agreement" name="term_b" required type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="link-checkbox-b" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $t('I agree with the') }} <a href="#" class="text-blue-600 dark:text-blue-500 hover:underline">{{ $t('terms and conditions') }}</a>.</label>
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
                            <a :href="redirectSocialTo()" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                                <i class="fa-brands fa-google"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="modalProfileEl" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full overflow-x-hidden overflow-y-auto md:inset-0 h-screen md:h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl md:max-w-lg max-h-full bg-white dark:bg-gray-900 rounded-lg shadow-lg">
            <div v-if="!isLoadingProfile" class="flex flex-col">

                <!-- PROFILE HEADER -->
                <div class="flex justify-between w-full p-4">
                    <h1 class="text-2xl font-bold">{{ $t('User data') }}</h1>
                    <button @click.prevent="profileToggle" type="button" class="text-2xl">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <!-- PROFILE BODY -->
                <div v-if="profileUser != null" class="flex flex-col w-full p-4">

                    <!-- PROFILE INFO -->
                    <div class="flex items-center self-center justify-between w-full">
                        <button @click.prevent="like(profileUser.id)" type="button" class="heart">
                            <i class="fa-solid fa-heart"></i>
                            <span class="ml-2">{{ profileUser.totalLikes }}</span>
                        </button>
                        <div class="text-center flex flex-col justify-center self-center items-center">
                            <div class="relative">
                                <img class="w-24 h-246 p-1 rounded-full ring-2 ring-gray-300 dark:ring-gray-500"
                                     :src="avatarUrl"
                                     alt="">
                                <input ref="fileInput" type="file" style="display: none" @change="handleFileChange">
                                <button @click="openFileInput" type="button" class="absolute bottom-0 right-0 text-3xl">
                                    <i class="fa-duotone fa-image"></i>
                                </button>
                            </div>
                            <div class="relative">
                                <input @change.prevent="updateName" v-model="profileName" type="text" :readonly="!readonly" class="mt-4 appearance-none border border-gray-300 rounded-md p-2 bg-transparent border-none text-center" :placeholder="profileName" >
                            </div>
                        </div>
                        <div class="">
                            <button @click.prevent="readonly = !readonly" type="button" class="bg-gray-200 hover:bg-gray-400 dark:bg-gray-600 hover:dark:bg-gray-700 w-10 h-10  rounded">
                                <i v-if="!readonly" class="fa-sharp fa-light fa-pen"></i>
                                <i v-if="readonly" class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mt-3 shadow flex flex-col bg-gray-100 dark:bg-gray-900 rounded-lg">
                        <div class="flex justify-between px-4 pt-4">
                            <h1><span class="mr-2"><i class="fa-solid fa-chart-mixed"></i></span> {{ $t('Statistics') }}</h1>
                        </div>
                        <div class="p-4">
                            <div class="grid grid-cols-3 gap-4">
                                <div class="bg-gray-200 dark:bg-gray-700 text-center p-4">
                                    <p class="text-[12px]">{{ $t('Total winnings') }}</p>
                                    <p class="text-2xl font-bold">
                                        {{ totalEarnings }}
                                    </p>
                                </div>
                                <div class="bg-gray-200 dark:bg-gray-700 text-center p-4">
                                    <p class="text-[12px]">{{ $t('Total bets') }}</p>
                                    <p class="text-2xl font-bold">{{ totalBets }}</p>
                                </div>
                                <div class="bg-gray-200 dark:bg-gray-700 text-center p-4">
                                    <p class="text-[12px]">{{ $t('Total bet') }}</p>
                                    <p class="text-2xl font-bold">{{ sumBets }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="py-3 text-center">
                        <p>ingressou em {{ profileUser.dateHumanReadable }}</p>
                    </div>

                </div>
            </div>
            <div v-if="isLoadingProfile" class="flex flex-col w-full h-full">
                <div role="status" class="absolute -translate-x-1/2 -translate-y-1/2 top-2/4 left-1/2">
                    <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
                    <span class="sr-only">{{ $t('Loading') }}...</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { RouterLink, useRoute } from "vue-router";
import { sidebarStore } from "@/Stores/SideBarStore.js";
import { Modal } from 'flowbite';
import { useAuthStore } from "@/Stores/Auth.js";
import { useToast } from "vue-toastification";
import { useRouter } from 'vue-router';

import DropdownDarkLight from "@/Components/UI/DropdownDarkLight.vue";
import LanguageSelector from "@/Components/UI/LanguageSelector.vue";
import WalletBalance from "@/Components/UI/WalletBalance.vue";
import HttpApi from "@/Services/HttpApi.js";
import MakeDeposit from "@/Components/UI/MakeDeposit.vue";
import {useSettingStore} from "@/Stores/SettingStore.js";
import {searchGameStore} from "@/Stores/SearchGameStore.js";
import CassinoGameCard from "@/Pages/Cassino/Components/CassinoGameCard.vue";

export default {
    props: ['simple'],
    components: {CassinoGameCard, MakeDeposit, WalletBalance, LanguageSelector, DropdownDarkLight, RouterLink },
    data() {
        return {
            isLoadingLogin: false,
            isLoadingRegister: false,
            isReferral: false,
            modalAuth: null,
            modalRegister: null,
            modalProfile: null,
            typeInputPassword: 'password',
            readonly: false,
            profileUser: null,
            loginForm: {
                email: '',
                password: '',
            },
            registerForm: {
                name: '',
                email: '',
                cpf: '',
                password: '',
                password_confirmation: '',
                reference_code: '',
                term_a: false,
                agreement: false,
            },
            avatarUrl: '/assets/images/profile.jpg',
            isLoadingProfile: false,
            profileName: '',
            sumBets: 0,
            totalBets: 0,
            totalEarnings: 0,
            showSearchMenu: false,
            games: null,
            searchTerm: '',
            isLoadingSearch: true,
        }
    },
    setup() {
        const router = useRouter();

        return {
            router,
        };
    },
    computed: {
        searchGameDataStore() {
            return searchGameStore();
        },
        searchGameMenu() {
            const search = searchGameStore();
            return search.getSearchGameStatus;
        },
        sidebarMenuStore() {
            return sidebarStore();
        },
        isAuthenticated() {
            const authStore = useAuthStore();
            return authStore.isAuth;
        },
        userData() {
            const authStore = useAuthStore();
            return authStore.user;
        },
        setting() {
            const authStore = useSettingStore();
            return authStore.setting;
        }
    },
    unmounted() {

    },
    mounted() {
        /*
        * $targetEl: required
        * options: optional
        */
        this.modalProfile = new Modal(document.getElementById('modalProfileEl'), {
            placement: 'center',
            backdrop: 'dynamic',
            backdropClasses: 'bg-gray-700 bg-opacity-50 dark:bg-opacity-80 fixed inset-0 z-40',
            closable: false,
            onHide: () => {

            },
            onShow: () => {

            },
            onToggle: () => {

            }
        });

        /*
        * $targetEl: required
        * options: optional
        */
        this.modalAuth = new Modal(document.getElementById('modalElAuth'), {
            placement: 'center',
            backdrop: 'dynamic',
            backdropClasses: 'bg-gray-700 bg-opacity-50 dark:bg-opacity-80 fixed inset-0 z-40',
            closable: false,
            onHide: () => {

            },
            onShow: () => {

            },
            onToggle: () => {

            }
        });

        /*
       * $targetEl: required
       * options: optional
       */
        this.modalRegister = new Modal(document.getElementById('modalElRegister'), {
            placement: 'center',
            backdrop: 'dynamic',
            backdropClasses: 'bg-gray-700 bg-opacity-50 dark:bg-opacity-80 fixed inset-0 z-40',
            closable: false,
            onHide: () => {

            },
            onShow: () => {

            },
            onToggle: () => {

            }
        });
    },
    methods: {
        toggleSearch: function() {
            this.searchGameDataStore.setSearchGameToogle();
        },
        redirectSocialTo: function() {
            return '/auth/redirect/google'
        },
        like: async function(id) {
            const _this = this;
            const _toast = useToast();
            await HttpApi.post('/profile/like/' + id, {})
                .then(response => {

                    _this.getProfile();
                    _toast.success(_this.$t(response.data.message));
                })
                .catch(error => {
                    Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                        _toast.error(`${value}`);
                    });
                });
        },
        updateName: async function(event) {
            const _this = this;
            _this.isLoadingProfile = true;

            await HttpApi.post('/profile/updateName', { name: _this.profileName })
                .then(response => {
                    _this.isLoadingProfile = false;
                })
                .catch(error => {
                    const _this = this;
                    Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {

                    });
                    _this.isLoadingProfile = false;
                });
        },
        togglePassword: function() {
            if(this.typeInputPassword === 'password') {
                this.typeInputPassword = 'text';
            }else{
                this.typeInputPassword = 'password';
            }
        },
        loginSubmit: function(event) {
            const _this = this;
            const _toast = useToast();
            _this.isLoadingLogin = true;
            const authStore = useAuthStore();

            HttpApi.post('auth/login', _this.loginForm)
                .then(async response => {
                    await new Promise(r => {
                        setTimeout(() => {
                            authStore.setToken(response.data.access_token);
                            authStore.setUser(response.data.user);
                            authStore.setIsAuth(true);

                            _this.loginForm = {
                                email: '',
                                password: '',
                            }

                            _this.modalAuth.toggle();
                            _toast.success(_this.$t('You have been authenticated, welcome!'));

                            _this.isLoadingLogin = false;
                        }, 1000)
                    });
                })
                .catch(error => {
                    const _this = this;
                    Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                        _toast.error(`${value}`);
                    });
                    _this.isLoadingLogin = false;
                });
        },
        registerSubmit: async function(event) {
            const _this = this;
            const _toast = useToast();
            _this.isLoadingRegister = true;

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
                        }

                        _this.modalRegister.toggle();
                        _this.router.push({ name: 'profileDeposit' });
                        _toast.success(_this.$t('Your account has been created successfully'));
                    }

                    _this.isLoadingRegister = false;
                })
                .catch(error => {
                    Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                        _toast.error(`${value}`);
                    });
                    _this.isLoadingRegister = false;
                });
        },
        logoutAccount: function() {
            const authStore = useAuthStore();
            const _toast = useToast();

            HttpApi.post('auth/logout', {})
                .then(response => {
                    authStore.logout();
                    this.router.push({ name: 'home' });

                    _toast.success(this.$t('You have been successfully disconnected'));
                })
                .catch(error => {
                    Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                        console.log(value);
                        //_toast.error(`${value}`);
                    });
                });
        },
        hideLoginShowRegisterToggle: function() {
            this.modalAuth.toggle();
            this.modalRegister.toggle();
        },
        toggleMenu: function() {
            this.sidebarMenuStore.setSidebarToogle();
        },
        loginToggle: function() {
            this.modalAuth.toggle();
        },
        registerToggle: function() {
            this.modalRegister.toggle();
        },
        profileToggle: function() {
            this.modalProfile.toggle();
        },
        openFileInput() {
            this.$refs.fileInput.click();
        },
        async handleFileChange(event) {
            const file = event.target.files[0];
            const formData = new FormData();
            formData.append('avatar', file);

            const reader = new FileReader();
            reader.onload = () => {
                this.avatarUrl = reader.result;
            };
            reader.readAsDataURL(file);

            await HttpApi.post('/profile/upload-avatar', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            }).then(response => {
                console.log('Avatar atualizado com sucesso', response.data);
            })
                .catch(error => {
                    console.error('Erro ao atualizar avatar', error);
                });
        },
        getProfile: async function() {
            const _this = this;
            _this.isLoadingProfile = true;

            await HttpApi.get('/profile/')
                .then(response => {
                    _this.sumBets = response.data.sumBets;
                    _this.totalBets = response.data.totalBets;
                    _this.totalEarnings = response.data.totalEarnings;

                    const user = response.data.user;

                    if(user?.avatar != null) {
                        _this.avatarUrl = '/storage/'+user.avatar;
                    }

                    _this.profileName = user.name;
                    _this.profileUser = user;
                    _this.isLoadingProfile = false;
                })
                .catch(error => {
                    const _this = this;
                    Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {

                    });
                    _this.isLoadingProfile = false;
                });
        },
        getSearch: async function() {
            const _this = this;

            await HttpApi.get('/search/games?searchTerm='+this.searchTerm)
                .then(response => {
                    _this.games = response.data.games;
                    _this.isLoadingSearch = false;
                })
                .catch(error => {
                    const _this = this;
                    Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {

                    });
                    _this.isLoadingSearch = false;
                });
        },
        clearData: async function() {
            this.searchTerm = '';
            await this.getSearch();
        }
    },
    async created() {
        if(this.isAuthenticated) {

            await this.getProfile();
        }
    },
    watch: {
        searchTerm(newValue, oldValue) {
            this.getSearch();
        },
        async searchGameMenu(newValue, oldValue) {

            await this.getSearch();
            this.showSearchMenu = !this.showSearchMenu;
        },
    },
};
</script>

<style scoped>

</style>
