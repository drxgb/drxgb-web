<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import ActionMessage from '@/Templates/ActionMessage.vue';
import FormSection from '@/Components/Section/FormSection.vue';
import InputError from '@/Components/Input/InputError.vue';
import InputLabel from '@/Components/Input/InputLabel.vue';
import Button from '@/Components/Input/Button.vue';
import PasswordInput from '@/Components/Input/PasswordInput.vue';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
	current_password: '',
	password: '',
	password_confirmation: '',
});

function updatePassword()
{
	form.put(route('user-password.update'), {
		errorBag: 'updatePassword',
		preserveScroll: true,
		onSuccess: () => form.reset(),
		onError: () =>
		{
			if (form.errors.password)
			{
				form.reset('password', 'password_confirmation');
				passwordInput.value.focus();
			}

			if (form.errors.current_password)
			{
				form.reset('current_password');
				currentPasswordInput.value.focus();
			}
		},
	});
};
</script>

<template>
	<FormSection @submitted="updatePassword">
		<template #title>
			{{ $t('profile.update_password') }}
		</template>

		<template #description>
			{{ $t('profile.update_password_description') }}
		</template>

		<template #form>
			<div class="col-span-6 sm:col-span-4">
				<InputLabel for="current_password" :value="$t('profile.current_password')" />
				<PasswordInput v-model="form.current_password"
					id="current_password"
					ref="currentPasswordInput"
					class="mt-1 block w-full"
					autocomplete="current-password" />
				<InputError :message="form.errors.current_password" class="mt-2" />
			</div>

			<div class="col-span-6 sm:col-span-4">
				<InputLabel for="password" :value="$t('profile.new_password')" />
				<PasswordInput v-model="form.password"
					id="password"
					ref="passwordInput"
					class="mt-1 block w-full"
					autocomplete="new-password" />
				<InputError :message="form.errors.password" class="mt-2" />
			</div>

			<div class="col-span-6 sm:col-span-4">
				<InputLabel for="password_confirmation" :value="$t('profile.confirm_password')" />
				<PasswordInput v-model="form.password_confirmation"
					id="password_confirmation"
					class="mt-1 block w-full"
					autocomplete="new-password" />
				<InputError :message="form.errors.password_confirmation" class="mt-2" />
			</div>
		</template>

		<template #actions>
			<ActionMessage :on="form.recentlySuccessful" class="me-3">
				{{ $t('Saved') }}
			</ActionMessage>

			<Button color="primary"
				icon="floppy-disk"
				:class="{ 'opacity-25': form.processing }" :disabled="form.processing"
			>
				{{ $t('Save') }}
			</Button>
		</template>
	</FormSection>
</template>
