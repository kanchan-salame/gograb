<template>
    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6"
        v-show="from"
    >
        <div class="flex-1 flex justify-end sm:hidden">
            <a :href="links.prev" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:text-gray-500"
                @click.prevent="visit(links.prev)"
            >
                <chevron-left-icon classes="h-4 w-4" /> Previous
            </a>
            <a :href="links.next" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:text-gray-500"
               @click.prevent="visit(links.next)"
            >
                Next <chevron-right-icon classes="h-4 w-4" />
            </a>
        </div>
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                Showing
                <span class="font-medium">{{ from }}</span>
                to
                <span class="font-medium">{{ to }}</span>
                of
                <span class="font-medium">{{ total }}</span>
                results
                </p>
            </div>
            <div>
                <nav class="relative z-0 inline-flex shadow-sm -space-x-px" aria-label="Pagination">
                    <a :href="link.url" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50"
                        :class="{
                            'rounded-l-md': index === 0,
                            'rounded-r-md': index === links.length - 1,
                            'bg-light-blue text-primary': link.active,
                        }"
                        v-for="(link, index) in links"
                        :key="index"
                        @click.prevent="visit(link.url)"
                    >
                        <span v-html="link.label"></span>
                    </a>
                </nav>
            </div>
        </div>
    </div>
</template>

<script>
import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/outline'

export default {
    components: {
        ChevronLeftIcon,
        ChevronRightIcon,
    },

    props: [
        'links',
        'from',
        'to',
        'total',
    ],

    methods: {
        visit(url) {
            if (! url) return;
            this.$inertia.visit(url, {
                data: {
                        filter: route().params.filter,
                    }
            }
            );
        }
    },
}
</script>
