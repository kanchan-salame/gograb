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
  props: ["goodTypes"],
  data() {
    return {
      goodTypeBeingDeleted: null,
      goodTypeBeingToggled: null,
      toggleCategoryForm: this.$inertia.form({}),
    };
  },
  methods: {
    confirmGoodTypeDelete(goodType) {
      this.goodTypeBeingDeleted = goodType;
    },
    deleteGoodType() {
      this.toggleCategoryForm.delete(
        route("goodType.destroy", this.goodTypeBeingDeleted.id),
        {
          preserveScroll: true,
          preserveState: true,
          onSuccess: () => (this.goodTypeBeingDeleted = null),
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
  <Head title="Good Types" />
  <AppLayout title="Good Types">
    <template #header>
      <div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
        <div>
          <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            <span class="text-gray-800">Good Types</span>
          </h2>
        </div>
        <div class="ml-4 flex-shrink-0">
          <primary-button :href="route('goodType.create')">
            Add Good Type
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
                  v-if="goodTypes.data.length"
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
                          Actions
                        </th>
                      </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                      <tr
                        v-for="(goodType, index) in goodTypes.data"
                        :key="`user-${goodType.id}`"
                      >
                        <td class="px-6 py-4 whitespace-nowrap">
                          {{ index }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <div class="text-sm font-medium text-gray-900">
                            {{ goodType.id }}
                          </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <div class="text-sm text-gray-900">
                            {{ goodType.name }}
                          </div>
                        </td>

                        <td
                          class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                        >
                          <div class="flex justify">
                            <Link :href="route('goodType.edit', goodType.id)">
                              <pencil-alt-icon
                                class="h-5 w-5 text-primary hover:text-dark"
                              />
                            </Link>
                            <button
                              @click.prevent="confirmGoodTypeDelete(goodType)"
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
                    :links="goodTypes.links"
                    :from="goodTypes.from"
                    :to="goodTypes.to"
                    :total="goodTypes.total"
                  />
                </div>
                <EmptyList
                  v-else
                  icon="ClockIcon"
                  title="No Good Types"
                  description="Good Types not found. Get started by adding a new Good Type."
                  button-title="Add Good Type"
                  :button-url="route('goodType.create')"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8"></div>
    </div>

    <!-- User Delete  Confirmation Modal -->
    <jet-confirmation-modal
      :show="goodTypeBeingDeleted"
      @close="goodTypeBeingDeleted = null"
    >
      <template #title> Delete Good Type </template>

      <template #content>
        Are you sure you would like to delete {{ goodTypeBeingDeleted.name }}?
      </template>

      <template #footer>
        <jet-secondary-button
          @click="goodTypeBeingDeleted = null"
          style="margin-right: 10px"
        >
          Nevermind
        </jet-secondary-button>

        <jet-danger-button class="mr-2" @click="deleteGoodType">
          Delete
        </jet-danger-button>
      </template>
    </jet-confirmation-modal>
  </AppLayout>
</template>
