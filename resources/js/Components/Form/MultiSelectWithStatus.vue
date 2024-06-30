<template>
    <MultiSelect  v-bind="$attrs">
        <template #value="slotProps">
            <template  v-for="(option, index) of slotProps.value" :key="option.name">
                {{option.name}}
                <span
                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800"
                    v-if="! option.activated_at"
                >
                    Inactive
                </span>
                <span v-if="slotProps.value.length-1 > index" class="mr-1">,</span>
            </template>
            <template v-if="!slotProps.value || slotProps.value.length === 0">
                {{slotProps.placeholder}}
            </template>
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
    </MultiSelect>
</template>

<script>
    import MultiSelect from 'primevue/multiselect'
    import 'primevue/resources/primevue.min.css'
    import 'primevue/resources/themes/bootstrap4-light-blue/theme.css'
    import 'primeicons/primeicons.css'
    export default {
        components: {
            MultiSelect,
        },
    }
</script>
