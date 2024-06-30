<template>
<app-layout>
    <Head :title="restaurant ? 'Update Restaurant' : 'Add Restaurant'" />
    <template #header>
        <div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    <span class="text-gray-800">
                        {{ restaurant ? 'Update Restaurant' : 'Add Restaurant'  }}
                    </span>
                </h2>
            </div>
            <div class="ml-4 flex-shrink-0 relative z-1">
                <sub-nav-link :href="route('restaurant.index')" icon="Plus">
                    Go Back
                </sub-nav-link>
            </div>
        </div>
    </template>

        <div>
            <div class="pb-10 sm:px-6 lg:px-8">
                <ItemForm
                    :restaurant="restaurant"
                />
            </div>
        </div>
</app-layout>

</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue"
import SubNavLink from '@/Components/Ui/SubNavLink.vue'
import ItemForm from '@/Pages/Restaurant/Form.vue'
import { Head, Link } from '@inertiajs/vue3';
export default {
    components: {
        AppLayout,
        SubNavLink,
        ItemForm,
        Head
    },
    props: [
        'restaurant',
    ],
    computed: {
        title () {
            return props.restaurant ? 'Update Restaurant' : 'Add Restaurant'
        }
    }
}
</script>
