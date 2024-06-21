<template>
    <div>
        <div
            class="
                pb-7
                grid grid-cols-1
                gap-3
                sm:gap-6
                sm:grid-cols-3
                md:grid-cols-3
                lg:grid-cols-3
            "
        >
            <div class="col-span-1">
                <form @submit.prevent="applyFilter(filterStatus)" method="GET">
                    <div
                        class="
                            flex
                            border border-gray-300
                            rounded-l-md
                            rounded-md
                            overflow-hidden
                            relative
                        "
                    >
                            <span
                                class="
                                    inline-flex
                                    items-center
                                    px-3
                                    border-r border-gray-300
                                    bg-gray-50
                                    text-gray-500
                                    sm:text-sm
                                "
                            >
                                <SearchIcon class="h-6 w-6 text-gray-400" />
                            </span>
                        <input
                            id="name"
                            v-model="searchTerm"
                            placeholder="Search"
                            name="name"
                            type="text"
                            class="
                                block
                                w-full
                                z-10
                                border-0
                                rounded-r-md
                                focus:outline-none
                                focus:ring-0
                                focus:ring-white
                                focus:ring-opacity-0
                            "
                        />
                        <div
                            v-if="searchTerm != ''"
                            class="
                                absolute
                                inset-y-0
                                right-0
                                pr-3
                                flex
                                items-center
                                cursor-pointer
                                z-20
                            "
                        >
                            <XCircleIcon
                                class="
                                    h-5
                                    w-5
                                    text-gray-400
                                    hover:text-gray-500
                                "
                                @click="clearSearch"
                                aria-hidden="true"
                            />
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-span-1"></div>
            <div class="col-span-1">
                <div class="sm:hidden w-full mt-1">
                    <label for="tabs" class="sr-only">Select a tab</label>
                    <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
                    <select
                        id="tabs"
                        name="tabs"
                        v-model="filterStatus"
                        @change="applyFilter(filterStatus)"
                        class="
                            block
                            w-full
                            focus:border-medium-blue focus:ring-light-blue
                            border-gray-300
                            rounded-md
                            text-gray-500
                        "
                    >
                        <option value="">All</option>

                        <option value="active">Active</option>

                        <option value="inactive">In-Active</option>
                    </select>
                </div>
                <div class="hidden sm:block">
                    <nav class="flex space-x-4 sm:justify-end sm:items-center" aria-label="Tabs">
                        <a
                            v-for="(filter, index) in filterLinks"
                            :key="index"
                            href="#"
                            @click="applyFilter(filter.value)"
                            class="
                                text-gray-500
                                hover:deep-blue
                                px-3
                                py-2
                                font-medium
                                text-sm
                                rounded-md
                            "
                            :class="{
                                'bg-light-blue text-dark':
                                    filterStatus == filter.value,
                            }"
                        >
                            {{ filter.title }}
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, onMounted, reactive } from "vue";
import { router } from "@inertiajs/vue3";
// import * as Inertia from '@inertiajs/inertia';
import { XCircleIcon, SearchIcon } from "@heroicons/vue/outline";
export default {
    components: {
        XCircleIcon,
        SearchIcon,
    },
    props: {
        filterLinks: {
            type: Array,
            default: [],
        },
        searchFilterKey: {
            type: String,
            default: 'name'
        }
    },
    setup: (props) => {
        const route = window.route;
        const filterStatus = ref("active");

        onMounted(() => {
            const filter = route().params.hasOwnProperty("filter")
                ? route().params.filter
                : { role: "", id: "" };
            filterStatus.value =
                typeof filter.role != "undefined" ? filter.role : "";
            searchTerm.value =
                typeof filter[props.searchFilterKey] != "undefined" ? filter[props.searchFilterKey] : "";
        });

        /** Filter and Search Logic start */
        const searchTerm = ref("");

        const applyFilter = (role) => {
            let filters = {};
            filters = Object.assign(filters, route().params.filter);
            filters = Object.assign(filters, {role: role});
            filters[props.searchFilterKey ] = searchTerm.value;
            filterStatus.value = role;
            router.visit(route(route().current()), {
                method: "get",
                preserveState: true,
                data: {
                    filter: filters,
                },
            });
        };

        const clearSearch = () => {
            searchTerm.value = "";
            applyFilter(filterStatus.value);
        };
        /** Filter and Search Logic end  */

        return {
            searchTerm,
            filterStatus,
            applyFilter,
            clearSearch,
        };
    },
};
</script>

<style></style>
