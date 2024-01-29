<script setup>
import { computed, onMounted, onUnmounted, watch } from 'vue';

const props = defineProps({
	show: {
		type: Boolean,
		default: false,
	},
	maxWidth: {
		type: String,
		default: '2xl',
	},
	closeable: {
		type: Boolean,
		default: true,
	},
	type: {
		type: String,
		default: '',
	}
});

const emit = defineEmits([ 'close' ]);

watch(() => props.show, () => {
	if (props.show) {
		document.body.style.overflow = 'hidden';
	} else {
		document.body.style.overflow = null;
	}
});

const close = () => {
	if (props.closeable) {
		emit('close');
	}
};

const closeOnEscape = (e) => {
	if (e.key === 'Escape' && props.show) {
		close();
	}
};

onMounted(() => document.addEventListener('keydown', closeOnEscape));

onUnmounted(() => {
	document.removeEventListener('keydown', closeOnEscape);
	document.body.style.overflow = null;
});

const maxWidthClass = computed(() => {
	return {
		'sm': 'sm:max-w-sm',
		'md': 'sm:max-w-md',
		'lg': 'sm:max-w-lg',
		'xl': 'sm:max-w-xl',
		'2xl': 'sm:max-w-2xl',
	}[props.maxWidth];
});
const headerIcon = computed(() => {
	return {
		info: 'circle-info',
		warning: 'triangle-exclamation',
		danger: 'circle-xmark',
	}[props.type];
});
const headerIconClass = computed(() => {
	return {
		info: 'text-sky-600 dark:text-sky-400',
		warning: 'text-amber-400 dark:text-amber-300',
		danger: 'text-red-600 dark:text-red-400',
	}[props.type];
});


function isValidType() {
	return [ 'info', 'warning', 'danger' ].includes(props.type);
}
</script>

<template>
	<teleport to="body">
		<transition leave-active-class="duration-200">
			<div v-show="show" class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50" scroll-region>
				<transition
					enter-active-class="ease-out duration-300"
					enter-from-class="opacity-0"
					enter-to-class="opacity-100"
					leave-active-class="ease-in duration-200"
					leave-from-class="opacity-100"
					leave-to-class="opacity-0">
					<div v-show="show" class="fixed inset-0 transform transition-all" @click="close">
						<div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75" />
					</div>
				</transition>

				<transition
					enter-active-class="ease-out duration-300"
					enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
					enter-to-class="opacity-100 translate-y-0 sm:scale-100"
					leave-active-class="ease-in duration-200"
					leave-from-class="opacity-100 translate-y-0 sm:scale-100"
					leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
					<div v-show="show" class="mb-6 bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:mx-auto" :class="maxWidthClass">
						<div
							v-if="$slots.header"
							class="flex justify-between align-middle p-2 bg-gray-200 dark:bg-slate-700"
						>
							<font-awesome-icon
								v-if="isValidType()"
								:icon="[ 'fas', headerIcon ]"
								:class="[ headerIconClass ]"
								size="2xl" />
							<h1 class="text-2xl">
								<slot name="header" />
							</h1>
							<font-awesome-icon
								v-if="$props.closeable"
								:icon="[ 'fas', 'times' ]"
								class="hover:cursor-pointer active:text-purple-300"
								@click="close" />
						</div>

						<slot v-if="show" />

						<div
							v-if="$slots.footer"
							class="flex justify-center gap-2 p-2 bg-gray-200 dark:bg-slate-700">
							<slot name="footer" />
						</div>
					</div>
				</transition>
			</div>
		</transition>
	</teleport>
</template>
