	 /**
     * @Name: NewForm Class
     * @Description: Builds a form in a new bootstrap tab.
     * @Parameters: 
	 *		        name - name of the form
	 *		        tabNo - id for the tab
	 *				variables - object containing various form elements - defined in formVariables.js
	 *						  - can define arrays within variables Object to override the colNo value
	 *						  - useful when forms cannot be uniformly defined into a certain 
	 *						  - number of columns
	 *				buttons - variables object
	 *				groups - defined in variables.group - stores arrays of buttons
	 *				variables - individual buttons defined in the variables object
	 *				functionName - function called when the submit button is pushed
	 *				displayName - Name displayed on the tab label
	 *				preview - Boolean - creates a preview area with the text in the clipboard, if true
	 *            
     * @Methods: create(colNo) - creates a form with buttons grouped in to rows 
	 *                           with colNo of columns
	 *           buildForm() - static method to build a form - used for forms.json
     * @Author: Jacob Conner
     */
class NewForm
 {
	 constructor(name, tabNo, srcType, variables, functionName, displayName, preview){
		 this.name = name; 
		 this.tabNo = tabNo;
		 this.srcType = srcType;
		 this.buttons = variables; 
		 this.groups = variables.groups;
		 this.variables = variables.buttons;
		 this.functionName = functionName; 
		 this.displayName = displayName; 
		 this.preview = preview; 
	 }
	
	create(colNo, location){	
		const formName = () =>
				{
					return this.functionName.replace(/[A-Za-z].*\./, "")
									   .replace(/\(.*\)/, "") + "_form";
				};
		const phpAction = () =>
				{
					return this.functionName.replace(/[A-Za-z].*\./, "")
									   .replace(/\(.*\)/, "") + ".php";
				};
		var displayName = this.displayName;
		var buttons; 
		
		var html = `<form name='${this.name}' id='${this.name}' method='post' enctype='multipart/form-data'>`;
		html += `<input type='hidden' value='${this.srcType}' name='type' id='type_${this.tabNo}' />`;

		//console.log(this.variables); 
		this.groups.map((currentElement)=>{
			var length = currentElement.length;
			var buttonsG = new ButtonGroup(currentElement, length, 'testid', 'test');
			html += `${buttonsG.createNoDiv()} <br />`;
		});
		if(this.variables){
			buttons = new ButtonGroup(this.variables, colNo, formName(), 'form');
		  html += `${buttons.createNoDiv()} <br />`;
		}
		html += `<input type='button' id='${this.name}_submit' class='submit' onclick='postDatas(\"../private/shared/${phpAction()}\", \"${this.name}\")'value='Create'></input>
				</form>`;
		//Create results section
		html += `<div id='${this.name}_Result'></div>`
		//Create a preview box
		this.preview 
			? html += `<br />
			 <br />
			 <p id='templateName_${this.tabNo}' class='templateName'>${displayName}</p>
			 <p id='Preview_${this.tabNo}' class='Preview'></p>`
			 : null;
		var results = {"html": html,
						tab(){ createTab(formName(), displayName, html, location);
						}
					  }
		return results; 
	 }
	 // buttonGroup constructor(buttons, cols, id, classType)
	 static buildForm(name, location){
		const IsName = formList => formList.name == name; 
		var formsObject = formList.filter(IsName)
								  .map((currentElement)=>{
									var srcType = currentElement.srcType;
									var id = nextTab(location); 
									var functionName;
									var variables = {};
									var groups = [];
									variables.buttons = [];
									variables.groups = [];
									var variablesList = currentElement.variables.map((currentVariable)=> {
										if(Array.isArray(currentVariable)){
											groups = [];
											currentVariable.map((cv)=>{
												groups.push(window[cv](id))
												});
											variables.groups.push(groups);	
										}else{ 
											variables.buttons.push(window[currentVariable](id));	
										}
									});
									var colTotal = colTotal;
									functionName = `${currentElement.functionName}(${id})`;
									var newForm1 = new NewForm(name, 
															   id, 
															   srcType,
															   variables, 
															   functionName, 
															   currentElement.displayName,
															   currentElement.preview);
									newForm1.create(currentElement.colTotal, location).tab();
								  });
	 }
	 
	static buildFormDiv(name, location, id){
		var html;
		const IsName = formList => formList.name == name; 
		var formsObject = formList.filter(IsName)
								  .map((currentElement)=>{
									var srcType = currentElement.srcType;
									var functionName;
									var variables = {};
									var groups = [];
									variables.buttons = [];
									variables.groups = [];
									var variablesList = currentElement.variables.map((currentVariable)=> {
										if(Array.isArray(currentVariable)){
											groups = [];
											currentVariable.map((cv)=>{
												groups.push(window[cv](id))
												});
											variables.groups.push(groups);	
										}else{ 
											variables.buttons.push(window[currentVariable](id));	
										}
									});
									var colTotal = currentElement.colTotal;
									functionName = `${currentElement.functionName}(${id})`;
									var newForm1 = new NewForm(name, 
															   id, 
															   srcType,
															   variables, 
															   functionName, 
															   currentElement.displayName,
																currentElement.preview);
									 html = newForm1.create(currentElement.colTotal, location).html;
								  });
								  document.getElementById(location).innerHTML = html;
	 }
 }