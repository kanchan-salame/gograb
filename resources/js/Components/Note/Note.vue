<template>
    <div>
        
        <div class="flex space-x-3 justify-between">
            <div :id="`note-${note.id}`">
                <div class="text-sm">
                    <span class="font-medium text-gray-900">
                        {{ note.user.name }}
                    </span>
                </div>
                <div v-if="!editing" class="mt-1 text-sm text-gray-700">
                    <div
                        class="notes"
                        v-html="parseMarkdown(note.description)"
                    ></div>
                </div>
                <div v-if="!editing" class="mt-2 text-sm space-x-2">
                    <span class="text-gray-500 font-medium">{{
                        note.updated_at_humans
                    }}</span>
                </div>
            </div>
            <div>
             <note-options @on-edit="editing = !editing" @on-delete="deleteNote" v-if="user.id == note.user_id" />
            </div>
        </div>
        
         <textarea
            v-if="user.id == note.user_id && editing"
                class="w-full mt-2  border rounded border-gray-300 max-h-44"
                v-model="note.description"
            />
        <div
            v-if="user.id == note.user_id && editing"
            class="mt-3 flex items-center justify-end"
        >
            <button
                type="button"
                @click.prevent="updateNote"
                class="
                    inline-flex
                    items-center
                    justify-center
                    px-4
                    py-2
                    border border-transparent
                    text-sm
                    font-medium
                    rounded-md
                    shadow-sm
                    text-white
                    btn btn__primary
                    focus:outline-none
                    focus:ring-2
                    focus:ring-offset-2
                    focus:ring-blue-500
                "
            >
                Update note
            </button>
          <div  class="ml-3 p-0.5 bg-blue-500 rounded">
              <button  @click="editing = !editing" class="bg-white p-1 rounded px-4 text-gray-500">
                  NEVERMIND
              </button>
          </div>
        </div>
       
    </div>
</template>
<script>
import { PencilAltIcon, TrashIcon } from "@heroicons/vue/outline";
import { parseMarkdown } from "@/helpers";
import { ref } from "vue";
import { Inertia } from "@inertiajs/inertia";
import NoteOptions from "@/Components/Note/NoteOptions"
import JetSecondaryButton from '@/Jetstream/SecondaryButton'


export default {
    components: {
        PencilAltIcon,
        TrashIcon,
        NoteOptions,
        JetSecondaryButton
    },
    props: {
        note: {
            type: Object,
            default: {},
        },
        user: {
            type: Object,
            default: {},
        },
    },
    setup(props, context) {
        const editing = ref(false);
        const updateNote = () => {
            Inertia.put(
                `/invoice/${route().params.invoice}/note/${props.note.id}`,
                props.note,
                {
                    preserveState: true,
                    preserveScroll: true,
                    onSuccess: () => {
                        editing.value = false;
                    },
                }
            );
        };

        const deleteNote = () => {
            Inertia.delete(
                `/invoice/${route().params.invoice}/note/${props.note.id}`,
                {
                    preserveState: false,
                    preserveScroll: true,
                    onSuccess: () => {
                    },
                }
            );
        }
        return { editing, parseMarkdown, updateNote, deleteNote };
    },
};
</script>
