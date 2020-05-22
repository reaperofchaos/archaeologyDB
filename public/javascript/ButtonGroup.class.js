class ButtonGroup {
		constructor(buttons, cols, id, classType){
			this.buttons = buttons;
			this.cols = cols;
			this.id = id;
			this.classType = classType;
		}
		buildCopyButton(currElement){
			var newCopyButton = new CopyButton(currElement);
			var html = "<td>" + newCopyButton.createButton() + "</td>";
			return html; 
		}
		
		buildButton(currElement){
			var newButton = new Button(currElement);
			var html = "<td>" + newButton.createButton() + "</td>";
			return html; 
		}
		
		createButtonRow(currElement, colCount, fromObj){
			var html = '';
			var i = colCount - 1;
			colCount == 1
				? html += "<tr>"
				: i % this.cols == 0
					? html+= "</tr>"
						  + "<tr>"
					: null;
			fromObj == 'yes' 
				? html += this.buildButton(currElement)
				: html += "<td>" + currElement + "</td>";
			return html;
		}
		
		createCopyButtonRow(currElement, colCount, fromObj){
			var html = '';
			var i = colCount - 1;
			colCount == 1
				? html += "<tr>"
				: i % this.cols == 0
					? html+= "</tr>"
						  + "<tr>"
					: null;
			fromObj == 'yes' 
				? html += this.buildCopyButton(currElement)
				: html += "<td>" + currElement + "</td>";
			return html;
		}
		
		createCopyButtons(){
			var html = "<div id='" + this.id + "' class='"+ this.classType +"'>"
					 + "<table class='table borderless'>";
			console.log(this.buttons);
			this.buttons.map((currElement, index) =>
				{
					var colCount = index + 1; 
					html += this.createCopyButtonRow(currElement, colCount, 'yes');
				});
			html += "</tr>"
				 +"</table>"
				 + "</div>";
			return html;
		}
		createButtons(){
			var html = "<div id='" + this.id + "' class='"+ this.classType +"'>"
					 + "<table class='table borderless'>";
			this.buttons.map((currElement, index) =>
				{
					var colCount = index + 1; 
					html += this.createButtonRow(currElement, colCount, 'yes');
				});
			html += "</tr>"
				 +"</table>"
				 + "</div>";
			return html;
		}
		create(groupType){
			var html = '';
			groupType == 'copy'
			? html += this.createCopyButtons()
			: html += this.createButtons();
			return html;
		}
		
		createNoDiv(){
		var html = "<table class='table borderless'>";
		this.buttons.map((currElement, index)=>{
				var colCount = index + 1; 
				html += this.createButtonRow(currElement, colCount, 'no');
		});
			html += "</tr>"
				 +"</table>";
		return html;
		}
}
