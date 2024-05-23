<template>
    <Dropdown  v-bind="$attrs">
        <template #value="slotProps">
            <div v-if="slotProps.value">
                {{slotProps.value.name}}
                <span
                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800"
                    v-if="! slotProps.value.activated_at"
                >
                    Inactive
                </span>
            </div>
            <span v-else>
                {{slotProps.placeholder}}
            </span>
        </template>
        <template #option="slotProps">
            <div>
                {{slotProps.option.name}}
                <span
                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800"
                    v-if="! slotProps.option.activated_at"
                >
                    Inactive
                </span>
            </div>
        </template>
    </Dropdown>
</template>

<script>
    import Dropdown from 'primevue/dropdown'
    import 'primevue/resources/primevue.min.css'
    import 'primevue/resources/themes/bootstrap4-light-blue/theme.css'
    import 'primeicons/primeicons.css'
    export default {
        components: {
            Dropdown,
        },
    }
</script>
