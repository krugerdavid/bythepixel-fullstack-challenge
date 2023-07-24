<template>
    <div class="flex flex-col bg-gray-50 border border-gray-200 rounded-lg shadow-sm">
        <div class="bg-orange-500 px-4 py-4 sm:px-6 rounded-t-lg">
            <div class="flex items-center justify-between">
                <h2 class="text-base font-semibold leading-tight text-white" id="slide-over-title">Weather Forecast</h2>
            </div>
            <div class="mt-0">
                <p class="text-sm text-white">For <strong>{{ user.name }}</strong></p>
            </div>
        </div>

        <div class="px-4 py-6 sm:px-6 rounded-b-lg">
            <div class="flex">
                <div class="w-1/3">
                    <img :src="props.weather.current.condition.icon" alt="" class="w-full">
                </div>

                <div class="flex-1 text-right">
                    <h1 class="text-6xl font-extrabold leading-none text-right flex items-center justify-end">{{
                        props.weather.current.forecast.temp }}
                        <small class="text-gray-500 font-medium text-4xl">{{ unit }}</small>
                    </h1>
                    <p class="m-0 text-2xl font-semibold leading-none">{{ props.weather.current.datetime.formatted_day }}
                    </p>
                    <p class="m-0 text-sm leading-tight text-slate-500">{{ props.weather.current.datetime.formatted_date }}
                    </p>

                </div>
            </div>

            <div class="border-t mt-4">
                <ul class="divide-y divide-gray-200">
                    <li v-for="forecast in props.weather.daily" class="flex items-center justify-between gap-x-6 py-3">
                        <div class="min-w-0">
                            <h3 class="text-sm font-semibold leading-none text-gray-900">{{ forecast.datetime.formatted_day
                            }}</h3>
                            <p class="mt-1 flex items-center text-xs leading-tight text-gray-500">{{
                                forecast.datetime.formatted_date
                            }}</p>

                        </div>

                        <div class="flex items-center gap-x-4">
                            <span>{{ forecast.forecast.temp }} {{ unit }}</span>
                            <img :src="forecast.condition.icon" :alt="forecast.condition.name" class="h-10">
                        </div>

                    </li>
                </ul>
            </div>
        </div>

    </div>
</template>

<script setup>
const props = defineProps(['weather', 'user'])
const unit = props.weather.formats.units == 'imperial' ? '°F' : '°C'

console.log(props.weather)
</script>