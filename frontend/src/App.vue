<script setup lang="ts">
import { RouterLink, RouterView } from "vue-router";
</script>

<template>
    <header>
        <nav class="bg-gray-800">
            <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
                <div class="relative flex h-16 items-center justify-between">

                    <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                        <div class="flex flex-shrink-0 items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" viewBox="0 0 777.9 187.7"
                                enable-background="new 0 0 777.939 187.689" xml:space="preserve" class="block h-6">
                                <path fill="#D3D3D3"
                                    d="M127.6 14.8c-5.9-5-12.8-8.7-20.6-11.1C99.1 1.2 90.8 0 82 0H0v187.7h37.5v-66.5h41.3c9.6 0 18.6-1.1 26.9-3.5 8.3-2.3 15.5-6 21.6-11 6.1-5 10.8-11.4 14.2-19.2 3.4-7.8 5.1-17.1 5.1-28 0-10-1.7-18.7-5.1-26.1C138.1 26 133.5 19.8 127.6 14.8zM81.2 84.7H37.5V36.5H80.7c8.4 0 15.1 1.9 20 5.8 4.9 3.8 7.3 9.9 7.3 18.1C108 76.6 99.1 84.7 81.2 84.7z" />
                                <rect fill="#D3D3D3" x="181.3" y="0.1" width="37.5" height="187.4" />
                                <polygon fill="#D3D3D3"
                                    points="509.8 105.5 563.6 105.5 563.6 69.1 509.8 69.1 509.8 36.7 602.4 36.7 602.4 0.1 472.3 0.1 472.3 187.4 606.4 187.4 606.4 150.8 509.8 150.8 " />
                                <polygon fill="#D3D3D3"
                                    points="684 0.1 646.6 0.1 646.6 187.4 777.9 187.4 777.9 150.5 684 150.5 " />
                                <path fill="#D3D3D3"
                                    d="M337.4 45.8c-0.3-0.5-26.5-45.8-26.5-45.8h-44.7l28.4 45.8H337.4zM424.7 0.1h-44.7c0 0-26.1 45.2-26.4 45.8h42.6L424.7 0.1zM353.6 137.6c0.3 0.5 29 49.8 29 49.8h44.7l-31-49.8H353.6zM263.6 187.4h44.7c0 0 26.7-45 28.5-48.4 0.3-0.5 0.5-0.9 0.7-1.4h-43L263.6 187.4zM281 120.6c2.7-3.4 4.1-8.3 4.1-14.5 0-7.5-2.7-12.6-8-15.2 5-2.6 7.5-7.4 7.5-14.3 0-11.9-5.2-17.9-15.6-17.9h-11v67.1h11C274.2 125.7 278.3 124.1 281 120.6zM266.4 66.8h2.9c4.4 0 6.6 3.3 6.6 9.9 0 6.9-2.3 10.4-6.7 10.4h-2.8V66.8zM266.4 94.8h2.5c5.1 0 7.6 3.8 7.6 11.3 0 4-0.6 7-1.7 8.8 -1.1 1.8-3 2.7-5.6 2.7h-2.8V94.8zM310.3 125.7V96.2l11.4-37.6H312.5l-3.9 16.9c-1.2 5.3-2 9.7-2.5 13.1 -0.6-4.6-1.4-8.4-2.7-13.1l-4.4-16.9h-9.7l12.4 38.1v29H310.3z" />
                                <polygon fill="#D3D3D3"
                                    points="362.9 58.7 335.3 58.7 335.3 67.1 344.8 67.1 344.8 125.7 353.4 125.7 353.4 67.1 362.9 67.1 " />
                                <polygon fill="#D3D3D3"
                                    points="399.3 125.7 399.3 58.7 390.6 58.7 390.6 85.6 379.7 85.6 379.7 58.7 371.1 58.7 371.1 125.7 379.7 125.7 379.7 94 390.6 94 390.6 125.7 " />
                                <polygon fill="#D3D3D3"
                                    points="421.7 94.6 433.1 94.6 433.1 86.2 421.7 86.2 421.7 67.1 436.4 67.1 436.4 58.7 413 58.7 413 125.7 437.6 125.7 437.6 117.3 421.7 117.3 " />
                            </svg>
                        </div>
                        <div class="hidden sm:ml-6 sm:block">
                            <div class="flex space-x-4">
                                <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                                <a href="#" class="bg-gray-700 text-gray-300 rounded-md px-3 py-2 text-sm font-medium"
                                    aria-current="page">Home</a>

                            </div>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <h3 class="bg-gray-900 text-white block rounded-md px-3 py-2 text-base font-medium">Fullstack
                            Challenge</h3>
                    </div>

                </div>
            </div>


        </nav>
    </header>
    <RouterView />
</template>

<style scoped></style>
