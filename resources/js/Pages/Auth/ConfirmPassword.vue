<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Button from '@/Components/Button.vue';
import InputError from '@/Components/InputError.vue';

const form = useForm({
    password: '',
});

const passwordInput = ref(null);

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => {
            form.reset();

            passwordInput.value.focus();
        },
    });
};
</script>

<template>
	<AppLayout title="Secure Area">

		<div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
			This is a secure area of the application. Please confirm your password before continuing.
		</div>

		<form @submit.prevent="submit">
			<div>
				<InputLabel for="password" value="Password" />
				<PaswordInput
					id="password"
					ref="passwordInput"
					v-model="form.password"
					class="mt-1 block w-full"
					required
					autocomplete="current-password"
					autofocus
				/>
				<InputError class="mt-2" :message="form.errors.password" />
			</div>

			<div class="flex justify-end mt-4">
				<Button color="primary" class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
					Confirm
				</Button>
			</div>
		</form>
	</AppLayout>
</template>
