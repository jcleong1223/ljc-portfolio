<template>
	<div class="d-flex flex-column fill-height">
		<div>
			<v-row
				class="fill-width ma-auto"
				style="height: 100vh;"
			>
				<v-col
					v-if="$vuetify.breakpoint.mdAndUp"
					cols="12"
					md="2"
					lg="2"
					style="background: rgb(22,24,32);background: linear-gradient(180deg, rgba(22,44,52,1) 0%, rgba(36,54,64,1) 100%);box-shadow: 4px 2px 20px 0px rgba(32,86,144,0.75); opacity: 0.9; padding-top: 50px ;"
					class="fill-height"
				>
					<Sidebar></Sidebar>
				</v-col>
				<v-app-bar 
					v-else
					app
					height="60"
					flat
					style="background: rgb(22,24,32);background: linear-gradient(180deg, rgba(22,44,52,1) 0%, rgba(36,54,64,1) 100%);box-shadow: 4px 2px 20px 0px rgba(32,86,144,0.75); opacity: 0.8;"
				>
					<template v-if="!isOpen">
						<v-app-bar-nav-icon @click="isOpen=!isOpen"></v-app-bar-nav-icon>
					</template>

					<v-toolbar-title>
						<v-row>
							<v-col>
								<span class="font-weight-bold" style="letter-spacing: 2px; font-size: large;">Kevin Leong</span>
							</v-col>
						</v-row>
					</v-toolbar-title>
				</v-app-bar>
				<v-col
					cols="12"
					md="10"
					lg="10"
					:class="$vuetify.breakpoint.smAndDown ? 'px-0 mt-16' : 'mx-auto'"
					style="overflow-y: scroll"
				>
					<v-container fluid>
						<transition name="slide-fade">
							<keep-alive>
								<router-view v-if="$route.meta.keepAlive"></router-view>
							</keep-alive>
						</transition>
						<transition name="slide-fade">
							<router-view v-if="!$route.meta.keepAlive"></router-view>
						</transition>
					</v-container>
				</v-col>
			</v-row>
		</div>
		<!-- <v-container fluid>
			<transition name="slide-fade">
				<keep-alive>
					<router-view v-if="$route.meta.keepAlive"></router-view>
				</keep-alive>
			</transition>
			<transition name="slide-fade">
				<router-view v-if="!$route.meta.keepAlive"></router-view>
			</transition>
		</v-container> -->


		<!-- Side bar -->
		<v-navigation-drawer
			ref="sidebar"
			v-model="isOpen"
			app
			temporary
			floating
			class="elevation-1 secondary"
		>
			<template #prepend>
				<v-row class="ma-0" align="center">
					<v-col cols="auto">
						<v-app-bar-nav-icon @click="isOpen=!isOpen"></v-app-bar-nav-icon>
					</v-col>
					<v-col cols="auto" class="text-center">
						<!-- <span class="font-weight-bold" style="letter-spacing: 2px; font-size: large;">{{ $config.name }}</span> -->
					</v-col>
					<v-spacer></v-spacer>
				</v-row>
				<v-divider></v-divider>
			</template>
			<template v-for="(group,i) in route_groups">
				<v-list
					v-if="group.routes.length > 0"
					:key="i"
					dense
					flat
					class="pt-16 mt-16"
					style="background: transparent;"
				>
					<v-subheader v-if="group.title!=null">
						{{ group.title }}
					</v-subheader>
					<template v-for="item in group.routes">
						<template v-if="item.sub">
							<v-list-group
								:key="item.title"
								append-icon="mdi-menu-down"
								color="primary"
								no-action
							>
								<template #activator>
									<v-list-item-content>
										<v-list-item-title>{{ item.title }}</v-list-item-title>
									</v-list-item-content>
								</template>
								<v-list-item
									v-for="child in item.sub"
									:key="child.title"
									:to="child.to"
								>
									<v-list-item-title>{{ child.title }}</v-list-item-title>
								</v-list-item>
							</v-list-group>
						</template>
						<v-list-item
							v-else
							:key="item.title"
							:to="item.to"
							active-class="font-weight-bold"
						>
							<template #default="{ active }">
								<v-list-item-title
									:class="active ? 'text-h6 font-ibm-plex my-4 font-weight-bold' : 'text-h6 font-ibm-plex my-4'"
									style="line-height: 28px; white-space:inherit; color: #66FCD1; text-shadow: 3px 1px 15px rgba(60,228,233,0.6); font-weight: 400; text-transform: uppercase"
								>
									{{ item.title }}
								</v-list-item-title>
							</template>
						</v-list-item>
					</template>
				</v-list>
			</template>
			<template #append>
				<div
					class="pa-4 text-caption text-center relative"
					style="width: 100%; font-size: 0.6rem !important;"
				>
					<a :href="poweredBy.href" target="_BLANK" class="text-decoration-none opposite--text"><strong>{{ poweredBy.text }}</strong></a>
					<div class="position-absolute grey--text px-1" style="right: 0; font-size: 9px;">{{ app_version }}</div>
				</div>
			</template>
		</v-navigation-drawer>
	</div>
</template>

<script>
import Sidebar from '@src/components/Sidebar.vue'
import { getNavbarList } from "@src/config/navbar";
//import Footer from "@src/components/Footer.vue";
export default {
	components: {
		Sidebar,
		//Footer
	},
	data(){
		return {
			isOpen: false,
			app_version : this.$config.version,
			poweredBy: null,
			route_groups: [],

		}
	},
	created(){
		this.getNavRoute()
		this.poweredBy = {
			text: "© 2024 LJC. All rights reserved.",
			href: "https://www.etctech.com.my/",
		}
	},
	methods:{
		getNavRoute(){
			this.route_groups = getNavbarList(this.$auth.user())
		},
	}
}
</script>