<script>

export default {
    data: () => ({
        userList: null,
        selectedUser: null,
        userForecast: null
    }),

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
        class="mx-auto grid max-w-2xl grid-cols-1 grid-rows-1 items-start gap-x-0 gap-y-8 lg:mx-0 lg:max-w-none lg:grid-cols-2 bg-white border rounded shadow-sm h-full overflow-auto">
        <div class="col-span-1 col-start-1 border-r h-full overflow-auto">
            <h1 class="mt-3 px-5 border-b border-gray-200 pb-3 text-2xl font-semibold tracking-tight text-slate-800">Users
            </h1>

            <div v-if="!userList" class="overflow-y-scroll">
                <ul class="divide-y divide-gray-200 animate-pulse">
                    <li v-for="n in 5" class="py-5 px-5 grid grid-cols-3 gap-2">
                        <div class="col-span-2">
                            <div class="grid grid-cols-3 gap-2">
                                <div class="h-2 bg-slate-200 rounded col-span-2 col-start-1"></div>
                                <div class="h-2 bg-slate-200 rounded col-span-2 col-start-1"></div>
                            </div>
                        </div>
                        <div class="col-span-1">
                            <a href="#"
                                class="hidden rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:block w-full">
                                <div class="h-2 bg-slate-200 rounded w-full"></div>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>

            <div v-if="userList" class="w-full">
                <ul class="divide-y divide-gray-200">
                    <li v-for="user in userList.data" class="flex items-center justify-between gap-x-6 py-5 px-5"
                        :class="{ 'bg-slate-100': selectedUser.id === user.id }">
                        <div class="min-w-0">
                            <p class="text-sm font-semibold leading-none text-gray-900">{{ user.name }}</p>
                            <div class="mt-1 flex items-center gap-x-2 text-xs leading-5 text-gray-500">
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
        <div class="col-span-1 h-full overflow-hidden">
            <div class="flex flex-col h-full text-center justify-center items-center bg-gray-50"
                v-if="!selectedUser && !userForecast">
                <h3 class="mt-2 text-sm font-semibold text-gray-900">Weather Forecast</h3>
                <p class="mt-1 text-sm text-gray-500">Select an user to check their weather forecast</p>
            </div>

            <div class="flex flex-col h-full text-center justify-center items-center bg-gray-50"
                v-if="selectedUser && !userForecast">
                <h3 class="mt-2 text-sm font-semibold text-gray-900">Loading weather forecast for {{ selectedUser.name }}
                </h3>
            </div>

            <div class="flex flex-col h-full " v-if="selectedUser && userForecast">
                <h1 class="mt-3 px-5 border-b border-gray-200 pb-3 text-2xl font-semibold tracking-tight text-slate-800">
                    Weather Forecast for {{ selectedUser.name }}</h1>


                <div class="grid grid-cols-3" v-if="userForecast.weather">
                    <div v-if="userForecast.weather.current" class="col-span-3 col-start-1">
                        <div class="flex w-full space-x-4">
                            <div class="w-32 h-32">
                                <img :src="userForecast.weather.current.condition.icon"
                                    :alt="userForecast.weather.current.condition.name">
                            </div>
                            <div class="flex-1 space-y-6 py-1">
                                <h1>{{ userForecast.weather.current.forecast.temp }}°</h1>
                            </div>
                        </div>
                    </div>

                    <div v-for="forecast in userForecast.weather.daily" class="col-span-1">
                        <h3 v-html="forecast.datetime.formatted_day"></h3>
                        <p class="mt-1" v-html="forecast.datetime.formatted_date"></p>

                        <img :src="forecast.condition.icon" :alt="forecast.condition.name">

                    </div>
                </div>
            </div>

        </div>
    </div>
</template>