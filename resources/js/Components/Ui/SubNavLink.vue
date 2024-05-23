<template>
    <inertia-link :href="url" :class="type == 'secondaryButton' ? classesSecondary : classes">
        <component :is="iconName" :class="type == 'secondaryButton' ? gradientIcon : iconClasses" v-if="icon"></component>
        <slot></slot>
    </inertia-link>
</template>

<script>
    import { PlusIcon, ArrowLeftIcon } from '@heroicons/vue/outline'
    import { computed } from 'vue'

    export default {
        props: {
            href: {
                default: ''
            },
            active: {
                default: ''
            },
            icon: {
                default: ''
            },
            back: {
                default: ''
            },
            type: {
                default: 'primary'
            }
        },

        components: {
            PlusIcon,
            ArrowLeftIcon,
        },

        setup(props) {
            const classes = computed(() => {
                return props.active
                            ? 'group flex justify-center md:justify-start items-center py-2 text-sm leading-5 font-medium rounded-md btn__primary text-white transition ease-in-out duration-150 bg-medium-blue hover:bg-light-blue'
                            : 'group flex justify-center md:justify-start items-center py-2 text-sm leading-5 font-medium rounded-md btn__primary text-white transition ease-in-out duration-150'
            })

            const classesSecondary = computed(() => {
                return props.active
                            ? 'btn btn__bordered transition'
                            : 'btn btn__bordered transition'
            })

            const iconClasses = computed(() => {
                return props.active
                    ? 'mr-1 h-4 w-5 text-white transition ease-in-out duration-150 text-primary'
                    : 'mr-1 h-4 w-5 text-white transition ease-in-out duration-150'
            })

            const gradientIcon = computed(() => {
                return props.active
                    ? 'mr-1 h-4 w-5 text-primary transition ease-in-out duration-150'
                    : 'mr-1 h-4 w-5 text-primary transition ease-in-out duration-150'
            })

            const iconName = computed(() => {
                return `${props.icon}Icon`
            })

            const typeName = computed(() => {
                return `${props.type}Icon`
            })

            const url = computed(() => {
                if (props.back && ! _.isUndefined(route().params.back)) {
                    return route().params.back
                }

                return props.href
            })

            return {
                classes,
                classesSecondary,
                iconClasses,
                gradientIcon,
                iconName,
                typeName,
                url,
            }
        },
    }
</script>
