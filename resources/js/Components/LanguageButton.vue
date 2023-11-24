<script setup lang="ts">
import { ref, reactive } from 'vue';
import { usePage, Link, router } from '@inertiajs/vue3';
import { Language } from '@/Classes/Language';
import { Cookie } from '@/Classes/Util/Cookie';
import Button from './Button.vue';
import Modal from './Modal.vue';
import RadioButton from './RadioButton.vue';

defineProps({
	color: {
		type: String,
		default: 'primary'
	},
	modelValue: null,
});
const page = usePage();
const language: Language = makeLanguage(page.props.language);
const languages = page.props.languages;
const open = ref(false);
const form = reactive({
	id: String(language.id),
});

function makeLanguage(props: object): Language {
	return new Language(props.id, props.name, props.locale, props.country_flag);
}

function changeLanguage(): void {
	console.log(form.id);
	//Cookie.set('xgb_language_id', form.id);
	router.post(route('languages.change', form.id), form);
	open.value = false;
}
</script>


<template>
	<Button :color="color" @click="open = !open">
		<span class="flex items-baseline">
			<img :src="`/img/flags/${language.countryFlag}.gif`" :alt="language.countryFlag" />
			<span class="mx-2">{{ language.name }}</span>
			<font-awesome-icon :icon="['fas', 'angle-right']" />
		</span>
	</Button>

	<Modal :show="open" maxWidth="md" @close="open = false">
		<template #header>
			<h1>{{ $t('choose_language') }}</h1>
		</template>

		<form @submit.prevent="changeLanguage">
			<div>
				<RadioButton
					v-for="lang in languages" :key="lang.id"
					class="w-full border-b-2 last:border-b-0 px-4 py-2 border-b-gray-300 dark:border-b-slate-600"
					name="id"
					:id="lang.locale"
					:value="String(lang.id)"
					v-model="form.id">
					<div class="flex items-center gap-2">
						<img :src="`/img/flags/${lang.country_flag}.gif`" :alt="lang.country_flag" />
						<span>{{ lang.name }}</span>
					</div>
				</RadioButton>
			</div>
			<div class="flex justify-center p-2 bg-gray-200 dark:bg-slate-700">
				<Button color="primary" icon="floppy-disk">
					{{ $t('save') }}
				</Button>
			</div>
		</form>
	</Modal>
</template>
