<template>
    <button :type="type" class="btn btn__bordered transition">
        <span class="gradient__text"><slot></slot></span>
    </button>
</template>

<script>
    export default {
        props: {
            type: {
                type: String,
                default: 'button',
            },
        }
    }
</script>
