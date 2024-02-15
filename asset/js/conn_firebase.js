function conn_firebase(){
var config = 
	{
			apiKey: "{api_key}",
			authDomain: "{domain}",
			databaseURL: "{url}",
			projectId: "{project_id}",
			storageBucket: "{app}",
			messagingSenderId: "{msg_send}"
	}
	
	return firebase.initializeApp(config);
}

function malika_update_data(db){
	db.ref('Product').on('child_changed',function(snapshot){
		var post = snapshot.val();
		var name = snapshot.key;
		var dtUpTo = {name:post};
		dtUpTo = JSON.stringify(dtUpTo);
		console.log(dtUpTo);
		malika_ajax_update('update',post.product_code,dtUpTo);
	});
}

function malika_ajax_update(tp,sku,dt){
    if (sku.length == 0) { 
        //document.getElementById(id).innerHTML = "";
        return;
    } else {
		jQuery(function($){
			$.ajax({
				url: ajaxurl,
				type: 'post',
				data: {
					action: 'update_stock_malika',
					type: tp,
					sku: sku,
					data: dt
				},
				context: this,
				success: function(res) {
					//console.log(res);
				},
				error: function(err) {
					//console.log(err);
				}
			});
		}
    }
}