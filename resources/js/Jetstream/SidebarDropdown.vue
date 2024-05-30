<template>
    <div :class="classes">
        <slot :class="classes"></slot>
    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';
    export default {
        props: ['active'],

        computed: {
            classes() {
                return this.active
                            ? 'bg-gray-300 text-gray-900 group flex items-center px-2 py-2 text-base cursor-pointer leading-6 font-semibold rounded-md'
                            : 'text-gray-100 hover:text-gray-900 hover:bg-gray-200 group flex cursor-pointer items-center px-2 py-2 text-base leading-6 font-semibold rounded-md'
            }
        }
    }
</script>
