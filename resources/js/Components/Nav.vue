<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import NavLink from '@/Components/NavLink.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ThemeSwitcher from '@/Components/ThemeSwitcher.vue';

const logout = () => {
	// @ts-ignore
	router.post(route('logout'));
};
</script>


<template>
	<nav class="px-20 py-2 max-h-[48px] flex items-center justify-between overflow-hidden bg-green-600">
		<!-- Links de navegação -->
		<div class="flex">
			<Link href="/">
			<ApplicationLogo class="w-10 mt-8" />
			</Link>

			<div class="ml-8 flex gap-4">
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
			<template v-if="$page.props.canLogin">
				<div v-if="$page.props.auth.user"></div>
				<div v-else>
					<PrimaryButton icon="arrow-right-to-bracket">
						{{ $t('auth.login').toUpperCase() }}
					</PrimaryButton>
				</div>
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
