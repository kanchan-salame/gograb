<template>
    <select class="border-gray-300 focus:secondary focus:ring-opacity-50 rounded-md shadow-sm" @change="change">
        <option v-if="empty" value="">{{ empty }}</option>
        <option v-for="option in options"
            :key="`option-${option.value}`"
            :value="option.value"
            :selected="selectedOption(option)"
        >
            {{ option.label ? option.label : option.value }}
        </option>
    </select>
</template>

<script>
    export default {
        props: ['options', 'modelValue', 'empty'],

        methods: {
            selectedOption(option) {
                if (this.modelValue) {
                    return option.value == this.modelValue;
                }

                return false;
            },

            change(e) {
                const selectedValue = e.target.value;

                const option = this.options.find((option) => {
                    return selectedValue == option.value;
                });

                this.$emit("update:modelValue", option ? option.value : '');
            }
        },

    }
</script>

