<script setup>
import { ref, computed, watch } from 'vue';
import { router, useForm, usePage } from '@inertiajs/vue3';
import ActionSection from '@/Components/Section/ActionSection.vue';
import Button from '@/Components/Input/Button.vue';
import ConfirmsPassword from '@/Components/Modal/ConfirmsPassword.vue';
import InputError from '@/Components/Input/InputError.vue';
import InputLabel from '@/Components/Input/InputLabel.vue';
import TextInput from '@/Components/Input/TextInput.vue';

const props = defineProps({
	requiresConfirmation: Boolean,
});

const page = usePage();
const enabling = ref(false);
const confirming = ref(false);
const disabling = ref(false);
const qrCode = ref(null);
const setupKey = ref(null);
const recoveryCodes = ref([]);

const confirmationForm = useForm({
	code: '',
});

const twoFactorEnabled = computed(
	() => !enabling.value && page.props.auth.user?.two_factor_enabled,
);

watch(twoFactorEnabled, () =>
{
	if (!twoFactorEnabled.value)
	{
		confirmationForm.reset();
		confirmationForm.clearErrors();
	}
});

function enableTwoFactorAuthentication()
{
	enabling.value = true;

	router.post(route('two-factor.enable'), {}, {
		preserveScroll: true,
		onSuccess: () => Promise.all([
			showQrCode(),
			showSetupKey(),
			showRecoveryCodes(),
		]),
		onFinish: () =>
		{
			enabling.value = false;
			confirming.value = props.requiresConfirmation;
		},
	});
};

function showQrCode()
{
	return axios.get(route('two-factor.qr-code')).then(response =>
	{
		qrCode.value = response.data.svg;
	});
};

function showSetupKey()
{
	return axios.get(route('two-factor.secret-key')).then(response =>
	{
		setupKey.value = response.data.secretKey;
	});
}

function showRecoveryCodes()
{
	return axios.get(route('two-factor.recovery-codes')).then(response =>
	{
		recoveryCodes.value = response.data;
	});
};

function confirmTwoFactorAuthentication()
{
	confirmationForm.post(route('two-factor.confirm'), {
		errorBag: "confirmTwoFactorAuthentication",
		preserveScroll: true,
		preserveState: true,
		onSuccess: () =>
		{
			confirming.value = false;
			qrCode.value = null;
			setupKey.value = null;
		},
	});
};

function regenerateRecoveryCodes()
{
	axios.post(route('two-factor.recovery-codes'))
		.then(() => showRecoveryCodes());
};

function disableTwoFactorAuthentication()
{
	disabling.value = true;

	router.delete(route('two-factor.disable'), {
		preserveScroll: true,
		onSuccess: () =>
		{
			disabling.value = false;
			confirming.value = false;
		},
	});
};
</script>

<template>
	<ActionSection>
		<template #title>
			{{ $t('profile.2fa') }}
		</template>

		<template #description>
			{{ $t('profile.2fa_description') }}
		</template>

		<template #content>
			<h3 v-if="twoFactorEnabled && !confirming"
				class="text-lg font-medium text-gray-900 dark:text-gray-100"
			>
				{{ $t('profile.2fa_enabled') }}
			</h3>

			<h3 v-else-if="twoFactorEnabled && confirming"
				class="text-lg font-medium text-gray-900 dark:text-gray-100"
			>
				{{ $t('profile.2fa_finish_enable') }}
			</h3>

			<h3 v-else
				class="text-lg font-medium text-gray-900 dark:text-gray-100"
			>
				{{ $t('profile.2fa_not_enabled') }}
			</h3>

			<div class="mt-3 max-w-xl text-sm text-gray-600 dark:text-gray-400">
				<p>
					{{ $t('profile.2fa_not_enabled_description') }}
				</p>
			</div>

			<div v-if="twoFactorEnabled">
				<div v-if="qrCode">
					<div class="mt-4 max-w-xl text-sm text-gray-600 dark:text-gray-400">
						<p v-if="confirming" class="font-semibold">
							{{ $t('profile.2fa_scan_qrcode_confirm') }}
						</p>

						<p v-else>
							{{ $t('profile.2fa_scan_qrcode') }}
						</p>
					</div>

					<div class="mt-4 p-2 inline-block bg-white" v-html="qrCode" />

					<div v-if="setupKey" class="mt-4 max-w-xl text-sm text-gray-600 dark:text-gray-400">
						<p class="font-semibold">
							{{ $t('profile.setup_key') }}: <span v-html="setupKey"></span>
						</p>
					</div>

					<div v-if="confirming" class="mt-4">
						<InputLabel for="code" :value="$t('Code')" />

						<TextInput v-model="confirmationForm.code"
							id="code"
							type="text"
							name="code"
							class="block mt-1 w-1/2"
							inputmode="numeric"
							autofocus
							autocomplete="one-time-code"
							@keyup.enter="confirmTwoFactorAuthentication" />

						<InputError :message="confirmationForm.errors.code" class="mt-2" />
					</div>
				</div>

				<div v-if="recoveryCodes.length > 0 && !confirming">
					<div class="mt-4 max-w-xl text-sm text-gray-600 dark:text-gray-400">
						<p class="font-semibold">
							{{ $t('profile.store_recovery_codes') }}
						</p>
					</div>

					<div class="grid gap-1 max-w-xl mt-4 px-4 py-4 font-mono text-sm bg-gray-100 dark:bg-gray-900 dark:text-gray-100 rounded-lg">
						<div v-for="code in recoveryCodes" :key="code">
							{{ code }}
						</div>
					</div>
				</div>
			</div>

			<div class="mt-5">
				<div v-if="!twoFactorEnabled">
					<ConfirmsPassword @confirmed="enableTwoFactorAuthentication">
						<Button color="success"
							icon="check"
							type="button"
							:class="{ 'opacity-25': enabling }"
							:disabled="enabling">
							{{ $t('Enable') }}
						</Button>
					</ConfirmsPassword>
				</div>

				<div v-else>
					<ConfirmsPassword @confirmed="confirmTwoFactorAuthentication">
						<Button v-if="confirming"
							color="primary"
							icon="check"
							type="button"
							class="me-3"
							:class="{ 'opacity-25': enabling }"
							:disabled="enabling">
							{{ $t('Confirm') }}
						</Button>
					</ConfirmsPassword>

					<ConfirmsPassword @confirmed="regenerateRecoveryCodes">
						<Button v-if="recoveryCodes.length > 0 && !confirming"
							color="secondary"
							icon="rotate"
							class="me-3">
							{{ $t('profile.regenerate_recovery_codes') }}
						</Button>
					</ConfirmsPassword>

					<ConfirmsPassword @confirmed="showRecoveryCodes">
						<Button v-if="recoveryCodes.length === 0 && !confirming"
							color="secondary"
							icon="eye"
							class="me-3">
							{{ $t('profile.show_recovery_codes') }}
						</Button>
					</ConfirmsPassword>

					<ConfirmsPassword @confirmed="disableTwoFactorAuthentication">
						<Button v-if="confirming"
							color="secondary"
							icon="times"
							:class="{ 'opacity-25': disabling }"
							:disabled="disabling">
							{{ $t('Cancel') }}
						</Button>
					</ConfirmsPassword>

					<ConfirmsPassword @confirmed="disableTwoFactorAuthentication">
						<Button v-if="!confirming"
							color="danger"
							icon="times"
							:class="{ 'opacity-25': disabling }"
							:disabled="disabling">
							{{ $t('disable') }}
						</Button>
					</ConfirmsPassword>
				</div>
			</div>
		</template>
	</ActionSection>
</template>
