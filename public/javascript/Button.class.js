class Button {
	constructor({name, action, classType, value}){
		this.name = name;
		this.action = action;
		this.classType  = classType;
		this.value = value;
	}
	createButton(){
		var html = ''; 
		this.action != ''
			? html =  "<button name='" + this.name + 
						 "' class='" + this.classType +
						 "' onclick ='" + this.action + 
						 "'>" + this.value + "</button>"
			: html = "<button name='" + this.name +
						"' class='" + this.classType +
						"'>" + this.value + "</button>"
			return html;
	}
	createRadio(){
		var html = "<input type='radio' onclick='" + this.action + 
				   "' id='" + this.name +
				   "' name='" + this.name +
				   "' value='" + this.value + "'>"
		return html;
	}
	createInput(id){
		var html =''; 
		var label = this.name.charAt(0).toUpperCase() + string.substr(1) + ":";
		console.log(label); 
		id != ''
			?	html =  label + "<br /><br /" +
				"<input type='text' id='" + 
				this.name+"_"+id+"' name = '"+
				this.name+"'/>"
			: 	html =  label + "<br /><br /" +
				"<input type='text' id='" + 
				this.name+"' name = '"+
				this.name+"'/>"; 
		return html;
	}
}
