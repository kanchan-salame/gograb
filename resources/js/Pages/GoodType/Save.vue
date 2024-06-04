<template>
<app-layout>
    <Head title="Add Good Type" />
    <template #header>
        <div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    <span class="text-gray-800">
                        {{ goodType ? 'Update Good Type' : 'Add Good Type'  }}
                    </span>
                </h2>
            </div>
            <div class="ml-4 flex-shrink-0 relative z-1">
                <primary-button :href="route('goodType.create')" icon="Plus">
                    Add Good Type
                </primary-button>
            </div>
        </div>
    </template>

        <div>
            <div class="pb-10 sm:px-6 lg:px-8">
                <ItemForm
                    :goodType="goodType"
                />
            </div>
        </div>
</app-layout>

</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue"
import SubNavLink from '@/Components/Ui/SubNavLink.vue'
import ItemForm from '@/Pages/GoodType/Form.vue'
import { Head, Link } from '@inertiajs/vue3';
export default {
    components: {
        AppLayout,
        SubNavLink,
        ItemForm,
        Head
    },
    props: [
        'goodType',
    ],
}
</script>
