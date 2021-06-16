
	var CLIENT_ID		= CLIENT_ID;
	var API_KEY			= API_KEY;
	var DISCOVERY_DOCS	= ['https://docs.googleapis.com/$discovery/rest?version=v1'];
	//Authorization scopes required by the API; multiple scopes can be included, separated by spaces.
	
	var SCOPES			= "https://www.googleapis.com/auth/documents https://www.googleapis.com/auth/drive https://www.googleapis.com/auth/drive.file";
	var authorizeButton	= document.getElementById('authorize_button');
	var signoutButton	= document.getElementById('signout_button');
	
	function handleClientLoad() {
    	gapi.load('client:auth2', initClient);
    }
    function initClient() {
		gapi.client.init({
			apiKey: API_KEY,
			clientId: CLIENT_ID,
			discoveryDocs: DISCOVERY_DOCS,
			scope: SCOPES
		}).then(function() {
			// Listen for sign-in state changes.
			gapi.auth2.getAuthInstance().isSignedIn.listen(updateSigninStatus);
			// Handle the initial sign-in state.
			updateSigninStatus(gapi.auth2.getAuthInstance().isSignedIn.get());
			authorizeButton.onclick	= handleAuthClick;
			signoutButton.onclick	= handleSignoutClick;
    	});
    }
    function updateSigninStatus(isSignedIn) {
		if (isSignedIn) {
			authorizeButton.style.display	= 'none';
			signoutButton.style.display		= 'inline-block';
			$('.createdoc').show();
			//printDocTitle();
		} else {
			authorizeButton.style.display	= 'inline-block';
			signoutButton.style.display		= 'none';
			$('.createdoc').hide();
		}
    }
    function handleAuthClick(event) {
    	gapi.auth2.getAuthInstance().signIn();
    }
    function handleSignoutClick(event) {
    	gapi.auth2.getAuthInstance().signOut();
    }
    function appendPre(message) {
		var pre			= document.getElementById('content');
		var textContent	= document.createTextNode(message + '\n');
		pre.appendChild(textContent);
    }
    function get_google_doc_content(doc_id, sub_id) {
		gapi.client.docs.documents.get({
			documentId: doc_id
		}).then(function(response) {
			var doc			= response.result;
			var title		= doc.title;
			var dbody		= doc.documentId;
			var revisionId	= doc.revisionId;
			var docBody		= JSON.stringify(doc.body, null, 4);
			var token		= $("meta[name='csrf-token']").attr("content");
			
            $.ajax({
            	url: APP_URL + '/publish_submission',
				type: 'POST',
				data: {
					"sid": sub_id,
					"docBody": docBody,
					"_token": token,
				},
				success: function (data) {
					$('#loading-indicator').hide();
					window.location.href = '/submissions?message=' + data;
				}
            });
    	}, function(response) {
			$('#loading-indicator').hide();
			alert(response.result.error.message);
			return false;
		});
    }
    function create_google_doc(title, sid) {
		return gapi.client.docs.documents.create({
			"resource": {
				"title": title
			}
		}).then(function(response) {
            var Doc_Title	= response.result.title;
            var Doc_Id		= response.result.documentId;
            //appendPre(JSON.stringify(response.body, null, 4));
            var token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
            	url: APP_URL + '/updateGoogleDocId',
				type: 'POST',
				data: {
					"sid": sid,
					"doc_id": Doc_Id,
					"_token": token,
				},
				success: function () {
					$('#reslt').html('<p class="alert alert-success">Document Created Successfully</p>');
					setTimeout(function(){location.reload();}, 1000);
				}
            });
		},
		function(err) {
			console.error("Execute error", err);
		});
    }