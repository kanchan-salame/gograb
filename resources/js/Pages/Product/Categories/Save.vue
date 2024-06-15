<template>
<app-layout>
    <Head title="Add Product Category" />
    <template #header>
        <div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    <span class="text-gray-800">
                        {{ productCategory ? 'Update Product Category' : 'Add Product Category'  }}
                    </span>
                </h2>
            </div>
            <div class="ml-4 flex-shrink-0 relative z-1">
                <!-- <sub-nav-link :href="route('sliders.index')" :back="true" icon="Plus">
                    <span class="gradient__text">Go Back</span>
                </sub-nav-link> -->
            </div>
        </div>
    </template>

        <div>
            <div class="pb-10 sm:px-6 lg:px-8">
                <ItemForm
                    :productCategory="productCategory"
                />
            </div>
        </div>
</app-layout>

</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue"
import SubNavLink from '@/Components/Ui/SubNavLink.vue'
import ItemForm from '@/Pages/Product/Categories/Form.vue'
import { Head, Link } from '@inertiajs/vue3';
export default {
    components: {
        AppLayout,
        SubNavLink,
        ItemForm,
        Head
    },
    props: [
        'productCategory',
    ],
    computed: {
        title () {
            return slider ? 'Update product Category' : 'Add product Category'
        }
    }
}
</script>
