<script setup>
import {ref, reactive, nextTick} from 'vue';
import DialogModal from './DialogModal.vue';
import InputError from '@/Components/Input/InputError.vue';
import Button from '@/Components/Input/Button.vue';
import PasswordInput from '@/Components/Input/PasswordInput.vue';

const emit = defineEmits([ 'confirmed' ]);

defineProps({
	title: {
		type: String,
		default: '',
	},
	content: {
		type: String,
		default: '',
	},
	button: {
		type: String,
		default: '',
	},
});

const confirmingPassword = ref(false);

const form = reactive({
	password: '',
	error: '',
	processing: false,
});

const passwordInput = ref(null);

const startConfirmingPassword = () =>
{
	axios.get(route('password.confirmation')).then(response =>
	{
		if (response.data.confirmed)
		{
			emit('confirmed');
		}
		else
		{
			confirmingPassword.value = true;

			setTimeout(() => passwordInput.value.focus(), 250);
		}
	});
};

const confirmPassword = () =>
{
	form.processing = true;

	axios.post(route('password.confirm'), {
		password: form.password,
	}).then(() =>
	{
		form.processing = false;

		closeModal();
		nextTick().then(() => emit('confirmed'));

	}).catch(error =>
	{
		form.processing = false;
		form.error = error.response.data.errors.password[0];
		passwordInput.value.focus();
	});
};

const closeModal = () =>
{
	confirmingPassword.value = false;
	form.password = '';
	form.error = '';
};
</script>

<template>
	<span>
		<span @click="startConfirmingPassword">
			<slot />
		</span>

		<DialogModal :show="confirmingPassword" @close="closeModal">
			<template #title>
				{{ title || $t('auth.confirm_password') }}
			</template>

			<template #content>
				{{ content || $t('auth.confirm_password_description') }}

				<div class="mt-4">
					<PasswordInput v-model="form.password"
						ref="passwordInput"
						class="mt-1 block w-3/4"
						:placeholder="$t('auth.password')"
						autocomplete="current-password"
						@keyup.enter:model-value="confirmPassword" />

					<InputError :message="form.error" class="mt-2" />
				</div>
			</template>

			<template #footer>
				<Button color="secondary" @click="closeModal">
					{{ $t('Cancel') }}
				</Button>

				<Button color="primary"
					class="ms-3"
					:class="{ 'opacity-25': form.processing }"
					:disabled="form.processing"
					@click="confirmPassword"
				>
					{{ button || $t('Confirm') }}
				</Button>
			</template>
		</DialogModal>
	</span>
</template>
