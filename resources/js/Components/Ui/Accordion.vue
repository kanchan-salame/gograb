<script setup lang="ts">
import { ref, onMounted } from "vue";
import { Head, Link } from '@inertiajs/vue3';
import { PlusIcon, PencilAltIcon, TrashIcon } from "@heroicons/vue/outline";
import { ClockIcon, TagIcon, MenuIcon   } from "@heroicons/vue/solid"
import { useForm } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";
import JetConfirmationModal from "@/Components/Jetstream/ConfirmationModal.vue";
import JetDangerButton from "@/Jetstream/DangerButton.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import JetButton from '@/Jetstream/Button.vue';

const accordionOpen = ref<boolean>(false);
const beingDeleted = ref<string>(null);
const toggleRestaurantForm = useForm({});

const props = defineProps<{
  title: string;
  id: string;
  image: string;
  description: string;
  active?: boolean;
  deleteRoute: string;
  editRoute: string;
  menuId: number;
  beingDeleted: {
    default: null
  }
}>();


onMounted(() => {
  accordionOpen.value = props.active;
});

const confirmDelete = (Id) => {
    console.log(props.beingDeleted);

    // props.beingDeleted = Id;
}

const closeDeleted = () => {
    console.log('hi');

    beingDeleted.value = null;
    console.log(beingDeleted.value);

}

const deleteMenu = (Id) => {
    console.log('delete');
    console.log(Id);
// return false;

    toggleRestaurantForm.delete(
        route(props.deleteRoute, Id),
        {
          preserveScroll: true,
          preserveState: true,
          onSuccess: () => (beingDeleted.value = null),
          onError: (errors) => {
            toast.error(errors.id);
          },
        }
      );
}
</script>

<template>
  <div class="py-2 bg-white">
    <div class="w-full lg:max-w-full lg:flex">
      <img
        :src="image"
        alt=""
        class="h-48 lg:h-auto lg:w-48 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden"
      />
      <div
        class="bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal"
      >
        <div class="mb-8">
          <div class="text-gray-900 font-bold text-xl mb-2">

            <div
              class="flex items-center justify-between w-full text-left font-semibold py-2"
            >
              <span>{{ title }}</span>
                <TrashIcon
                @click.prevent="confirmDelete(menuId)"
                class="ml-1 h-5 w-5 text-red-500 cursor-pointer"
                title="Delete Restaurant Menu"
              />

              <Link
                :href="editRoute"
                title="Edit Restaurant Menu"
              >
                <pencil-alt-icon class="h-5 w-5 text-primary hover:text-dark" />
              </Link>

              <button
                :id="`accordion-title-${id}`"
                @click.prevent="accordionOpen = !accordionOpen"
                :aria-expanded="accordionOpen"
                :aria-controls="`accordion-text-${id}`"
              >
                <svg
                  class="fill-indigo-500 shrink-0 ml-2"
                  width="16"
                  height="16"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <rect
                    y="7"
                    width="16"
                    height="2"
                    rx="1"
                    class="transform origin-center transition duration-200 ease-out"
                    :class="{ '!rotate-180': accordionOpen }"
                  />
                  <rect
                    y="7"
                    width="16"
                    height="2"
                    rx="1"
                    class="transform origin-center rotate-90 transition duration-200 ease-out"
                    :class="{ '!rotate-180': accordionOpen }"
                  />
                </svg>
              </button>
            </div>
          </div>
          <p class="text-gray-700 text-base">{{ description }}</p>
        </div>
      </div>
    </div>
    <div
      :id="`accordion-text-${id}`"
      role="region"
      :aria-labelledby="`accordion-title-${id}`"
      class="grid text-sm text-slate-600 overflow-hidden transition-all duration-300 ease-in-out"
      :class="
        accordionOpen
          ? 'grid-rows-[1fr] opacity-100'
          : 'grid-rows-[0fr] opacity-0'
      "
    >
      <div class="overflow-hidden">
        <p class="pb-3">
          <slot />
        </p>
      </div>
    </div>
  </div>

  <!-- Menu Delete  Confirmation Modal -->
    <!-- <jet-confirmation-modal
      :show="beingDeleted.value"
      @close="beingDeleted.value = null"
    >
      <template #title> Delete Menu </template>

      <template #content>
        Are you sure you would like to delete menu?
      </template>

      <template #footer>
        <jet-secondary-button
          @click="beingDeleted.value = null"
          style="margin-right: 10px"
        >
          Nevermind
        </jet-secondary-button>

        <jet-danger-button class="mr-2" @click="deleteMenu(menuId)">
          Delete
        </jet-danger-button>
      </template>
    </jet-confirmation-modal> -->
</template>
