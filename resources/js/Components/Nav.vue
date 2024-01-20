<script setup>
import {ref} from 'vue';
import {Link, router, usePage} from '@inertiajs/vue3';
import {loadLanguageAsync} from 'laravel-vue-i18n';
import CollapseGroup from './CollapseGroup.vue';
import ApplicationLogo from './ApplicationLogo.vue';
import Avatar from './Avatar.vue';
import Button from './Button.vue';
import Dropdown from './Dropdown.vue';
import DropdownGroup from './DropdownGroup.vue';
import DropdownLink from './DropdownLink.vue';
import LanguageButton from './LanguageButton.vue';
import NavLink from './NavLink.vue';
import Slide from '@/Transitions/Slide.vue';
import ThemeSwitcher from './ThemeSwitcher.vue';
import Tooltip from './Tooltip.vue';

const menuOpen = ref(false);

function logout() {
	router.post(route('logout'), {}, {
		preserveState: true,
		onSuccess: page => {
			loadLanguageAsync(page.props.language.locale);
		}
	});
};
</script>


<template>
	<nav class="lg:px-20 sm:px-8 px-2 py-4 min-h-12 max-h-12 relative flex items-center justify-between bg-green-600">
		<div class="flex items-center gap-4">
			<!-- Navegação lateral (Dispositivos móveis) -->
			<font-awesome-icon icon="bars" class="max-lg:inline-block hidden text-green-200" @click="menuOpen = true" />
			<teleport to="body">
				<Slide from="left">
					<nav
						class="absolute left-0 top-0 w-screen sm:w-1/2 h-screen z-50 flex flex-col justify-between lg:hidden bg-green-600 text-green-200 border-r-4 border-r-green-800"
						v-if="menuOpen">
						<!-- Fechar menu -->
						<div class="flex justify-end mx-2 mt-2">
							<font-awesome-icon icon="times" size="2xl" @click="menuOpen = false" />
						</div>

						<!-- Lista -->
						<section class="w-full h-full mt-2 overflow-y-auto border-y-2 border-y-green-800">
							<CollapseGroup>
								{{ $t('nav.softwares') }}
								<template #children>
									<CollapseGroup>
										Item 1
									</CollapseGroup>
								</template>
							</CollapseGroup>
							<CollapseGroup>
								{{ $t('nav.games') }}
								<template #children>
									<CollapseGroup>
										Item 1
									</CollapseGroup>
								</template>
							</CollapseGroup>
							<CollapseGroup>
								{{ $t('nav.online_tools') }}
								<template #children>
									<CollapseGroup>
										Item 1
									</CollapseGroup>
								</template>
							</CollapseGroup>
							<CollapseGroup>
								{{ $t('nav.blog') }}
							</CollapseGroup>
							<CollapseGroup>
								{{ $t('nav.store') }}
							</CollapseGroup>
						</section>

						<!-- Rodapé -->
						<section class="bg-green-700 px-2 py-2">
							<LanguageButton />
						</section>
					</nav>
				</Slide>
			</teleport>

			<!-- Logo -->
			<div class="relative w-10 h-12 overflow-hidden">
				<Link href="/">
				<ApplicationLogo class="w-10 absolute top-0" />
				</Link>
			</div>

			<!-- Links de navegação -->
			<div class="ml-2 hidden lg:flex gap-4">
				<Dropdown align="left">
					<template #trigger>
						<NavLink>
							{{ $t('nav.softwares') }}
						</NavLink>
					</template>
					<template #content>
						Software
					</template>
				</Dropdown>
				<Dropdown align="left">
					<template #trigger>
						<NavLink>
							{{ $t('nav.games') }}
						</NavLink>
					</template>
					<template #content>
						Games
					</template>
				</Dropdown>
				<Dropdown align="left">
					<template #trigger>
						<NavLink>
							{{ $t('nav.online_tools') }}
						</NavLink>
					</template>
					<template #content>
						Online Tools
					</template>
				</Dropdown>
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
			<template v-if="$page.props.auth.user">
				<Dropdown size="md" :content-classes="['w-full']">
					<template #trigger>
						<div class="flex gap-1 items-center px-2 text-green-200">
							<span class="hidden lg:block">{{ $page.props.auth.user.show_name }}</span>
							<Avatar :user="$page.props.auth.user" size="xxs" />
							<font-awesome-icon icon="chevron-down" />
						</div>
					</template>
					<template #content>
						<div class="pl-4 py-2 text-sm bg-slate-300 dark:bg-slate-500 lg:hidden">
							{{ $page.props.auth.user.show_name }}
						</div>
						<DropdownGroup>
							<DropdownLink v-if="$page.props.can.view_dashboard" :href="route('admin.index')">
								<font-awesome-icon icon="gauge" />
								<span class="ml-4">{{ $t('nav.admin_dashboard') }}</span>
							</DropdownLink>
							<DropdownLink :href="route('profile.show')">
								<font-awesome-icon icon="user" />
								<span class="ml-4">{{ $t('Profile') }}</span>
							</DropdownLink>
							<DropdownLink :href="route('profile.show')">
								<font-awesome-icon icon="gear" />
								<span class="ml-4">{{ $t('Settings') }}</span>
							</DropdownLink>
							<DropdownLink type="button" @click="logout">
								<font-awesome-icon icon="arrow-right-from-bracket" />
								<span class="ml-4">{{ $t('auth.logout') }}</span>
							</DropdownLink>
						</DropdownGroup>
					</template>
				</Dropdown>
			</template>
			<template v-else>
				<Button v-if="$page.props.canLogin" :href="route('login')" icon="arrow-right-to-bracket" color="primary">
					<span class="max-sm:hidden block">
						{{ $t('auth.login').toUpperCase() }}
					</span>
				</Button>
				<Button v-if="$page.props.canRegister" :href="route('register')" icon="arrow-right-to-bracket" color="secondary" class="hidden sm:inline-flex">
					{{ $t('auth.register').toUpperCase() }}
				</Button>
			</template>
			<ThemeSwitcher size="lg" />
			<Tooltip>
				<template #label>
					<NavLink href="/">
						<font-awesome-icon icon="cart-shopping" size="lg" />
					</NavLink>
				</template>

				<span>{{ $t('nav.my_cart') }}</span>
			</Tooltip>
		</div>
	</nav>
</template>
