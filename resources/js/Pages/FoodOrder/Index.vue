<script >
import AppLayout from "@/Layouts/AppLayout.vue";
import SubNavLink from "@/Components/Ui/SubNavLink.vue";
import SearchFilter from "@/Components/Ui/SearchFilter.vue";
import Pagination from "@/Components/Ui/Pagination.vue";
import { PlusIcon, PencilAltIcon, TrashIcon, UserCircleIcon, ShieldCheckIcon  } from "@heroicons/vue/outline";
import JetConfirmationModal from "@/Components/Jetstream/ConfirmationModal.vue";
import JetDangerButton from "@/Jetstream/DangerButton.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import JetButton from "@/Jetstream/Button.vue";
import EmptyList from "@/Components/Ui/EmptyList.vue";
import InputSelect from "@/Components/Form/Select.vue";
import { useForm } from "@inertiajs/vue3";
import JetLabel from "@/Jetstream/Label.vue";

export default {
  components: {
    AppLayout,
    SubNavLink,
    SearchFilter,
    Pagination,
    PlusIcon,
    PencilAltIcon,
    TrashIcon,
    JetConfirmationModal,
    JetDangerButton,
    JetSecondaryButton,
    JetButton,
    EmptyList,
    InputSelect,
    UserCircleIcon,
    ShieldCheckIcon,
    JetLabel
  },
  props: ["foodOrders", "drivers"],
  setup(props){
    const form = useForm({
        _method: 'POST',
      driver: "",
    });

    const driversOption = [];
    console.log(props.drivers);

    props.drivers.forEach(element => {
        let option = { 'value': element.id, 'label': element.name}
        driversOption.push(option)
    });



    return {
        form,
        driversOption,
        }
  },
  data() {



    return {
      userBeingDeleted: null,
      userBeingToggled: null,
      orderBeingAssigned: null,
      filterStatus: "",
      toggleUserForm: this.$inertia.form({}),
      toggleAssignDriverForm: this.$inertia.form({}),
      searchTerm: "",
      filters: [
        {
          title: "All",
          value: "",
        },
        {
          title: "Processing",
          value: "processing",
        },
        {
          title: "Cancelled",
          value: "cancelled",
        },
        {
          title: "Completed",
          value: "completed",
        },
      ],
      statusOption: [
            {
          label: "Dispached",
          value: "dispached",
        },
        {
          label: "Delivered",
          value: "delivered",
        },
        {
          label: "Processing",
          value: "processing",
        },
        {
          label: "Cancelled",
          value: "cancelled",
        },
        {
          title: "Completed",
          value: "completed",
        },
      ]
    };
  },
  methods: {
    confirmUserDelete(client) {
      this.userBeingDeleted = client;
    },
    confirmAassignToDriver(client) {
      this.orderBeingAssigned = client;
    },

    sassignToDriver() {
        // Save slider
      const options = {
        errorBag: "sassignToDriver",
        preserveScroll: (page) => Object.keys(page.props.errors).length,
        onSuccess: () => (this.orderBeingAssigned = null),
        onError: () => {
          toast.error("Please check form errors!", {
                position: toast.POSITION.BOTTOM_RIGHT,
            });
        },
      };
        this.form.post(route("foodOrder.assignToDriver", this.orderBeingAssigned.id ), options);

    },

    deleteUser() {
      this.toggleUserForm.delete(
        route("foodOrders.destroy", this.userBeingDeleted.id),
        {
          preserveScroll: true,
          preserveState: true,
          onSuccess: () => (this.userBeingDeleted = null),
          onError: (errors) => {
            const toast = useToast();
            toast.error(errors.id);
          },
        }
      );
    },
  },
};
</script>

<template>
  <AppLayout>
    <template #header>
      <div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
        <div>
          <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            <span class="text-gray-800">Food Orders</span>
          </h2>
        </div>
        <div class="ml-4 flex-shrink-0">
          <!-- <sub-nav-link :href="route('foodOrders.create')" icon="Plus">
            Add User
          </sub-nav-link> -->
        </div>
      </div>
    </template>

    <div>
      <div class="sm:px-6 lg:px-8 pb-20">
        <search-filter :filterLinks="filters" />
        <div>
          <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
              <div
                class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8"
              >
                <div
                  class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg"
                  v-if="foodOrders.data.length"
                >
                  <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                      <tr>
                        <th
                          scope="col"
                          class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                          #ID
                        </th>
                        <th
                          scope="col"
                          class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                          Food Item
                        </th>
                        <th
                          scope="col"
                          class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                          Status
                        </th>
                        <th
                          scope="col"
                          class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                          Payment Status
                        </th>
                        <th
                          scope="col"
                          class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                          Actions
                        </th>
                      </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                      <tr
                        v-for="(user, index) in foodOrders.data"
                        :key="`user-${index}`"
                      >
                        <td class="px-6 py-4 whitespace-nowrap">
                          <div
                            class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white"
                          >
                            {{ user.id }}
                          </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <div
                            class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white"
                          >
                            <img
                              class="w-10 h-10 rounded-full"
                              :src="user.restaurant_menu_item.imagepath"
                              alt="Jese image"
                            />
                            <div class="ps-3">
                              <div class="text-base font-semibold">
                                {{ user.restaurant_menu_item.name }}
                              </div>
                              <div class="font-normal text-gray-500">
                                {{ user.restaurant.name }}
                              </div>
                            </div>
                          </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                          <div class="flex items-center">
                            <div
                              class="text-sm text-gray-900 h-2.5 w-2.5 rounded-full bg-green-500 me-2"
                            ></div>
                            {{ user.status }}
                          </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <div class="items-center">
                            <div class="text-sm text-gray-900">
                              Status:
                              <b>
                                {{
                                  user.payment_status == null
                                    ? "Not Paid"
                                    : "Paid"
                                }}</b
                              >
                            </div>
                            <div class="text-sm text-gray-900">
                              Type:
                              <b>{{
                                user.payment_type == null ? "Cash" : "By Card"
                              }}</b>
                            </div>
                          </div>
                        </td>
                        <td
                          class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                        >
                          <div class="flex justify">
                            <TrashIcon
                              @click.prevent="confirmUserDelete(user)"
                              class="ml-1 h-5 w-5 text-red-500 cursor-pointer"
                            />
                            <UserCircleIcon
                                title="Assign to Driver"
                                @click.prevent="confirmAassignToDriver(user)"
                                class="ml-1 h-5 w-5 text-red-500 cursor-pointer"
                            />
                            <ShieldCheckIcon
                                title="Change Status"
                                @click.prevent="confirmAassignToDriver(user)"
                                class="ml-1 h-5 w-5 text-red-500 cursor-pointer"
                            />

                          </div>
                        </td>
                      </tr>

                      <!-- More rows... -->
                    </tbody>
                  </table>
                  <pagination
                    :links="foodOrders.links"
                    :from="foodOrders.from"
                    :to="foodOrders.to"
                    :total="foodOrders.total"
                  />
                </div>
                <EmptyList
                  v-else
                  icon="ClockIcon"
                  title="No Food Orders"
                  description="Food Orders not found. Click on below button to continue shopping."
                />
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8"></div>
    </div>
    <!-- User Active toggle Confirmation Modal -->
    <jet-confirmation-modal
      :show="userBeingToggled"
      @close="userBeingToggled = null"
    >
      <template #title>
        {{ userBeingToggled.activated_at ? "Deactivate" : "Activate" }} Client
      </template>

      <template #content>
        Are you sure you would like to
        {{ userBeingToggled.activated_at ? "deactivate" : "activate" }}
        {{ userBeingToggled.name }}?
      </template>

      <template #footer>
        <jet-secondary-button @dblclick="userBeingToggled = null">
          Nevermind
        </jet-secondary-button>

        <jet-danger-button
          class="mr-2"
          @click="toggleClient"
          :class="{ 'opacity-25': toggleUserForm.processing }"
          :disabled="toggleUserForm.processing"
          v-if="userBeingToggled.activated_at"
        >
          Deactivate
        </jet-danger-button>
        <jet-button
          class="mr-2"
          @click="toggleClient"
          :class="{ 'opacity-25': toggleUserForm.processing }"
          :disabled="toggleUserForm.processing"
          v-else
        >
          Activate
        </jet-button>
      </template>
    </jet-confirmation-modal>
    <!-- User Delete  Confirmation Modal -->
    <jet-confirmation-modal
      :show="userBeingDeleted"
      @close="userBeingDeleted = null"
    >
      <template #title> Delete User </template>

      <template #content>
        Are you sure you would like to delete {{ userBeingDeleted.name }}?
      </template>

      <template #footer>
        <jet-secondary-button
          @click="userBeingDeleted = null"
          style="margin-right: 10px"
        >
          Nevermind
        </jet-secondary-button>

        <jet-danger-button class="mr-2" @click="deleteUser">
          Delete
        </jet-danger-button>
      </template>
    </jet-confirmation-modal>

    <!-- User Delete  Confirmation Modal -->
    <jet-confirmation-modal
      :show="orderBeingAssigned"
      @close="orderBeingAssigned = null"
    >
      <template #title> Assign To Driver </template>

      <template #content>
        Are you sure you would like to assign to driver?

        <div class="flex rounded-md shadow-sm mt-1">
              <input-select
                id="serviceCategory"
                class="flex-1 block w-full rounded"
                :options="driversOption"
                v-model="form.driver"
                :empty="'Select Driver'"
              />
            </div>
      </template>

      <template #footer>
        <jet-secondary-button
          @click="orderBeingAssigned = null"
          style="margin-right: 10px"
        >
          Nevermind
        </jet-secondary-button>

        <jet-danger-button class="mr-2" @click="sassignToDriver">
          Assign To Driver
        </jet-danger-button>
      </template>
    </jet-confirmation-modal>

    <!-- User Delete  Confirmation Modal -->
    <jet-confirmation-modal
      :show="orderBeingAssigned"
      @close="orderBeingAssigned = null"
    >
      <template #title> Change Status </template>

      <template #content>
        Are you sure you would like to change status of order?

        <div class="flex rounded-md shadow-sm mt-1">
                <jet-label for="image" value="Change Status" />
              <input-select
                id="serviceCategory"
                class="flex-1 block w-full rounded"
                :options="statusOption"
                v-model="form.status"
                :empty="'Select Status'"
              />
            </div>
            <div class="flex rounded-md shadow-sm mt-1">
              <jet-label for="image" value="Status Reason" />
              <textarea cols="30" rows="10"
                class="flex-1 block w-full rounded"
                v-model="form.status_reason"
              ></textarea>
            </div>
      </template>

      <template #footer>
        <jet-secondary-button
          @click="orderBeingAssigned = null"
          style="margin-right: 10px"
        >
          Nevermind
        </jet-secondary-button>

        <jet-danger-button class="mr-2" @click="sassignToDriver">
          Assign To Driver
        </jet-danger-button>
      </template>
    </jet-confirmation-modal>
  </AppLayout>
</template>
