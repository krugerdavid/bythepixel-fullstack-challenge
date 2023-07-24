<template>
    <div
        class="flex flex-col text-center justify-center items-center bg-gray-50 h-96 border-dashed border-gray-200 border-2 rounded-lg px-8">

        <svg class="mx-auto h-14 w-14 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
            aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M2.25 15a4.5 4.5 0 004.5 4.5H18a3.75 3.75 0 001.332-7.257 3 3 0 00-3.758-3.848 5.25 5.25 0 00-10.233 2.33A4.502 4.502 0 002.25 15z" />
        </svg>


        <h3 class="mt-2 text-sm font-semibold text-gray-900">{{ title }}</h3>
        <p class="mt-1 text-sm text-gray-500" v-if="hasContent">{{ content }}</p>
    </div>
</template>

<script>
export default {
    props: {
        title: String,
        content: String
    },

    data: () => ({

    }),


    computed: {
        hasContent: function () {
            return this.content !== '';
        }
    }
}
</script>

<style lang="scss" scoped></style>