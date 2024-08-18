<script setup lang="ts">
import { ref, reactive, computed, type Ref, type ComputedRef } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import { loadLanguageAsync } from 'laravel-vue-i18n';
import { Language } from '@/Classes/Language';
import Button from '@/Components/Input/Button.vue';
import Modal from '@/Components/Modal/Modal.vue';

defineProps({
	color: {
		type: String,
		default: 'primary'
	},
	modelValue: null,
});
const page: any = usePage();
const language: ComputedRef<Language> = computed(() => makeLanguage(page.props.language));
const languages: Ref<any[]> = ref(page.props.languages);
const open: Ref<boolean> = ref(false);
const form: any = reactive({
	language_id: String(language.value.id),
});

const flagImage = (flag : string) : string => `/img/flags/${flag}.gif`;

function makeLanguage(props : any) : Language
{
	return new Language(props.id, props.name, props.locale, props.country_flag);
}

function changeLanguage() : void
{
	// @ts-ignore
	router.post(route('languages.change'), form, {
		preserveState: true,
		onSuccess: () =>
		{
			loadLanguageAsync(language.value.locale);
			open.value = false;
		},
	});
}
</script>


<template>
	<Button :color="color" @click="open = !open">
		<span class="flex items-baseline">
			<img :src="flagImage(language.countryFlag)" :alt="language.countryFlag" />
			<span class="mx-2">{{ language.name }}</span>
			<font-awesome-icon :icon="['fas', 'angle-right']" />
		</span>
	</Button>

	<Modal :show="open" maxWidth="md" @close="open = false">
		<template #header>
			<h1>{{ $t('Choose a language') }}</h1>
		</template>

		<form @submit.prevent="changeLanguage">
			<div v-for="lang in languages" :key="String(lang.id)"
				class="flex items-center gap-6 w-full border-b-2 last:border-b-0 px-4 border-b-gray-300 dark:border-b-slate-600"
				:class="{ 'bg-orange-400 text-orange-900': lang.id == form.language_id }">
				<input v-model="form.language_id"
					type="radio"
					class="text-purple-600"
					:id="lang.locale"
					:value="String(lang.id)"
				/>
				<label :for="lang.locale" class="flex w-full py-2 items-center gap-2">
					<img :src="flagImage(lang.country_flag)" :alt="lang.country_flag" />
					<span>{{ lang.name }}</span>
				</label>
			</div>
			<div class="flex justify-center p-2 bg-gray-200 dark:bg-slate-700">
				<Button color="primary" icon="floppy-disk">
					{{ $t('Save') }}
				</Button>
			</div>
		</form>
	</Modal>
</template>
