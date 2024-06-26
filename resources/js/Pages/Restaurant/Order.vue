<script >
import AppLayout from "@/Layouts/AppLayout.vue";
import SubNavLink from "@/Components/Ui/SubNavLink.vue";
import SearchFilter from "@/Components/Ui/SearchFilter.vue";
import Pagination from "@/Components/Ui/Pagination.vue";
import { PlusIcon, PencilAltIcon, TrashIcon } from "@heroicons/vue/outline";
import JetConfirmationModal from "@/Components/Jetstream/ConfirmationModal.vue";
import JetDangerButton from "@/Jetstream/DangerButton.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import JetButton from '@/Jetstream/Button.vue';
import { Head, Link } from '@inertiajs/vue3';
import EmptyList from '@/Components/Ui/EmptyList.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ClockIcon, TagIcon, MenuIcon   } from "@heroicons/vue/solid"

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
    Head,
    EmptyList,
    PrimaryButton,
    Link,
    ClockIcon,
    TagIcon,
    MenuIcon
  },
  props: ["orders", "user_data"],
  data() {
    return {
      restaurantBeingDeleted: null,
      restaurantBeingToggled: null,
      toggleRestaurantForm: this.$inertia.form({}),
    };
  },
  methods: {
    confirmRestaurantDelete(restaurant) {
      this.restaurantBeingDeleted = restaurant;
    },
    deleteRestaurant() {
      this.toggleRestaurantForm.delete(
        route("restaurant.destroy", this.restaurantBeingDeleted.id),
        {
          preserveScroll: true,
          preserveState: true,
          onSuccess: () => (this.restaurantBeingDeleted = null),
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
<Head title="Orders" />
  <AppLayout title="Orders">
    <template #header>
      <div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
        <div>
          <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            <span class="text-gray-800">Orders</span>
          </h2>
        </div>
        <div class="ml-4 flex-shrink-0">
          <!-- <primary-button @click="$inertia.get(route('restaurant.create'))">
            Add Restaurant
          </primary-button> -->
        </div>
      </div>
    </template>

    <div>
      <div class="sm:px-6 lg:px-8 pb-20">
        <div>
          <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
              <div
                class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8"
              >
                <div
                  class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg"
                  v-if="orders.data.length"
                >
                  <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                      <tr>
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
                        v-for="(user, index) in orders.data"
                        :key="`user-${index}`"
                      >
                        <td class="px-6 py-4 whitespace-nowrap">
                          <div class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                            <img class="w-10 h-10 rounded-full" :src="user.restaurant_menu_item.imagepath" alt="Jese image">
                            <div class="ps-3">
                                <div class="text-base font-semibold">{{user.restaurant_menu_item.name}}</div>
                                <div class="font-normal text-gray-500">{{user.restaurant.name}}</div>
                            </div>
                          </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                          <div class="flex items-center">
                            <div class="text-sm text-gray-900 h-2.5 w-2.5 rounded-full bg-green-500 me-2"></div> {{ user.status }}
                        </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="items-center">
                                <div class="text-sm text-gray-900 ">
                                  Status: <b> {{ user.payment_status == null ? 'Not Paid' : 'Paid' }}</b>
                                </div>
                                <div class="text-sm text-gray-900 ">
                                  Type: <b>{{ user.payment_type == null ? 'Cash' : 'By Card' }}</b>
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
                          </div>
                        </td>
                      </tr>

                      <!-- More rows... -->
                    </tbody>
                  </table>
                  <pagination
                    :links="orders.links"
                    :from="orders.from"
                    :to="orders.to"
                    :total="orders.total"
                  />
                </div>
                <EmptyList
                  v-else
                  icon="ClockIcon"
                  title="No Food Orders"
                  description="Food Orders not found. Click on below button to continue shopping."
                /></div>
            </div>
          </div>
        </div>
      </div>
      <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8"></div>
    </div>
    <!-- User Active toggle Confirmation Modal -->
        <jet-confirmation-modal :show="restaurantBeingToggled" @close="restaurantBeingToggled = null">
            <template #title>
                {{ restaurantBeingToggled.activated_at ?  'Deactivate' : 'Activate' }} Client
            </template>

            <template #content>
                Are you sure you would like to {{ restaurantBeingToggled.activated_at ?  'deactivate' : 'activate' }} {{ restaurantBeingToggled.id }}?
            </template>

            <template #footer>
                <jet-secondary-button @dblclick="restaurantBeingToggled = null">
                    Nevermind
                </jet-secondary-button>

                <jet-danger-button class="mr-2" @click="toggleClient"
                    :class="{ 'opacity-25': toggleRestaurantForm.processing }" :disabled="toggleRestaurantForm.processing"
                    v-if="restaurantBeingToggled.activated_at">
                    Deactivate
                </jet-danger-button>
                <jet-button class="mr-2" @click="toggleClient"
                    :class="{ 'opacity-25': toggleRestaurantForm.processing }" :disabled="toggleRestaurantForm.processing"
                    v-else>
                    Activate
                </jet-button>
            </template>
        </jet-confirmation-modal>
    <!-- User Delete  Confirmation Modal -->
    <jet-confirmation-modal
      :show="restaurantBeingDeleted"
      @close="restaurantBeingDeleted = null"
    >
      <template #title> Delete Restaurant </template>

      <template #content>
        Are you sure you would like to delete {{ restaurantBeingDeleted.name }}?
      </template>

      <template #footer>
        <jet-secondary-button
          @click="restaurantBeingDeleted = null"
          style="margin-right: 10px"
        >
          Nevermind
        </jet-secondary-button>

        <jet-danger-button class="mr-2" @click="deleteRestaurant">
          Delete
        </jet-danger-button>
      </template>
    </jet-confirmation-modal>
  </AppLayout>
</template>
