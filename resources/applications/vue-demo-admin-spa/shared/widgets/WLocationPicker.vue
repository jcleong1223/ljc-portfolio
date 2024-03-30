<template>
	<v-card>
		<v-card-title>Select Location</v-card-title>
		<v-card-subtitle>Enter Your Address Or Move The GPS Icon.</v-card-subtitle>
		<v-divider></v-divider>
		<v-card-text class="pb-2">
			<v-row dense>
				<v-col cols="12">
					<gmap-autocomplete
						placeholder="This is a placeholder text"
						:options="options"
						@place_changed="setPlace"
					>
						<template #input="slotProps">
							<v-text-field
								ref="input"
								placeholder="Enter Address"
								hide-details
								prepend-inner-icon="mdi-magnify"
								@listeners="slotProps.listeners"
								@attrs="slotProps.attrs"
							></v-text-field>
						</template>
					</gmap-autocomplete>
				</v-col>
				<v-col cols="12">
					<GmapMap
						:center="centerView"
						:zoom="zoom"
						map-type-id="terrain"
						style="width: 100%; height: 300px"
					>
						<GmapMarker
							:position="marker"
							draggable
							@dragend="marker_dragend"
						/>
					</GmapMap>
				</v-col>
			</v-row>
		</v-card-text>
		<v-card-actions>
			<v-spacer></v-spacer>
			<v-btn
				color="blue darken-1" text title="Cancel"
				@click="closeDialog()"
			>
				Cancel
			</v-btn>
			<v-btn
				color="blue darken-1"
				text title="Save"
				@click="save()"
			>
				Save
			</v-btn>
		</v-card-actions>
	</v-card>
</template>

<script>
export default{
	props:{
		value:{
			type: Object,
			default: ()=>{
				return {
					lat: 3.1390,
					lng: 101.6869
				}
			}
		}
	},
	data(){
		return {
			marker: {},
			options : {
				fields: [
					'geometry'
				]
			},
			zoom: 7,
		}
	},
	computed:{
		centerView(){
			return this.marker
		}
	},
	watch:{
		'value':{
			handler(){
				let position = {}
				if(this.value != null){
					position = {
						lat: +this.value.lat,
						lng: +this.value.lng
					}
				}
				this.updateMarker(position.lat, position.lng)
			},
			immediate: true,
		},
	},
	methods:{
		save(){
			this.$emit('input',{
				lat : this.marker.lat.toFixed(6),
				lng : this.marker.lng.toFixed(6),
			})
			this.closeDialog()
		},
		closeDialog(){
			this.updateMarker(+this.value.lat, +this.value.lng)
			this.$emit('update:visible',false)
		},
		marker_dragend(geo){
			this.updateMarker(geo.latLng.lat(), geo.latLng.lng())
		},
		setPlace(place){
			let geometry = place.geometry
			this.updateMarker(geometry.location.lat(), geometry.location.lng())
		},
		updateMarker(lat, lng){
			this.marker = {
				lat : lat,
				lng : lng,
			}
		},
	}
}
</script>