<template>
    <transition leave-active-class="transition ease-in duration-500" leave-from-class="opacity-100" leave-to-class="opacity-0">
        <div class="rounded-md p-4" :class="bgClass" v-show="show">
            <div class="flex">
                <div class="flex-shrink-0">
                    <component :is="iconComponent" class="h-5 w-5" :class="iconClass" aria-hidden="true" />
                </div>
                <div class="ml-3">
                    <h3 class="mb-2 text-sm font-medium" :class="titleClass" v-if="title">
                        {{ title }}
                    </h3>
                    <p class="text-sm font-medium" :class="messageClass">
                        {{ message }}
                    </p>
                </div>
                <div class="ml-auto pl-3" v-if="dismissable">
                    <div class="-mx-1.5 -my-1.5">
                        <button type="button"
                            class="inline-flex rounded-md p-1.5 focus:outline-none focus:ring-2 focus:ring-offset-2"
                            :class="dismissClass"
                            @click.prevent="show = false"
                        >
                            <span class="sr-only">Dismiss</span>
                            <XIcon class="h-5 w-5" aria-hidden="true" />
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
import { CheckCircleIcon, XIcon, XCircleIcon, InformationCircleIcon, ExclamationIcon } from '@heroicons/vue/solid'
import { ref } from 'vue'

export default {
    props: {
        title: {
            type: String,
            default: ''
        },
        message: {
            type: String,
            default: ''
        },
        type: {
            type: String,
            default: 'success'
        },
        dismissable: {
            type: Boolean,
            default: false
        },
    },
    components: {
        CheckCircleIcon,
        XCircleIcon,
        ExclamationIcon,
        InformationCircleIcon,
        XIcon,
    },

    setup(props) {
        let bgClass = 'bg-green-50'
        let iconClass = 'text-green-400'
        let iconComponent = 'CheckCircleIcon'
        let titleClass = 'text-green-800'
        let messageClass = 'text-green-700'
        let dismissClass = 'bg-green-50  text-green-500 hover:bg-green-100 focus:ring-offset-green-50 focus:ring-green-600'

        const show = ref(true)

        switch (props.type) {
            case 'warning':
                bgClass = 'bg-yellow-50'
                iconClass = 'text-yellow-400'
                iconComponent = 'ExclamationIcon'
                titleClass = 'text-yellow-800'
                messageClass = 'text-yellow-700'
                dismissClass = 'bg-yellow-50  text-yellow-500 hover:bg-yellow-100 focus:ring-offset-yellow-50 focus:ring-yellow-600'
                break;
            case 'error':
                bgClass = 'bg-red-50'
                iconClass = 'text-red-400'
                iconComponent = 'XCircleIcon'
                titleClass = 'text-red-800'
                messageClass = 'text-red-700'
                dismissClass = 'bg-red-50  text-red-500 hover:bg-red-100 focus:ring-offset-red-50 focus:ring-red-600'
                break;
            case 'info':
                bgClass = 'bg-blue-50'
                iconClass = 'text-blue-400'
                iconComponent = 'InformationCircleIcon'
                titleClass = 'text-blue-800'
                messageClass = 'text-blue-700'
                dismissClass = 'bg-blue-50  text-blue-500 hover:bg-blue-100 focus:ring-offset-blue-50 focus:ring-blue-600'
                break;
        }

        return {
            bgClass,
            iconClass,
            iconComponent,
            titleClass,
            messageClass,
            dismissClass,
            show,
        }
    }
}
</script>
