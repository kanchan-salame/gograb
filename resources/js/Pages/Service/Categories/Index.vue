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
    Link
  },
  props: ["serviceCategories"],
  data() {
    return {
      categoryBeingDeleted: null,
      categoryBeingToggled: null,
      toggleCategoryForm: this.$inertia.form({}),
    };
  },
  methods: {
    confirmCategoryDelete(category) {
      this.categoryBeingDeleted = category;
    },
    deleteCategory() {
      this.toggleCategoryForm.delete(
        route("serviceCategory.destroy", this.categoryBeingDeleted.id),
        {
          preserveScroll: true,
          preserveState: true,
          onSuccess: () => (this.categoryBeingDeleted = null),
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
  <Head title="Service Categories" />
  <AppLayout title="Service Categories">
    <template #header>
      <div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
        <div>
          <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            <span class="text-gray-800">Service Categories</span>
          </h2>
        </div>
        <div class="ml-4 flex-shrink-0">
          <primary-button :href="route('serviceCategory.create')" icon="Plus">
            Add Service Category
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
                  v-if="serviceCategories.data.length"
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
                          Name
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
                        v-for="(serviceCategory, index) in serviceCategories.data"
                        :key="`user-${serviceCategory.id}`"
                      >
                        <td class="px-6 py-4 whitespace-nowrap">
                          {{ index }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <div class="text-sm font-medium text-gray-900">
                            {{ serviceCategory.id }}
                          </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <div class="text-sm text-gray-900">
                            {{ serviceCategory.name }}
                          </div>
                        </td>
                        <td class="whitespace-nowrap text-right">
                          <img :src="serviceCategory.imagepath" :alt="serviceCategory.imagepath" class="rounded-full h-20 w-20 object-cover" />
                        </td>
                        <td
                          class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                        >
                          <div class="flex justify">
                            <Link :href="route('serviceCategory.edit', serviceCategory.id)">
                              <pencil-alt-icon
                                class="h-5 w-5 text-primary hover:text-dark"
                              />
                            </Link>
                            <button
                              @click.prevent="confirmCategoryDelete(serviceCategory)"
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
                    :links="serviceCategories.links"
                    :from="serviceCategories.from"
                    :to="serviceCategories.to"
                    :total="serviceCategories.total"
                  />
                </div>
                <EmptyList
                  v-else
                  icon="ClockIcon"
                  title="No Service Categories"
                  description="Service Categories not found. Get started by adding a new Service Category."
                  button-title="Add Service Category"
                  :button-url="route('serviceCategory.create')"
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
      :show="categoryBeingToggled"
      @close="categoryBeingToggled = null"
    >
      <template #title>
        {{
          categoryBeingToggled.activated_at ? "Deactivate" : "Activate"
        }}
        Client
      </template>

      <template #content>
        Are you sure you would like to
        {{ categoryBeingToggled.activated_at ? "deactivate" : "activate" }}
        {{ categoryBeingToggled.id }}?
      </template>

      <template #footer>
        <jet-secondary-button @dblclick="categoryBeingToggled = null">
          Nevermind
        </jet-secondary-button>

        <jet-danger-button
          class="mr-2"
          @click="toggleClient"
          :class="{ 'opacity-25': toggleCategoryForm.processing }"
          :disabled="toggleCategoryForm.processing"
          v-if="categoryBeingToggled.activated_at"
        >
          Deactivate
        </jet-danger-button>
        <jet-button
          class="mr-2"
          @click="toggleClient"
          :class="{ 'opacity-25': toggleCategoryForm.processing }"
          :disabled="toggleCategoryForm.processing"
          v-else
        >
          Activate
        </jet-button>
      </template>
    </jet-confirmation-modal>
    <!-- User Delete  Confirmation Modal -->
    <jet-confirmation-modal
      :show="categoryBeingDeleted"
      @close="categoryBeingDeleted = null"
    >
      <template #title> Delete Category </template>

      <template #content>
        Are you sure you would like to delete {{ categoryBeingDeleted.name }}?
      </template>

      <template #footer>
        <jet-secondary-button
          @click="categoryBeingDeleted = null"
          style="margin-right: 10px"
        >
          Nevermind
        </jet-secondary-button>

        <jet-danger-button class="mr-2" @click="deleteCategory">
          Delete
        </jet-danger-button>
      </template>
    </jet-confirmation-modal>
  </AppLayout>
</template>
