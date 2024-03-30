import truncate from "lodash/truncate"

export default class Helper
{
	static formatThousandSeparator(n) {
		var parts = n.toString().split(".");
		const numberPart = parts[0];
		const decimalPart = parts[1];
		const thousands = /\B(?=(\d{3})+(?!\d))/g;
		return numberPart.replace(thousands, ",") + (decimalPart ? "." + decimalPart : "");
	}

	static truncate(str, length){
		return truncate(str, {
			'length': length,
			'omission': '...'
		})
	}
}