<template>
  <div>
    <jet-form-section class="mt-10 sm:mt-0">
      <template #title> Basic Information </template>

      <template #description>
        Provide basic information like Name, Image and image url for the
        Category.
      </template>

      <template #form>
        <div class="col-span-6 sm:col-span-4">
          <div>
            <jet-label for="user-type" value="User Type" />
            <div class="flex rounded-md shadow-sm mt-1">
              <select
                v-model="form.user_type"
                id="user-type"
                class="flex-1 block w-full rounded"
                placeholder="Select User Type"
              >
                <option disabled value="">Please Select</option>
                <option v-for="role in roles" :value="role.value">
                  {{ role.name }}
                </option>
              </select>
            </div>
            <jet-input-error :message="form.errors.user_type" class="mt-2" />
          </div>
        </div>
        <div
          class="grid grid-cols-1 md:grid-cols-1 gap-2 col-span-6 sm:col-span-4"
        >
          <jet-label for="Message" value="Message" />
          <textarea
            id="message"
            v-model="form.comment"
            class="flex-1 block w-full rounded"
          ></textarea>

          <jet-input-error :message="form.errors.comment" class="mt-2" />
        </div>
      </template>
    </jet-form-section>

    <form-actions>
      <jet-action-message class="mr-3"> Added. </jet-action-message>

      <jet-secondary-button
        class="text-sm px-10"
        @click="$inertia.get(route('sliders.index'))"
      >
        Nevermind
      </jet-secondary-button>

      <primary-button
        class="ml-2 text-sm px-10"
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
        @click="sendNotification"
      >
        Send Notification
      </primary-button>
    </form-actions>
  </div>
</template>

<script>
import JetFormSection from "@/Jetstream/FormSection.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetSectionBorder from "@/Jetstream/SectionBorder.vue";
import JetActionMessage from "@/Jetstream/ActionMessage.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetTextArea from "@/Jetstream/TextArea.vue";
import InputHelp from "@/Components/Form/InputHelp.vue";
import InputSelect from "@/Components/Form/Select.vue";
import FormActions from "@/Components/Form/Actions.vue";
import axios from "axios";
import PrimaryButton from "@/Components/PrimaryButton.vue";

import {
  CalculatorIcon,
  AdjustmentsIcon,
  CalendarIcon,
} from "@heroicons/vue/outline";
import { reactive, computed, watch, ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

export default {
  components: {
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
    CalculatorIcon,
    AdjustmentsIcon,
    CalendarIcon,
    InputSelect,
    PrimaryButton,
  },
  props: ["category"],
  data() {
    return {
      roles: [
        { value: "admin", name: "Admin" },
        { value: "user", name: "User" },
        { value: "driver", name: "Driver" },
        { value: "vendor", name: "Vendor" },
      ],
    };
  },
  setup(props) {
    const form = useForm({
      user_type: "",
      comment: "",
    });

    // Save slider
    function sendNotification() {
      console.log(form);
      const options = {
        errorBag: "sendNotification",
        preserveScroll: (page) => Object.keys(page.props.errors).length,
        onError: () => {
          toast.error("Please check form errors!", {
            position: toast.POSITION.BOTTOM_RIGHT,
          });
        },
      };
      // New Category
      form.post(route("notification.sent"), options);
    }

    return {
      form,
      sendNotification,
    };
  },
};
</script>

