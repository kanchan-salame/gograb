<template>
    <div class="bg-black">
        <jet-banner />
        <!-- <div class="relative h-screen flex overflow-hidden bg-white"></div> -->
            <div class="relative h-screen lg:flex lg:flex-shrink-0 bg-white overflow-hidden">
            <!-- Static sidebar for desktop -->
            <div class="hidden lg:flex lg:flex-shrink-0">
                <div class="flex flex-col w-64">
                    <div class="flex flex-col flex-grow lg:border-r lg:border-gray-200 lg:pb-4 lg:pt-5 lg:bg-gray-800 pt-5 pb-4 overflow-y-auto">
                        <common-links></common-links>
                    </div>
                </div>
            </div>
            <!-- Static sidebar for desktop end -->
            <div class="flex flex-col min-w-0 flex-1 overflow-hidden">
                <!-- Static Topbar -->
                <div class="lg:px-8 bg-white">
                    <top-bar-menu></top-bar-menu>
                </div>
                <!-- Static Topbar end -->
                <div class="flex-1 relative z-0 flex overflow-hidden">
                    <main class="flex-1 relative pb-8 z-0 overflow-y-auto bg-gray-100 h-screen">
                    <!-- Page header -->
                    <div class="bg-white shadow sm:px-6 lg:px-8" v-if="$slots.header">
                        <div class="px-4 sm:px-6 lg:px-8">
                            <div class="py-6 md:flex md:items-center md:justify-between lg:border-t lg:border-gray-200">
                                <div :class="{'w-full' : route().current() != 'dashboard' }">
                                        <slot name="header"></slot>
                                    <div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-8">
                        <div class="px-4 sm:px-6 lg:px-8">
                            <slot></slot>
                        </div>
                    </div>
                    </main>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import JetApplicationMark from '@/Jetstream/ApplicationMark.vue'
    import JetBanner from '@/Components/Jetstream/Banner.vue'
    import TopBarMenu from '@/Components/Ui/TopBarMenu.vue'
    // import SideBarMenu from '@/Components/Ui/SideBarMenu'
    import CommonLinks from '@/Components/Ui/CommonLinks.vue'

    export default {
        components: {
            JetApplicationMark,
            JetBanner,
            TopBarMenu,
            // SideBarMenu,
            CommonLinks,
        },
    }
</script>
