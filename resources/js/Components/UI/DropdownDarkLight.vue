<template>
    <div class="relative inline-block text-left">
        <button id="dropdownTopButton" data-dropdown-toggle="dropdownTop" data-dropdown-placement="top" class=" w-8 h-8 font-medium leading-none flex items-center justify-center text-sm transition-all border-white rounded-full outline-none ring-opacity-20 dark:ring-0 ring-2 ring-white focus:ring-offset-white bg-gray-100 text-violet-700 dark:bg-gray-600">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-gray-300 dark:fill-gray-400">
                <path
                    d="M18.6493 4.59125C16.8893 2.99125 14.5593 2.03125 11.9993 2.03125C6.4993 2.03125 2.0293 6.50125 2.0293 12.0013C2.0293 17.5013 6.4993 21.9712 11.9993 21.9712C14.5593 21.9712 16.8893 21.0112 18.6493 19.4112C20.6893 17.6012 21.9693 14.9412 21.9693 12.0013C21.9693 9.06125 20.6893 6.40125 18.6493 4.59125ZM11.9693 16.3912C11.9493 18.0413 10.7193 18.4412 9.5693 17.9812C7.1993 17.0312 5.5293 14.7113 5.5293 12.0013C5.5293 9.29125 7.1993 6.97125 9.5693 6.01125C10.7193 5.55125 11.9493 5.96125 11.9693 7.60125V16.3912Z"
                ></path>
            </svg>
        </button>
        <!-- Dropdown menu -->
        <div id="dropdownTop" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
            <ul id="theme-toggle" class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownTopButton">
                <li id="theme-toggle-light-icon" class="transition duration-700 flex w-full px-4 py-2 text-sm leading-5 outline-none text-gray-600 dark:text-gray-200 hover:bg-gray-200/30 focus:bg-gray-100 focus:text-gray-900 cursor-pointer">
                    <div class="mr-2">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 stroke-gray-400 block dark:hidden">
                            <path
                                d="M12 18.5C15.5899 18.5 18.5 15.5899 18.5 12C18.5 8.41015 15.5899 5.5 12 5.5C8.41015 5.5 5.5 8.41015 5.5 12C5.5 15.5899 8.41015 18.5 12 18.5Z"
                                stroke-width="1.5"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            ></path>
                            <path
                                d="M19.14 19.14L19.01 19.01M19.01 4.99L19.14 4.86L19.01 4.99ZM4.86 19.14L4.99 19.01L4.86 19.14ZM12 2.08V2V2.08ZM12 22V21.92V22ZM2.08 12H2H2.08ZM22 12H21.92H22ZM4.99 4.99L4.86 4.86L4.99 4.99Z"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            ></path>
                        </svg>
                        <svg data-v-c2d7f2c4="" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 dark:fill-gray-400 hidden dark:block">
                            <path d="M12 19C15.866 19 19 15.866 19 12C19 8.13401 15.866 5 12 5C8.13401 5 5 8.13401 5 12C5 15.866 8.13401 19 12 19Z"></path>
                            <path
                                d="M12 22.96C11.45 22.96 11 22.55 11 22V21.92C11 21.37 11.45 20.92 12 20.92C12.55 20.92 13 21.37 13 21.92C13 22.47 12.55 22.96 12 22.96ZM19.14 20.14C18.88 20.14 18.63 20.04 18.43 19.85L18.3 19.72C17.91 19.33 17.91 18.7 18.3 18.31C18.69 17.92 19.32 17.92 19.71 18.31L19.84 18.44C20.23 18.83 20.23 19.46 19.84 19.85C19.65 20.04 19.4 20.14 19.14 20.14ZM4.86 20.14C4.6 20.14 4.35 20.04 4.15 19.85C3.76 19.46 3.76 18.83 4.15 18.44L4.28 18.31C4.67 17.92 5.3 17.92 5.69 18.31C6.08 18.7 6.08 19.33 5.69 19.72L5.56 19.85C5.37 20.04 5.11 20.14 4.86 20.14ZM22 13H21.92C21.37 13 20.92 12.55 20.92 12C20.92 11.45 21.37 11 21.92 11C22.47 11 22.96 11.45 22.96 12C22.96 12.55 22.55 13 22 13ZM2.08 13H2C1.45 13 1 12.55 1 12C1 11.45 1.45 11 2 11C2.55 11 3.04 11.45 3.04 12C3.04 12.55 2.63 13 2.08 13ZM19.01 5.99C18.75 5.99 18.5 5.89 18.3 5.7C17.91 5.31 17.91 4.68 18.3 4.29L18.43 4.16C18.82 3.77 19.45 3.77 19.84 4.16C20.23 4.55 20.23 5.18 19.84 5.57L19.71 5.7C19.52 5.89 19.27 5.99 19.01 5.99ZM4.99 5.99C4.73 5.99 4.48 5.89 4.28 5.7L4.15 5.56C3.76 5.17 3.76 4.54 4.15 4.15C4.54 3.76 5.17 3.76 5.56 4.15L5.69 4.28C6.08 4.67 6.08 5.3 5.69 5.69C5.5 5.89 5.24 5.99 4.99 5.99ZM12 3.04C11.45 3.04 11 2.63 11 2.08V2C11 1.45 11.45 1 12 1C12.55 1 13 1.45 13 2C13 2.55 12.55 3.04 12 3.04Z"
                            ></path>
                        </svg>
                    </div>

                    <span>{{ $t('Light theme') }}</span>
                </li>
                <li id="theme-toggle-dark-icon" class="transition duration-700 flex w-full px-4 py-2 text-sm leading-5 outline-none text-gray-600 dark:text-gray-200 hover:bg-gray-200/30 focus:bg-gray-100 focus:text-gray-900 cursor-pointer">
                    <div class="mr-2">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 stroke-gray-400 block dark:hidden">
                            <path
                                d="M2.03009 12.42C2.39009 17.57 6.76009 21.76 11.9901 21.99C15.6801 22.15 18.9801 20.43 20.9601 17.72C21.7801 16.61 21.3401 15.87 19.9701 16.12C19.3001 16.24 18.6101 16.29 17.8901 16.26C13.0001 16.06 9.00009 11.97 8.98009 7.13996C8.97009 5.83996 9.24009 4.60996 9.73009 3.48996C10.2701 2.24996 9.62009 1.65996 8.37009 2.18996C4.41009 3.85996 1.70009 7.84996 2.03009 12.42Z"
                                stroke-width="1.5"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            ></path>
                        </svg>
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 dark:fill-gray-400 hidden dark:block">
                            <path
                                d="M21.5287 15.9294C21.3687 15.6594 20.9187 15.2394 19.7987 15.4394C19.1787 15.5494 18.5487 15.5994 17.9187 15.5694C15.5887 15.4694 13.4787 14.3994 12.0087 12.7494C10.7087 11.2994 9.90873 9.40938 9.89873 7.36938C9.89873 6.22938 10.1187 5.12938 10.5687 4.08938C11.0087 3.07938 10.6987 2.54938 10.4787 2.32938C10.2487 2.09938 9.70873 1.77938 8.64873 2.21938C4.55873 3.93938 2.02873 8.03938 2.32873 12.4294C2.62873 16.5594 5.52873 20.0894 9.36873 21.4194C10.2887 21.7394 11.2587 21.9294 12.2587 21.9694C12.4187 21.9794 12.5787 21.9894 12.7387 21.9894C16.0887 21.9894 19.2287 20.4094 21.2087 17.7194C21.8787 16.7894 21.6987 16.1994 21.5287 15.9294Z"
                            ></path>
                        </svg>
                    </div>

                    <span>{{ $t('Dark theme') }}</span>
                </li>
                <li id="theme-toggle-system-theme" class="transition duration-700 flex w-full px-4 py-2 text-sm leading-5 outline-none text-gray-600 dark:text-gray-200 hover:bg-gray-200/30 focus:bg-gray-100 focus:text-gray-900 cursor-pointer">
                    <div class="mr-2">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 stroke-gray-400 block dark:hidden">
                            <path
                                d="M6.44 2H17.55C21.11 2 22 2.89 22 6.44V12.77C22 16.33 21.11 17.21 17.56 17.21H6.44C2.89 17.22 2 16.33 2 12.78V6.44C2 2.89 2.89 2 6.44 2Z"
                                stroke-width="1.5"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            ></path>
                            <path d="M12 17.22V22" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M2 13H22" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M7.5 22H16.5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 dark:fill-gray-400 hidden dark:block">
                            <path
                                d="M17.56 2H6.41C3.98 2 2 3.98 2 6.41V12.91V13.11C2 15.55 3.98 17.52 6.41 17.52H10.25C10.8 17.52 11.25 17.97 11.25 18.52V19.49C11.25 20.04 10.8 20.49 10.25 20.49H7.83C7.42 20.49 7.08 20.83 7.08 21.24C7.08 21.65 7.41 22 7.83 22H16.18C16.59 22 16.93 21.66 16.93 21.25C16.93 20.84 16.59 20.5 16.18 20.5H13.76C13.21 20.5 12.76 20.05 12.76 19.5V18.53C12.76 17.98 13.21 17.53 13.76 17.53H17.57C20.01 17.53 21.98 15.55 21.98 13.12V12.92V6.42C21.97 3.98 19.99 2 17.56 2Z"
                            ></path>
                        </svg>
                    </div>

                    <span>{{ $t('System theme') }}</span>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    name: "DropdownDarkLight",
    data() {
        return {

        };
    },
    methods: {

    },
    mounted() {
        let themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        let themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
        let themeToggleSystemTheme = document.getElementById('theme-toggle-system-theme');

        themeToggleDarkIcon.addEventListener('click', function() {
            document.documentElement.classList.remove('light');
            document.documentElement.classList.add('dark');
            localStorage.setItem('color-theme', 'dark');
        })

        themeToggleLightIcon.addEventListener('click', function() {
            document.documentElement.classList.remove('dark');
            document.documentElement.classList.add('light');
            localStorage.setItem('color-theme', 'light');
        })


        themeToggleSystemTheme.addEventListener('click', function() {
            if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                document.documentElement.classList.remove('light');
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            } else {
                // o tema do navegador é claro (light)
                document.documentElement.classList.remove('dark');
                document.documentElement.classList.add('light');
                localStorage.setItem('color-theme', 'light');
            }
        })
    }
}
</script>

<style scoped>

</style>
