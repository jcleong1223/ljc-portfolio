type callback = (item: object) => string;

export class DataBlockOption{

	static readonly TYPE_DIVIDER = "divider";
	static readonly TYPE_TEXT_VALUE = "text-value";
	static readonly TYPE_TITLE = "title";
	static readonly TYPE_SLOT = "slot";

	type: string;
	text: string;
	value: string|callback;
	cols: string|number;

	constructor({
		type,
		text,
		value,
		cols = 12,
	}) {
		this.type = type;
		this.text = text;
		this.value = value;
		this.cols = cols;
	}


	/**
	 * Create Divider Type
	 *
	 * @returns DataBlockOption
	 */
	static constructDivider() {
		return new DataBlockOption({
			type: DataBlockOption.TYPE_DIVIDER,
			text: "null",
			value: "null",
		});
	}

	/**
	 * Create Text-Value Type
	 *
	 * @param text Text Name
	 * @param value slot name
	 * @returns DataBlockOption
	 */
	static constructTextValue(text : string, value : string|callback ) : DataBlockOption
	{
		return new DataBlockOption({
			type: DataBlockOption.TYPE_TEXT_VALUE,
			text: text,
			value: value,
		});
	}

	static constructTitle(title: string) : DataBlockOption
	{
		return new DataBlockOption({
			type: DataBlockOption.TYPE_TITLE,
			text: title,
			value: "null",
		});
	}

	/**
	 * Create Slot Type
	 *
	 * use with `item-block.slot-name` slot
	 * ```
	 * <template #[`item-block.slot-name`]="{ item }"></template>
	 * ```
	 * @param value slot name
	 * @returns DataBlockOption
	 */
	static constructSlot(value: string) : DataBlockOption
	{
		return new DataBlockOption({
			type: DataBlockOption.TYPE_SLOT,
			text: "null",
			value: value,
		});
	}

}
// type : item.type || 'text',
// text : item.text,
// value : item.value,
// cols : item.cols || 12,
// md : item.md || 12,
// callback : item.callback
