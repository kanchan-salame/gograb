<template>
    <div class="flex-shrink-0">
        <div class="overflow-hidden -space-x-1">
            <img v-for="user in visibleUsers"
                :key="user.id"
                class="inline-block h-6 w-6 rounded-full ring-2 ring-white"
                :src="user.profile_photo_url" :alt="user.name" />
            <span v-if="hiddenUsersCount" class="text-sm font-medium text-gray-400 pl-1">
                + {{ hiddenUsersCount }}
            </span>
        </div>
    </div>
</template>

<script>
import { reactive } from '@vue/reactivity'
import { computed } from 'vue'
export default {
    props: {
        users: {
            type: Array,
            default: [],
        },
        max: {
            type: Number,
            default: 5,
        }
    },

    setup(props) {
        const visibleUsers = computed(() => {
            return props.users.slice(0, props.max)
        })

        const hiddenUsersCount = computed(() => {
            const count = props.users.length - props.max
            return count > 0 ? count : 0
        })

        return {
            visibleUsers,
            hiddenUsersCount,
        }
    },
}
</script>
