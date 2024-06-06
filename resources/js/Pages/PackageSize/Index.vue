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
import { ClockIcon, TagIcon, MenuIcon } from "@heroicons/vue/solid";
import Accordion from "@/Components/Ui/Accordion.vue";

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
    MenuIcon,
    Accordion,
  },
  props: ["packageSizes"],
  data() {
    return {
      packageSizeBeingDeleted: null,
      packageSizeBeingToggled: null,
      togglePackageSizeForm: this.$inertia.form({}),
    };
  },
  methods: {
    confirmPackageSizeDelete(packageSize) {
      this.packageSizeBeingDeleted = packageSize;
    },
    deletePackageSize() {
      this.togglePackageSizeForm.delete(
        route("packageSize.destroy", this.packageSizeBeingDeleted.id),
        {
          preserveScroll: true,
          preserveState: true,
          onSuccess: () => (this.packageSizeBeingDeleted = null),
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
  <Head title="Package Size" />
  <AppLayout title="Package Size">
    <template #header>
      <div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
        <div>
          <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            <span class="text-gray-800">Package Size</span>
          </h2>
        </div>
        <div class="ml-4 flex-shrink-0">
          <primary-button @click="$inertia.get(route('packageSize.create'))">
            Add Package Size
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
                  class="bg-white overflow-hidden border-b border-gray-200 sm:rounded-lg"
                  v-if="packageSizes.data.length"
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
                          Title
                        </th>
                        <th
                          scope="col"
                          class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                          Description
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
                          Image Url
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
                        v-for="(packageSize, index) in packageSizes.data"
                        :key="`menus-${index}`"
                      >
                        <td class="px-6 py-4 whitespace-nowrap">
                          {{ index }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <div class="text-sm font-medium text-gray-900">
                            {{ packageSize.title }}
                          </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <div class="text-sm text-gray-900">
                            {{ packageSize.description }}
                          </div>
                        </td>
                        <td class="whitespace-nowrap text-right">
                          <img
                            :src="packageSize.imagepath"
                            :alt="packageSize.imagepath"
                            class="rounded-full h-20 w-20 object-cover"
                          />
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                          <div class="text-sm text-gray-900">
                            {{ packageSize.price }}
                          </div>
                        </td>
                        <td
                          class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                        >
                          <div class="flex justify">
                            <Link
                              :href="route('packageSize.edit', packageSize.id)"
                              title="Edit Package Size"
                            >
                              <pencil-alt-icon
                                class="h-5 w-5 text-primary hover:text-dark"
                              />
                            </Link>

                            <TrashIcon
                              @click.prevent="
                                confirmPackageSizeDelete(packageSize)
                              "
                              class="ml-1 h-5 w-5 text-red-500 cursor-pointer"
                              title="Delete Restaurant"
                            />
                          </div>
                        </td>
                      </tr>

                      <!-- More rows... -->
                    </tbody>
                  </table>
                  <pagination
                    :links="packageSizes.links"
                    :from="packageSizes.from"
                    :to="packageSizes.to"
                    :total="packageSizes.total"
                  />
                </div>
                <EmptyList
                  v-else
                  icon="ClockIcon"
                  title="No Package Size"
                  description="Package Size not found. Get started by adding a new Package Sizes."
                  button-title="Add Package Sizes"
                  :button-url="route('packageSize.create')"
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
      :show="packageSizeBeingToggled"
      @close="packageSizeBeingToggled = null"
    >
      <template #title>
        {{ packageSizeBeingToggled.activated_at ? "Deactivate" : "Activate" }}
        Client
      </template>

      <template #content>
        Are you sure you would like to
        {{ packageSizeBeingToggled.activated_at ? "deactivate" : "activate" }}
        {{ packageSizeBeingToggled.id }}?
      </template>

      <template #footer>
        <jet-secondary-button @dblclick="packageSizeBeingToggled = null">
          Nevermind
        </jet-secondary-button>

        <jet-danger-button
          class="mr-2"
          @click="toggleClient"
          :class="{ 'opacity-25': togglePackageSizeForm.processing }"
          :disabled="togglePackageSizeForm.processing"
          v-if="packageSizeBeingToggled.activated_at"
        >
          Deactivate
        </jet-danger-button>
        <jet-button
          class="mr-2"
          @click="toggleClient"
          :class="{ 'opacity-25': togglePackageSizeForm.processing }"
          :disabled="togglePackageSizeForm.processing"
          v-else
        >
          Activate
        </jet-button>
      </template>
    </jet-confirmation-modal>
    <!-- User Delete  Confirmation Modal -->
    <jet-confirmation-modal
      :show="packageSizeBeingDeleted"
      @close="packageSizeBeingDeleted = null"
    >
      <template #title> Delete Package Size </template>

      <template #content>
        Are you sure you would like to delete
        {{ packageSizeBeingDeleted.title }}?
      </template>

      <template #footer>
        <jet-secondary-button
          @click="packageSizeBeingDeleted = null"
          style="margin-right: 10px"
        >
          Nevermind
        </jet-secondary-button>

        <jet-danger-button class="mr-2" @click="deletePackageSize">
          Delete
        </jet-danger-button>
      </template>
    </jet-confirmation-modal>
  </AppLayout>
</template>
