<script setup>
import { computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Alert from '@/Components/Container/Alert.vue';
import Button from '@/Components/Input/Button.vue';
import Card from '@/Components/Card/Card.vue';
import FormRow from '@/Components/Container/FormRow.vue';
import InputError from '@/Components/Input/InputError.vue';
import InputLabel from '@/Components/Input/InputLabel.vue';
import PasswordExaminator from '@/Templates/PasswordExaminator.vue';
import PasswordInput from '@/Components/Input/PasswordInput.vue';

const props = defineProps({
    email: String,
    token: String,
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.update'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
const otherErrors = computed(() => Object.keys(form.errors).filter(k => k !== 'password'));
</script>

<template>
	<AppLayout :title="$t('auth.reset_password')">
		<section class="flex flex-col justify-center items-center h-full py-8">
			<h1 class="text-2xl uppercase">{{ $t('auth.reset_password') }}</h1>

			<!-- Erros -->
			<Alert v-if="otherErrors.length > 0"
					type="danger"
					size="md"
					class="mt-8"
				>
				<ul>
					<li v-for="e in otherErrors">
						{{ form.errors[e] }}
					</li>
				</ul>
			</Alert>

			<Card :no-padding="true" size="md">
				<form @submit.prevent="submit"
					class="pr-8">
					<!-- Senha -->
						<FormRow>
							<template #label>
								<InputLabel for="password" :value="$t('auth.password')" />
							</template>
							<div class="mt-4">
								<div class="flex justify-between items-center gap-2">
									<PasswordInput v-model:model-value="form.password"
										id="password"
										class="mt-1 block w-full"
										required
										autocomplete="new-password"
									/>
								</div>
								<InputError class="mt-2" :message="form.errors.password" />
							</div>
						</FormRow>

						<!-- Medidor de força da senha -->
						<FormRow>
							<PasswordExaminator class="mt-4" :value="form.password" />
						</FormRow>

						<!-- Confirmação da senha -->
						<FormRow>
							<template #label>
								<InputLabel for="password_confirmation"
									:value="$t('auth.confirm_password')"
								/>
							</template>
							<div class="mt-4">
								<PasswordInput v-model="form.password_confirmation"
									id="password_confirmation"
									class="mt-1 block w-full"
									required
									autocomplete="new-password"
								/>
								<InputError class="mt-2" :message="form.errors.password_confirmation" />
							</div>
						</FormRow>

					<FormRow>
						<div class="flex items-center justify-end mt-8 mb-4">
							<Button color="primary"
								icon="rotate"
								:class="{ 'opacity-25': form.processing }"
								:disabled="form.processing"
							>
								{{ $t('auth.reset_password') }}
							</Button>
						</div>
					</FormRow>
				</form>
			</Card>
		</section>
	</AppLayout>
</template>
