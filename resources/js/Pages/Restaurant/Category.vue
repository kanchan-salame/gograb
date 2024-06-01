<template>
  <app-layout>
    <Head title="Update Category" />
    <template #header>
      <div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
        <div>
          <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            <span class="text-gray-800">
              Update Restaurant Food Category
            </span>
          </h2>
        </div>
        <div class="ml-4 flex-shrink-0 relative z-1">
          <primary-button @click="$inertia.get(route('restaurant.index'))">
            Go Back
          </primary-button>
        </div>
      </div>
    </template>

    <div>
      <div class="pb-10 sm:px-6 lg:px-8">
        <jet-form-section class="mt-10 sm:mt-0">
          <template #title> Restaurant Category Settings </template>
          <template #description>
            Please select food categories for the
            Restaurant.
          </template>
          <template #form>
            <div class="col-span-6 sm:col-span-4">
              <div v-for="(category, index) in categories" :key="`category-${category.id}`">
                <input v-model="form.categories" id="index" :value="category.id" type="checkbox"
                    :checked="checked"
                >  {{ category.name}}

                <jet-input-error :message="form.errors.categories" class="mt-2" />
              </div>
            </div>
          </template>
        </jet-form-section>
        <form-actions>
      <jet-action-message class="mr-3"> Added. </jet-action-message>
      <jet-secondary-button
        class="text-sm px-10"
        @click="$inertia.get(route('restaurant.index'))"
      >
        Nevermind
      </jet-secondary-button>
      <primary-button
        class="ml-2 text-sm px-10"
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
        @click="saveRestaurantCategories"
      >
        Update Categories
      </primary-button>
    </form-actions>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import SubNavLink from "@/Components/Ui/SubNavLink.vue";
import ItemForm from "@/Pages/Restaurant/Form.vue";
import JetFormSection from "@/Jetstream/FormSection.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetSectionBorder from "@/Jetstream/SectionBorder.vue";
import CheckBox from "@/Jetstream/Checkbox.vue";
import JetActionMessage from "@/Jetstream/ActionMessage.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetTextArea from "@/Jetstream/TextArea.vue";
import InputHelp from "@/Components/Form/InputHelp.vue";
import InputSelect from "@/Components/Form/Select.vue";
import FormActions from "@/Components/Form/Actions.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import { ref } from "vue";
export default {
  components: {
    AppLayout,
    SubNavLink,
    ItemForm,
    Head,
    JetFormSection,
    JetInputError,
    JetLabel,
    JetInput,
    JetSectionBorder,
    JetActionMessage,
    JetSecondaryButton,
    JetButton,
    JetTextArea,
    InputHelp,
    FormActions,
    InputSelect,
    PrimaryButton,
    CheckBox
  },
  props: ["restaurant", "categories", "restaurantCategories"],
  computed: {
    // check category
    categoryChecked(category) {

        for (let index = 0; index < props.restaurantCategories.length; index++) {
            if (props.restaurantCategories.category_id == category.id) {
                return 'checked';
            }
        }
    }
  },
  setup(props) {
    const form = useForm({
      categories: [],
    });

    const isChecked = ref(false);
    const checked = ref('checked');



    // Save restaurant
    function saveRestaurantCategories() {
      const options = {
        errorBag: "saveRestaurantCategories",
        preserveScroll: (page) => Object.keys(page.props.errors).length,
        onError: () => {
          toast.error("Please check form errors!", {
            position: toast.POSITION.BOTTOM_RIGHT,
          });
        },
      };

        form.post(route("restaurant.update.categories" , props.restaurant.id), options);

    }

    return {
      form,
      saveRestaurantCategories,
      isChecked,
      checked,
    };
  },
  computed: {
    title() {
      return props.restaurant ? "Update Restaurant" : "Add Restaurant";
    },
  },


};
</script>
