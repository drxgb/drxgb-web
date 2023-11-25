<script setup lang="ts">
import { ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import Accordion from './Accordion.vue';
import ApplicationLogo from './ApplicationLogo.vue';
import Button from './Button.vue';
import Dropdown from './Dropdown.vue';
import LanguageButton from './LanguageButton.vue';
import NavLink from './NavLink.vue';
import ThemeSwitcher from './ThemeSwitcher.vue';


const menuOpen = ref(false);

function logout(): void {
	// @ts-ignore
	router.post(route('logout'));
};
</script>


<template>
	<nav class="lg:px-20 sm:px-8 px-2 py-4 min-h-12 max-h-12 relative flex items-center justify-between bg-green-600">
		<div class="flex items-center gap-4">
			<!-- Navegação lateral (Dispositivos móveis) -->
			<font-awesome-icon :icon="['fas', 'bars']" class="max-lg:inline-block hidden text-green-200" @click="menuOpen = true" />
			<transition
				enter-active-class="transition ease-out duration-200"
				enter-from-class="transform -translate-x-full"
				enter-to-class="transform translate-x-0"
				leave-active-class="transition ease-in duration-200"
				leave-from-class="transform translate-x-0"
				leave-to-class="transform -translate-x-full">
				<nav
					class="absolute left-0 top-0 w-screen sm:w-1/2 h-screen z-50 flex flex-col justify-between lg:hidden bg-green-600 text-green-200 border-r-4 border-r-green-800"
					v-if="menuOpen">
					<!-- Fechar menu -->
					<div class="flex justify-end mx-2 mt-2">
						<font-awesome-icon :icon="['fas', 'times']" size="2xl" @click="menuOpen = false" />
					</div>

					<!-- Lista -->
					<section class="w-full h-full mt-2 overflow-y-auto border-y-2 border-y-green-800">
						<Accordion>
							{{ $t('nav.softwares') }}

							<template #children>
								<Accordion>
									Item 1
								</Accordion>
							</template>
						</Accordion>

						<Accordion>
							{{ $t('nav.games') }}

							<template #children>
								<Accordion>
									Item 1
								</Accordion>
							</template>
						</Accordion>

						<Accordion>
							{{ $t('nav.online_tools') }}

							<template #children>
								<Accordion>
									Item 1
								</Accordion>
							</template>
						</Accordion>

						<Accordion>
							{{ $t('nav.blog') }}
						</Accordion>

						<Accordion>
							{{ $t('nav.store') }}
						</Accordion>
					</section>

					<!-- Rodapé -->
					<section class="bg-green-700 px-2 py-2">
						<LanguageButton />
					</section>
				</nav>
			</transition>

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
			<template v-if="$page.props.auth.user"></template>
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
			<ThemeSwitcher />
			<NavLink href="/">
				<font-awesome-icon :icon="['fas', 'cart-shopping']" />
			</NavLink>
		</div>
	</nav>
</template>
