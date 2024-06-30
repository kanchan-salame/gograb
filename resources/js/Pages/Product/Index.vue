<script >
import AppLayout from "@/Layouts/AppLayout.vue";
import SubNavLink from "@/Components/Ui/SubNavLink.vue";
import SearchFilter from "@/Components/Ui/SearchFilter.vue";
import Pagination from "@/Components/Ui/Pagination.vue";
import { PlusIcon, PencilAltIcon, TrashIcon } from "@heroicons/vue/outline";
import JetConfirmationModal from "@/Components/Jetstream/ConfirmationModal.vue";
import JetDangerButton from "@/Jetstream/DangerButton.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import JetButton from "@/Jetstream/Button.vue";
import { Head, Link } from "@inertiajs/vue3";
import EmptyList from "@/Components/Ui/EmptyList.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

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
  },
  props: ["products"],
  data() {
    return {
      sliderBeingDeleted: null,
      sliderBeingToggled: null,
      toggleSliderForm: this.$inertia.form({}),
    };
  },
  methods: {
    confirmSliderDelete(slider) {
      this.sliderBeingDeleted = slider;
    },
    deleteSlider() {
      this.toggleSliderForm.delete(
        route("product.destroy", this.sliderBeingDeleted.id),
        {
          preserveScroll: true,
          preserveState: true,
          onSuccess: () => (this.sliderBeingDeleted = null),
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
  <Head title="Products" />
  <AppLayout title="Products">
    <template #header>
      <div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
        <div>
          <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            <span class="text-gray-800">Products</span>
          </h2>
        </div>
        <div class="ml-4 flex-shrink-0">
          <primary-button :href="route('product.create')" icon="Plus">
            Add Product
          </primary-button>
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
                  v-if="products.data.length"
                >
                  <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                      <tr>
                        <th
                          scope="col"
                          class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                          #
                        </th>
                        <th
                          scope="col"
                          class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                          ID
                        </th>
                        <th
                          scope="col"
                          class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                          Url
                        </th>
                        <th
                          scope="col"
                          class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                          Image
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
                        v-for="(product, index) in products.data"
                        :key="`user-${product.id}`"
                      >
                        <td class="px-6 py-4 whitespace-nowrap">
                          {{ index }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <div class="text-sm font-medium text-gray-900">
                            {{ product.id }}
                          </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <div class="text-sm text-gray-900">
                            {{ product.name }}
                          </div>
                        </td>
                        <td class="whitespace-nowrap text-right">
                          <img
                            :src="product.imagepath"
                            :alt="product.imagepath"
                            class="rounded-full h-20 w-20 object-cover"
                          />
                        </td>
                        <td
                          class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                        >
                          <div class="flex justify">
                            <a :href="route('product.edit', product.id)">
                              <pencil-alt-icon
                                class="ml-1 h-5 w-5 text-primary hover:text-dark cursor-pointer"
                              />
                            </a>
                            <button
                              @click.prevent="confirmSliderDelete(product)"
                            >
                              <TrashIcon
                                class="ml-1 h-5 w-5 text-red-500 cursor-pointer"
                              />
                            </button>
                          </div>
                        </td>
                      </tr>

                      <!-- More rows... -->
                    </tbody>
                  </table>
                  <pagination
                    :links="products.links"
                    :from="products.from"
                    :to="products.to"
                    :total="products.total"
                  />
                </div>
                <EmptyList
                  v-else
                  icon="ClockIcon"
                  title="No Product"
                  description="Product not found. Get started by adding a new Product."
                  button-title="Add Product"
                  :button-url="route('product.create')"
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
      :show="sliderBeingToggled"
      @close="sliderBeingToggled = null"
    >
      <template #title>
        {{ sliderBeingToggled.activated_at ? "Deactivate" : "Activate" }} Client
      </template>

      <template #content>
        Are you sure you would like to
        {{ sliderBeingToggled.activated_at ? "deactivate" : "activate" }}
        {{ sliderBeingToggled.id }}?
      </template>

      <template #footer>
        <jet-secondary-button @dblclick="sliderBeingToggled = null">
          Nevermind
        </jet-secondary-button>

        <jet-danger-button
          class="mr-2"
          @click="toggleClient"
          :class="{ 'opacity-25': toggleSliderForm.processing }"
          :disabled="toggleSliderForm.processing"
          v-if="sliderBeingToggled.activated_at"
        >
          Deactivate
        </jet-danger-button>
        <jet-button
          class="mr-2"
          @click="toggleClient"
          :class="{ 'opacity-25': toggleSliderForm.processing }"
          :disabled="toggleSliderForm.processing"
          v-else
        >
          Activate
        </jet-button>
      </template>
    </jet-confirmation-modal>
    <!-- User Delete  Confirmation Modal -->
    <jet-confirmation-modal
      :show="sliderBeingDeleted"
      @close="sliderBeingDeleted = null"
    >
      <template #title> Delete Slider </template>

      <template #content>
        Are you sure you would like to delete {{ sliderBeingDeleted.name }}?
      </template>

      <template #footer>
        <jet-secondary-button
          @click="sliderBeingDeleted = null"
          style="margin-right: 10px"
        >
          Nevermind
        </jet-secondary-button>

        <jet-danger-button class="mr-2" @click="deleteSlider">
          Delete
        </jet-danger-button>
      </template>
    </jet-confirmation-modal>
  </AppLayout>
</template>
