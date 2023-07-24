<script>

import SkeletonUser from '@/components/skeleton/user.vue'
import SkeletonWeather from '@/components/skeleton/weather.vue'

import Weather from '@/components/Weather.vue'

export default {
    data: () => ({
        userList: null,
        selectedUser: null,
        userForecast: null
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
            this.userList = await (await fetch(url)).json()
        },

        async fetchUserForecast(user) {
            this.selectedUser = user;
            this.userForecast = null;

            const url = `http://localhost/users/${user.id}/forecast`
            const res = await (await fetch(url)).json();

            this.userForecast = res;
            console.log({ res });
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

            <div v-if="!userList" class="overflow-y-scroll">
                <ul class="divide-y divide-gray-200 animate-pulse">
                    <skeleton-user v-for="n in 5"></skeleton-user>
                </ul>
            </div>

            <div v-if="userList" class="w-full">
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
        </div>
        <div class="col-span-1 overflow-hidden">
            <skeleton-weather title="Weather Forecast" content="Select an user to check their current weather forecast "
                v-if="!selectedUser && !userForecast"></skeleton-weather>

            <skeleton-weather :title="'Loading weather forecast for ' + selectedUser.name"
                v-if="selectedUser && !userForecast"></skeleton-weather>


            <weather :weather="userForecast?.weather" :user="selectedUser" v-if="selectedUser && userForecast" />



        </div>
    </div>
</template>