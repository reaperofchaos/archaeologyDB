//sources fields
function frmSrcTypeHidden(id, $srcType)
{
    return `<input type='hidden' value='${srcType}' name='srcType_${id}' />`;
}
function frmTitle(id) 
{
    return `Title: <br /> <br/><input type='text' id='title_${id}' name='title'/>`;
}
function frmAuthor(id, number) 
{
    return `<label for='author${number}_${id}'>Author ${number}:</label>
            <input type='text' id='author${number}_${id}' list='authors' name='author[]'/>`;
}
function frmAuthors(id) 
{
    var html = `<input type='hidden' id='authorClicks_${id}' value='1' />
    <table class='table' id='authors_${id}'>
        <tr>
            <td>
                ${frmAuthor(id, 1)}
            </td>
            <td>
                ${frmAuthor(id, 2)}
            </td>
            <td>
                ${frmAuthor(id, 3)}
            </td>
            <td>
                ${frmAuthor(id, 4)}
            </td>
        </tr>
    </table><br />
    <input type='button' onClick='addAuthors(${id})' value = 'Add Authors' />`;
    return html;
}
function addAuthors(id){
    //Get current click count stored in hidden div
    var clicks = document.getElementById('authorClicks_'+id).value;
    clicks++;
    document.getElementById('authorClicks_'+id).value = clicks; 
    //get table
    var authorTable = document.getElementById('authors_'+id);
    // Create an empty <tr> element and add it to the 1st position of the table:
    var row = authorTable.insertRow(-1);
    var endValue = 4 * clicks; 
    var i = endValue - 4;
    var td = [];
    // Insert new cells (<td> elements) at the 1st and 2nd position of the "new" <tr> element:
    td.push(row.insertCell(0));
    td.push(row.insertCell(1));
    td.push(row.insertCell(2));
    td.push(row.insertCell(3));
    a = 0;
    while(i < endValue){
        if(a < 4){
            td[a].innerHTML = `${frmAuthor(id, i)}`;
        }
        i++;
        a++;
    } 
}
function frmEditor(id, number) 
{
    return `<label for='editor${number}_${id}'>Editor ${number}:</label>
            <input type='text' id='editor${number}_${id}' list='authors' name='editor[]'/>`;
}
function frmEditors(id) 
{
    var html = `<input type='hidden' id='editorClicks_${id}' value='1' />
    <table id='editors_${id}' class='table'>
        <tr>
            <td>
                ${frmEditor(id, 1)}
            </td>
            <td>
                ${frmEditor(id, 2)}
            </td>
            <td>
                ${frmEditor(id, 3)}
            </td>
            <td>
                ${frmEditor(id, 4)}
            </td>
        </tr>
    </table><br />
    <input type='button' onClick='addEditors(${id})' value = 'Add Editors' />`;
    return html;
}
function addEditors(id){
    //Get current click count stored in hidden div
    var clicks = document.getElementById('editorClicks_'+id).value;
    clicks++;
    document.getElementById('editorClicks_'+id).value = clicks; 
    //get table
    var editorTable = document.getElementById('editors_'+id);
    // Create an empty <tr> element and add it to the 1st position of the table:
    var row = editorTable.insertRow(-1);
    var endValue = 4 * clicks; 
    var i = endValue - 4;
    var td = [];
    // Insert new cells (<td> elements) at the 1st and 2nd position of the "new" <tr> element:
    td.push(row.insertCell(0));
    td.push(row.insertCell(1));
    td.push(row.insertCell(2));
    td.push(row.insertCell(3));
    a = 0;
    while(i < endValue){
        if(a < 4){
            td[a].innerHTML = `${frmEditor(id, i)}`;
        }
        i++;
        a++;
    } 
}

function frmSupervisor(id, number) 
{
    return `<label for='supervisor${number}_${id}'>Supervisor ${number}:</label>
            <input type='text' id='supervisor${number}_${id}' list='authors' name='supervisor[]'/>`;
}
function frmSupervisors(id) 
{
    var html = `<input type='hidden' id='supervisorClicks_${id}' value='1' />
    <table id='supervisors_${id}' class='table'>
        <tr>
            <td>
                ${frmSupervisor(id, 1)}
            </td>
            <td>
                ${frmSupervisor(id, 2)}
            </td>
            <td>
                ${frmSupervisor(id, 3)}
            </td>
            <td>
                ${frmSupervisor(id, 4)}
            </td>
        </tr>
    <input type='button' onClick='addSupervisors(${id})' value = 'Add Supervisors' />`;
    return html;
}
function addSupervisors(id){
    //Get current click count stored in hidden div
    var clicks = document.getElementById('supervisorClicks_'+id).value;
    clicks++;
    document.getElementById('supervisorClicks_'+id).value = clicks; 
    //get table
    var supervisorTable = document.getElementById('supervisors_'+id);
    // Create an empty <tr> element and add it to the 1st position of the table:
    var row = supervisorTable.insertRow(-1);
    var endValue = 4 * clicks; 
    var i = endValue - 4;
    var td = [];
    // Insert new cells (<td> elements) at the 1st and 2nd position of the "new" <tr> element:
    td.push(row.insertCell(0));
    td.push(row.insertCell(1));
    td.push(row.insertCell(2));
    td.push(row.insertCell(3));
    a = 0;
    while(i < endValue){
        if(a < 4){
            td[a].innerHTML = `${frmSupervisor(id, i)}`;
        }
        i++;
        a++;
    } 
}


function frmPresenter(id, number) 
{
    return `<label for='presenter${number}_${id}'>Presenter ${number}:</label>
            <input type='text' id='presenter${number}_${id}' list='authors' name='presenter[]'/>`;
}
function frmPresenters(id) 
{
    var html = `<input type='hidden' id='presenterClicks_${id}' value='1' />
    <table id='presenters_${id}' class='table'>
        <tr>
            <td>
                ${frmPresenter(id, 1)}
            </td>
            <td>
                ${frmPresenter(id, 2)}
            </td>
            <td>
                ${frmPresenter(id, 3)}
            </td>
            <td>
                ${frmPresenter(id, 4)}
            </td>
        </tr>
    <input type='button' onClick='addPresenters(${id})' value = 'Add Presenters' />`;
    return html;
}
function addPresenters(id){
    //Get current click count stored in hidden div
    var clicks = document.getElementById(`presenterClicks_${id}`).value;
    clicks++;
    document.getElementById(`presenterClicks_${id}`).value = clicks; 
    //get table
    var presenterTable = document.getElementById(`presenters_${id}`);
    // Create an empty <tr> element and add it to the 1st position of the table:
    var row = presenterTable.insertRow(-1);
    var endValue = 4 * clicks; 
    var i = endValue - 4;
    var td = [];
    // Insert new cells (<td> elements) at the 1st and 2nd position of the "new" <tr> element:
    td.push(row.insertCell(0));
    td.push(row.insertCell(1));
    td.push(row.insertCell(2));
    td.push(row.insertCell(3));
    a = 0;
    while(i < endValue){
        if(a < 4){
            td[a].innerHTML = `${frmPresenter(id, i)}`;
        }
        i++;
        a++;
    } 
}

function frmCreator(id, number) 
{
    return `<label for='creator${number}_${id}'>Creator ${number}:</label>
            <input type='text' id='creator${number}_${id}' list='authors' name='creator[]'/>`;
}
function frmCreators(id) 
{
    var html = `<input type='hidden' id='creatorClicks_${id}' value='1' />
    <table id='creators_${id}' class='table'>
        <tr>
            <td>
                ${frmCreator(id, 1)}
            </td>
            <td>
                ${frmCreator(id, 2)}
            </td>
            <td>
                ${frmCreator(id, 3)}
            </td>
            <td>
                ${frmCreator(id, 4)}
            </td>
        </tr>
    <input type='button' onClick='addCreators(${id})' value = 'Add Creators' />`;
    return html;
}
function addCreators(id){
    //Get current click count stored in hidden div
    var clicks = document.getElementById(`creatorClicks_${id}`).value;
    clicks++;
    document.getElementById(`creatorClicks_${id}`).value = clicks; 
    //get table
    var creatorTable = document.getElementById(`creators_${id}`);
    // Create an empty <tr> element and add it to the 1st position of the table:
    var row = creatorTable.insertRow(-1);
    var endValue = 4 * clicks; 
    var i = endValue - 4;
    var td = [];
    // Insert new cells (<td> elements) at the 1st and 2nd position of the "new" <tr> element:
    td.push(row.insertCell(0));
    td.push(row.insertCell(1));
    td.push(row.insertCell(2));
    td.push(row.insertCell(3));
    a = 0;
    while(i < endValue){
        if(a < 4){
            td[a].innerHTML = `${frmCreator(id, i)}`;
        }
        i++;
        a++;
    } 
}

function frmUploader(id, number) 
{
    return `<label for='uploader${number}_${id}'>Uploader ${number}:</label>
            <input type='text' id='uploader${number}_${id}' list='authors' name='uploader[]'/>`;
}
function frmUploaders(id) 
{
    var html = `<input type='hidden' id='uploaderClicks_${id}' value='1' />
    <table id='uploaders_${id}' class='table'>
        <tr>
            <td>
                ${frmUploader(id, 1)}
            </td>
            <td>
                ${frmUploader(id, 2)}
            </td>
            <td>
                ${frmUploader(id, 3)}
            </td>
            <td>
                ${frmUploader(id, 4)}
            </td>
        </tr>
    <input type='button' onClick='addUploaders(${id})' value = 'Add Uploaders' />`;
    return html;
}
function addUploaders(id){
    //Get current click count stored in hidden div
    var clicks = document.getElementById(`uploaderClicks_${id}`).value;
    clicks++;
    document.getElementById(`uploaderClicks_${id}`).value = clicks; 
    //get table
    var uploaderTable = document.getElementById(`uploaders_${id}`);
    // Create an empty <tr> element and add it to the 1st position of the table:
    var row = uploaderTable.insertRow(-1);
    var endValue = 4 * clicks; 
    var i = endValue - 4;
    var td = [];
    // Insert new cells (<td> elements) at the 1st and 2nd position of the "new" <tr> element:
    td.push(row.insertCell(0));
    td.push(row.insertCell(1));
    td.push(row.insertCell(2));
    td.push(row.insertCell(3));
    a = 0;
    while(i < endValue){
        if(a < 4){
            td[a].innerHTML = `${frmUploader(id, i)}`;
        }
        i++;
        a++;
    } 
}
function frmWebmaster(id, number) 
{
    return `<label for='webmaster${number}_${id}'>Webmaster ${number}:</label>
            <input type='text' id='webmaster${number}_${id}' list='authors' name='webmaster[]'/>`;
}
function frmWebmasters(id) 
{
    var html = `<input type='hidden' id='webmasterClicks_${id}' value='1' />
    <table id='webmasters_${id}' class='table'>
        <tr>
            <td>
                ${frmWebmaster(id, 1)}
            </td>
            <td>
                ${frmWebmaster(id, 2)}
            </td>
            <td>
                ${frmWebmaster(id, 3)}
            </td>
            <td>
                ${frmWebmaster(id, 4)}
            </td>
        </tr>
    <input type='button' onClick='addWebmasters(${id})' value = 'Add Webmasters' />`;
    return html;
}
function addWebmasters(id){
    //Get current click count stored in hidden div
    var clicks = document.getElementById(`webmasterClicks_${id}`).value;
    clicks++;
    document.getElementById(`webmasterClicks_${id}`).value = clicks; 
    //get table
    var webmasterTable = document.getElementById(`webmasters_${id}`);
    // Create an empty <tr> element and add it to the 1st position of the table:
    var row = webmasterTable.insertRow(-1);
    var endValue = 4 * clicks; 
    var i = endValue - 4;
    var td = [];
    // Insert new cells (<td> elements) at the 1st and 2nd position of the "new" <tr> element:
    td.push(row.insertCell(0));
    td.push(row.insertCell(1));
    td.push(row.insertCell(2));
    td.push(row.insertCell(3));
    a = 0;
    while(i < endValue){
        if(a < 4){
            td[a].innerHTML = `${frmWebmaster(id, i)}`;
        }
        i++;
        a++;
    } 
}
function frmPublisher(id) 
{
    return `<label for='publisher_${id}'>Publisher:</label>
            <input type='text' id='publisher_${id}' name='publisher'/>`;
}
function frmLocation(id) 
{
    return `<label for='location_${id}'>Location:</label>
            <input type='text' id='location_${id}' name='location'/>`;
}
function frmYear(id) 
{
    return `<label for='year_${id}'>Year:</label>
            <input type='text' id='year_${id}' name='year'/>`;
}
function frmDate(id) 
{
    return `<label for='date_${id}'>Date:</label>
            <input type='date' id='date_${id}' name='date'/>`
}
function frmJournal(id) 
{
    return `<label for='journal_${id}'>Journal:</label>
            <input type='text' id='journal_${id}' name='journal'/>`;
}
function frmVolume(id) 
{
    return `<label for='volume_${id}'>Volume:</label>
            <input type='text' id='volume_${id}' name='volume'/>`;
}
function frmIssue(id) 
{
    return `<label for='issue_${id}'>Issue:</label>
            <input type='text' id='issue_${id}' name='issue'/>`;
}
function frmLevel(id) 
{
    return `<label for='level_${id}'>Level:</label>
            <input type='text' id='level_${id}' name='level'/>`;
}
function frmConference(id) 
{
    return `<label for='conference_${id}'>Conference:</label>
            <input type='text' id='conference_${id}' name='conference'/>`;
}

function frmWebsite(id) 
{
    return `<label for='website_${id}'>Website:</label>
            <input type='text' id='website_${id}' name='website'/>`;
}
function frmSrcLocation(id) 
{
    return `<label for='srcLocation_${id}'>Source File:</label>
            <input type='file' id='srcLocation' name='srcLocation'/>`;
}
//artifacts type of fields
function frmArtifact(id) 
{
    return `<label for='artifact_${id}'>Artifact:</label>
            <input type='text' id='artifact_${id}' name='artifact'/>`;
}

function frmArtifactId(id) 
{
    return `<label for='artifactId_${id}'>Artifact ID:</label>
            <input type='text' id='artifactId_${id}' name='artifactId'/>`;
}
function frmArtifactClass(id) 
{
    return `<label for='artifactClass_${id}'>Artifact Class:</label>
            <input type='text' id='artifactClass_${id}' name='artifactClass'/>`;
}
function frmRadioCarbonDate(id) 
{
    return `<label for='radioCarbonDate_${id}'>Radiocarbon Date:</label>
            <input type='text' id='frmradioCarbonDate_${id}' name='radioCarbonDate'/>`;
}
function frmStandardError(id) 
{
    return `<label for='standardError_${id}'>Standard Error: +/- </label>
            <input type='text' id='standardError${id}' name='standardError'/>`;
}
function frmMaterial(id) 
{
    return `<label for='material_${id}'>Material Type: </label>
            <input type='text' id='material_${id}' name='material'/>`;
}
function frmContext(id) 
{
    return `<label for='context_${id}'>Context: </label>
            <input type='text' id='context_${id}' name='context'/>`;
}
function frmCollectedBy(id) 
{
    return `<label for='collectedBy_${id}'>Collected By: </label>
            <input type='text' id='collectedBy_${id}' name='collectedBy'/>`;
}
function frmSubmittedBy(id) 
{
    return `<label for='submittedBy_${id}'>Submitted By: </label>
            <input type='text' id='submittedBy_${id}' name='submittedBy'/>`;
}
function frmArticleTitle(id) 
{
    return `<label for='articleTitle_${id}'>Article Title: </label>
            <input type='text' id='articleTitle_${id}' name='articleTitle'/>`;
}
function frmArticleCitation(id) 
{
    return `<label for='articleCitation_${id}'>Article Citation: </label>
            <input type='text' id='articleCitation_${id}' name='articleCitation'/>`;
}
function frmIndirectSrc(id) 
{
    return `<label for='indirectSrc_${id}'>Indirect Source: </label>
            <input type='text' id='indirectSrc_${id}' name='indirectSrc'/>`;
}
function frmSiteId(id) 
{
    return `<label for='siteID_${id}'>Site ID:</label>
            <input type='text' id='siteID_${id}' name='siteID'/>`;
}
function frmSiteName(id) 
{
    return `<label for='siteName_${id}'>Site Name:</label>
            <input type='text' id='siteName_${id}' name='siteName'/>`;
}
function frmPlantName(id) 
{
    return `<label for='plantName_${id}'>Plant Name:</label>
            <input type='text' id='plantName_${id}' name='plantName'/>`;
}
function frmPlantType(id) 
{
    return `<label for='plantType_${id}'>Plant Type:</label>
            <input type='text' id='plantType_${id}' name='plantType'/>`;
}
function frmQuantity(id) 
{
    return `<label for='quantity_${id}'>Quantity:</label>
            <input type='text' id='quantity_${id}' name='quantity'/>`;
}
function frmSrcType(id) 
{
    return `<label for='srcType_${id}'>Source Type:</label>
            <select id='srcType_${id}'>
                <option value='a'>Article</option>
                <option value='b'>Book</option>
                <option value='pr'>Presentation</option>
                <option value='po'>Poster</option>
                <option value='ab'>Abstract</option>
                <option value='t'>Thesis</option>
                <option value='d'>Dissertation</option>
                <option value='v'>Video</option>
                <option value='w'>Website</option>
                <option value='r'>Radio Broadcast</option>
            </select>`;
}
function frmSrcId(id) 
{
    return `<label for='srcId_${id}'>Source Id:</label>
            <input type='text' id='srcId_${id}' name='srcId'/>`;
}
function frmLabNo(id) 
{
    return `<label for='labNo_${id}'>Lab No:</label>
            <input type='text' id='labNo_${id}' name='labNo'/>`;
}
function frmTimePeriod(id) 
{
    return `<label for='timePeriod_${id}'>Time Period:</label>
            <input type='text' id='timePeriod_${id}' name='timePeriod'/>`;
}
function frmSampleId(id) 
{
    return `<label for='sampleId_${id}'>Sample ID:</label>
            <input type='text' id='sampleId_${id}' name='sampleId'/>`;
}
function frmSpecies(id) 
{
    return `<label for='species_${id}'>Species:</label>
            <input type='text' id='species_${id}' name='species'/>`;
}
function frmElement(id) 
{
    return `<label for='element_${id}'>Element: </label>
            <input type='text' id='element_${id}' name='element'/>`;
}
function frmAge(id) 
{
    return `<label for='age_${id}'>Age: </label>
            <input type='text' id='age_${id}' name='age'/>`;
}
function frmSex(id) 
{
    return `<label for='sex_${id}'>Sex: </label>
            <input type='text' id='sex_${id}' name='sex'/>`;
}
function frmC13(id) 
{
    return `<label for='c13_${id}'>&delta;C<sub>13</sub>: </label>
            <input type='text' id='c13_${id}' name='c13'/>`;
}
function frmN15(id) 
{
    return `<label for='n15_${id}'>&delta;N<sub>15</sub>: </label>
            <input type='text' id='n15_${id}' name='n15'/>`;
}
function toggleShow(div){
	var button1 = "btn" + div;
	if(document.getElementById(div).style.display == 'block'){
		document.getElementById(div).style.display='none';
		document.getElementById(button1).value='+';
	}else if(document.getElementById(div).style.display='none'){
		document.getElementById(div).style.display='block';
		document.getElementById(button1).value='-';
	}else{
		document.getElementById(div).style.display='none';
		document.getElementById(button1).value='+';
	}
}

            