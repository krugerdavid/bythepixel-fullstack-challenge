<script>

import SkeletonUser from '@/components/skeleton/user.vue'
import SkeletonWeather from '@/components/skeleton/weather.vue'

import Weather from '@/components/Weather.vue'

export default {
    data: () => ({
        userList: null,
        hasUsersListError: false,
        selectedUser: null,
        userForecast: null,
        hasForecastError: false
    }),

    components: {
        SkeletonUser,
        SkeletonWeather,
        Weather
    },

    created() {
        this.fetchUsers()
    },

    methods: {
        async fetchUsers() {
            const url = 'http://localhost/users'
            try {
                const res = await fetch(url);
                this.userList = await res.json()

            } catch (error) {
                this.hasUsersListError = true;
                if (error instanceof SyntaxError) {
                    // Unexpected token < in JSON
                    console.log('There was a SyntaxError', error);
                } else {
                    console.log('There was an error', error);
                }
            }

        },

        async fetchUserForecast(user) {
            this.selectedUser = user;
            this.userForecast = null;

            const url = `http://localhost/users/${user.id}/forecast`

            try {
                const res = await fetch(url);
                this.userForecast = await res.json();

            } catch (error) {
                this.hasForecastError = true;
                if (error instanceof SyntaxError) {
                    // Unexpected token < in JSON
                    console.log('There was a SyntaxError', error);
                } else {
                    console.log('There was an error', error);
                }
            }
        }

    }
}
</script>

<template>
    <div
        class="mx-auto grid max-w-2xl grid-cols-1 grid-rows-1 items-start gap-x-8 gap-y-8 lg:mx-0 lg:max-w-none lg:grid-cols-3 h-full overflow-auto">
        <div class="col-span-2 col-start-1 border-r h-full overflow-auto bg-white border rounded-lg shadow-sm ">
            <h1 class="mt-3 px-5 border-b border-gray-200 pb-3 text-2xl font-semibold tracking-tight text-slate-800">Users
            </h1>

            <div v-if="!userList && !hasUsersListError" class="overflow-y-scroll">
                <ul class="divide-y divide-gray-200 animate-pulse">
                    <skeleton-user v-for="n in 5"></skeleton-user>
                </ul>
            </div>

            <div v-if="userList && !hasUsersListError" class="w-full">
                <ul class="divide-y divide-gray-200">
                    <li v-for="user in userList.data" class="flex items-center justify-between gap-x-6 py-3 px-5"
                        :class="{ 'bg-slate-100': selectedUser && selectedUser.id === user.id }">
                        <div class="min-w-0">
                            <p class="text-sm font-semibold leading-none text-gray-900">{{ user.name }}</p>
                            <div class="mt-1 flex items-center text-xs leading-tight text-gray-500">
                                <p class="whitespace-nowrap">{{ user.email }}</p>

                            </div>
                        </div>
                        <div class="flex flex-none items-center gap-x-4">
                            <button v-on:click="fetchUserForecast(user)" type="button"
                                class="hidden rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:block">View
                                Forecast</button>
                        </div>
                    </li>
                </ul>
            </div>

            <div v-if="hasUsersListError" class="h-full">
                <div class="flex flex-col text-center justify-center items-center h-full">

                    <svg class="mx-auto h-14 w-14 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>

                    <h3 class="mt-2 text-sm font-semibold text-gray-900">Can't fetch users.</h3>
                    <p class="mt-1 text-sm text-gray-500">There was an error during the request.</p>
                </div>
            </div>
        </div>
        <div class="col-span-1 overflow-hidden">
            <skeleton-weather title="Weather Forecast" content="Select an user to check their current weather forecast "
                v-if="!selectedUser && !userForecast && !hasForecastError"></skeleton-weather>

            <skeleton-weather :title="'Loading weather forecast for ' + selectedUser.name"
                v-if="selectedUser && !userForecast && !hasForecastError"></skeleton-weather>


            <weather :weather="userForecast?.weather" :user="selectedUser"
                v-if="selectedUser && userForecast && !hasForecastError" />

            <skeleton-weather :title="'Can\'t fetch weather forecast for ' + selectedUser.name"
                content="There was an error during the request. Please try again."
                v-if="selectedUser && hasForecastError"></skeleton-weather>


        </div>
    </div>
</template>