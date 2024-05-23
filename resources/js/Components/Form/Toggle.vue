<template>
    <SwitchGroup as="div" class="flex items-center">
        <Switch v-model="modelValue" :class="[modelValue ? 'bg-primary' : 'bg-gray-200', 'relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-medium-blue']">
            <span class="sr-only">Is Billable?</span>
            <span aria-hidden="true" :class="[modelValue ? 'translate-x-5' : 'translate-x-0', 'pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200']" />
        </Switch>
        <SwitchLabel as="span" class="ml-3" v-if="label">
            <span class="text-sm font-medium text-gray-700">{{ label }}</span>
        </SwitchLabel>
    </SwitchGroup>
</template>

<script>
import { Switch, SwitchGroup, SwitchLabel } from '@headlessui/vue'
export default {
    props: [
        'id',
        'modelValue',
        'label',
    ],

    components: {
        Switch,
        SwitchGroup,
        SwitchLabel,
    },

    watch: {
        modelValue() {
            this.$emit('update:modelValue', this.modelValue)
        }
    },
}
</script>

