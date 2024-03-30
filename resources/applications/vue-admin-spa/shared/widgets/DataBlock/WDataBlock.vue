<template>
	<v-row
		v-if="Object.keys(item).length > 0"
		v-bind="$attrs"
		v-on="$listeners"
	>
		<template v-for="(dataBlock,i) in dataBlocks">
			<v-col
				:key="i"
				:cols="dataBlock.cols"
				:md="dataBlock.md"
			>
				<template v-if="dataBlock.type == 'divider' ">
					<v-divider class="mx-0"></v-divider>
				</template>
				<template v-else-if="dataBlock.type == 'title' ">
					<div class="text-h6 font-weight-bold">{{ dataBlock.text }}</div>
				</template>
				<template v-else>
					<slot :name="'item-block.'+dataBlock.value" :item="item">
						<v-row>
							<v-col cols="5" md="3">
								<div class="font-weight-bold">{{ dataBlock.text }}</div>
							</v-col>
							<v-col cols="7" md="9">
								<slot :name="'item-block-value.'+dataBlock.value" :item="item">
									<div>{{ computeBlockValue(dataBlock, item) }}</div>
								</slot>
							</v-col>
						</v-row>
					</slot>
				</template>
			</v-col>
		</template>
	</v-row>
</template>

<script lang="ts">
import { defineComponent, PropType } from 'vue'
import { DataBlockOption } from './DataBlockOption'
export default defineComponent({
	props:{
		item: {
			type: Object as PropType<unknown>,
			required: true,
			default: ()=>{
				return {}
			}
		},
		dataBlocks: {
			type: Array as PropType<DataBlockOption[]>,
			default: () => [],
			validator: (val : DataBlockOption[]) => val.every((item) => item instanceof DataBlockOption)
		},
		fallbackText: {
			type: String as PropType<string>,
			default: '-'
		},
	},
	methods:{
		computeBlockValue(dataBlock : DataBlockOption, item : object) : string | object
		{
			if(dataBlock.value instanceof Function){
				return dataBlock.value(item)
			}else{
				return this.getPropByString(item, dataBlock.value)
			}
		},
		getPropByString(obj: object, propString: string): string | object
		{
			if (!propString){
				return obj;
			}

			let prop: string, props = propString.split('.');

			for (var i = 0, iLen = props.length - 1; i < iLen; i++) {
				prop = props[i];

				let candidate = obj[prop];
				if (candidate !== undefined) {
					obj = candidate;
				} else {
					break;
				}
			}

			if(obj[props[i]] == null){
				console.log(this.fallbackText)
				return "null"
			}else{
				return obj[props[i]]
			}
		}
	}
})
</script>