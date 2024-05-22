<template>
	<div>
		<div class="mx-auto pl-4">
			<v-avatar
				size="75"
			>
				<img
					src="/images/profileimg_placeholder.png"
					alt="John"
				>
			</v-avatar>
			<br>
			<br>
			<span
				class="text-h5 text-center font-family-primary" 
				style="line-height: 28px; white-space:inherit; color: #45a29e; text-shadow: 3px 1px 15px rgba(89,188,184,0.6); font-weight: 900;"
			>
				Kevin Leong
			</span>
		</div>
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

			<div class="ml-4 mt-3 ">
				<button class="letter-animation floating">
					<div class="LETTER">
						<span class="special_text">Resume <span class="mdi mdi-download pl-1"></span></span>
					</div>
				</button>
			</div>
		</template>
	</div>
</template>

<script>
import { getNavbarList } from "@src/config/navbar";
export default {
	data () {
		return {
			title : this.$config.name,
			app_version : this.$config.version,
			isOpen: true,
			menu: false,
			route_groups: [],
			poweredBy: null
		}
	},
	// watch:{
	// 	$route (to, from){
	// 		console.log(to,from)
	// 	}
	// },
	created(){
		this.getNavRoute()
		this.poweredBy = {
			text: "© 2024 LJC. All rights reserved.",
			href: "https://www.etctech.com.my/",
		}
	},
	methods: {
		getNavRoute(){
			this.route_groups = getNavbarList(this.$auth.user())
		},
		// toggleDarkMode() {
		// 	this.$vuetify.theme.dark = !this.$vuetify.theme.dark;
		// 	localStorage.setItem("dark-theme", this.$vuetify.theme.dark);
		// },
		// toUseProfile(){
		// 	this.menu = false
		// 	this.$router.push({ name: 'my-account' });
		// },
		logout(){
			this.$auth.logout({
				makeRequest: true,
				data: {},
				redirect: { name: "login" },
				// etc...
			});
		},
	}
}
</script>

<style scoped>
.letter-animation {
	text-align: center;
	background-color: #171717;
	padding: 10px 25px;
	border: 3px solid transparent;
	border-radius: 0.6em;	
	transition: 0.2s;
}

.letter-animation:hover {
	background-color: #000000;
	border: 3px solid #3d93ee;
	box-shadow: 0px 0px 27px 5px rgba(117, 219, 215, 0.6);
}

.LETTER {
	color: #fff;
	font-size: 19px;
	font-weight: bold;
	overflow: hidden;
	border-right: 4px solid transparent;
	white-space: nowrap;
	margin: 0 auto;
}

.letter-animation:hover .LETTER {
	border-right: 4px solid #3d93ee;
	animation: letters 1.5s steps(22, end),
	cursor .4s step-end infinite;
}

.special_text {
	background: linear-gradient(
		90deg,
		#866ee7,
		#ea60da,
		#ed8f57,
		#fbd41d,
		#2cca91,
		#38dbff,
		#4ef72d,
		#a46ec8,
		#ea60da,
		#f5e42a
	);
	-webkit-background-clip: text;
	-webkit-text-fill-color: transparent;
	background-clip: text;
	text-fill-color: transparent;
	display: block;
	font-weight: 900;
}

.floating {
	animation: 3s infinite alternate floating-up;
	/* animation: bounce_ani 1s infinite alternate; */
}

@keyframes letters {
	from {
		width: 0;
	}

	to {
		width: 100%;
	}
}

@keyframes cursor {
	from {
		border-color: transparent
	}

	50% {
		border-color: #3d93ee
	}
}

@keyframes floating-up {
    0% {
        transform: translatey(0px);
    }
    50% {
        transform: translatey(-10px);
    }
    100% {
        transform: translatey(0px);
    }
}

@keyframes bounce_ani {
  0%,
    100% {
    transform: translateY(-25%);
    animation-timing-function: cubic-bezier(0.8, 0, 1, 1);
  }

  50% {
    transform: translateY(0);
    animation-timing-function: cubic-bezier(0, 0, 0.2, 1);
  }
}

</style>