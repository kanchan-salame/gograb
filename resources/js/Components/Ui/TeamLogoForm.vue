<template>
    <jet-section-border />

    <jet-form-section @submitted="updateTeamLogo">
        <template #title>
            Team Logo
        </template>

        <template #description>
            Upload team's logo.
        </template>

        <template #form>
            <!-- Team Logo Information -->
            <div class="col-span-6 sm:col-span-4">

                <!-- Team Logo File Input -->
                <input type="file" class="hidden"
                            ref="selectedLogo"
                            @change="updatePhotoPreview">
                <jet-label value="Team Logo" />

                    <!-- Current Team Logo Preview -->
                    <div class="mt-2" v-show="! photoPreview">
                        <img :src="team.logo_url" :alt="team.name" class="h-auto w-48 object-cover" v-if="team.logo_url">
                        <img src="/images/dummy-image-square.jpeg" class="h-auto w-48 object-cover" v-else>
                    </div>

                    <!-- New Team Logo Preview -->
                    <div class="mt-2" v-show="photoPreview">
                        <img :src="photoPreview" class="h-auto w-48 object-cover">
                    </div>
                    <jet-input-error :message="form.errors.logo" class="mt-2" />
                    <div class="flex z-1 relative mb-2">
                        <jet-secondary-button type="button" class="mt-2 mr-2" @click.prevent="selectNewPhoto">
                            Select A New Logo
                        </jet-secondary-button>

                        <jet-button class="mt-2 ml-2" @click="deleteTeamLogo" v-if="team.logo_path">
                            Delete Logo
                        </jet-button>
                    </div>
                    <input-help>Please upload logo ( size 100 x 35).</input-help>
            </div>
        </template>

        <template #actions v-if="permissions.canUpdateTeam">

            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Saved.
            </jet-action-message>

            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Save
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
    import JetActionMessage from '@/Jetstream/ActionMessage'
    import JetButton from '@/Jetstream/Button'
    import JetFormSection from '@/Jetstream/FormSection'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'
    import JetSectionBorder from '@/Jetstream//SectionBorder'
    import { ref, watch } from "vue"
    import { Inertia } from '@inertiajs/inertia'
    import { useToast } from 'vue-toastification'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import JetConfirmationModal from '@/Components/Jetstream/ConfirmationModal'
    import JetDangerButton from '@/Jetstream/DangerButton'
    import InputHelp from '@/Components/Form/InputHelp'

    export default {
        components: {
            JetActionMessage,
            JetButton,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
            JetSectionBorder,
            JetSecondaryButton,
            JetConfirmationModal,
            JetDangerButton,
            InputHelp
        },

        props: ['team', 'permissions'],

        setup(props) {

            const selectedLogo = ref(null)
            const photoPreview = ref(null)

            const form = Inertia.form({
                logo: null
            })

            function updateTeamLogo() {
                if (selectedLogo.value.value != '') {
                    form.logo = selectedLogo.value.files[0]
                }
                const options = {
                    errorBag: 'updateTeamLogo',
                    preserveScroll: (page) => Object.keys(page.props.errors).length,
                    onSuccess: () => {
                        form.reset()
                        selectedLogo.value.value = null
                    },
                    onError: () => {
                        const toast = useToast();
                        toast.error('Please check the form for errors.')
                    }
                }
                form.post(route('team-logo.update', {team: props.team.id}), options)
            }

            function selectNewPhoto() {
                selectedLogo.value.click()
            }

            function updatePhotoPreview() {
                const reader = new FileReader()
                reader.onload = (e) => {
                    photoPreview.value = e.target.result
                };
                form.logo = selectedLogo.value.files[0]
                reader.readAsDataURL(selectedLogo.value.files[0])
            }

            function deleteTeamLogo() {

               form.delete(route('team-logo.destroy', props.team.id), {
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: () => {
                        photoPreview.value = null
                        selectedLogo.value.value = null
                        document.body.style.overflow = null
                    },
                    onError: () => {
                        const toast = useToast();
                        toast.error('Something went wrong')
                    }
                })
            }
            return {
                form,
                photoPreview,
                updateTeamLogo,
                selectNewPhoto,
                updatePhotoPreview,
                deleteTeamLogo,
                selectedLogo
            }
        }
    }
</script>
