<template>
    <modal
        :show="show"
        :max-width="maxWidth"
        :closeable="closeable"
        @close="close"
    >
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-center">
                <div
                    class="
                        mx-auto
                        flex-shrink-0 flex
                        items-center
                        justify-center
                        h-12
                        w-12
                        rounded-full
                        bg-red-100
                        sm:mx-0 sm:h-10 sm:w-10
                    "
                >
                    <MailIcon class="h-6 w-6" />
                </div>

                <div
                    class="
                        mt-3
                        flex
                        items-center
                        text-center
                        sm:mt-0 sm:ml-4 sm:text-left
                    "
                >
                    <h3 class="text-lg">
                        <slot name="title"></slot>
                    </h3>
                </div>
            </div>
        </div>
        <div class="mt-2">
            <slot name="content">
                <div class="px-8">
                    <Dropdown
                        :filter="true"
                        v-model="selectedUser"
                        :options="filteredUsers"
                        optionLabel="name"
                        placeholder="Select a user to add"
                        class="w-full mb-2"
                        @change="onOptionSelect"
                    >
                        <template #value="slotProps">
                            <div v-if="slotProps.value" class="flex">
                                <span>{{ slotProps.option }}</span>
                            </div>
                            <span v-else>
                                {{ slotProps.placeholder }}
                            </span>
                        </template>
                        <template #option="slotProps">
                            <div class="flex">
                                <span>{{ slotProps.option.name }}</span>
                            </div>
                        </template>
                    </Dropdown>
                    <div class="grid grid-cols-1">
                        <ul class="divide-y divide-gray-200">
                            <li
                                class="py-4 flex"
                                v-for="id in mailingList"
                                :key="id"
                            >
                                <div
                                    class="
                                        ml-3
                                        flex
                                        items-center
                                        justify-between
                                        w-full
                                    "
                                >
                                    <div
                                        class="
                                            text-sm
                                            font-medium
                                            text-gray-900
                                        "
                                    >
                                        {{ getUser(id).name }}
                                        <span v-if="getUser(id).type" class="ml-2 sinline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">{{getUser(id).type}}</span>
                                    </div>
                                    <div
                                        @click.native="remove(id)"
                                        class="
                                            text-sm
                                            font-medium
                                            text-gray-900
                                        "
                                    >
                                        <a href="#">
                                            <x-icon
                                                class="
                                                    h-5
                                                    w-5
                                                    text-gray-400
                                                    mr-2
                                                "
                                            />
                                        </a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <h1 class="mt-4">Email Body</h1>
                    <textarea v-model="mailBody" class="w-full  border border-gray-300 rounded" />
                </div>
                <slot name="errors"></slot>
            </slot>
        </div>

        <div class="px-6 py-4 bg-gray-100 text-right flex justify-end">
            <slot name="footer"> </slot>
        </div>
    </modal>
</template>

<script>
import Modal from "@/Components/Jetstream/Modal";
import { MailIcon } from "@heroicons/vue/solid";
import Dropdown from "primevue/dropdown";
import { XIcon } from "@heroicons/vue/outline";


export default {
    emits: ["close", "optionSelect"],

    components: {
        Modal,
        MailIcon,
        Dropdown,
        XIcon,
    },
    inheritAttrs: false,

    props: {
        show: {
            default: false,
        },
        maxWidth: {
            default: "2xl",
        },
        closeable: {
            default: true,
        },
        mailOptions: {
            type: Object,
            default: {},
        },
    },
    data() {
        return {
            selectedUser: null,
            filteredUser: [],
            mailingList: [],
            mailBody: this.mailOptions.client.team.name + ' has sent an invoice #' + this.mailOptions.number + ' to you. Please find the invoice attached to this email. Request you to please acknowledge the receipt of the invoice and let us know once the transfer is initiated.',
        };
    },
    mounted() {
        if (this.mailOptions) {
            this.filteredUser = this.mailOptions.client.contacts;
            this.mailOptions.client.primary_contact.type = 'primary'
            this.filteredUser.push(this.mailOptions.client.primary_contact);
            this.mailingList.push(this.mailOptions.client.primary_contact.id);
        }
    },
    computed: {
        filteredUsers() {
            // We want to show only those users in the dropdown
            // who are not already added and are not in exclude list
            return _.filter(this.filteredUser, (user) => {
                return _.indexOf(this.mailingList, user.id) === -1;
            });
        },
    },
    watch: {
        selectedUser(value) {
            // When selectedUser changes i.e. a user is selected in the dropdown
            // then push the selected user to projectUsers array
            if (value) {
                this.mailingList.push(value.id);
                // Null out the selected user so that another selection can be made
                this.selectedUser = null;
            }
        },
    },
    methods: {
        close() {
            this.$emit("close");
        },
        onOptionSelect() {
            this.$emit('optionSelect');
        },
        remove(id) {
            const index = _.findIndex(this.mailingList, (val) => {
                return val == id;
            });

            index !== -1 ? this.mailingList.splice(index, 1) : "";
        },

        getUser(id) {
            return this.filteredUser.find((user) => {
                return user.id == id;
            });
        },

        getMailingList() {
            let mailingListTemp = [];
            mailingListTemp[0] = {};
            mailingListTemp[1] = {};
            this.mailingList.map(mailId => {
                let user = this.getUser(mailId);
                if(user.type === 'primary') {
                    mailingListTemp[0][user.email] = user.name
                }else {
                    mailingListTemp[1][user.email] = user.name
                }
            })
            return mailingListTemp;
        },
        getMailBody() {
            return this.mailBody
        },
    },
};
</script>
