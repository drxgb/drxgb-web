<script setup>
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Button from '@/Components/Button/Button.vue';
import Card from '@/Components/Card/Card.vue';
import InputError from '@/Components/Input/InputError.vue';
import InputLabel from '@/Components/Input/InputLabel.vue';
import TextInput from '@/Components/Input/TextInput.vue';

defineProps({
    status: String,
});

const form = useForm({
    email: '',
});

const submit = () =>
{
    form.post(route('password.email'));
};
</script>

<template>
	<AppLayout :title="$t('auth.forgot_password')">
		<section class="flex flex-col justify-center items-center h-full py-8">
			<h1 class="text-2xl uppercase">{{ $t('auth.forgot_password') }}</h1>

			<Alert v-if="status"
				type="success"
				size="sm"
				class="mt-8"
			>
				{{ status }}
			</Alert>

			<Card>
				<p class="mb-4 text-sm text-gray-600 dark:text-gray-400">
					{{ $t('auth.forgot_password_description') }}
				</p>

				<form @submit.prevent="submit">
					<div>
						<InputLabel for="email" :value="$t('auth.email')" />
						<TextInput v-model="form.email"
							id="email"
							type="email"
							class="mt-1 block w-full"
							required
							autofocus
							autocomplete="username"
						/>
						<InputError class="mt-2" :message="form.errors.email" />
					</div>

					<div class="flex items-center justify-end mt-4">
						<Button color="primary" icon="paper-plane" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
							{{ $t('auth.email_password_reset_link') }}
						</Button>
					</div>
				</form>
			</Card>
		</section>
	</AppLayout>
</template>
