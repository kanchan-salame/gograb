<template>
    <div class="text-center">
        <component :is="iconComponent" class="mx-auto h-12 w-12 text-gray-400" v-if="icon"></component>
        <h3 class="mt-2 text-sm font-medium text-gray-900">{{ title }}</h3>
        <p class="mt-1 text-sm text-gray-500">
            {{ description }}
        </p>
        <div class="mt-6">
            <jet-button type="button" class="text-sm px-10"
                @click="$inertia.get(buttonUrl)">
                <PlusIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
                {{ buttonTitle }}
            </jet-button>
        </div>
  </div>
</template>

<script>
import { PlusIcon } from '@heroicons/vue/outline'
import { defineAsyncComponent, computed } from 'vue'
import JetButton from '@/Jetstream/Button'

export default {
    props: {
        title: {
            type: String,
            default: 'No records',
        },
        description: {
            type: String,
            default: 'Get started by creating a new record',
        },
        buttonTitle: {
            type: String,
            default: 'New Record',
        },
        buttonUrl:  {
            type: String,
            default: '',
        },
        icon: {
            type: String,
            default: 'FolderAddIcon'
        }
    },

     components: {
        PlusIcon,
        JetButton,
    },

    setup(props) {
        const iconComponent = computed(() => {
            return defineAsyncComponent(() => import(`@heroicons/vue/outline/${props.icon}.js`))
        })

        return {
            iconComponent,
        }
    },
}
</script>
