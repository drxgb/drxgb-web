<script setup>
import { nextTick, ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Button from '@/Components/Button.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import Card from '@/Components/Card.vue';

const recovery = ref(false);

const form = useForm({
    code: '',
    recovery_code: '',
});

const recoveryCodeInput = ref(null);
const codeInput = ref(null);

const toggleRecovery = async () => {
    recovery.value ^= true;

    await nextTick();

    if (recovery.value) {
        recoveryCodeInput.value.focus();
        form.code = '';
    } else {
        codeInput.value.focus();
        form.recovery_code = '';
    }
};

function input(event) {
	const value = event.target.value;

	if (value.length === 6) {
		submit();
	}
}

function submit() {
    form.post(route('two-factor.login'));
};
</script>

<template>
    <AppLayout :title="$t('auth.two_factor_confirmation')">
		<section class="flex flex-col justify-center items-center h-full py-8">
			<h1 class="text-2xl uppercase">{{ $t('auth.two_factor_confirmation') }}</h1>
			<Card size="xs">
				<div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
					<template v-if="! recovery">
						{{ $t('auth.two_factor_description') }}
					</template>

					<template v-else>
						{{ $t('auth.recovery_code_description') }}
					</template>
				</div>

				<form @submit.prevent="submit">
					<div v-if="! recovery">
						<InputLabel for="code" :value="$t('Code')" />
						<TextInput
							id="code"
							ref="codeInput"
							v-model="form.code"
							type="text"
							inputmode="numeric"
							class="mt-1 block w-full"
							maxlength="6"
							autofocus
							autocomplete="one-time-code"
							@input="input"
						/>
						<InputError class="mt-2" :message="form.errors.code" />
					</div>

					<div v-else>
						<InputLabel for="recovery_code" :value="$t('auth.recovery_code')" />
						<TextInput
							id="recovery_code"
							ref="recoveryCodeInput"
							v-model="form.recovery_code"
							type="text"
							class="mt-1 block w-full"
							autocomplete="one-time-code"
						/>
						<InputError class="mt-2" :message="form.errors.recovery_code" />
					</div>

					<div class="flex items-center justify-end mt-4">
						<button type="button" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 underline cursor-pointer" @click.prevent="toggleRecovery">
							<template v-if="! recovery">
								{{ $t('auth.use_a_recovery_code') }}
							</template>

							<template v-else>
								{{ $t('auth.use_an_authenticator_code') }}
							</template>
						</button>

						<Button
							icon="arrow-right-to-bracket"
							color="primary"
							class="ms-4"
							:class="{ 'opacity-25': form.processing }"
							:disabled="form.processing"
						>
							{{ $t('auth.login') }}
						</Button>
					</div>
				</form>
			</Card>
		</section>
	</AppLayout>
</template>
