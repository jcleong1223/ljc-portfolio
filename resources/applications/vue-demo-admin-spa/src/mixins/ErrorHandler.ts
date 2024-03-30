// export default class ErrorHandler{

// 	errorHandler_(err, tracker = []){
// 		let { a, b } = self.errorSeparator_(err, tracker)
// 		if(Object.keys(b).length > 0){
// 			this.alertErrorMessages_( this.computeErrorMessages_(b) )
// 		}
// 		return a
// 	}

// 	errorSeparator_(err, tracker = []){

// 		let responseMsg = "Something Is Not Right. Please Try Again Later."
// 		let intersect_errors = {}
// 		let not_intersect_errors = {}

// 		if(err == null){
// 			this.defaultNotify_(responseMsg)
// 		}else if(err.status && err.data){
// 			let { status, data } = err

// 			// if is validation error
// 			if(status == 422){
// 				let errors =  data.errors || data.message

// 				Object.keys(errors).forEach(function(key) {
// 					if (tracker.includes(key)) {
// 						intersect_errors[key] = errors[key];
// 					}else{
// 						not_intersect_errors[key] = errors[key];
// 					}
// 				});
// 			}else{
// 				responseMsg = [400,403].includes(status) ? data.message : responseMsg
// 				this.defaultNotify_(responseMsg)
// 			}

// 		}else{
// 			console.error(err)
// 		}

// 		return {
// 			"intersectErrors" : intersect_errors,
// 			"notIntersectErrors" : not_intersect_errors
// 		};
// 	}

// 	defaultNotify_(message){
// 		this.$toast.warning(message)
// 		return null;
// 	}

// 	computeErrorMessages_(errors){
// 		let error_keys = Object.keys(errors)
// 		if(error_keys.length > 0){
// 			let messages = []
// 			error_keys.forEach((key)=>{
// 				messages.push( errors[key][0] )
// 			})
// 			return messages;
// 		}
// 		return []
// 	}

// 	alertErrorMessages_(messages){
// 		this.$toast.warning(messages.join('<br>'))
// 	}
// }