<script setup lang="ts">
import { ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import ApplicationLogo from './ApplicationLogo.vue';
import NavLink from './NavLink.vue';
import Button from './Button.vue';
import ThemeSwitcher from './ThemeSwitcher.vue';


const menuOpen = ref(false);

const logout = () => {
	// @ts-ignore
	router.post(route('logout'));
};
</script>


<template>
	<nav class="lg:px-20 sm:px-8 px-2 py-4 min-h-[48px] max-h-[48px] flex items-center justify-between overflow-hidden bg-green-600">
		<div class="flex items-end gap-4">
			<!-- Navegação lateral (Dispositivos móveis) -->
			<font-awesome-icon :icon="[ 'fas', 'bars' ]" class="max-lg:inline-block hidden mb-12 text-green-200" @click="menuOpen = true" />
			<transition
				enter-active-class="transition ease-out duration-200"
				enter-from-class="transform -translate-x-full"
				enter-to-class="transform translate-x-0"
				leave-active-class="transition ease-in duration-200"
				leave-from-class="transform translate-x-0"
				leave-to-class="transform -translate-x-full"
			>
				<div
					class="absolute left-0 top-0 w-screen h-screen z-10 px-4 py-4 lg:hidden bg-green-600 text-green-200"
					v-if="menuOpen"
				>
					<div class="flex justify-end">
						<font-awesome-icon :icon="[ 'fas', 'times' ]" @click="menuOpen = false" />
					</div>
				</div>
			</transition>

			<!-- Logo-->
			<Link href="/">
				<ApplicationLogo class="w-10 mt-8" />
			</Link>

			<!-- Links de navegação -->
			<div class="ml-8 hidden lg:flex gap-4">
				<NavLink href="/">
					{{ $t('nav.softwares') }}
				</NavLink>
				<NavLink href="/">
					{{ $t('nav.games') }}
				</NavLink>
				<NavLink href="/">
					{{ $t('nav.online_tools') }}
				</NavLink>
				<NavLink href="/">
					{{ $t('nav.blog') }}
				</NavLink>
				<NavLink href="/">
					{{ $t('nav.store') }}
				</NavLink>
			</div>
		</div>

		<!-- Controles da página -->
		<div class="flex items-center gap-2">
			<template v-if="$page.props.auth.user"></template>
			<template v-else>
				<Button v-if="$page.props.canLogin" :href="route('login')" icon="arrow-right-to-bracket" color="primary">
					<span class="max-sm:hidden block">
						{{ $t('auth.login').toUpperCase() }}
					</span>
				</Button>
				<Button v-if="$page.props.canRegister" :href="route('register')" icon="arrow-right-to-bracket" color="info" class="hidden sm:inline-flex">
					{{ $t('auth.register') }}
				</Button>
			</template>
			<ThemeSwitcher />
			<NavLink href="/">
				<font-awesome-icon :icon="['fas', 'cart-shopping']" />
			</NavLink>
			<NavLink href="/">
				<font-awesome-icon :icon="['fas', 'globe']" />
			</NavLink>
		</div>
	</nav>
</template>
