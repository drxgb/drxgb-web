<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import ActionSection from '@/Components/ActionSection.vue';
import Button from '@/Components/Button.vue';
import DialogModal from '@/Components/DialogModal.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    setTimeout(() => passwordInput.value.focus(), 250);
};

const deleteUser = () => {
    form.delete(route('current-user.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.reset();
};
</script>

<template>
    <ActionSection color="danger">
        <template #title>
            {{ $t('profile.delete_account') }}
        </template>

        <template #description>
            {{ $t('profile.delete_account_description') }}
        </template>

        <template #content>
            <div class="max-w-xl text-sm">
                {{ $t('profile.delete_account_warning') }}
            </div>

            <div class="mt-5">
                <Button
					color="custom"
					class="bg-white text-red-500 hover:bg-red-700 hover:text-red-50"
					@click="confirmUserDeletion">
                    {{ $t('profile.delete_account') }}
                </Button>
            </div>

            <!-- Delete Account Confirmation Modal -->
            <DialogModal :show="confirmingUserDeletion" @close="closeModal">
                <template #title>
                    {{ $t('profile.delete_account') }}
                </template>

                <template #content>
                    {{ $t('profile.delete_account_confirm') }}

                    <div class="mt-4">
                        <TextInput
                            ref="passwordInput"
                            v-model="form.password"
                            type="password"
                            class="mt-1 block w-3/4"
                            :placeholder="$t('auth.password')"
                            autocomplete="current-password"
                            @keyup.enter="deleteUser"
                        />

                        <InputError :message="form.errors.password" class="mt-2" />
                    </div>
                </template>

                <template #footer>
                    <Button color="secondary" @click="closeModal">
                        {{ $t('cancel') }}
                    </Button>

                    <Button
						color="danger"
                        class="ms-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteUser"
                    >
                        {{ $t('profile.delete_account') }}
                    </Button>
                </template>
            </DialogModal>
        </template>
    </ActionSection>
</template>
