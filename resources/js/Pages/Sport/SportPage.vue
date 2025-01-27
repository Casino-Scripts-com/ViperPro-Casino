<template>
    <BaseLayout>
        <LoadingComponent :isLoading="isLoading">
            <div class="text-center">
                <span>{{ $t('Filling with the best odds') }}</span>
            </div>
        </LoadingComponent>

        <div v-if="!isLoading">
            <div v-if="setting && setting.turn_on_football">
                <HeaderNav />

                <HeaderOptions />

                <!-- banner no carouse -->
                <div class="mx-4 mt-5">
                    <Carousel v-bind="settings" :breakpoints="breakpoints">
                        <Slide  v-for="(event, slideId) in liveevents" :key="slideId">
                            <div class="carousel__item min-h-[200px] rounded-2xl w-full pr-0 lg:pr-4">
                                <SportCardLive :event="event" :index="slideId"/>
                            </div>
                        </Slide>

                        <template #addons>
                            <Navigation />
                        </template>
                    </Carousel>
                </div>

                <!-- jogos principais categorias -->
                <section class="mx-4 mt-5">
                    <div class="section-title">
                        <h1 class="flex text-3xl">
                            <img :src="`/assets/images/icons/trophy.svg`" alt="" width="32" class="mr-3">
                            <span class="ml-2">{{ $t('Main Games') }}</span>
                        </h1>
                    </div>

                    <div class="flex w-full scrollable-container">
                        <div id="scrollable-move" class="category-options flex mt-4 w-full scrollable-content">

                            <button @click.prevent="setCategory('all')" v-if="!isLoadingCategories" class="league-list hover:dark:bg-gray-600/10  hover:dark:text-gray-500 justify-center transition duration-700 px-4 py-1 flex bg-gray-100 dark:bg-gray-700 rounded-full items-center mr-3">
                                <img :src="`/assets/images/icons/futebol.svg`" alt="" width="20">
                                <span class="ml-2">{{ $t('All') }}</span>
                            </button>


                            <button v-if="isLoadingCategories" disabled type="button" class="hover:dark:bg-gray-600/10 hover:dark:text-gray-500 transition duration-700 px-3 lg:px-3 py-1 lg:py-2 flex bg-gray-100 dark:bg-[#252F38] rounded-full items-center mr-3">
                                <svg aria-hidden="true" role="status" class="inline w-4 h-4 mr-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                                </svg>
                                {{ $t('Loading') }}...
                            </button>

                            <button v-else v-for="(league, index) in leagues" :key="index"
                                    @click.prevent="setCategory(league.name)"
                                    class="league-list hover:dark:bg-gray-600/10  hover:dark:text-gray-500 justify-center transition duration-700 px-4 py-1 flex bg-gray-100 dark:bg-gray-700 rounded-full items-center mr-3">
                                <img :src="`/storage/football/leagues/`+state.generateSlug(league.country + '-' + league.name)+`.png`" alt="" width="20">
                                <span class="ml-2">{{ $t(league.name) }}</span>
                            </button>
                        </div>
                    </div>
                </section>

                <!-- lista de apostas -->
                <section v-if="events && events.length" class="mx-4 mt-8">
                    <div class="flex-col">
                        <div class="grid grid-cols-1 lg:grid-cols-3 xl:grid-cols-3 gap-4">
                            <div v-if="isLoadingSports" v-for="i in 12"  role="status" class="w-full space-y-8 md:space-y-0 md:space-x-8 md:flex md:items-center">
                                <div class="flex items-center justify-center w-full bg-gray-300 rounded sm:w-96 dark:bg-gray-700/10 min-h-[240px]">

                                </div>
                            </div>

                            <SportCard v-if="!isLoadingSports" v-for="(event, index) in events" :event="event" :index="index"/>
                        </div>
                    </div>
                </section>
                <section v-else class="mx-4 mt-8">
                    <div class="min-h-[calc(100vh-565px)] text-center flex flex-col items-center justify-center">
                        <div class="mb-3">
                            <svg data-editor-id="searchNoResultIcon" width="263" height="110" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M99.979 39.646A17.82 17.82 0 0 0 82.861 26.98a17.82 17.82 0 0 0-17.88 17.881c0 3.695 1.389 6.629 3.517 7.194 2.928.778 13.056 3.83 20.775 6.287.414.132.855.277 1.402.46l1.44.486c.46.155.83.278 1.185.395 2.816.92 4.658 1.355 5.974 1.336 1.166-.017 1.468-.271 1.468-1.257V54.23c-5.084-1.144-7.592-1.782-16.583-4.18-3.29-.878-5.023-2.38-5.023-5.19 0-3.116 2.09-5.215 5.215-5.215H99.98Zm.38 1.49H84.351c-2.3 0-3.725 1.43-3.725 3.725 0 1.983 1.204 3.027 3.917 3.75 8.777 2.342 11.353 2.998 16.199 4.093V44.86c0-1.28-.132-2.525-.383-3.725Zm-11.99 20.046c-7.676-2.443-17.765-5.484-20.636-6.246C63.985 53.94 62 49.749 62 44.86A20.801 20.801 0 0 1 82.861 24a20.801 20.801 0 0 1 20.861 20.861v14.9c0 2.75-1.719 4.2-4.404 4.238-1.754.025-3.82-.462-6.945-1.484-.365-.12-.742-.245-1.21-.403l-1.436-.485c-.534-.179-.96-.32-1.358-.445Zm147.385-17.234-1.315-1.37a.777.777 0 0 1 1.12-1.075l1.196 1.246a58.797 58.797 0 0 1 1.885-2.098l-1.114-1.16a.775.775 0 1 1 1.12-1.075l1.076 1.12.047-.047a55.272 55.272 0 0 1 1.989-1.892l-1.145-1.193a.775.775 0 1 1 1.12-1.075l1.191 1.241c2.339-2 4.858-3.82 7.556-5.456-1.799-1.317-3.607-2.212-5.188-2.625-3.91 1.338-7.936 3.594-11.047 6.705-2.963 2.963-5.155 6.712-6.523 10.402.228 1.737 1.148 3.862 2.664 5.991a69.113 69.113 0 0 1 5.368-7.64Zm1.084 1.128a67.975 67.975 0 0 0-5.435 7.83 23.95 23.95 0 0 0 1.47 1.61c2.637 2.637 5.568 4.36 7.965 4.965 3.871-1.349 7.854-3.612 10.968-6.726 2.965-2.965 5.152-6.76 6.509-10.493-.365-2.532-2.174-5.864-5.137-8.828a24.366 24.366 0 0 0-1.397-1.29 55.933 55.933 0 0 0-7.78 5.548l1.683 1.753a.776.776 0 1 1-1.12 1.075l-1.731-1.803a53.808 53.808 0 0 0-1.966 1.87l-.07.07 1.8 1.875a.776.776 0 1 1-1.12 1.075l-1.761-1.835a57.067 57.067 0 0 0-1.881 2.102l1.675 1.745a.776.776 0 0 1-1.119 1.075l-1.553-1.618ZM226.811 58.1a86.387 86.387 0 0 1 2.712-5.062c-1.187-1.565-2.093-3.168-2.672-4.693-1.037 3.939-1.075 7.557-.04 9.755Zm1.035 1.416c1.896 1.647 5.947 1.85 10.466.722-2.167-.955-4.453-2.54-6.537-4.624a25.357 25.357 0 0 1-1.202-1.287 86.405 86.405 0 0 0-2.727 5.189Zm29.115-31.824c-2.119-.882-5.475-.845-9.146.057 1.354.604 2.751 1.453 4.115 2.514a63.915 63.915 0 0 1 5.031-2.571Zm1.525 1.017a63.077 63.077 0 0 0-5.281 2.618c.361.322.719.66 1.07 1.01 2.293 2.294 3.982 4.831 4.892 7.187 1.22-4.715 1.031-8.96-.681-10.815Zm-33.022 32.828c-5.022-5.023-2.141-19.81 6.586-28.537 8.669-8.67 23.598-11.523 28.536-6.585 4.938 4.938 2.085 19.867-6.585 28.536-8.727 8.727-23.514 11.608-28.537 6.586Z" fill="rgba(255,255,255,0.4)"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M3.03 41.562A17.29 17.29 0 0 0 2.856 44a17.08 17.08 0 0 0 4.642 11.73c2.108-7.982 7.2-14.832 14.08-19.384a31.34 31.34 0 0 0-2.312-2.104 14.212 14.212 0 0 1-7.067 1.9 12.851 12.851 0 0 0-9.17 5.42Zm.708-3a14.266 14.266 0 0 1 9.78-3.92 12.78 12.78 0 0 0 4.523-1.358 29.592 29.592 0 0 0-7.047-3.873 17.19 17.19 0 0 0-7.256 9.15ZM23.804 27.28A17.2 17.2 0 0 0 20 26.857c-2.645 0-5.15.6-7.386 1.669a31.184 31.184 0 0 1 6.752 3.969 12.888 12.888 0 0 0 4.438-5.214Zm1.397.38a14.31 14.31 0 0 1-4.679 5.767 32.844 32.844 0 0 1 2.292 2.137 35.565 35.565 0 0 1 9.108-3.883 17.133 17.133 0 0 0-6.721-4.022Zm-6.027 33.462c.901-1.712 1.54-5.603 1.54-9.98v-1.57a12.12 12.12 0 0 1 4.308-9.136 32.716 32.716 0 0 0-2.444-3.039c-6.926 4.509-11.991 11.428-13.894 19.48a17.072 17.072 0 0 0 10.49 4.245Zm1.563.004a17.071 17.071 0 0 0 10.492-4.173c-.616-5.632-2.513-10.873-5.4-15.328a10.69 10.69 0 0 0-3.686 8.088v1.429c0 4.11-.532 7.813-1.406 9.984ZM36.59 39.668A10.694 10.694 0 0 0 32.857 39c-2.174 0-4.197.648-5.886 1.76 2.852 4.373 4.785 9.474 5.544 14.956A17.083 17.083 0 0 0 37.143 44a17.19 17.19 0 0 0-.552-4.332ZM36.063 38a17.13 17.13 0 0 0-3.025-5.13 34.174 34.174 0 0 0-9.226 3.764c.835.934 1.62 1.918 2.354 2.947a12.086 12.086 0 0 1 6.691-2.009c1.097 0 2.173.146 3.206.428ZM20 64C8.954 64 0 55.046 0 44s8.954-20 20-20 20 8.954 20 20-8.954 20-20 20Z" fill="rgba(255,255,255,0.4)"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M157.667 55.207a21.318 21.318 0 0 0 8.963 2.18l5.273-6.039a21.478 21.478 0 0 0-2.393-10.236l-10.428-2.428a21.454 21.454 0 0 0-4.935 7.7l3.52 8.823Zm-.55 1.718-3.524 2.938A21.35 21.35 0 0 0 168 65.429c1.065 0 2.111-.078 3.134-.228l-4.518-6.027a23.114 23.114 0 0 1-9.499-2.249Zm-10.504-11.577h6.018a23.247 23.247 0 0 1 5.403-8.139v-6.496a21.361 21.361 0 0 0-6.394-.553A21.342 21.342 0 0 0 146.571 44c0 .453.014.902.042 1.348Zm35.786 5.628a21.47 21.47 0 0 0 4.404-6.556l-2.845-9.708a21.281 21.281 0 0 0-7.776-2.233l-4.839 8.306a23.237 23.237 0 0 1 2.339 9.534l8.717.657Zm1.036 1.49v6.398a21.354 21.354 0 0 0 5.943-13.375l-1.015-.178a23.246 23.246 0 0 1-4.928 7.155Zm1.229-21.94a21.417 21.417 0 0 0-12.758-7.6 21.297 21.297 0 0 0-1.954 2.68l5.851 5.052c2.892.192 5.686.916 8.268 2.123l.593-2.255Zm-16.488-5.43a23.03 23.03 0 0 1 1.654-2.448 21.705 21.705 0 0 0-1.83-.077 21.355 21.355 0 0 0-14.62 5.762c1.681.026 3.354.235 4.992.624a.888.888 0 0 1 .231-.133l9.573-3.728ZM168 69c-13.807 0-25-11.193-25-25s11.193-25 25-25 25 11.193 25 25-11.193 25-25 25Z" fill="#ffffff"></path><path d="M101.351 105.649a6.151 6.151 0 0 1 0-8.7l28.124-28.125c-5.391-7.194-8.626-16.09-8.626-25.749C120.849 19.322 140.172 0 163.925 0S207 19.322 207 43.075c0 23.753-19.322 43.076-43.075 43.076-9.659 0-18.556-3.235-25.749-8.626l-28.124 28.124a6.152 6.152 0 0 1-8.701 0Zm101.547-62.574c0-21.49-17.483-38.973-38.973-38.973-21.491 0-38.973 17.483-38.973 38.973s17.482 38.973 38.973 38.973c21.49 0 38.973-17.482 38.973-38.973Z" fill="#43B309"></path></svg>
                        </div>
                        <h1 class="text-2xl font-bold">{{ $t('No matches were found.') }}</h1>
                    </div>
                </section>

                <section class="mx-4 mt-5">
                    <div class="section-title">
                        <h1 class="flex text-3xl">
                            <i class="fa-duotone fa-calendar-days mr-3"></i>
                            <span class="ml-2">{{ $t('Next Events') }}</span>
                        </h1>
                    </div>
                </section>

                <section v-if="nextevents && nextevents.length" class="mx-4 mt-8">
                    <div class="flex-col">
                        <div class="grid grid-cols-1 lg:grid-cols-3 xl:grid-cols-3 gap-4">
                            <SportCard v-for="(event, index) in nextevents" :event="event" :index="index"/>
                        </div>
                    </div>
                </section>
                <section v-else class="mx-4 mt-8">
                    <div class="min-h-[calc(100vh-565px)] text-center flex flex-col items-center justify-center">
                        <div class="mb-3">
                            <svg data-editor-id="searchNoResultIcon" width="263" height="110" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M99.979 39.646A17.82 17.82 0 0 0 82.861 26.98a17.82 17.82 0 0 0-17.88 17.881c0 3.695 1.389 6.629 3.517 7.194 2.928.778 13.056 3.83 20.775 6.287.414.132.855.277 1.402.46l1.44.486c.46.155.83.278 1.185.395 2.816.92 4.658 1.355 5.974 1.336 1.166-.017 1.468-.271 1.468-1.257V54.23c-5.084-1.144-7.592-1.782-16.583-4.18-3.29-.878-5.023-2.38-5.023-5.19 0-3.116 2.09-5.215 5.215-5.215H99.98Zm.38 1.49H84.351c-2.3 0-3.725 1.43-3.725 3.725 0 1.983 1.204 3.027 3.917 3.75 8.777 2.342 11.353 2.998 16.199 4.093V44.86c0-1.28-.132-2.525-.383-3.725Zm-11.99 20.046c-7.676-2.443-17.765-5.484-20.636-6.246C63.985 53.94 62 49.749 62 44.86A20.801 20.801 0 0 1 82.861 24a20.801 20.801 0 0 1 20.861 20.861v14.9c0 2.75-1.719 4.2-4.404 4.238-1.754.025-3.82-.462-6.945-1.484-.365-.12-.742-.245-1.21-.403l-1.436-.485c-.534-.179-.96-.32-1.358-.445Zm147.385-17.234-1.315-1.37a.777.777 0 0 1 1.12-1.075l1.196 1.246a58.797 58.797 0 0 1 1.885-2.098l-1.114-1.16a.775.775 0 1 1 1.12-1.075l1.076 1.12.047-.047a55.272 55.272 0 0 1 1.989-1.892l-1.145-1.193a.775.775 0 1 1 1.12-1.075l1.191 1.241c2.339-2 4.858-3.82 7.556-5.456-1.799-1.317-3.607-2.212-5.188-2.625-3.91 1.338-7.936 3.594-11.047 6.705-2.963 2.963-5.155 6.712-6.523 10.402.228 1.737 1.148 3.862 2.664 5.991a69.113 69.113 0 0 1 5.368-7.64Zm1.084 1.128a67.975 67.975 0 0 0-5.435 7.83 23.95 23.95 0 0 0 1.47 1.61c2.637 2.637 5.568 4.36 7.965 4.965 3.871-1.349 7.854-3.612 10.968-6.726 2.965-2.965 5.152-6.76 6.509-10.493-.365-2.532-2.174-5.864-5.137-8.828a24.366 24.366 0 0 0-1.397-1.29 55.933 55.933 0 0 0-7.78 5.548l1.683 1.753a.776.776 0 1 1-1.12 1.075l-1.731-1.803a53.808 53.808 0 0 0-1.966 1.87l-.07.07 1.8 1.875a.776.776 0 1 1-1.12 1.075l-1.761-1.835a57.067 57.067 0 0 0-1.881 2.102l1.675 1.745a.776.776 0 0 1-1.119 1.075l-1.553-1.618ZM226.811 58.1a86.387 86.387 0 0 1 2.712-5.062c-1.187-1.565-2.093-3.168-2.672-4.693-1.037 3.939-1.075 7.557-.04 9.755Zm1.035 1.416c1.896 1.647 5.947 1.85 10.466.722-2.167-.955-4.453-2.54-6.537-4.624a25.357 25.357 0 0 1-1.202-1.287 86.405 86.405 0 0 0-2.727 5.189Zm29.115-31.824c-2.119-.882-5.475-.845-9.146.057 1.354.604 2.751 1.453 4.115 2.514a63.915 63.915 0 0 1 5.031-2.571Zm1.525 1.017a63.077 63.077 0 0 0-5.281 2.618c.361.322.719.66 1.07 1.01 2.293 2.294 3.982 4.831 4.892 7.187 1.22-4.715 1.031-8.96-.681-10.815Zm-33.022 32.828c-5.022-5.023-2.141-19.81 6.586-28.537 8.669-8.67 23.598-11.523 28.536-6.585 4.938 4.938 2.085 19.867-6.585 28.536-8.727 8.727-23.514 11.608-28.537 6.586Z" fill="rgba(255,255,255,0.4)"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M3.03 41.562A17.29 17.29 0 0 0 2.856 44a17.08 17.08 0 0 0 4.642 11.73c2.108-7.982 7.2-14.832 14.08-19.384a31.34 31.34 0 0 0-2.312-2.104 14.212 14.212 0 0 1-7.067 1.9 12.851 12.851 0 0 0-9.17 5.42Zm.708-3a14.266 14.266 0 0 1 9.78-3.92 12.78 12.78 0 0 0 4.523-1.358 29.592 29.592 0 0 0-7.047-3.873 17.19 17.19 0 0 0-7.256 9.15ZM23.804 27.28A17.2 17.2 0 0 0 20 26.857c-2.645 0-5.15.6-7.386 1.669a31.184 31.184 0 0 1 6.752 3.969 12.888 12.888 0 0 0 4.438-5.214Zm1.397.38a14.31 14.31 0 0 1-4.679 5.767 32.844 32.844 0 0 1 2.292 2.137 35.565 35.565 0 0 1 9.108-3.883 17.133 17.133 0 0 0-6.721-4.022Zm-6.027 33.462c.901-1.712 1.54-5.603 1.54-9.98v-1.57a12.12 12.12 0 0 1 4.308-9.136 32.716 32.716 0 0 0-2.444-3.039c-6.926 4.509-11.991 11.428-13.894 19.48a17.072 17.072 0 0 0 10.49 4.245Zm1.563.004a17.071 17.071 0 0 0 10.492-4.173c-.616-5.632-2.513-10.873-5.4-15.328a10.69 10.69 0 0 0-3.686 8.088v1.429c0 4.11-.532 7.813-1.406 9.984ZM36.59 39.668A10.694 10.694 0 0 0 32.857 39c-2.174 0-4.197.648-5.886 1.76 2.852 4.373 4.785 9.474 5.544 14.956A17.083 17.083 0 0 0 37.143 44a17.19 17.19 0 0 0-.552-4.332ZM36.063 38a17.13 17.13 0 0 0-3.025-5.13 34.174 34.174 0 0 0-9.226 3.764c.835.934 1.62 1.918 2.354 2.947a12.086 12.086 0 0 1 6.691-2.009c1.097 0 2.173.146 3.206.428ZM20 64C8.954 64 0 55.046 0 44s8.954-20 20-20 20 8.954 20 20-8.954 20-20 20Z" fill="rgba(255,255,255,0.4)"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M157.667 55.207a21.318 21.318 0 0 0 8.963 2.18l5.273-6.039a21.478 21.478 0 0 0-2.393-10.236l-10.428-2.428a21.454 21.454 0 0 0-4.935 7.7l3.52 8.823Zm-.55 1.718-3.524 2.938A21.35 21.35 0 0 0 168 65.429c1.065 0 2.111-.078 3.134-.228l-4.518-6.027a23.114 23.114 0 0 1-9.499-2.249Zm-10.504-11.577h6.018a23.247 23.247 0 0 1 5.403-8.139v-6.496a21.361 21.361 0 0 0-6.394-.553A21.342 21.342 0 0 0 146.571 44c0 .453.014.902.042 1.348Zm35.786 5.628a21.47 21.47 0 0 0 4.404-6.556l-2.845-9.708a21.281 21.281 0 0 0-7.776-2.233l-4.839 8.306a23.237 23.237 0 0 1 2.339 9.534l8.717.657Zm1.036 1.49v6.398a21.354 21.354 0 0 0 5.943-13.375l-1.015-.178a23.246 23.246 0 0 1-4.928 7.155Zm1.229-21.94a21.417 21.417 0 0 0-12.758-7.6 21.297 21.297 0 0 0-1.954 2.68l5.851 5.052c2.892.192 5.686.916 8.268 2.123l.593-2.255Zm-16.488-5.43a23.03 23.03 0 0 1 1.654-2.448 21.705 21.705 0 0 0-1.83-.077 21.355 21.355 0 0 0-14.62 5.762c1.681.026 3.354.235 4.992.624a.888.888 0 0 1 .231-.133l9.573-3.728ZM168 69c-13.807 0-25-11.193-25-25s11.193-25 25-25 25 11.193 25 25-11.193 25-25 25Z" fill="#ffffff"></path><path d="M101.351 105.649a6.151 6.151 0 0 1 0-8.7l28.124-28.125c-5.391-7.194-8.626-16.09-8.626-25.749C120.849 19.322 140.172 0 163.925 0S207 19.322 207 43.075c0 23.753-19.322 43.076-43.075 43.076-9.659 0-18.556-3.235-25.749-8.626l-28.124 28.124a6.152 6.152 0 0 1-8.701 0Zm101.547-62.574c0-21.49-17.483-38.973-38.973-38.973-21.491 0-38.973 17.483-38.973 38.973s17.482 38.973 38.973 38.973c21.49 0 38.973-17.482 38.973-38.973Z" fill="#43B309"></path></svg>
                        </div>
                        <h1 class="text-2xl font-bold">{{ $t('No matches were found.') }}</h1>
                    </div>
                </section>
            </div>
            <div v-else class="flex flex-col w-full justify-center items-center self-center py-24 mx-auto">
                <img :src="`/assets/images/web-maintenance-services.png`" alt="" class="max-w-[550px]">
            </div>
        </div>

        <BettingBulletinComponent v-once />
    </BaseLayout>
</template>


<script>
import { RouterLink } from "vue-router";
import { Carousel, Navigation, Slide } from 'vue3-carousel';
import 'vue3-carousel/dist/carousel.css';
import BaseLayout from "@/Layouts/BaseLayout.vue";
import SportCard from "@/Pages/Sport/Components/SportCard.vue";
import LoadingComponent from "@/Components/UI/LoadingComponent.vue";
import BettingBulletinComponent from "@/Components/UI/BettingBulletinComponent.vue";
import HeaderNav from "@/Pages/Sport/Components/HeaderNav.vue";
import HeaderOptions from "@/Pages/Sport/Components/HeaderOptions.vue";
import {useToast} from "vue-toastification";
import HttpApi from "@/Services/HttpApi.js";
import SportCardLive from "@/Pages/Sport/Components/SportCardLive.vue";
import {useSettingStore} from "@/Stores/SettingStore.js";

export default {
    props: [],
    components: {
        SportCardLive,
        HeaderOptions,
        RouterLink,
        HeaderNav,
        BettingBulletinComponent,
        LoadingComponent,
        SportCard,
        BaseLayout,
        Carousel,
        Slide,
        Navigation,
    },
    data() {
        return {
            isLoading: true,
            isLoadingCategories: true,
            isLoadingSports: true,
            leagues: null,
            sports: [],
            settings: {
                itemsToShow: 1,
                snapAlign: 'start',
            },
            breakpoints: {
                700: {
                    itemsToShow: 1,
                    snapAlign: 'center',
                },
                1024: {
                    itemsToShow: 3.1,
                    snapAlign: 'start',
                },
            },
            events: null,
            nextevents: null,
            liveevents: null,
            selectedLeague: 'all',
            intervalId: null,
        }
    },
    setup(props) {

    },
    computed: {
        setting() {
            const authStore = useSettingStore();
            return authStore.setting;
        }
    },
    mounted() {

    },
    beforeDestroy() {
        this.stopInterval();
    },
    methods: {
        setCategory: async function(league) {
            this.isLoadingCategories = true;
            this.selectedLeague = league;
            await this.getFixtures();

            this.isLoadingCategories = false;
        },
        getLeagues: function() {
            const _this = this;
            const _toast = useToast();

            HttpApi.get('sports/football/leagues/')
                .then(response => {
                    _this.leagues = response.data.leagues;
                    _this.isLoadingCategories = false;
                })
                .catch(error => {
                    Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                        _toast.error(`${value}`);
                    });

                    _this.isLoadingCategories = false;
                });
        },
        getFixtures: async function() {
            const _this = this;
            const _toast = useToast();

            HttpApi.get('sports/football/events?category='+this.selectedLeague)
                .then(response => {
                    _this.events = response.data.events;

                    _this.isLoadingSports = false;
                    _this.isLoading = false;
                })
                .catch(error => {
                    // Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                    //     _toast.error(`${value}`);
                    // });

                    _this.isLoadingSports = false;
                    _this.isLoading = false;
                });
        },
        getNextFixtures: async function() {
            const _this = this;
            HttpApi.get('sports/football/nextevents?category='+this.selectedLeague)
                .then(response => {
                    _this.nextevents = response.data.nextevents;
                })
                .catch(error => console.error);
        },
        getLiveFixtures: async function() {
            const _this = this;
            HttpApi.get('sports/football/liveevents')
                .then(response => {
                    _this.liveevents = response.data.liveevents;
                })
                .catch(error => console.error);
        },
        updateEvents: async function() {
            await this.getLiveFixtures();
            await this.getFixtures();
        },
        stopInterval() {
            clearInterval(this.intervalId);
        },
    },
    created() {
        this.getLeagues();
        this.getNextFixtures();
        this.getLiveFixtures();
        this.getFixtures();

        this.intervalId = setInterval(this.updateEvents, 60000);
    },
    watch: {

    },
};
</script>

<style >

</style>
